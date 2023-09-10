<?php

require_once 'src/Model/Dto/DeleteDto.php';
require_once 'src/Model/Dto/CreateOrderDto.php';
require_once 'src/Model/Dto/UpdateOrderDto.php';
require_once 'src/Service/CartService.php';

class OrderService
{
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getAllOrders()
    {
        try {
            $orders = $this->orderRepository->getAllOrders();
            return $orders;
        } catch (PDOException $e) {
            //TODO log $e->getMessage()
            http_response_code(500);
        }
    }



    public function getOrder($order_id)
    {
        try {
            $order = $this->orderRepository->getorder($order_id);

            if (!$order) {
                echo "Order not found";
            }
            return $order;
        } catch (PDOException $e) {
            //TODO log $e->getMessage()
            http_response_code(500);
        }
    }

    public function getLatestOrder()
    {
        try {
            //Get user id from session
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];
                $order = $this->orderRepository->getLatestOrder($userId);
                if ($order) {
                    return $order;
                } else {
                    echo "Order not found";
                    http_response_code(404);
                }
            } else {
                echo "An error occured, user not found";
                http_response_code(404);
            }
        } catch (PDOException $e) {
            //TODO log $e->getMessage()
            http_response_code(500);
        }
    }

    public function createOrder(CreateOrderDto $orderDto)
    {
        $cartService = new CartService();

        try {
            //Get user id from session
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];

                $order = $this->orderRepository->createOrder($userId, $orderDto->lines);
                if ($order) {
                    echo "Order created successfully";
                    //Clear cart on successful order
                    $cartService->clearCart();
                } else {
                    echo "Failed to create the order, order not found";
                    http_response_code(404);
                }
            } else {
                echo "An error occured, user not found";
                http_response_code(404);
            }
        } catch (PDOException $e) {
            //TODO log $e->getMessage()
            http_response_code(500);
        }
    }

    public function updateOrderStatus(UpdateOrderDto $dto)
    {
        try {
            $updatedOrder = $this->orderRepository->updateOrderStatus($dto->id, "Completed");
            if ($updatedOrder > 0) {
                echo "Order status updated successfully";
                return $updatedOrder;
            } else {
                echo "Order was not updated, as it is already completed or the id was invalid";
                http_response_code(500);
            }
        } catch (PDOException $e) {
            //TODO log $e->getMessage()
            http_response_code(500);
        }
    }

    public function deleteOrder(DeleteDto $dto)
    {
        try {
            $rowsDeleted = $this->orderRepository->DeleteOrder($dto->id);
            if ($rowsDeleted > 0) {
                echo "Order deleted successfully";
                return $rowsDeleted;
            } else {
                echo "Order not found or couldn't be deleted";
            }
        } catch (PDOException $e) {
            //TODO log $e->getMessage()
            //TODO Statuscode
        }
    }
}

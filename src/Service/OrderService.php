<?php

require_once 'src/Model/Dto/DeleteDto.php';
require_once 'src/Model/Dto/CreateOrderDto.php';
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
            echo $e->getMessage();
            //TODO log $e->getMessage()
            //TODO Statuscode
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
            echo $e->getMessage();
            //TODO log $e->getMessage()
            //TODO Statuscode
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
                    //TODO statuscode
                }
            } else {
                echo "An error occured, user not found";
                //TODO statuscode
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            //TODO log $e->getMessage()
            //TODO Statuscode
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
                    echo "Failed to create the order";
                    //TODO statuscode
                }
            } else {
                echo "An error occured, user not found";
                //TODO statuscode
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            //TODO log $e->getMessage()
            //TODO Statuscode
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
            echo $e->getMessage();
            //TODO log $e->getMessage()
            //TODO Statuscode
        }
    }
}

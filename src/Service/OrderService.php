<?php

require_once 'src/Model/Dto/DeleteDto.php';
require_once 'src/Model/Dto/CreateOrderDto.php';


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
                echo "Order not found.";
            }
            return $order;
        } catch (PDOException $e) {
            echo $e->getMessage();
            //TODO log $e->getMessage()
            //TODO Statuscode
        }
    }

    public function createOrder(CreateOrderDto $orderDto)
    {
        try {
            $product = $this->orderRepository->createOrder($orderDto->id, $orderDto->lines);
            if ($product) {
                echo "Order created successfully";
            } else {
                echo "Failed to create the order";
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

<?php

require_once 'src/Database/Connector.php';
require_once 'src/Model/Dto/OrderDto.php';
require_once 'src/Model/Dto/OrderWithProductDto.php';

/* "bindParam" - Binding Parameters: You're using parameter binding to safely insert the values into the query. This helps prevent SQL injection. */

class OrderService extends Connector
{

    public function getAllOrdersWithDetails()
    {
        // Initialize an empty array to store order data
        $orders = array();

        // SQL query to retrieve all orders and their associated product details
        $sql = "SELECT
                    o.order_id,
                    o.user_id,
                    ol.product_id,
                    ol.quantity,
                    p.product_name,
                    p.product_price
                FROM
                    `Order` o
                JOIN
                    OrderLine ol ON o.order_id = ol.order_id
                JOIN
                    Product p ON ol.product_id = p.product_id";

        // Prepare the SQL statement
        $stmt = $this->getConnection()->prepare($sql);

        // Execute the SQL query
        $stmt->execute();

        // Check if the query executed successfully
        if ($stmt) {
            // Fetch the results as an associative array
            $orderData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Iterate through the order data and create DTOs
            foreach ($orderData as $orderItem) {
                $orderDto = new OrderWithProductDto(
                    $orderItem['order_id'],
                    $orderItem['user_id'],
                    $orderItem['product_id'],
                    $orderItem['quantity'],
                    $orderItem['product_name'],
                    $orderItem['product_price']
                );

                // Add the DTO to the orders array
                $orders[] = $orderDto;
            }
        }

        return $orders;
    }



    public function getOrderById($order_id)
    {
        // Initialize an empty variable to store the order
        $order = null;

        // SQL query to retrieve the order by its ID
        $sql = "SELECT
                    o.order_id,
                    o.user_id,
                    ol.product_id,
                    ol.quantity,
                    p.product_name,
                    p.product_price
                FROM
                    `Order` o
                JOIN
                    OrderLine ol ON o.order_id = ol.order_id
                JOIN
                    Product p ON ol.product_id = p.product_id
                WHERE
                    o.order_id = :order_id";

        // Prepare the SQL statement
        $stmt = $this->getConnection()->prepare($sql);

        // Bind the order_id parameter
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);

        // Execute the SQL query
        $stmt->execute();

        // Check if the query executed successfully and fetch the result
        if ($stmt && $stmt->rowCount() > 0) {
            // Fetch the result as an associative array
            $orderData = $stmt->fetch(PDO::FETCH_ASSOC);

            // Create a DTO for the order
            $orderDto = new OrderWithProductDto(
                $orderData['order_id'],
                $orderData['user_id'],
                $orderData['product_id'],
                $orderData['quantity'],
                $orderData['product_name'],
                $orderData['product_price']
            );

            // Assign the DTO to the $order variable
            $order = $orderDto;
        }

        return $order;
    }


    public function deleteOrderById(OrderDto $orderDto)
    {
        $sql = "DELETE FROM `Order` WHERE order_id = :order_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':order_id', $orderDto->order_id, PDO::PARAM_INT);
        $success = $stmt->execute();
        if ($success) {
            return true;
        } else {
            return false;
        }
    }
}

<?php
require_once 'src/Database/Connector.php';

class OrderRepository extends Connector
{
    public function GetOrder(int $id)
    {
        //TODO wrong - it shouldnt return product price as the price is quantity * product_price (now a field on orderline)
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

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':order_id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function GetAllOrders()
    {
        $sql = "SELECT * FROM order";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function CreateOrder(int $user_id, array $orderLines)
    {
        $connection = $this->getConnection();
        $connection->beginTransaction();

        try {
            // Generate a unique order_id
            $order_id = uniqid();

            // Insert the new order into the `Order` table
            $sql = "INSERT INTO `Order` (order_id, user_id) VALUES (:order_id, :user_id)";
            $stmtOrder = $connection->prepare($sql);
            $stmtOrder->bindParam(':order_id', $order_id, PDO::PARAM_STR);
            $stmtOrder->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmtOrder->execute();

            // Insert order lines into the `OrderLine` table
            foreach ($orderLines as $orderLine) {
                $product_id = $orderLine['productId'];
                $quantity = $orderLine['quantity'];
                $price = $orderLine['price'];

                $sql = "INSERT INTO OrderLine (order_id, product_id, quantity, price) 
                        VALUES (:order_id, :product_id, :quantity, :price)";
                $stmtOrderLine = $connection->prepare($sql);
                $stmtOrderLine->bindParam(':order_id', $order_id, PDO::PARAM_STR);
                $stmtOrderLine->bindParam(':product_id', $product_id, PDO::PARAM_INT);
                $stmtOrderLine->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                $stmtOrderLine->bindParam(':price', $price, PDO::PARAM_STR);
                $stmtOrderLine->execute();
            }

            // Commit the transaction
            $connection->commit();

            return true;
        } catch (PDOException $e) {
            // If an error occurs, rollback the transaction
            $connection->rollBack();
            return false; // Order creation failed
        }
    }




    public function UpdateOrder()
    {
        //TODO Implement
    }

    public function DeleteOrder(int $id)
    {
        $sql = "DELETE FROM order WHERE order_id = :id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}

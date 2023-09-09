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
        // Start a database transaction to ensure data integrity
        $this->getConnection()->beginTransaction();

        // Create order
        $orderInsertSql = "INSERT INTO `Order` (user_id) VALUES (:user_id)";
        $orderStmt = $this->getConnection()->prepare($orderInsertSql);
        $orderStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        return $orderStmt->execute();

        // Get the ID of the newly inserted order
        $order_id = $this->getConnection()->lastInsertId();

        //Create order lines
        $orderLineInsertSql = "INSERT INTO OrderLine (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)";
        $orderLineStmt = $this->getConnection()->prepare($orderLineInsertSql);

        foreach ($orderLines as $orderLine) {
            $product_id = $orderLine['product_id'];
            $quantity = $orderLine['quantity'];

            $orderLineStmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $orderLineStmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $orderLineStmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $orderLineStmt->bindParam(':price', $price, PDO::PARAM_INT);
            $orderLineStmt->execute();
        }

        // Commit the transaction
        $this->getConnection()->commit();
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

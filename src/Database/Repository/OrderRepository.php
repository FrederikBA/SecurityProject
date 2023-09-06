<?php
require_once 'src/Database/Connector.php';

class OrderRepository extends Connector
{
    public function GetOrder(int $id)
    {
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
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
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

    public function CreateOrder()
    {
        //TODO Implement
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

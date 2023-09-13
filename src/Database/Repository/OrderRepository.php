<?php
require_once 'src/Database/Connector.php';

class OrderRepository extends Connector
{
    public function getOrder(string $id)
    {
        $sql = "SELECT O.order_id, O.order_status, O.created, OL.product_id, OL.quantity, OL.price, P.product_name
        FROM `Order` AS O
        INNER JOIN OrderLine AS OL ON O.order_id = OL.order_id
        INNER JOIN Product AS P ON OL.product_id = P.product_id
        WHERE O.order_id = :order_id";


        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':order_id', $id, PDO::PARAM_STR);
        $stmt->execute();

        // Initialize variables to store the order
        $order = null;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($order === null) {
                $order = [
                    'order_id' => $row['order_id'],
                    'order_status' => $row['order_status'],
                    'created' => $row['created'],
                    'lines' => [],
                ];
            }
            $order['lines'][] = [
                'product_name' => $row['product_name'],
                'product_id' => $row['product_id'],
                'quantity' => $row['quantity'],
                'price' => $row['price'],
            ];
        }

        return $order;
    }


    public function getAllOrders()
    {
        $sql = "SELECT * FROM `order`";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function GetLatestOrder(int $user_id)
    {
        $sql = "SELECT O.order_id, O.order_status, O.created, OL.product_id, OL.quantity, OL.price, P.product_name
        FROM `Order` AS O
        INNER JOIN OrderLine AS OL ON O.order_id = OL.order_id
        INNER JOIN Product AS P ON OL.product_id = P.product_id
        WHERE O.order_id = (
            SELECT MAX(order_id)
            FROM `Order`
            WHERE user_id = :user_id
        )";



        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        // Initialize variables to store the latest order and its order lines
        $latestOrder = null;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($latestOrder === null) {
                $latestOrder = [
                    'order_id' => $row['order_id'],
                    'order_status' => $row['order_status'],
                    'created' => $row['created'],
                    'lines' => [],
                ];
            }
            $latestOrder['lines'][] = [
                'product_name' => $row['product_name'],
                'product_id' => $row['product_id'],
                'quantity' => $row['quantity'],
                'price' => $row['price'],
            ];
        }
        return $latestOrder;
    }



    public function createOrder(int $user_id, array $orderLines)
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
            return false;
        }
    }

    public function updateOrderStatus(string $id, string $status)
    {
        $sql = "UPDATE `order` o SET o.order_status = :order_status WHERE o.order_id = :id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':order_status', $status);
        $stmt->execute();
        return $stmt->rowCount();
    }


    public function deleteOrder(string $id)
    {
        try {
            $connection = $this->getConnection();
            $connection->beginTransaction();

            $deleteOrderLinesQuery = "DELETE FROM OrderLine WHERE order_id = :order_id";
            $orderLinesStmt = $connection->prepare($deleteOrderLinesQuery);
            $orderLinesStmt->bindParam(":order_id", $id, PDO::PARAM_STR);
            $orderLinesStmt->execute();

            $deleteOrderQuery = "DELETE FROM `Order` WHERE order_id = :order_id";
            $orderStmt = $connection->prepare($deleteOrderQuery);
            $orderStmt->bindParam(":order_id", $id, PDO::PARAM_STR);
            $orderStmt->execute();

            // Commit the transaction
            $connection->commit();

            return true; // Return true to indicate successful deletion
        } catch (PDOException $e) {
            // Rollback the transaction on error
            $connection->rollback();
            return false; // Return false to indicate deletion failure
        }
    }
}

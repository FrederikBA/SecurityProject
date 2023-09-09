<?php
require_once 'src/Database/Connector.php';

class OrderRepository extends Connector
{
    public function GetOrder(string $id)
    {
        try {
            // Create a query to fetch the order and its order lines
            $sql = "SELECT O.order_id, O.user_id, OL.product_id, OL.quantity, OL.price
                FROM `Order` AS O
                INNER JOIN OrderLine AS OL ON O.order_id = OL.order_id
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
                        'order_lines' => [],
                    ];
                }
                $order['order_lines'][] = [
                    'product_id' => $row['product_id'],
                    'quantity' => $row['quantity'],
                    'price' => $row['price'],
                ];
            }

            $stmt->closeCursor();

            return $order;
        } catch (PDOException $e) {
            // Handle any exceptions here (e.g., log the error)
            //TODO log $e->getMessage()
        }
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
            return false;
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

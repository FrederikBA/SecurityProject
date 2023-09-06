<?php
require_once 'src/Database/Connector.php';

class ProductRepository extends Connector
{
    public function getProduct(int $id)
    {
        $sql = "SELECT * FROM product WHERE product_id = :id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllProducts()
    {
        $sql = "SELECT * FROM product";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createProduct(string $name, float $price)
    {
        $sql = "INSERT INTO product (product_name, product_price) VALUES (:name, :price)";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        return $stmt->execute();
    }

    public function updateProductPrice(int $id, float $price)
    {
        $sql = "UPDATE product p SET p.product_price = :price WHERE product_id = :id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':price', $price);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function deleteProduct(int $id)
    {
        $sql = "DELETE FROM product WHERE product_id = :id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}

<?php

require_once 'src/Database/Connector.php';
require_once 'src/Model/Product.php';
require_once 'src/Model/Dto/UpdateProductDto.php';

/* "bindParam" - Binding Parameters: You're using parameter binding to safely insert the values into the query. This helps prevent SQL injection. */

class ProductService
{
    private $connection;

    public function __construct()
    {
        $this->connection = (new Connector())->getConnection();
    }

    public function createProduct(Product $product)
    {
        $stmt = $this->connection->prepare("INSERT INTO product (product_name, product_price, product_img) VALUES (:name, :price, :img)");
        $stmt->bindParam(':name', $product->name);
        $stmt->bindParam(':price', $product->price);
        $stmt->bindParam(':img', $product->img);
        $stmt->execute();
    }

    public function updateProductPriceByID( UpdateProductDto $productDto) {
        $sql = "UPDATE product p SET p.product_price = :newPrice WHERE product_id = :productID";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':productID', $productDto->id);
        $stmt->bindParam(':newPrice', $productDto->price);
        // Check if the update was successful
        return $stmt->execute();
    }
    

    public function getProductsFromDatabase() {
        // Initialize an empty array to store product data
        $products = array();
    
        // Select all products from the "product" table
        $sql = "SELECT * FROM product";
        $stmt = $this->connection->query($sql);
    
        // Check if the query executed successfully
        if ($stmt) {
            // Fetch the results as an associative array
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    
        return $products;
    }
    


    
    public function getProductByID($productID) {
        $sql = "SELECT * FROM product WHERE product_id = :productID";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        
        // Fetch the result as an associative array
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        return $product;
    }


    public function deleteProductByID($productID) {
        $sql = "DELETE FROM product WHERE product_id = :productID";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        
        // Check if any rows were affected (deleted)
        return $stmt->rowCount() > 0;
    }
    
    
    


}
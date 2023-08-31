<?php

require_once 'src/Database/Connector.php';
require_once 'src/Model/Product.php';
require_once 'src/Model/Dto/UpdateProductDto.php';
require_once 'src/Model/Dto/CreateProductDto.php';

/* "bindParam" - Binding Parameters: You're using parameter binding to safely insert the values into the query. This helps prevent SQL injection. */

class ProductService extends Connector
{

    public function createProduct(CreateProductDto $createProductDto)
    {
        $stmt = $this->getConnection()->prepare("INSERT INTO product (product_name, product_price) VALUES (:name, :price)");
        $stmt->bindParam(':name', $createProductDto->name);
        $stmt->bindParam(':price', $createProductDto->price);
        $stmt->execute();
    }

    public function updateProductPriceByID(UpdateProductDto $productDto) {
        $sql = "UPDATE product p SET p.product_price = :newPrice WHERE product_id = :productID";
        $stmt = $this->getConnection()->prepare($sql);
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
        $stmt = $this->getConnection()->query($sql);
    
        // Check if the query executed successfully
        if ($stmt) {
            // Fetch the results as an associative array
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    
        return $products;
    }
    
    public function getProductByID($productID) {
        $sql = "SELECT * FROM product WHERE product_id = :productID";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        
        // Fetch the result as an associative array
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        return $product;
    }


    public function deleteProductByID($productID) {
        $sql = "DELETE FROM product WHERE product_id = :productID";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':productID', $productID, PDO::PARAM_INT);
        $stmt->execute();
        
        // Check if any rows were affected (deleted)
        return $stmt->rowCount() > 0;
    }
    
    
    


}
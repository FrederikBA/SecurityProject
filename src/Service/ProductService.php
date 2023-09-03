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
        try {

        $stmt = $this->getConnection()->prepare("INSERT INTO product (product_name, product_price) VALUES (:name, :price)");
        $stmt->bindParam(':name', $createProductDto->name);
        $stmt->bindParam(':price', $createProductDto->price);
        if ($stmt->execute()) {
        echo "Product created successfully!";
    } else {
        echo "Failed to create the product!";
    }
} catch (PDOException $e) {
    // Handle PDO exceptions
    echo "Database error: " . $e->getMessage();
}
    }


    public function updateProductPriceByID(UpdateProductDto $productDto)
    {
        try {
            // Check if the product with the specified ID exists before updating
            $checkSql = "SELECT COUNT(*) FROM product WHERE product_id = :productID";
            $checkStmt = $this->getConnection()->prepare($checkSql);
            $checkStmt->bindParam(':productID', $productDto->id);
            $checkStmt->execute();
    
            $productExists = ($checkStmt->fetchColumn() > 0);
    
            if ($productExists) {
                $updateSql = "UPDATE product p SET p.product_price = :newPrice WHERE product_id = :productID";
                $updateStmt = $this->getConnection()->prepare($updateSql);
                $updateStmt->bindParam(':productID', $productDto->id);
                $updateStmt->bindParam(':newPrice', $productDto->price);
    
                // Check if the update was successful
                if ($updateStmt->execute()) {
                    echo "Product price updated successfully!";
                } else {
                    echo "Failed to update the product price!";
                }
            } else {
                echo "Product not found. Price not updated.";
            }
        } catch (PDOException $e) {
            // Handle PDO exceptions
            echo "Database error: " . $e->getMessage();
        }
    }


    public function getProductsFromDatabase()
{
    try {
        $products = array();
        $sql = "SELECT * FROM product";
        $stmt = $this->getConnection()->query($sql);

        if (!$stmt) {
            echo "Failed to retrieve products from the database.";
        } else {
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $products;
    } catch (PDOException $e) {
        // Handle PDO exceptions
        echo "Database error: " . $e->getMessage();
        return array(); // Return an empty array or handle the error as needed
    }
}

    


    public function getProductByID($productID)
    {
        try {
            $sql = "SELECT * FROM product WHERE product_id = :productID";
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':productID', $productID, PDO::PARAM_INT);
            $stmt->execute();
    
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$product) {
                echo "Product not found.";
            }
    
            return $product;
        } catch (PDOException $e) {
            // Handle PDO exceptions
            echo "Database error: " . $e->getMessage();
            return null; // Return null or handle the error as needed
        }
    }
    


    public function deleteProductByID(UpdateProductDto $productDto)
    {
        try {
            $sql = "DELETE FROM product WHERE product_id = :productID";
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':productID', $productDto->id, PDO::PARAM_INT);
            $stmt->execute();
    
            // Check if any rows were affected (deleted)
            $rowCount = $stmt->rowCount();
    
            if ($rowCount === 0) {
                echo "Product not found.";
            } else {
                echo "Product deleted successfully!";
            }
    
            return $rowCount > 0;
        } catch (PDOException $e) {
            // Handle PDO exceptions
            echo "Database error: " . $e->getMessage();
            return false; // Return false or handle the error as needed
        }
    }

}
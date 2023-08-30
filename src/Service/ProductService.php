<?php

require_once 'src/Database/Connector.php';
require_once 'src/Model/Product.php';

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
    
}

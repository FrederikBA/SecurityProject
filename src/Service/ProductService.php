<?php

require_once 'src/Model/Product.php';
require_once 'src/Model/Dto/UpdateProductDto.php';
require_once 'src/Model/Dto/CreateProductDto.php';
require_once 'src/Model/Dto/DeleteDto.php';

class ProductService
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getProduct($id)
    {
        try {
            $product = $this->productRepository->getProduct($id);

            if (!$product) {
                echo "Product not found.";
                http_response_code(404);
            }
            return $product;
        } catch (PDOException $e) {
            $logMessage = "[" . date("d.m.Y H:i:s") . "] " . $e->getMessage() .  "\n";
            error_log($logMessage, 3, 'logs/servererror.log');
            http_response_code(500);
        }
    }

    public function getAllProducts()
    {
        try {
            $products = $this->productRepository->getAllProducts();
            return $products;
        } catch (PDOException $e) {
            http_response_code(500);
            $logMessage = "[" . date("d.m.Y H:i:s") . "] " . $e->getMessage() .  "\n";
            error_log($logMessage, 3, 'logs/servererror.log');
        }
    }


    public function createProduct(CreateProductDto $productDto)
    {
        try {
            $product = $this->productRepository->createProduct($productDto->name, $productDto->price);
            if ($product) {
                echo "Product created successfully!";
            } else {
                echo "Failed to create the product!";
                http_response_code(500);
            }
        } catch (PDOException $e) {
            $logMessage = "[" . date("d.m.Y H:i:s") . "] " . $e->getMessage() .  "\n";
            error_log($logMessage, 3, 'logs/servererror.log');
            http_response_code(500);
        }
    }


    public function updateProductPrice(UpdateProductDto $productDto)
    {
        try {
            $updatedProduct = $this->productRepository->updateProductPrice($productDto->id, $productDto->price);
            if ($updatedProduct > 0) {
                echo "Product price updated successfully";
                return $updatedProduct;
            } else {
                echo "An error occured updating the price on the product";
                http_response_code(500);
            }
        } catch (PDOException $e) {
            $logMessage = "[" . date("d.m.Y H:i:s") . "] " . $e->getMessage() .  "\n";
            error_log($logMessage, 3, 'logs/servererror.log');
            http_response_code(500);
        }
    }

    public function deleteProduct(DeleteDto $dto)
    {
        try {
            $rowsDeleted = $this->productRepository->DeleteProduct($dto->id);
            if ($rowsDeleted > 0) {
                echo "Product deleted successfully";
                return $rowsDeleted;
            } else {
                echo "Product not found";
                http_response_code(404);
            }
        } catch (PDOException $e) {
            $logMessage = "[" . date("d.m.Y H:i:s") . "] " . $e->getMessage() .  "\n";
            error_log($logMessage, 3, 'logs/servererror.log');
            http_response_code(500);
        }
    }
}

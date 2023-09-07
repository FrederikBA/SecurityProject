<?php
require __DIR__ . '/src/cors/init.php';
require __DIR__ . '/config.php';
require_once __DIR__ . '/router.php';

//Views
get('/security', '/public/index.php');

//Headers
header("Content-Type: application/json");

//Endpoints

//Create Product
post('/security/product/create', 'src/Endpoints/CreateProduct.php');

//Get all Products
get('/security/products', 'src/Endpoints/GetAllProducts.php');

//Get Product.
get('/security/product/$id', 'src/Endpoints/GetProduct.php');

//Delete product.
post('/security/deleteproduct', 'src/Endpoints/DeleteProduct.php');

//Update price on a product.
post('/security/updateproduct', 'src/Endpoints/UpdateProductPrice.php');

//Update user info
post('/security/updateuser', 'src/Endpoints/UpdateUser.php');

//user by ID
get('/security/user/$id', 'src/Endpoints/GetUser.php');

//Delete user
post('/security/deleteuser', 'src/Endpoints/DeleteUser.php');

//Get all orders with products
get('/security/orders', 'src/Endpoints/GetAllOrders.php');

//Get Order by id
get('/security/order/$id', 'src/Endpoints/GetOrder.php');

//Delete order
post('/security/deleteorder', 'src/Endpoints/DeleteOrder.php');

//Register user
post('/security/register', 'src/Endpoints/RegisterUser.php');

//Login user
post('/security/login', 'src/Endpoints/Login.php');

//Logout user
post('/security/logout', 'src/Endpoints/Logout.php');

//Check user login
get('/security/checklogin', "src/Endpoints/CheckLogin.php");



get('/security/logtester', "src/Endpoints/Logtest.php");



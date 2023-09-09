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
post('/security/product/create', 'src/Endpoints/Product/CreateProduct.php');

//Get all Products
get('/security/products', 'src/Endpoints/Product/GetAllProducts.php');

//Get Product.
get('/security/product/$id', 'src/Endpoints/Product/GetProduct.php');

//Delete product.
post('/security/deleteproduct', 'src/Endpoints/Product/DeleteProduct.php');

//Update price on a product.
post('/security/updateproduct', 'src/Endpoints/Product/UpdateProductPrice.php');

//Update user info
post('/security/updateuser', 'src/Endpoints/User/UpdateUser.php');

//user by ID
get('/security/user/$id', 'src/Endpoints/User/GetUser.php');

//Delete user
post('/security/deleteuser', 'src/Endpoints/User/DeleteUser.php');

//Get all orders with products
get('/security/orders', 'src/Endpoints/Order/GetAllOrders.php');

//Get Order by id
get('/security/order/$id', 'src/Endpoints/Order/GetOrder.php');

//Get latest order
get('/security/latestorder', 'src/Endpoints/Order/GetLatestOrder.php');

//Create Order
post('/security/createorder', 'src/Endpoints/Order/CreateOrder.php');

//Delete order
post('/security/deleteorder', 'src/Endpoints/Order/DeleteOrder.php');

//Register user
post('/security/register', 'src/Endpoints/Login/RegisterUser.php');

//Login user
post('/security/login', 'src/Endpoints/Login/Login.php');

//Logout user
post('/security/logout', 'src/Endpoints/Login/Logout.php');

//Check user login
get('/security/checklogin', "src/Endpoints/Login/CheckLogin.php");

//Add to cart
post('/security/addtocart', "src/Endpoints/Cart/AddToCart.php");

//Get cart
get('/security/cart', "src/Endpoints/Cart/GetCart.php");

//Remove CartLine
post('/security/removecartline', "src/Endpoints/Cart/RemoveCartLine.php");

//Clear cart
post('/security/clearcart', "src/Endpoints/Cart/ClearCart.php");

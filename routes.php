<?php

require_once __DIR__ . '/router.php';

get('/security', '/public/index.php');
post('/security/product/create', 'src/Endpoints/CreateProduct.php');
post('/security/test', 'src/Endpoints/TestEndpoint.php');    
#any('/404', 'views/404.php');

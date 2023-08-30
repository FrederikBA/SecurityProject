<?php

require_once __DIR__ . '/router.php';
require_once 'src/Controller/ProductController.php';

get('/security', '/public/index.php');
post('/product/create', 'src/Controller/ProductController.php');
#any('/404', 'views/404.php');

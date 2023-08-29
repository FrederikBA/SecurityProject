<?php

require_once __DIR__ . '/router.php';

get('/security', '/public/index.php');
any('/404', 'views/404.php');

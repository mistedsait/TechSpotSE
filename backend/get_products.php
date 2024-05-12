<?php

require_once __DIR__ . "/rest/services/ProductService.class.php";

$category = isset($_GET['category']) ? $_GET['category'] : 'all';

$product_service = new ProductService();
$products = $product_service->getProductsByCategory($category);

echo json_encode($products);

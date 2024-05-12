<?php

require_once __DIR__ . '/rest/services/ProductService.class.php';

header('Content-Type: application/json');
$json_str = file_get_contents('php://input');
$payload = json_decode($json_str, true);

$product_service = new ProductService();

try {
    $product_item = [
        'name' => $payload['name'],
        'price' => $payload['price'],
        'image' => $payload['image'],
        'description' => $payload['description'],
        'product_id' => $payload['product_id'],
        'category' => $payload['category']
    ];
    $added_item = $product_service->add_product($product_item);
    echo json_encode(['message' => 'Product Added Succesfully', 'data' => $added_item]);
} catch (Exception $e) {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => $e->getMessage()]);
}


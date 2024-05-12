<?php
require_once __DIR__ . '/rest/services/ProductService.class.php';

header('Content-Type: application/json');
$json_str = file_get_contents('php://input');
$payload = json_decode($json_str, true);


if (empty($payload['id'])) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Product ID is required.']);
    exit();
}


$product_service = new ProductService();

try {
    $product_service->update_product($payload['id'], [
        'name' => $payload['name'],
        'category' => $payload['category'],
        'price' => $payload['price'],
        'image' => $payload['image'] ,
        'description' => $payload['description'] ?? null
    ]);
    
 
    echo json_encode(['message' => 'Product updated successfully']);
} catch (Exception $e) {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => $e->getMessage()]);
}

<?php
require_once __DIR__ . '/rest/services/ProductService.class.php';

header('Content-Type: application/json');

$product_id = isset($_GET['id']) ? $_GET['id'] : null;

if (empty($product_id)) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Product ID is required.']);
    exit();
}

$product_service = new ProductService();

try {
    $product_service->delete_product($product_id);
    
    echo json_encode(['message' => 'Product deleted successfully']);
} catch (Exception $e) {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => $e->getMessage()]);
}

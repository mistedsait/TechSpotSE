<?php

require_once __DIR__ . '/rest/services/ProductService.class.php';

header('Content-Type: application/json');
$json_str = file_get_contents('php://input');
$payload = json_decode($json_str, true);

$product_service = new ProductService();

try {
    $product_item = [
        'name' => $payload['name'],
        'total_ammount' => $payload['total_ammount'],
        //more i'm tired
    ];
    $added_item = $order_service->add_order($order_item);
    echo json_encode(['message' => 'Order Added Succesfully', 'data' => $added_item]);
} catch (Exception $e) {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => $e->getMessage()]);
}
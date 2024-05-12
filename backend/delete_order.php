<?php
require_once __DIR__ . '/rest/services/OrderService.class.php';

header('Content-Type: application/json');

$order_id = isset($_GET['id']) ? $_GET['id'] : null;

if (empty($order_id)) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'order ID is required.']);
    exit();
}

$order_service = new OrderService();

try {
    $order_service->delete_order($order_id);
    
    echo json_encode(['message' => 'order deleted successfully']);
} catch (Exception $e) {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => $e->getMessage()]);
}
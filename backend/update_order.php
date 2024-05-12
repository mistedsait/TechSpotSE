<?php
require_once __DIR__ . '/rest/services/OrderService.class.php';

header('Content-Type: application/json');
$json_str = file_get_contents('php://input');
$payload = json_decode($json_str, true);


if (empty($payload['id'])) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Order ID is required.']);
    exit();
}


$Order_service = new OrderService();

try {
    $order_service->update_order($payload['id'], [
        'total_ammount' => $payload['total_ammount']
    ]);
    
 
    echo json_encode(['message' => 'Order updated successfully']);
} catch (Exception $e) {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => $e->getMessage()]);
}

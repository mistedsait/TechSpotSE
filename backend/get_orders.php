<?php

require_once __DIR__ . "/rest/services/OrderService.class.php";

$id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id) {
    header('HTTP/1.1 400 Bad Request');
    die(json_encode(['error' => "order ID is missing"]));
}

$order_service = new orderService();
$order = $order_service->get_order_by_id($id);

if (!$order) {
    header('HTTP/1.1 404 Not Found');
    die(json_encode(['error' => "order not found"]));
}

echo json_encode($order);


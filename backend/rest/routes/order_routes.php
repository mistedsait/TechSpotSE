<?php

require_once __DIR__ . '/../services/OrderService.class.php';



Flight::route('POST /orders/add', function(){
    header('Content-Type: application/json');
    
    $json_str = Flight::request()->getBody();
    $payload = json_decode($json_str, true);

    $order_service = new ProductService(); // Assuming ProductService handles orders

    try {
        $order_item = [
            'name' => $payload['name'],
            'total_ammount' => $payload['total_ammount'],
            // more fields as needed
        ];

        $added_item = $order_service->add_order($order_item);
        
        Flight::json(['message' => 'Order Added Successfully', 'data' => $added_item]);
    } catch (Exception $e) {
        Flight::response()->status(500)->send(json_encode(['error' => $e->getMessage()]));
    }
});

Flight::route('DELETE /order/delete/@id:[0-9]+', function($order_id){
    header('Content-Type: application/json');

    if (empty($order_id)) {
        Flight::response()->status(400)->send(json_encode(['error' => 'Order ID is required.']));
    }

    $order_service = new OrderService();

    try {
        $order_service->delete_order($order_id);
        
        Flight::json(['message' => 'Order deleted successfully']);
    } catch (Exception $e) {
        Flight::response()->status(500)->send(json_encode(['error' => $e->getMessage()]));
    }
});

Flight::route('PUT /order', function(){
    header('Content-Type: application/json');
    
    $json_str = Flight::request()->getBody();
    $payload = json_decode($json_str, true);

    if (empty($payload['id'])) {
        Flight::response()->status(400)->send(json_encode(['error' => 'Order ID is required.']));
    }

    $order_service = new OrderService();

    try {
        $order_service->update_order($payload['id'], [
            'total_ammount' => $payload['total_ammount']
            // more fields as needed
        ]);
        
        Flight::json(['message' => 'Order updated successfully']);
    } catch (Exception $e) {
        Flight::response()->status(500)->send(json_encode(['error' => $e->getMessage()]));
    }
});
Flight::route('/order/test', function () {
    echo 'hello world!';
  });
Flight::start();
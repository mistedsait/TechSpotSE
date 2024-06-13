<?php

require_once __DIR__ . '/../services/OrderService.class.php';


/**
 * @OA\Post(
 *     path="/orders/add",
 *     summary="Add a new order",
 *     description="Add a new order to the system",
 *     operationId="addOrder",
 *     tags={"Order"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="JSON object containing the order details to add",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 required={"name", "total_ammount"},
 *                 @OA\Property(
 *                     property="name",
 *                     type="string",
 *                     description="Name of the order"
 *                 ),
 *                 @OA\Property(
 *                     property="total_ammount",
 *                     type="number",
 *                     format="float",
 *                     description="Total amount of the order"
 *                 ),
 *                 example={"name": "Example Order", "total_ammount": 50.00}
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Order added successfully",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Order Added Successfully"
 *             ),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 description="Details of the added order",
 *                 // Define properties of the added order here
 *             )
 *         )
 *     )
 * )
 */
Flight::route('POST /orders/add', function(){
    header('Content-Type: application/json');
    
    $json_str = Flight::request()->getBody();
    $payload = json_decode($json_str, true);

    $order_service = new OrderService(); 

    try {
        $order_item = [
            'name' => $payload['name'],
            'total_ammount' => $payload['total_ammount'],
            'order_id' =>$payload['total_ammount']
            // more fields as needed
        ];

        $added_item = $order_service->add_order($order_item);
        
        Flight::json(['message' => 'Order Added Successfully', 'data' => $added_item]);
    } catch (Exception $e) {
        Flight::response()->status(500)->send(json_encode(['error' => $e->getMessage()]));
    }
});
/**
 * @OA\Delete(
 *     path="/order/delete/{id}",
 *     summary="Delete an order by ID",
 *     description="Delete an order from the system by providing its ID",
 *     operationId="deleteOrder",
 *     tags={"Order"},
 *     security={
 *          {"ApiKey": {}}
 *      },
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of the order to delete",
 *         required=true,
 *         @OA\Schema(
 *             type="integer",
 *             format="int64"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Order deleted successfully",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Order deleted successfully"
 *             )
 *         )
 *     )
 * )
 */

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
/**
 * @OA\Put(
 *     path="/order/update",
 *     summary="Update an order",
 *     description="Update an existing order in the system",
 *     operationId="updateOrder",
 *     tags={"Order"},
 *     security={
 *          {"ApiKey": {}}
 *      },
 *     @OA\RequestBody(
 *         required=true,
 *         description="JSON object containing the order details to update",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 required={"order_id", "total_ammount"},
 *                 @OA\Property(
 *                     property="order_id",
 *                     type="integer",                 
 *                     description="ID of the order to update"
 *                 ),
 *                 @OA\Property(
 *                     property="total_ammount",
 *                     type="number",
 *                     description="Updated total amount of the order"
 *                 ),
 *                 example={"id": 123, "total_ammount": 50.00}
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Order updated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Order updated successfully"
 *             )
 *         )
 *     )
 * )
 */

Flight::route('PUT /order/update', function(){
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


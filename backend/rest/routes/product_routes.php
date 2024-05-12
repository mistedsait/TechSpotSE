<?php

require_once __DIR__ . '/../services/ProductService.class.php';


/**
 * @OA\Get(
 *     path="/products",
 *     summary="Get products",
 *     description="Retrieve products optionally filtered by category.",
 *     tags={"Products"},
 *     @OA\Parameter(
 *         name="category",
 *         in="query",
 *         description="Filter products by category (default: all)",
 *         required=false,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         
 *         )
 *     )
 * )
 */
Flight::route('GET /products', function(){
    header('Content-Type: application/json');

    $category = Flight::request()->query['category'] ?? 'all';

    $product_service = new ProductService();
    $products = $product_service->getProductsByCategory($category);

    Flight::json($products);
});

Flight::route('DELETE /product/delete/@id:[0-9]+', function($product_id){
    header('Content-Type: application/json');

    if (empty($product_id)) {
        Flight::response()->status(400)->send(json_encode(['error' => 'Product ID is required.']));
    }

    $product_service = new ProductService();

    try {
        $product_service->delete_product($product_id);
        
        Flight::json(['message' => 'Product deleted successfully']);
    } catch (Exception $e) {
        Flight::response()->status(500)->send(json_encode(['error' => $e->getMessage()]));
    }
});

Flight::route('PUT /product/update', function(){
    header('Content-Type: application/json');
    
    $json_str = Flight::request()->getBody();
    $payload = json_decode($json_str, true);

    if (empty($payload['id'])) {
        Flight::response()->status(400)->send(json_encode(['error' => 'Product ID is required.']));
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

        Flight::json(['message' => 'Product updated successfully']);
    } catch (Exception $e) {
        Flight::response()->status(500)->send(json_encode(['error' => $e->getMessage()]));
    }
});


Flight::route('POST /product/add', function(){
    header('Content-Type: application/json');
    
    $json_str = Flight::request()->getBody();
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
        Flight::json(['message' => 'Product Added Successfully', 'data' => $added_item]);
    } catch (Exception $e) {
        Flight::response()->status(500)->send(json_encode(['error' => $e->getMessage()]));
    }
});
Flight::route('/esk', function () {
    echo 'hello world!';
  });
Flight::start();


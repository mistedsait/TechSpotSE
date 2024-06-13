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

/**
     * @OA\Delete(
     *      path="/product/delete/{product_id}",
     *      tags={"Products"},
     *      summary="Delete product by id",
     *      security={
     *          {"ApiKey": {}}
     *      },
     *      @OA\Response(
     *           response=200,
     *           description="Status message"
     *      ),
     *      @OA\Parameter(@OA\Schema(type="number"), in="path", name="product_id", example="1", description="Product id")
     * )
     */
    Flight::route('DELETE /product/delete/@product_id:[0-9]+', function($product_id){
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
    
/**
 * @OA\Put(
 *     path="/product/update",
 *     summary="Update a product",
 *     tags={"Products"},
 *     security={
 *          {"ApiKey": {}}
 *      },
 *     @OA\RequestBody(
 *         required=true,
 *         description="Product data to update",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", description="Product ID"),
 *                 @OA\Property(property="name", type="string", description="Product name"),
 *                 @OA\Property(property="category", type="string", description="Product category"),
 *                 @OA\Property(property="price", type="number", format="float", description="Product price"),
 *                 @OA\Property(property="image", type="string", description="Product image URL"),
 *                 @OA\Property(property="description", type="string", description="Product description", nullable=true),
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product updated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 */

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

/**
 * @OA\Post(
 *     path="/product/add",
 *     summary="Add a new product",
 *     tags={"Products"},
 *     security={
 *          {"ApiKey": {}}
 *      },
 *     @OA\RequestBody(
 *         required=true,
 *         description="Product data to add",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(property="name", type="string", description="Product name"),
 *                 @OA\Property(property="price", type="number", format="float", description="Product price"),
 *                 @OA\Property(property="image", type="string", description="Product image URL"),
 *                 @OA\Property(property="description", type="string", description="Product description"),
 *                 @OA\Property(property="product_id", type="integer", description="Product ID"),
 *                 @OA\Property(property="category", type="string", description="Product category"),
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product added successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     )
 * )
 */
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

Flight::route('GET /get-product-id/@id', function($id){
    /**
 * @OA\Get(
 *     path="/get-product-id/{id}",
 *     summary="Get product by ID",
 *     tags={"Products"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="The ID of the product to fetch",
 *         @OA\Schema(
 *             type="integer",
 *             example=1
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product details retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="product_id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="iPhone 15"),
 *             @OA\Property(property="category", type="string", example="Phones"),
 *             @OA\Property(property="price", type="number", format="float", example=799.00),
 *             @OA\Property(property="image", type="string", example="path/to/image.jpg"),
 *             @OA\Property(property="description", type="string", example="Latest iPhone model with A17 chip.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Product not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Product not found")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server error",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Internal server error")
 *         )
 *     )
 * )
 */

    header('Content-Type: application/json');

    $product_service = new ProductService();
    $product = $product_service->getProductById($id);

    if ($product) {
        Flight::json($product);
    } else {
        Flight::halt(404, json_encode(["message" => "Product not found"]));
    }
});




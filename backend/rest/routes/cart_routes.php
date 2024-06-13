<?php

require_once __DIR__ . '/../services/CartService.class.php';

Flight::route('POST /add-to-cart', function(){
    /**
     * @OA\Post(
     *      path="/add-to-cart",
     *      tags={"cart"},
     *      summary="Add item to cart",
     *      description="Adds a product to the user's cart",
     *       security={
     *          {"ApiKey": {}}
     *      },
     *      @OA\RequestBody(
     *          required=true,
     *          description="Product information",
     *          @OA\JsonContent(
     *              required={"product_id"},
     *              @OA\Property(property="product_id", type="integer", example=1),
     *              @OA\Property(property="quantity", type="integer", example=1)
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Product added to cart successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Product added to cart successfully"),
     *              @OA\Property(property="data", type="object")
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Product ID is required"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="User not authenticated"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *      )
     * )
     */
    header('Content-Type: application/json');
    $cart_service = new CartService();
    
    try {
        $user_id = Flight::get('user_id'); // Get user_id from Flight
        if (!$user_id) {
            throw new Exception("User not authenticated");
        }

        $payload = Flight::request()->data->getData();

        if (!isset($payload['product_id']) || empty($payload['product_id'])) {
            Flight::halt(400, "Product ID is required");
        }

        $cart_item = [
            'user_id' => $user_id,
            'product_id' => $payload['product_id'],
            'quantity' => $payload['quantity'] ?? 1
        ];

        $added_item = $cart_service->add_to_cart($cart_item);
        Flight::json(['message' => 'Product added to cart successfully', 'data' => $added_item]);
    } catch (Exception $e) {
        Flight::halt(500, $e->getMessage());
    }
});


Flight::route('GET /cart', function(){
    /**
     * @OA\Get(
     *      path="/cart",
     *      tags={"cart"},
     *      summary="Get cart items",
     *      description="Retrieves all items in the user's cart",
     *      security={
     *          {"ApiKey": {}}
     *      },
     *      @OA\Response(
     *          response=200,
     *          description="Cart items retrieved successfully",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  type="object",
     *                  @OA\Property(property="product_id", type="integer", example=1),
     *                  @OA\Property(property="quantity", type="integer", example=1),
     *                  @OA\Property(property="product_name", type="string", example="Product Name"),
     *                  @OA\Property(property="product_image", type="string", example="image/path.jpg"),
     *                  @OA\Property(property="product_price", type="number", format="float", example=19.99)
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="User not authenticated"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *      )
     * )
     */
    header('Content-Type: application/json');
    $cart_service = new CartService();
    
    try {
        $user_id = Flight::get('user_id'); // Get user_id from Flight
        if (!$user_id) {
            Flight::json(['error' => 'User not authenticated'], 401);
            return;
        }

        $cart_items = $cart_service->get_cart_products($user_id);
        Flight::json($cart_items, 200);
    } catch (Exception $e) {
        Flight::json(['error' => 'Internal server error'], 500);
    }
});

/**
 * @OA\Delete(
 *      path="/cart-delete",
 *      tags={"cart"},
 *      summary="Remove item from cart",
 *      description="Removes a specific item from the user's cart",
 *      security={
 *          {"ApiKey": {}}
 *      },
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="cart_item_id", type="integer", example=1)
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Item removed successfully",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="message", type="string", example="Item removed from cart successfully")
 *          )
 *      ),
 *      @OA\Response(
 *          response=401,
 *          description="User not authenticated"
 *      ),
 *      @OA\Response(
 *          response=500,
 *          description="Internal server error"
 *      )
 * )
 */
Flight::route('DELETE /cart-delete', function(){
    header('Content-Type: application/json');
    $cart_service = new CartService();
    
    try {
        $json_str = file_get_contents('php://input');
        $payload = json_decode($json_str, true);

        $user_id = Flight::get('user_id'); // Get user_id from Flight
        if (!$user_id) {
            Flight::json(['error' => 'User not authenticated'], 401);
            return;
        }

        $cart_item_id = $payload['cart_item_id'];
        $cart_service->remove_from_cart($cart_item_id);

        Flight::json(['message' => 'Item removed from cart successfully']);
    } catch (Exception $e) {
        Flight::halt(500, $e->getMessage());
    }
});


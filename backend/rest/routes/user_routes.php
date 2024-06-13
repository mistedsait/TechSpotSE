<?php

require_once __DIR__ . '/../services/UserService.class.php';



/**
 * @OA\Get(
 *      path="/users",
 *      tags={"users"},
 *      summary="Get all users",
 *      security={
 *          {"ApiKey": {}}
 *      },
 *      @OA\Response(
 *           response=200,
 *           description="Array of all users in the database",
 *           
 *      ),
 *      @OA\Response(
 *           response=401,
 *           description="Unauthorized"
 *      )
 * )
 */

Flight::route('GET /users', function(){
    $user_service = new UserService();
    
    $offset = Flight::request()->query['offset'] ?? 0;
    $limit = Flight::request()->query['limit'] ?? 25;
    $order = Flight::request()->query['order'] ?? 'id'; // Default order
    
    try {
        $users = $user_service->get_all_users($offset, $limit, $order);
        Flight::json($users);
    } catch (Exception $e) {
        Flight::response()->status(500)->send(['error' => $e->getMessage()]);
    }
});

/**
     * @OA\Get(
     *      path="/user/{id}",
     *      tags={"users"},
     *      security={
     *          {"ApiKey": {}}
     *      },
     *      summary="Get user by ID",
     *      @OA\Response(
     *           response=200,
     *           description="Get patient by ID"
     *      ),
     * @OA\Parameter(@OA\Schema(type="number"), in="path", name="id", example="1", description="User ID")
     * )
     */
Flight::route('GET /user/@id:[0-9]+', function($id){
    $user_service = new UserService();
    
    if (!$id) {
        Flight::response()->status(400)->send(['error' => "User ID is missing"]);
    }
    
    $user = $user_service->get_user_by_id($id);
    
    if (!$user) {
        Flight::response()->status(404)->send(['error' => "User not found"]);
    }
    
    Flight::json($user);
});

/**
 * @OA\Post(
 *      path="/users/add",
 *      tags={"users"},
 *      summary="Add user",
 *      security={
 *          {"ApiKey": {}}
 *      },
 *      @OA\Response(
 *           response=200,
 *           description="Add user (registration)"
 *      ),
 *      @OA\RequestBody(
 *          description="User ID",
 *          @OA\JsonContent(
 *             required={"firstname", "lastname", "email", "password"},
 *             @OA\Property(property="firstname", required=true, type="string", example="Miralem"),
 *             @OA\Property(property="lastname", required=true, type="string", example="Masic"),
 *             @OA\Property(property="email", required=true, type="string", example="miralem.masic@stu.ibu.edu.ba"),
 *             @OA\Property(property="password", required=true, type="string", example="strong")
 *           )
 *      )
 * )
 */


Flight::route('POST /users/add', function(){
    $user_service = new UserService();
    
    // Retrieve the raw POST data
    $raw_post_data = Flight::request()->getBody();
    
    // Decode the JSON data into an associative array
    $payload = json_decode($raw_post_data, true);
    
    // Check if 'firstname' key exists in the payload
    if (!isset($payload['firstname']) || $payload['firstname'] === '') {
        Flight::response()->status(400)->send(['error' => "First name field is missing"]);
    }
    
    $users = $user_service->add_user($payload);
    Flight::json(["message" => "You have successfully added the user", 'data' => $users]);
});

/**
     * @OA\Delete(
     *      path="/user/delete/{user_id}",
     *      tags={"users"},
     *      summary="Delete user by id",
     *      security={
     *          {"ApiKey": {}}
     *      },
     *      @OA\Response(
     *           response=200,
     *           description="Status message"
     *      ),
     *      @OA\Parameter(@OA\Schema(type="number"), in="path", name="user_id", example="1", description="User id")
     * )
     */

Flight::route('DELETE /user/delete/@id:[0-9]+', function($user_id){
    header('Content-Type: application/json');

    if (empty($user_id)) {
        Flight::response()->status(400)->send(json_encode(['error' => 'User ID is required.']));
    }

    $user_service = new UserService();

    try {
        // Attempt to delete the user
        $user_service->delete_user_by_id($user_id);
        
        // Respond with success message
        Flight::json(['message' => 'User deleted successfully']);
    } catch (Exception $e) {
        // If something goes wrong, send a 500 server error and the error message
        Flight::response()->status(500)->send(json_encode(['error' => $e->getMessage()]));
    }
});




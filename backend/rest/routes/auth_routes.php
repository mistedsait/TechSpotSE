<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../services/AuthService.class.php';
require_once __DIR__ . '/../services/CartService.class.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

Flight::set('auth_service', new AuthService());

Flight::group('/auth', function() {
    
    /**
     * @OA\Post(
     *      path="/auth/login",
     *      tags={"auth"},
     *      summary="Login to system",
     *      @OA\Response(
     *           response=200,
     *           description="User data and JWT token"
     *      ),
     *      @OA\RequestBody(
     *          description="User credentials",
     *          @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", required=true, type="string", example="logintest@gmail.com"),
     *             @OA\Property(property="password", required=true, type="string", example="capcarap@12")
     *           )
     *      ),
     * )
     */
    Flight::route('POST /login', function() {
        $payload = Flight::request()->data->getData();
        $users = Flight::get('auth_service')->get_user_by_email($payload['email']);
        if(!$users || !password_verify($payload['password'], $users['password'])) {
            Flight::halt(500, "Invalid username or password");
        }

        unset($users['password']);

        $jwt_payload = [
            'user' => $users,
            'user_id' => $users['id'],
            
            'iat' => time(),
            // If this parameter is not set, JWT will be valid for life. This is not a good approach
            'exp' => time() + (60 * 60 * 24) // valid for day
        ];

        $token = JWT::encode(
            $jwt_payload,
            Config::JWT_SECRET(),
            'HS256'
        );
        Flight::json(
            array_merge($users, ['token' => $token])
        ); 
    });

     /**
     * @OA\Post(
     *      path="/auth/logout",
     *      tags={"auth"},
     *      summary="Logout from the system",
     *      security={
     *          {"ApiKey": {}}   
     *      },
     *      @OA\Response(
     *           response=200,
     *           description="Success response or exception if unable to verify jwt token"
     *      ),
     * )
     */
    Flight::route('POST /logout', function() {
        try {
            $token = Flight::request()->getHeader("Authentication");
            if(!$token) {
                Flight::halt(401, "Missing authentication header");
            }

            $decoded_token = JWT::decode($token, new Key(Config::JWT_SECRET(), 'HS256'));
            Flight::json([
                'jwt_decoded' => $decoded_token,
                'user' => $decoded_token->user
            ]);
        } catch (\Exception $e) {
            Flight::halt(401, $e->getMessage());
        }
    });
});
<?php

require_once __DIR__ . "/rest/services/UserService.class.php";

// Retrieve the raw POST data
$raw_post_data = file_get_contents('php://input');

// Decode the JSON data into an associative array
$payload = json_decode($raw_post_data, true);

// Check if 'firstname' key exists in the payload
if (!isset($payload['firstname']) || $payload['firstname'] === '') {
    header('HTTP/1.1 400 Bad Request');
    die(json_encode(['error' => "First name field is missing"]));
}

$user_service = new UserService();
$users = $user_service->add_user($payload);
echo json_encode(["message" => "You have successfully added the user", 'data' => $users]);

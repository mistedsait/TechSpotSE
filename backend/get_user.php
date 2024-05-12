<?php

require_once __DIR__ . "/rest/services/UserService.class.php";

$id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id) {
    header('HTTP/1.1 400 Bad Request');
    die(json_encode(['error' => "User ID is missing"]));
}

$user_service = new UserService();
$user = $user_service->get_user_by_id($id);

if (!$user) {
    header('HTTP/1.1 404 Not Found');
    die(json_encode(['error' => "User not found"]));
}

echo json_encode($user);


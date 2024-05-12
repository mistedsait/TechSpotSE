<?php
require_once __DIR__ . '/rest/services/UserService.class.php';

header('Content-Type: application/json');

$user_service = new UserService();


$offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
$limit = isset($_GET['limit']) ? $_GET['limit'] : 25;
$order = isset($_GET['order']) ? $_GET['order'] : 'id'; // Default order

try {
    $users = $user_service->get_all_users($offset, $limit, $order);
    

    echo json_encode($users);
} catch (Exception $e) {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => $e->getMessage()]);
}


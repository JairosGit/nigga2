<?php
// php/data/get_user_session.php
session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode([
        'authenticated' => false,
        'message'       => 'Not logged in'
    ]);
    exit;
}

// TODO: Add or adjust any session keys your dashboard needs
echo json_encode([
    'authenticated' => true,
    'user_id'       => $_SESSION['user_id'],
    'username'      => $_SESSION['username'] ?? '',
    'role'          => $_SESSION['role'] ?? ''
]);
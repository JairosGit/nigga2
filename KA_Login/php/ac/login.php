<?php
// php/ac/login.php
session_start();
require_once __DIR__ . '/../core/connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../login.html');
    exit;
}

// Form inputs from login.html
$loginInput    = trim($_POST['username'] ?? '');
$passwordInput = $_POST['password'] ?? '';

if ($loginInput === '' || $passwordInput === '') {
    header('Location: ../../login.html?error=empty_fields');
    exit;
}


// TODO: Replace table/column names & password check to match your DB
$sql = 'SELECT id, username, email, password, role 
        FROM YOUR_USERS_TABLE 
        WHERE username = :user OR email = :email 
        LIMIT 1';

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':user'  => $loginInput,
    ':email' => $loginInput,
]);
$user = $stmt->fetch();

// Swap password_verify() if your DB stores passwords differently
if ($user && password_verify($passwordInput, $user['password'])) {
    session_regenerate_id(true);
    $_SESSION['user_id']  = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role']     = $user['role'] ?? 'ADMIN';

    header('Location: ../../dashboard.html');
    exit;
}

header('Location: ../../login.html?error=invalid_credentials');
exit;
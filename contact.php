<?php
header('Content-Type: application/json; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');
if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $message === '') {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Please provide a valid name, email, and message.']);
    exit;
}
if (mb_strlen($name) > 100 || mb_strlen($email) > 150 || mb_strlen($message) > 3000) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'One or more fields are too long.']);
    exit;
}
require __DIR__ . '/db.php';
try {
    // Prepared statement keeps user input separate from SQL (helps prevent SQL injection).
    $stmt = $pdo->prepare('INSERT INTO messages (name, email, message) VALUES (:name, :email, :message)');
    $stmt->execute([':name' => $name, ':email' => $email, ':message' => $message]);
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Could not save the message.']);
}

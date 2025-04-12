<?php
session_start();
require_once 'connect.php'; // Kết nối database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $role     = $_POST['role'] ?? '';

    // Truy vấn kiểm tra người dùng
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ? AND role = ?");
    $stmt->execute([$username, $password, $role]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user'] = $user;
        echo json_encode(['success' => true, 'role' => $user['role']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Sai tên đăng nhập hoặc mật khẩu']);
    }
}
?>

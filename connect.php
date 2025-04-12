<?php
$host = 'localhost';      // hoặc '127.0.0.1'
$db   = 'education_file_sharing';    // tên database bạn đã tạo
$user = 'root';           // tên người dùng MySQL
$pass = '';               // mật khẩu, thường để trống với XAMPP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Kết nối thành công!";
} catch (PDOException $e) {
    die("Lỗi kết nối database: " . $e->getMessage());
}
?>

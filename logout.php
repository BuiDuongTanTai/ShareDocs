<?php
// Khởi động session để truy cập thông tin phiên đăng nhập
session_start();

// Xóa tất cả các biến session
$_SESSION = array();

// Xóa cookie session nếu có
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Hủy session
session_destroy();

// Thông báo đăng xuất thành công và chuyển hướng về trang đăng nhập
$_SESSION['message'] = "Đăng xuất thành công!";
header("Location: login.php");
exit();
?>
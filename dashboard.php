<?php
// Khởi động session
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
    header("Location: login.php");
    exit();
}

// Lấy thông tin người dùng từ session
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bảng điều khiển - Hệ thống chia sẻ tài liệu học tập</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Hệ thống chia sẻ tài liệu học tập</h1>
        <div class="user-info">
            Xin chào, <strong><?php echo htmlspecialchars($username); ?></strong> (<?php echo $role === 'teacher' ? 'Giáo viên' : 'Học sinh'; ?>)
            <a href="logout.php" class="logout-btn">Đăng xuất</a>
        </div>
    </header>
    
    <div class="container">
        <div class="dashboard">
            <h2>Bảng điều khiển</h2>
            
            <div class="dashboard-menu">
                <a href="files.php" class="dashboard-item">
                    <div class="icon">📁</div>
                    <div class="title">Danh sách tài liệu</div>
                    <div class="description">Xem và tải xuống các tài liệu học tập</div>
                </a>
                
                <?php if ($role === 'teacher'): ?>
                <a href="upload.php" class="dashboard-item">
                    <div class="icon">⬆️</div>
                    <div class="title">Tải lên tài liệu</div>
                    <div class="description">Chia sẻ tài liệu mới cho học sinh</div>
                </a>
                <?php endif; ?>
                
                <a href="profile.php" class="dashboard-item">
                    <div class="icon">👤</div>
                    <div class="title">Thông tin cá nhân</div>
                    <div class="description">Xem và cập nhật thông tin tài khoản</div>
                </a>
            </div>
            
            <div class="recent-files">
                <h3>Tài liệu mới nhất</h3>
                <div class="file-list">
                    <?php
                    // Kết nối đến database
                    require_once 'connect.php';
                    
                    // Truy vấn để lấy 5 tài liệu mới nhất
                    $query = "SELECT f.*, u.username as teacher_name, s.subject_name 
                             FROM files f 
                             JOIN users u ON f.teacher_id = u.user_id 
                             JOIN subjects s ON f.subject_id = s.subject_id 
                             ORDER BY f.upload_date DESC LIMIT 5";
                    
                    $result = mysqli_query($conn, $query);
                    
                    if (mysqli_num_rows($result) > 0) {
                        while ($file = mysqli_fetch_assoc($result)) {
                            ?>
                            <div class="file-item">
                                <div class="file-info">
                                    <div class="file-name"><?php echo htmlspecialchars($file['file_name']); ?></div>
                                    <div class="file-details">
                                        <span>Môn học: <?php echo htmlspecialchars($file['subject_name']); ?></span> | 
                                        <span>Ngày tải lên: <?php echo date('d/m/Y', strtotime($file['upload_date'])); ?></span> | 
                                        <span>Giáo viên: <?php echo htmlspecialchars($file['teacher_name']); ?></span>
                                    </div>
                                    <div class="file-description"><?php echo htmlspecialchars($file['description']); ?></div>
                                </div>
                                <div class="file-actions">
                                    <a href="download.php?id=<?php echo $file['file_id']; ?>">Tải xuống</a>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<p>Chưa có tài liệu nào.</p>';
                    }
                    
                    // Đóng kết nối
                    mysqli_close($conn);
                    ?>
                </div>
                <a href="files.php" class="view-all">Xem tất cả tài liệu</a>
            </div>
        </div>
    </div>
    
    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Hệ thống chia sẻ tài liệu học tập. Tất cả quyền được bảo lưu.</p>
        </div>
    </footer>
    
    <script src="js/main.js"></script>
</body>
</html>
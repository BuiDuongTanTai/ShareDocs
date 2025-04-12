<?php
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['fileName'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $description = $_POST['description'] ?? '';
    $teacher = $_POST['teacher'] ?? 'Không rõ';

    if (isset($_FILES['file'])) {
        $uploadDir = 'uploads/';
        $fileName = basename($_FILES['file']['name']);
        $targetPath = $uploadDir . time() . '_' . $fileName;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
            $stmt = $pdo->prepare("INSERT INTO files (name, subject, description, teacher, file_path) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $subject, $description, $teacher, $targetPath]);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Lỗi khi tải lên']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Không có file']);
    }
}

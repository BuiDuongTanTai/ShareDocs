<?php
require_once 'connect.php';

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM files WHERE id = ?");
$stmt->execute([$id]);
$file = $stmt->fetch();

if ($file && file_exists($file['file_path'])) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($file['file_path']) . '"');
    header('Content-Length: ' . filesize($file['file_path']));
    readfile($file['file_path']);
    exit;
} else {
    echo "File không tồn tại";
}

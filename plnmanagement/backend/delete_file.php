<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filename = $_POST['filename'];
    $folder = isset($_POST['folder']) ? $_POST['folder'] . '/' : '';
    $filepath = "uploads/" . $folder . $filename;

    if (is_file($filepath)) {
        unlink($filepath);
        $conn->query("DELETE FROM files WHERE filename='$filename' AND folder='$folder'");
        echo "File berhasil dihapus!";
    } else {
        echo "File tidak ditemukan.";
    }
}
?>

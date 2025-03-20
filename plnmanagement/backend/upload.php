<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $folder = isset($_POST['folder']) ? $_POST['folder'] . '/' : '';
    $target_dir = "uploads/" . $folder;

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file = $_FILES["file"];
    $filename = basename($file["name"]);
    $filetype = pathinfo($filename, PATHINFO_EXTENSION);
    $target_file = $target_dir . $filename;

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO files (filename, folder, filetype) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $filename, $folder, $filetype);
        $stmt->execute();
        echo "File berhasil diupload!";
    } else {
        echo "Gagal mengupload file.";
    }
}
?>

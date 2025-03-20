<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $foldername = $_POST['foldername'];
    $target_dir = "uploads/" . $foldername;

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
        echo "Folder berhasil dibuat!";
    } else {
        echo "Folder sudah ada.";
    }
}
?>

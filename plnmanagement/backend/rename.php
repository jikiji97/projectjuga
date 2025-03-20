<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $oldname = $_POST['oldname'];
    $newname = $_POST['newname'];
    $folder = isset($_POST['folder']) ? $_POST['folder'] . '/' : '';

    $oldpath = "uploads/" . $folder . $oldname;
    $newpath = "uploads/" . $folder . $newname;

    if (rename($oldpath, $newpath)) {
        $conn->query("UPDATE files SET filename='$newname' WHERE filename='$oldname' AND folder='$folder'");
        echo "Nama berhasil diubah!";
    } else {
        echo "Gagal mengubah nama.";
    }
}
?>

<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>About</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<!-- Navbar -->
<?php include 'dashboard.php'; ?>

<div class="container mt-5">
    <h2>Tentang Website Ini</h2>
    <p>Website ini digunakan untuk mengelola data jam nyala PLN dan manajemen file sederhana seperti Google Drive.</p>
</div>

</body>
</html>

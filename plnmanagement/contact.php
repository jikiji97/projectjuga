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
    <title>Contact</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<!-- Navbar -->
<?php include 'dashboard.php'; ?>

<div class="container mt-5">
    <h2>Kontak</h2>
    <p>Email: support@pln.co.id</p>
    <p>Telepon: (021) 123456</p>
</div>

</body>
</html>

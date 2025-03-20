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
    <title>Services</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<!-- Navbar -->
<?php include 'dashboard.php'; ?>

<div class="container mt-5">
    <h2>Google Drive Sederhana</h2>

    <!-- Buat Folder -->
    <form id="folderForm">
        <input type="text" name="foldername" placeholder="Nama Folder Baru" class="form-control mb-2">
        <button type="submit" class="btn btn-primary">Buat Folder</button>
    </form>

    <!-- Upload File -->
    <form id="uploadForm" enctype="multipart/form-data">
        <input type="file" name="file" class="form-control mb-2">
        <input type="text" name="folder" placeholder="Nama Folder (opsional)" class="form-control mb-2">
        <button type="submit" class="btn btn-success">Upload File</button>
    </form>

    <!-- List File -->
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Nama File</th>
                <th>Jenis</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="fileTable"></tbody>
    </table>
</div>

<script>
    function loadFiles() {
        fetch('backend/get_files.php')
            .then(response => response.json())
            .then(data => {
                let fileTable = document.getElementById('fileTable');
                fileTable.innerHTML = "";
                data.forEach(file => {
                    fileTable.innerHTML += `
                        <tr>
                            <td>${file.filename}</td>
                            <td>${file.filetype}</td>
                            <td>
                                <button onclick="deleteFile('${file.filename}')" class="btn btn-danger">Hapus</button>
                            </td>
                        </tr>
                    `;
                });
            });
    }
    loadFiles();
</script>

</body>
</html>
    
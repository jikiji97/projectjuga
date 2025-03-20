<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

$rootDir = "uploads"; // Direktori utama penyimpanan
$currentDir = isset($_GET['dir']) ? $rootDir . "/" . $_GET['dir'] : $rootDir;

// Buat folder utama jika belum ada
if (!file_exists($rootDir)) {
    mkdir($rootDir, 0777, true);
}

// Fungsi untuk membuat folder
// Fungsi untuk mengunggah file
// Fungsi untuk membuat folder baru
if (isset($_POST['create_folder']) && !empty($_POST['folder_name'])) {
    $newFolderName = trim($_POST['folder_name']);
    $newFolderPath = $currentDir . "/" . $newFolderName;

    if (!file_exists($newFolderPath)) {
        mkdir($newFolderPath, 0777, true);
        echo "<script>alert('Folder berhasil dibuat!'); window.location.href='lpb.php?dir=" . $_GET['dir'] . "';</script>";
    } else {
        echo "<script>alert('Folder sudah ada!');</script>";
    }
}


// Fungsi untuk mengunggah file
if (isset($_FILES['file_upload']) && $_FILES['file_upload']['error'] == UPLOAD_ERR_OK) {
    $file = $_FILES['file_upload'];

    // Ambil folder tujuan (jika ada) atau tetap di root
    $targetDir = isset($_GET['dir']) && !empty($_GET['dir']) ? $rootDir . "/" . $_GET['dir'] : $rootDir;
    
    // Pastikan folder tujuan ada
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Validasi ekstensi file yang diperbolehkan
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'docx', 'xlsx', 'txt']; 
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($fileExtension, $allowedExtensions)) {
        echo "<script>alert('Format file tidak diperbolehkan!');</script>";
        exit;
    }

    // Cegah nama file duplikat dengan menambahkan timestamp
    $safeFileName = pathinfo($file['name'], PATHINFO_FILENAME);
    $safeFileName = preg_replace('/[^a-zA-Z0-9-_]/', '_', $safeFileName);
    $targetFile = $targetDir . "/" . $safeFileName . "_" . time() . "." . $fileExtension;

    // Periksa apakah folder bisa ditulis
    if (!is_writable($targetDir)) {
        echo "<script>alert('Folder tidak dapat ditulisi! Periksa izin.');</script>";
        exit;
    }

    // Pindahkan file yang diunggah
    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        echo "<script>alert('File berhasil diunggah!'); window.location.href='lpb.php?dir=" . $_GET['dir'] . "';</script>";
    } else {
        echo "<script>alert('Gagal mengunggah file.');</script>";
    }
} else {
    // Tangani berbagai error saat upload file
    if (isset($_FILES['file_upload']['error'])) {
        switch ($_FILES['file_upload']['error']) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                echo "<script>alert('Ukuran file terlalu besar!');</script>";
                break;
            case UPLOAD_ERR_PARTIAL:
                echo "<script>alert('File hanya terunggah sebagian. Coba lagi.');</script>";
                break;
            case UPLOAD_ERR_NO_FILE:
                echo "<script>alert('Tidak ada file yang diunggah.');</script>";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                echo "<script>alert('Server error: folder temp tidak ditemukan.');</script>";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                echo "<script>alert('Gagal menyimpan file di server.');</script>";
                break;
            case UPLOAD_ERR_EXTENSION:
                echo "<script>alert('Upload file diblokir oleh ekstensi PHP.');</script>";
                break;
            default:
                echo "<script>alert('Terjadi kesalahan saat mengunggah file.');</script>";
                break;
        }
    }
}



// Fungsi untuk rename file/folder
if (isset($_POST['rename'])) {
    $oldName = $_POST['old_name'];
    $newName = $_POST['new_name'];
    rename($currentDir . "/" . $oldName, $currentDir . "/" . $newName);
}

// Fungsi untuk menghapus file/folder
if (isset($_POST['delete'])) {
    $target = $currentDir . "/" . $_POST['delete_name'];

    if (is_dir($target)) {
        // Hapus folder beserta isinya
        function deleteFolder($folder) {
            foreach (scandir($folder) as $item) {
                if ($item == '.' || $item == '..') continue;
                $itemPath = $folder . DIRECTORY_SEPARATOR . $item;
                is_dir($itemPath) ? deleteFolder($itemPath) : unlink($itemPath);
            }
            return rmdir($folder);
        }
        deleteFolder($target);
    } elseif (file_exists($target)) {
        unlink($target);
    }
}


// Dapatkan daftar file dan folder dalam direktori saat ini
$items = scandir($currentDir);
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LPB Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<!-- ✅ Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <!-- PLN Management ke kiri -->
        <a class="navbar-brand ms-3" href="dashboard.php">PLN Management</a>
        
        <!-- Menu Toggler untuk Responsiveness -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu Home & Logout ke kanan -->
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto me-3">
                <li class="nav-item"><a class="nav-link" href="dashboard.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="backend/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>


<style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            background: linear-gradient(to bottom, #2d5dcc, #1e3a8a);
            color: white;
            padding: 20px;
            overflow-y: auto;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        .content {
            margin-left: 260px;
            padding: 20px;
            height: 100vh; /* Gunakan tinggi penuh layar */
            overflow-y: auto; /* Scroll hanya di dalam main content */
        }
        .table thead {
            background-color: yellow;
        }
        .table tbody td {
            background-color: #d8e9f3;
        }
        .card {
    background: transparent; /* Membuat background card transparan */
    border: none; /* Menghapus border card */
    box-shadow: none; /* Menghapus bayangan card */
}
.card-body {
    background: transparent; /* Membuat body card juga transparan */
}

    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="jam_nyala.php">⏳ Monitoring</a>
        <a href="lpb.php">📜 Laporan LPB</a>
    </div>

<!-- ✅ Konten Halaman LPB -->
<section class="content">
    <h2 class="text-center">Ini adalah halaman LPB</h2>

    <h3>📂 Isi Folder: <?= str_replace($rootDir, "", $currentDir) ?></h3>

    <?php if (isset($_GET['dir']) && $_GET['dir'] != ""): ?>
    <?php 
        $currentPath = $_GET['dir'];
        $parentPath = substr($currentPath, 0, strrpos($currentPath, "/")); 
        $backLink = empty($parentPath) ? "lpb.php" : "lpb.php?dir=" . $parentPath;
    ?>
<a href="<?= $backLink ?>" class="btn btn-transparent mb-3">🔙 Kembali</a>

<?php endif; ?>

    <!-- ✅ Tampilkan Folder dalam Grid -->
<h3>📂 Folder</h3>
<div class="row">
    <?php foreach ($items as $item): ?>
        <?php if ($item != "." && $item != ".." && is_dir($currentDir . "/" . $item)): ?>
            <div class="col-md-3 mb-3">
                <div class="d-flex align-items-center justify-content-between bg-light p-3 rounded">
                    <a href="lpb.php?dir=<?= isset($_GET['dir']) ? $_GET['dir'] . "/" . $item : $item ?>" class="text-decoration-none text-dark">
                        <span>📁</span> <?= $item ?>
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-light border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">⋮</button>
                        <ul class="dropdown-menu">
                            <li>
                                <form method="POST" class="px-3">
                                    <input type="hidden" name="old_name" value="<?= $item ?>">
                                    <input type="text" name="new_name" class="form-control form-control-sm" placeholder="Rename">
                                    <button type="submit" name="rename" class="btn btn-sm btn-primary mt-2">Ubah Nama</button>
                                </form>
                            </li>
                            <li>
                                <form method="POST">
                                    <input type="hidden" name="delete_name" value="<?= $item ?>">
                                    <button type="submit" name="delete" class="dropdown-item text-danger">Hapus</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>



<div class="row">
    <?php foreach ($items as $item): ?>
        <?php if ($item != "." && $item != ".." && is_file($currentDir . "/" . $item)): ?>
            <div class="col-md-2 mb-2">
                <div class="card">
                    <a href="<?= $currentDir . "/" . $item ?>" target="_blank">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/8/87/PDF_file_icon.svg" class="card-img-top" style="height:50px; object-fit:contain;">
                    </a>
                    <div class="card-body text-center">
                        <p class="card-text"><?= $item ?></p>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="delete_name" value="<?= $item ?>">
                            <button type="submit" name="delete" class="btn btn-sm btn-danger">🗑 Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>



    <!-- Tombol Dropdown -->
<div class="dropdown mb-3">
    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
        ➕ Tambah
    </button>
    <ul class="dropdown-menu">
        <li>
            <button class="dropdown-item" onclick="showCreateFolderModal()">
                📂 Folder baru
            </button>
        </li>
        <li>
            <button class="dropdown-item" onclick="document.getElementById('fileUploadInput').click()">
                📄 Upload file
            </button>
            <input type="file" id="fileUploadInput" class="d-none" onchange="uploadFile()" />
        </li>
        <li>
            <button class="dropdown-item" onclick="document.getElementById('folderUploadInput').click()">
                📁 Upload folder
            </button>
            <input type="file" id="folderUploadInput" class="d-none" webkitdirectory directory onchange="uploadFolder()" />
        </li>
    </ul>
</div>

<!-- Modal Buat Folder -->
<div class="modal fade" id="createFolderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">📁 Buat Folder Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <input type="text" name="folder_name" class="form-control" placeholder="Nama Folder" required>
                    <button type="submit" name="create_folder" class="btn btn-primary mt-2">Buat</button>
                </form>
            </div>
        </div>
    </div>
</div>
</section>

<script>
    document.getElementById("fileUploadInput").addEventListener("change", function() {
        let file = this.files[0];
        if (file) {
            let formData = new FormData();
            formData.append("file_upload", file);

            fetch("lpb.php?dir=<?= $_GET['dir'] ?? '' ?>", {
                method: "POST",
                body: formData
            }).then(response => response.text()).then(data => {
                alert("File berhasil diunggah!");
                location.reload();
            }).catch(error => console.error("Error:", error));
        }
    });
</script>

<script>
    function showCreateFolderModal() {
        var myModal = new bootstrap.Modal(document.getElementById('createFolderModal'));
        myModal.show();
    }

    function uploadFile() {
        let fileInput = document.getElementById("fileUploadInput");
        if (fileInput.files.length > 0) {
            alert("Mengunggah file: " + fileInput.files[0].name);
            // TODO: Tambahkan AJAX untuk upload file ke server
        }
    }

    function uploadFolder() {
        let folderInput = document.getElementById("folderUploadInput");
        if (folderInput.files.length > 0) {
            alert("Mengunggah folder: " + folderInput.files[0].webkitRelativePath.split('/')[0]);
            // TODO: Tambahkan AJAX untuk upload folder ke server
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

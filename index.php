<?php  
session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

require "functions.php";
$mahasiswa = query("SELECT * FROM mahasiswa");

if(isset($_POST['cari'])){
    $mahasiswa = cari($_POST['keyword']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>php dengan database</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/script.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 2rem;
            min-height: 100vh;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #2d3748;
            margin-bottom: 1.5rem;
            font-size: 1.8rem;
        }

        .btn-tambah {
            display: inline-block;
            padding: 0.6rem 1.2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: transform 0.2s ease;
        }
        .btn-logout {
            display: inline-block;
            padding: 0.6rem 1.2rem;
            background: linear-gradient(135deg,rgb(234, 142, 102) 0%,rgb(162, 75, 75) 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: transform 0.2s ease;
        }

        .btn-tambah:hover {
            transform: translateY(-2px);
        }
        .btn-logout:hover {
            transform: translateY(-2px);
        }

        .search-form {
            margin: 1.5rem 0;
            display: flex;
            gap: 0.5rem;
        }

        .search-form input {
            flex: 1;
            padding: 0.8rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: border-color 0.3s ease;
        }

        .search-form input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .search-form button {
            padding: 0.8rem 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .search-form button:hover {
            transform: translateY(-1px);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1.5rem;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        th {
            background-color: #f7fafc;
            color: #2d3748;
            font-weight: 600;
        }

        tr:hover {
            background-color: #f7fafc;
        }

        img {
            border-radius: 8px;
            object-fit: cover;
        }

        .aksi a {
            text-decoration: none;
            padding: 0.3rem 0.5rem;
            border-radius: 5px;
            transition: all 0.2s ease;
        }

        .aksi a[href*="update"] {
            color: #667eea;
            margin-right: 0.5rem;
        }

        .aksi a[href*="hapus"] {
            color: #e53e3e;
        }

        .aksi a:hover {
            background-color: rgba(102, 126, 234, 0.1);
        }

        @media (max-width: 768px) {
            .container {
                padding: 1.5rem;
            }
            
            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
        }
        .image-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 999;
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.3s ease;
        }

        .modal-content {
            max-width: 90%;
            max-height: 90%;
            background: white;
            border-radius: 10px;
            padding: 1rem;
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .modal-content img {
            max-width: 100%;
            max-height: 80vh;
            border-radius: 8px;
            display: block;
            margin: 0 auto;
        }

        .close-btn {
            position: absolute;
            top: -15px;
            right: -15px;
            background: #fff;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            font-size: 1.5rem;
            color: #667eea;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .thumbnail {
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .thumbnail:hover {
            transform: scale(1.05);
        }

        .loader{
            width: 50px;
            display: none;
            
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Daftar Mahasiswa</h1>
        <a href="tambah.php" class="btn-tambah">Tambah Data Mahasiswa</a>
        <a href="logout.php" class="btn-logout">Logout</a>
        
        <form action="" method="post" class="search-form">
            <input type="text" 
                placeholder="Cari nama mahasiswa..." 
                name="keyword" 
                autofocus 
                autocomplete="off"
                id="keyword"
                value="<?php // htmlspecialchars($keyword)?>"> 
                <button type="submit" name="cari" id="tombol-cari">Cari!</button>
                <img src="img/loader.gif" class="loader" >
        </form>

        <div id="container-table">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Aksi</th>
                        <th>Gambar</th>
                        <th>NRP</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Jurusan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $nomor=1; foreach($mahasiswa as $row): ?>
                    <tr>
                        <td><?= $nomor; ?></td>
                        <td class="aksi">
                            <a href="update.php?id=<?= $row["id"];?>">Ubah</a>
                            <a href="hapus.php?id=<?= $row["id"];?>" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                        </td>
                        <td>
                            <img src="img/<?= $row["gambar"]; ?>" 
                                class="thumbnail" 
                                width="80" 
                                height="80" 
                                alt="Foto Profil"
                                onclick="showImage('img/<?= $row['gambar']; ?>')">
                        </td>
                        <td><?= $row["nrp"]; ?></td>
                        <td><?= $row["nama"]; ?></td>
                        <td><?= $row["email"]; ?></td>
                        <td><?= $row["jurusan"]; ?></td>
                    </tr>
                    <?php $nomor++; endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div id="imageModal" class="image-modal" onclick="closeModal()">
            <div class="modal-content" onclick="event.stopPropagation()">
                <span class="close-btn" onclick="closeModal()">&times;</span>
                <img id="expandedImg">
            </div>
    </div>
    <script>
        // Tambahkan script ini
        function showImage(src) {
            const modal = document.getElementById('imageModal');
            const expandedImg = document.getElementById('expandedImg');
            expandedImg.src = src;
            modal.style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('imageModal').style.display = 'none';
        }

        // Tutup modal dengan tombol ESC
        document.addEventListener('keydown', (e) => {
            if(e.key === 'Escape') closeModal();
        });
    </script>
</body>
</html>
<?php 
session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}
include "functions.php";

if(isset($_POST["submit"])){
    if(ubah($_POST,$_GET["id"])>0){
        echo "<script>
        alert('Data berhasil disimpan!');
        document.location.href = 'index.php';
        </script>";
    }else{
        echo "<script>
        alert('Data gagal disimpan!');
        document.location.href = 'index.php';
        </script>";
    }
}else{
    $mahasiswa = $_GET["id"];
    $query = "SELECT * FROM mahasiswa where id=$mahasiswa";
    $data = query($query)[0];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Mahasiswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        h1 {
            color: #2d3748;
            margin-bottom: 2rem;
            text-align: center;
            font-size: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #4a5568;
            font-weight: 500;
        }

        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="file"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .preview-img {
            display: block;
            margin: 10px auto;
            max-height: 200px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        button[type="submit"] {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: transform 0.2s ease;
            margin-top: 1rem;
        }

        button[type="submit"]:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Data Mahasiswa</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $_GET["id"] ?>">
            <input type="hidden" name="gambarLama" value="<?= $data["gambar"] ?>">

            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" name="nama" id="nama" value="<?= $data["nama"] ?>" required>
            </div>

            <div class="form-group">
                <label for="nrp">NRP:</label>
                <input type="text" name="nrp" id="nrp" value="<?= $data["nrp"] ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" name="email" id="email" value="<?= $data["email"] ?>" required>
            </div>

            <div class="form-group">
                <label for="jurusan">Jurusan:</label>
                <input type="text" name="jurusan" id="jurusan" value="<?= $data["jurusan"] ?>" required>
            </div>

            <div class="form-group">
                <label for="gambar">Gambar:</label>
                <img src="img/<?= $data["gambar"] ?>" class="preview-img" id="preview" alt="Preview Gambar">
                <input type="file" name="gambar" id="gambar" accept="image/*">
            </div>

            <button type="submit" name="submit">Simpan Perubahan</button>
        </form>
    </div>

    <script>
        document.getElementById('gambar').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>

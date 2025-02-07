<?php 
session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}
include "functions.php";
$conn = mysqli_connect("localhost","root","","phpdasar");

if(isset($_POST["submit"])){
    $hasil_query = tambah($_POST);

    //cek apakah data berhasil di tambahkan
    if($hasil_query>0){
        echo "<script>
        alert('Data berhasil ditambahkan!');
        document.location.href = 'index.php';
        </script>";
    }else{
        echo "<script>
        alert('Data gagal ditambahkan!');
        document.location.href = 'index.php';
        </script>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Mahasiswa</title>
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

        .file-input {
            position: relative;
            overflow: hidden;
        }

        .file-input input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            cursor: pointer;
            height: 100%;
            width: 100%;
        }

        .custom-file-upload {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            background: #f7fafc;
            border: 2px dashed #cbd5e0;
            border-radius: 8px;
            cursor: pointer;
            color: #4a5568;
            transition: all 0.3s ease;
            width: 100%;
            text-align: center;
        }

        .custom-file-upload:hover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.05);
        }

        @media (max-width: 768px) {
            .container {
                padding: 1.5rem;
            }
            
            h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah Data Mahasiswa</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" name="nama" id="nama" required>
            </div>

            <div class="form-group">
                <label for="nrp">NRP:</label>
                <input type="text" name="nrp" id="nrp" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" name="email" id="email" required>
            </div>

            <div class="form-group">
                <label for="jurusan">Jurusan:</label>
                <input type="text" name="jurusan" id="jurusan" required>
            </div>

            <div class="form-group">
                <label for="gambar">Gambar:</label>
                <div class="file-input">
                    <input type="file" name="gambar" id="gambar" required>
                    <label for="gambar" class="custom-file-upload">
                        Pilih File Gambar
                    </label>
                </div>
            </div>

            <button type="submit" name="submit">Tambah Data</button>
        </form>
    </div>

    <script>
        // Script untuk menampilkan nama file yang dipilih
        document.getElementById('gambar').addEventListener('change', function(e) {
            const fileName = e.target.files[0].name;
            document.querySelector('.custom-file-upload').textContent = fileName;
        });
    </script>
</body>
</html>
<?php 
$hostname="localhost";
$username="root";
$password="";
$database="phpdasar";

$conn = mysqli_connect($hostname,$username,$password,$database);

function query($query){
    global $conn;
    $result = mysqli_query($conn,$query);
    //mysqli_query() berfungsi untuk mengambil tabel
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)){
        //mysqli_fetch_assoc() berfungsi untuk mengambil row dari tabel yang sudah dipanggil di mysqli_query()
        $rows[]=$row; //memasukkan baris dari table ke dalam rows, sehingga rows menjadi sebuah array yang berisi data baris table
    }
    return $rows;
}

function tambah($data){ 
    //htmlspecialchars agar ketika user menginputkan elemen HTML tidak diproses di web
    global $conn;
    $nrp = htmlspecialchars($data["nrp"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);

    //upload gambar
    $gambar = upload();
    if(!$gambar){
        return false;
    }

    $query = "INSERT INTO mahasiswa (nrp,nama,email,jurusan,gambar)
    values ('$nrp','$nama','$email','$jurusan','$gambar')";
    mysqli_query($conn,$query);

    return mysqli_affected_rows($conn);
}

function upload(){
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    //cek apakah tidak ada gambar yang diupload
    if($error === 4){
        echo "<script>
                alert('pilih gambar terlebih dahulu!');
                </script>";
        return false;
    }

    //apakah yang diupload gambar atau bukan
    $ekstensiGambarValid = ['jpg','jpeg','png'];
    $ekstensiGambar = explode('.',$namaFile); //explode function untuk memisah string
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if(!in_array($ekstensiGambar,$ekstensiGambarValid)){
        echo "<script>
                alert('Pastikan file yang anda upload adalah gambar');
                </script>";
        return false;
    }

    //apakah ukuran gambar sesuai
    if($ukuranFile > 1000000){
        echo "<script>
                alert('Ukuran gambar terlalu besar');
                </script>";
        return false;
    }

    //generate nama gambar baru
    $namaFileBaru = uniqid(). '.' . $ekstensiGambar;
    //gambar siap diupload
    move_uploaded_file($tmpName,'img/' . $namaFileBaru);
    return $namaFileBaru;
}

function hapus($data){
    global $conn;

    $query = "DELETE FROM mahasiswa where id=$data";
    mysqli_query($conn,$query);

    return mysqli_affected_rows($conn);
}

function ubah($data, $id){
    global $conn;
    $nrp = htmlspecialchars($data["nrp"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $gambarLama = htmlspecialchars($data["gambarLama"]);
    
    //cek apakah user pilih gambar baru atau tidak
    if($_FILES["gambar"]['error'] === 4){
        $gambar = $gambarLama;
    }else{
        $gambar=upload();
    }

    $query = "UPDATE mahasiswa set nama='$nama', nrp='$nrp', email='$email', jurusan='$jurusan', gambar='$gambar' where id=$id";
    mysqli_query($conn,$query);
    return mysqli_affected_rows($conn);
}

function cari($keyword){
    $query = "SELECT * FROM mahasiswa where 
    nama LIKE '%$keyword%' OR
    nrp LIKE '%$keyword%' OR
    email LIKE '%$keyword%' OR
    jurusan LIKE '%$keyword%'";
    return query($query);
}

function registrasi($data){
    global $conn;
    $username = strtolower(stripslashes($data['username']));
    $password = mysqli_real_escape_string($conn, $data['password']);
    $password2 = mysqli_real_escape_string($conn, $data['password2']);

    //cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username from user where username='$username';");
    if(mysqli_fetch_assoc($result)){
        echo "<script>
                alert('username sudah terdaftar!')
                </script>";
        return false;
    }

    if($password!==$password2){
        echo "<script>
                alert('konfirmasi password tidak sesuai');
                </script>";
        return false;
    }

    //enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO user
    values('','$username', '$password');";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}
?>
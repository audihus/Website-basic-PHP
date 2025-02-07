<?php 
usleep(500000);
include "../functions.php";
$keyword = $_GET['keyword'];
$query = "SELECT * FROM mahasiswa where 
        nama LIKE '%$keyword%' OR
        nrp LIKE '%$keyword%' OR
        email LIKE '%$keyword%' OR
        jurusan LIKE '%$keyword%'";
$mahasiswa = query($query);
?>
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
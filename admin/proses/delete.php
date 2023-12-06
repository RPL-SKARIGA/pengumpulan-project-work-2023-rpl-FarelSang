<?php
include '../sidebar.php';
include '../../connection/koneksi.php';
$id = $_GET['id'];

$query_lihat = "select * from tb_masakan where id_masakan = $id";
$sql_lihat = mysqli_query($conn, $query_lihat);
$result_lihat = mysqli_fetch_array($sql_lihat);
if (file_exists('gambar/' . $result_lihat['gambar_masakan'])) {
    unlink('gambar/' . $result_lihat['gambar_masakan']);
}

$sql = "DELETE FROM tb_masakan WHERE id_masakan = $id";
$result = mysqli_query($conn, $sql);
if (!$result) {
    echo "<script>alert('Menu Gagal Di Hapus');window.location.href='../menu.php'</script>";
} else {
    echo "<script>alert('Menu Berhasil Di Hapus');window.location.href='../menu.php'</script>";
}

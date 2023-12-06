<?php 
    include '../sidebar.php';
    include '../../connection/koneksi.php';
    $id = $_GET['id'];
    $sql = "DELETE FROM user WHERE id_user = $id";
    $result = mysqli_query($conn, $sql);    
    if (!$result) {
        echo "gakenek";
    }else {
        echo "<script>alert('User Berhasil Di Hapus');window.location.href='../kasir.php'</script>";
    }

    
?>
<?php
ob_start();
include '../connection/koneksi.php';
include '../admin/sidebar.php';
$id = $_GET['id'];
$query_data_edit = "select * from user where id_user = $id";
$sql_data_edit = mysqli_query($conn, $query_data_edit);
$result_data_edit = mysqli_fetch_array($sql_data_edit);

$id_user = $result_data_edit['id_user'];
$username_kasir = $result_data_edit['username'];
$password = $result_data_edit['password'];
$nama = $result_data_edit['nama_user'];
?>

<head>
    <title>Steak & milk</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <script src="tailwind.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="template/dashboard/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>

<body class="ml-52">

    <div class="container">
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="font-mono">
                        <div class="text-4xl font-bold ml-3 mt-4 mb-4">
                            <h5 class="ml-10"><span class="material-symbols-outlined">edit</span>Edit Kasir</h5>
                        </div>
                    <div class="border-4 border-slate-500 rounded-lg mx-60 w-[800px]">
                        <form action="" method="post" class="ml-10" accept-charset="UTF-8" enctype="multipart/form-data">
                            <div class="mt-5">
                                <label class="">Nama Kasir:</label>
                                <div class="border border-slate-600 rounded w-[187px] ml-5">
                                    <input name="" type="text" value="<?php echo $username_kasir; ?>" class="span11" placeholder="Username Kasir" />
                                    <input name="username_kasir" type="hidden" value="<?php echo $username_kasir; ?>" class="span11" placeholder="Username Kasir" />
                                </div>
                            </div>
                            <div>
                                <label class="control-label">Password</label>
                                <div class="border border-slate-600 rounded w-[187px] ml-5">
                                    <input required name="password" type="text" value="<?php echo $password; ?>" class="span11" placeholder="   Password" />
                                </div>
                            </div>
                            <div class="mb-5">
                                <label class="control-label">Nama :</label>
                                <div class="border border-slate-600 rounded w-[187px] ml-5">
                                    <input required name="nama" value="<?php echo $nama; ?>" type="text" class="span11" placeholder="   Nama" />
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" name="ubah_kasir" class="bg-blue-500 hover:bg-blue-800 items-center text-center rounded mb-5"><span class="material-symbols-outlined">save</span>&nbsp; Simpan Perubahan</button>

                                <a href="../admin/kasir.php"><button type="submit" class="bg-red-500 hover:bg-red-700 items-center text-center rounded"><span class="material-symbols-outlined">cancel</span>&nbsp; Batalkan</a></a>
                            </div>
                    </div>
                    </form>
                    <?php
                    if (isset($_POST['ubah_kasir'])) {
                        $username_kasir = $_POST['username_kasir'];
                        $password = $_POST['password'];
                        $nama = $_POST['nama'];
                        $query_ubah_kasir = "update tb_user set username = '$username_kasir', password = '$password', nama_user = '$nama'where id_user = '$id_user'";
                        $sql_ubah_kasir = mysqli_query($conn, $query_ubah_kasir);
                        if ($sql_ubah_kasir) {
                            echo "<script>alert('Berhasil Mengubah');window.location.href='../admin/kasir.php'</script>";
                        }else {
                            echo "<script>alert('Gagal Mengubah');window.location.href='../admin/kasir.php'</script>";

                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    </div>

</body>
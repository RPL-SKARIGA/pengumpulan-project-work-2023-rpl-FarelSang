<?php
include "../connection/koneksi.php";
include "../admin/sidebar.php";


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
                        <h5 class="ml-10"><span class="material-symbols-outlined">add_circle</span>Tambah Akun Kasir</h5>
                    </div>
                    <div class="border-4 border-slate-500 rounded-lg mx-60 w-[800px]">
                        <form action="" method="post" class="ml-10" accept-charset="UTF-8" enctype="multipart/form-data">
                            <div class="mt-5">
                                <label class="">Username Kasir:</label>
                                <div class="border border-slate-600 rounded w-[187px] ml-5">
                                        <input required name="username_kasir" type="text" value="" class="span11" placeholder="  Username Kasir" />
                                </div>
                            </div>
                            <div>
                                <label class="control-label">Password :</label>
                                <div class="border border-slate-600 rounded w-[187px] ml-5">
                                    <input required name="password" type="text" value="" class="span11" placeholder="   Password" />
                                </div>
                            </div>
                            <div class="mb-6">
                                <label class="control-label">Nama Kasir :</label>
                                <div class="border border-slate-600 rounded w-[187px] ml-5">
                                    <input required name="nama" value="" type="text" class="span11" placeholder="   Nama Kasir" />
                                </div>
                            </div>
                            <div class="form-actions">
                                <?php
                                if (isset($_SESSION['edit_menu'])) {
                                ?>
                                    <button type="submit" name="ubah_menu" class="bg-blue-500 hover:bg-blue-800 items-center text-center rounded mb-5"><span class="material-symbols-outlined">save</span>&nbsp; Simpan Perubahan</button>
                                <?php
                                } else {
                                ?>
                                    <div class="container w-60 mb-5">
                                        <button type="submit" name="tambah_kasir" class="bg-blue-500 hover:bg-blue-800 items-center text-center rounded"><span class="material-symbols-outlined">add_box</span>&nbsp;Tambahkan</button>
                                    <?php
                                }
                                    ?>
                                    <a href="../admin/kasir.php"><button type="submit" class="bg-red-500 hover:bg-red-700 items-center text-center rounded"><span class="material-symbols-outlined">cancel</span>&nbsp; Batalkan</a></a>
                                    </div>
                            </div>
                            <?php
                            if (empty($_POST["username_kasir"])) {
                                $errors[] = "Nama tidak boleh kosong.";
                            }

                            ?>
                        </form>
                        <?php
                        if (isset($_POST['tambah_kasir'])) {
                            $username_kasir = $_POST['username_kasir'];
                            $password = $_POST['password'];
                            $nama = $_POST['nama'];
                            $query_tambah_kasir = "insert into user values ('','$username_kasir','$password','$nama', '1','aktif','kasir')";
                            $sql_tambah_kasir = mysqli_query($conn, $query_tambah_kasir);
                            if ($sql_tambah_kasir) {
                                echo "<script>alert('Berhasil Menambahkan');window.location.href='../admin/kasir.php'</script>";
                            }else{
                                echo "<script>alert('Gagal');window.location.href='../admin/kasir.php'</script>";
                            }
                        }
                        if (isset($_REQUEST['batal_menu'])) {
                            //echo $_REQUEST['hapus_menu'];
                            if (isset($_SESSION['edit_menu'])) {
                                unset($_SESSION['edit_menu']);
                            }
                            header('location: ../admin/menu.php');
                        }

                        if (isset($_POST['ubah_menu'])) {
                            $nama_masakan = $_POST['nama_masakan'];
                            $harga = $_POST['harga'];
                            $stok = $_POST['stok'];
                            if ($stok > 0) {
                                $status_masakan = 'tersedia';
                            } else {
                                $status_masakan = 'habis';
                            }
                            $gbr = $_FILES["gambar"]["name"];

                            $query_ubah_masakan = "update tb_masakan set nama_masakan = '$nama_masakan', harga = '$harga', stok = '$stok', status_masakan = '$status_masakan' where id_masakan = '$id_masakan'";;
                            $sql_ubah_masakan = mysqli_query($conn, $query_ubah_masakan);

                            //$gambar = file($_POST['gambar']);
                            if ($gbr != "" || $gbr != null) {
                                $direktori = "gambar/";

                                $tmp_name = $_FILES["gambar"]["tmp_name"];
                                $name = pathinfo($_FILES["gambar"]["name"], PATHINFO_EXTENSION);
                                $nama_baru = $_POST['nama_masakan'] . "." . $name;
                                unlink('gambar/' . $gambar_masakan);
                                move_uploaded_file($tmp_name, $direktori . "/" . $nama_baru);
                                $gambar = $nama_baru;

                                $query_ubah_gambar = "update tb_masakan set gambar_masakan = '$gambar' where id_masakan = '$id_masakan'";;
                                $sql_ubah_gambar = mysqli_query($conn, $query_ubah_gambar);
                            }

                            if ($sql_ubah_masakan) {
                                unset($_SESSION['edit_menu']);
                                header('location: entri_referensi.php');
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
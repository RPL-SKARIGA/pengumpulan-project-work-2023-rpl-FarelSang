<?php
ob_start();
include '../connection/koneksi.php';
include '../admin/sidebar.php';
$id = $_GET['id'];

$query_data_edit = "select * from tb_masakan where id_masakan = $id";
$sql_data_edit = mysqli_query($conn, $query_data_edit);
$result_data_edit = mysqli_fetch_array($sql_data_edit);

$id_masakan = $result_data_edit['id_masakan'];
$nama_masakan = $result_data_edit['nama_masakan'];
$harga = $result_data_edit['harga'];
$stok = $result_data_edit['stok'];
$gambar_masakan = $result_data_edit['gambar_masakan'];

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
                    <?php
                    if (isset($_SESSION['edit_menu'])) { ?>
                        <div class="text-4xl font-bold ml-3 mt-4 mb-4">
                            <h5 class="ml-10"><span class="material-symbols-outlined">edit</span>Edit Menu</h5>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="text-4xl font-bold ml-3 mt-4 mb-4">
                            <h5 class="ml-10"><span class="material-symbols-outlined">add_circle</span>Tambah Menu</h5>
                        </div>
                    <?php } ?>
                    <div class="border-4 border-slate-500 rounded-lg mx-60 w-[800px]">
                        <form action="" method="post" class="ml-10" accept-charset="UTF-8" enctype="multipart/form-data">
                            <div class="mt-5">
                                <label class="">Nama Masakan:</label>
                                <div class="border border-slate-600 rounded w-[187px] ml-5">
                                    <input name="" type="text" value="<?php echo $nama_masakan; ?>" class="span11" placeholder="Nama Masakan" />
                                    <input name="nama_masakan" type="hidden" value="<?php echo $nama_masakan; ?>" class="span11" placeholder="Nama Masakan" />
                                </div>
                            </div>
                            <div>
                                <label class="control-label">Harga / Porsi :</label>
                                <div class="border border-slate-600 rounded w-[187px] ml-5">
                                    <input required name="harga" type="text" value="<?php echo $harga; ?>" class="span11" placeholder="   Rupiah" />
                                </div>
                            </div>
                            <div>
                                <label class="control-label">Stok Persediaan :</label>
                                <div class="border border-slate-600 rounded w-[187px] ml-5">
                                    <input required name="stok" value="<?php echo $stok; ?>" type="number" class="span11" placeholder="   Jumlah Stok" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Gambar Masakan :</label>
                                <div class="control-group">
                                    <div>
                                        <input value="" name="gambar" type="file" accept="image/*" onchange="preview(this,'previewne')" />
                                    </div>
                                </div>
                            </div>
                            <div class="mb-5">
                                <div class="control-group">
                                    <div class="controls">
                                        <img src="../gambar/<?php echo $gambar_masakan; ?>" id="previewne" class="rounded border p-1" style="width:220px; height:140px;">
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" name="ubah_menu" class="bg-blue-500 hover:bg-blue-800 items-center text-center rounded mb-5"><span class="material-symbols-outlined">save</span>&nbsp; Simpan Perubahan</button>

                                <a href="../admin/menu.php"><button type="submit" class="bg-red-500 hover:bg-red-700 items-center text-center rounded"><span class="material-symbols-outlined">cancel</span>&nbsp; Batalkan</a></a>
                            </div>
                    </div>
                    <?php
                    if (empty($_POST["nama_masakan"])) {
                        $errors[] = "Nama Masakan tidak boleh kosong.";
                    }

                    ?>
                    </form>
                    <?php
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
                            header('location: ../admin/menu.php');
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    </div>

</body>
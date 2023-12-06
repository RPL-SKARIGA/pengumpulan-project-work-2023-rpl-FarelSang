<?php
include "../connection/koneksi.php";
include "sidebar.php";
$kasir = $conn->query("SELECT * FROM user where role = 'kasir'")->fetch_all();
?>

<head>
    <title>Akun Kasir</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <script src="tailwind.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>

<div class="container" style="padding-bottom: 200px; width: 1200px; margin-left: 280px;">
    <table class="table table-striped mt-4">
        <thead class="border-y-2 border-gray-500">
            <tr>
                <th class="w-[100px]">No</th>
                <th class="w-[300px]">Username</th>
                <th class="w-[300px]">Password</th>
                <th class="w-[190px]">Nama</th>
                <th class="w-[100px]">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 0;
            foreach ($kasir as [$id, $username, $password, $nama, $lvl, $status, $role]) :
                $no++;
            ?>
                <tr class="border-y border-gray-500 text-center justify-center items-center">
                    <td><?= $no ?></td>
                    <td><?= $username ?></td>
                    <td><?= $password ?></td>
                    <td><?= $nama ?></td>
                    <td style="width: 200px" class="text-center">

                        <a href="edit_kasir.php?id=<?= $id ?>"><button class="bg-blue-600 hover:bg-gray-500 text-white rounded font-extralight mx-2 my-4 w-[50px] text-center" type="submit" value="<?php echo $r_dt_makanan['id_masakan']; ?>" name="edit_menu"><span class="material-symbols-outlined">edit</span></button></a>
                        <a href="proses/delete_kasir.php?id=<?= $id ?>"><button class="bg-red-600 hover:bg-gray-500 text-white rounded font-bold mx-2 my-4 w-[50px]" type="submit" value="<?php echo $r_dt_makanan['id_masakan']; ?>" name="hapus_menu"><span class="material-symbols-outlined">delete</span></button></a>

                    </td>
                </tr>
            <?php endforeach ?>
            <?php
            if (isset($_REQUEST['hapus_menu'])) {
                //echo $_REQUEST['hapus_menu'];
                $id_masakan = $_REQUEST['hapus_menu'];

                $query_lihat = "select * from tb_masakan where id_masakan = $id_masakan";
                $sql_lihat = mysqli_query($conn, $query_lihat);
                $result_lihat = mysqli_fetch_array($sql_lihat);
                if (file_exists('gambar/' . $result_lihat['gambar_masakan'])) {
                    unlink('gambar/' . $result_lihat['gambar_masakan']);
                }
                $query_hapus_masakan = "delete from tb_masakan where id_masakan = $id_masakan";
                $sql_hapus_masakan = mysqli_query($conn, $query_hapus_masakan);
                if ($sql_hapus_masakan) {
                    header('location: entri_referensi.php');
                }
            }

            if (isset($_REQUEST['edit_menu'])) {
                //echo $_REQUEST['hapus_menu'];
                $id_masakan = $_REQUEST['edit_menu'];
                $_SESSION['edit_menu'] = $id_masakan;
                header('location: tambah_menu.php');
            }
            ?>
        </tbody>

    </table>

    <a href="../admin/tambah_kasir.php">
        <button class="bg-green-500 my-5 w-[150px] rounded text-white">TAMBAH KASIR</button>
    </a>

</div>
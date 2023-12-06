<head>
    <title>Dashboard</title>
</head>
<?php
include "sidebar.php";
include "../connection/koneksi.php";
$jml1 = $conn->query("SELECT COUNT(*) as jml FROM tb_masakan")->fetch_assoc()['jml'];
$jml2 = $conn->query("SELECT COUNT(*) as jml FROM user where role = 'kasir'")->fetch_assoc()['jml'];
?>

<section>
    <a href="menu.php" class="mr-[100px] mt-[100px]">
        <div class="box font-bold text-2xl">
            <h3 class="my-7">MENU</h3>
            <h4><?php echo $jml1 ?></h4>
        </div>
    </a>

    <a href="#" class="mt-[100px]">
        <div class="box font-bold text-2xl">
            <h3 class="my-7">KASIR</h3>
            <h4><?php echo $jml2 ?></h4>
        </div>
    </a>
</section>
<style>
    section {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        /* Membuat kotak sejajar ke kanan */
        padding: 20px;
        margin-left: 200px;
    }

    .box {
        background-color: #fff;
        border: 1px solid #ddd;
        padding: 20px;
        margin: 10px;
        text-align: center;
        display: inline-block;
        width: 280px;
        height: 200px;
        /* Sesuaikan lebar kotak sesuai kebutuhan Anda */
        box-shadow: 2px 2px 9px rgba(0, 0, 0, 0.2);
    }

    @media screen and (max-width: 600px) {
        nav a {
            float: none;
            width: 100%;
        }

        section {
            flex-direction: column;
            /* Stack kotak di bawah satu sama lain pada layar kecil */
        }

        .box {
            width: 100%;
        }
    }
</style>

<?php
// } else {
//   header('location: logout.php');
// }
// ob_flush();
?>
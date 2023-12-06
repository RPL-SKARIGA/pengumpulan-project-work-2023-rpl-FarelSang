<!DOCTYPE html>

<?php
include "connection/koneksi.php";
include "topbar.php";
session_start();
ob_start();

$id = $_SESSION['id_user'];

if (isset($_SESSION['edit_order'])) {
  //echo $_SESSION['edit_order'];
  unset($_SESSION['edit_order']);
}

if (isset($_SESSION['username'])) {

  $query = "select * from user natural join tb_level where id_user = $id";

  mysqli_query($conn, $query);
  $sql = mysqli_query($conn, $query);

  while ($r = mysqli_fetch_array($sql)) {

    $nama_user = $r['nama_user'];

?>

    <html lang="en">

    <head>
      <title>Entri Transaksi</title>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <script src="https://cdn.tailwindcss.com"></script>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
      <link href="template/dashboard/font-awesome/css/font-awesome.css" rel="stylesheet" />
      <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
    </head>

    <body>

      <!--main-container-part-->
      <div class="container grid grid-cols-2">
        <?php
        if ($r['id_level'] == 1 || $r['id_level'] == 3) {
        ?>
          <div class="mx-4 my-[30px]">
            <div class="widget-box">
              <div class="widget-title bg_lg"><span class="icon"><i class="icon-th-large"></i></span>
                <h5 class="text-2xl text-center mb-6 font-serif">Belum Bayar</h5>
              </div>
              <div class="widget-content nopadding">
                <table class="border-black border-2">
                  <thead class="border-black border-2 bg-orange-500 text-black">
                    <tr>
                      <th class="border-r-2 border-black w-[100px]">No. Meja</th>
                      <th class="border-r-2 border-black w-[200px]">Pemesan</th>
                      <th class="border-r-2 border-black w-[200px]">Total Harga</th>
                      <th class="border-r-2 border-black w-[180px]">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $query_order = "select * from tb_order left join user on tb_order.id_pengunjung = user.id_user where status_order = 'belum bayar'";
                    $sql_order = mysqli_query($conn, $query_order);
                    while ($r_order = mysqli_fetch_array($sql_order)) {
                    ?>
                      <tr >
                        <td class="">
                          <center><?php echo $r_order['no_meja']; ?>. </center>
                        </td>
                        <td class="text-center"><?php echo $r_order['nama_user']; ?></td>
                        <td class="">
                          <center>Rp. <?php echo $r_order['total_harga']; ?>,-</center>
                        </td>
                        <td class="">
                          <form action="" method="post" class="text-center">
                            <button type="submit" value="<?php echo $r_order['id_order']; ?>" name="edit_order" class="bg-blue-500 w-20 text-white rounded">Transaksi</button>
                            <button type="submit" value="<?php echo $r_order['id_order']; ?>" name="hapus_order" class="bg-red-500 w-20 text-white rounded"><i class='icon icon-trash'></i>Hapus</button>
                          </form>
                        </td>
                      </tr>
                    <?php
                    }
                    if (isset($_REQUEST['edit_order'])) {
                      $id_order = $_REQUEST['edit_order'];
                      $_SESSION['edit_order'] = $id_order;
                      header('location: transaksi.php');
                    }

                    if (isset($_REQUEST['hapus_order'])) {
                      $id_order = $_REQUEST['hapus_order'];
                      $query_hapus_order = "delete from tb_order where id_order = $id_order";
                      $query_hapus_pesan_order = "delete from tb_pesan where id_order = $id_order";
                      $sql_hapus_order = mysqli_query($conn, $query_hapus_order);
                      $sql_hapus_pesan_order = mysqli_query($conn, $query_hapus_pesan_order);
                      if ($sql_hapus_order) {
                        header('location: entri_transaksi.php');
                      }
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="my-[30px]">
            <div class="widget-box">
              <div class="widget-title bg_lg"><span class="icon"><i class="icon-th-large"></i></span>
                <h5 class="text-2xl text-center mb-6 font-serif">Transaksi Terdahulu</h5>
              </div>
              <div class="widget-content nopadding">
                <table class="border-2 border-black">
                  <thead class="border-2 border-black bg-orange-500">
                    <tr>
                      <th class="border-r-2 border-black" style="width: 40px;">No.</th>
                      <th class="border-r-2 border-black" style="width: 170px;">Waktu Pesan</th>
                      <th class="border-r-2 border-black" style="width: 150px;">Nama Pemesan</th>
                      <th class="border-r-2 border-black" style="width: 70px;">No Meja</th>
                      <th class="border-r-2 border-black" style="width: 150px;">Total Harga</th>
                      <th class="border-r-2 border-black" style="width: 140px;">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $nomor = 1;
                    $query_sudah_order = "select * from tb_order left join user on tb_order.id_pengunjung = user.id_user where status_order = 'sudah bayar' order by id_order desc";
                    $sql_sudah_order = mysqli_query($conn, $query_sudah_order);
                    while ($r_sudah_order = mysqli_fetch_array($sql_sudah_order)) {
                    ?>
                      <tr>
                        <td>
                          <center><?php echo $nomor++; ?>. </center>
                        </td>
                        <td class="text-center"><?php echo $r_sudah_order['waktu_pesan']; ?></td>
                        <td class="text-center"><?php echo $r_sudah_order['nama_user']; ?></td>
                        <td class="text-center"><?php echo $r_sudah_order['no_meja']; ?></td>
                        <td class="text-center">Rp. <?php echo $r_sudah_order['total_harga']; ?>,-</td>
                        <td class="text-center">
                          <form action="" method="post" class="text-yellow-100">
                            <button type="submit" value="<?php echo $r_sudah_order['id_order']; ?>" name="hapus_transaksi" class="bg-red-500 rounded w-[60px]">Hapus</button>
                            <button type="submit" class="bg-blue-500 w-[60px] rounded"><a target='_blank' href="cetak_transaksi.php?konten=<?php echo $r_sudah_order['id_order']; ?>" >Cetak</a></button>
                          </form>
                        </td>
                      </tr>
                    <?php
                    }
                    if (isset($_REQUEST['hapus_transaksi'])) {
                      $id_order = $_REQUEST['hapus_transaksi'];
                      $query_hapus_transaksi = "delete from tb_order where id_order = $id_order";
                      $query_hapus_pesan = "delete from tb_pesan where id_order = $id_order";
                      $sql_hapus_transaksi = mysqli_query($conn, $query_hapus_transaksi);
                      $sql_hapus_pesan = mysqli_query($conn, $query_hapus_pesan);
                      if ($sql_hapus_transaksi) {
                        header('location: entri_transaksi.php');
                      }
                    }

                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        <?php
        }
        ?>
      </div>

      <script type="text/javascript">
        // This function is called from the pop-up menus to transfer to
        // a different page. Ignore if the value returned is a null string:
        function goPage(newURL) {

          // if url is empty, skip the menu dividers and reset the menu selection to default
          if (newURL != "") {

            // if url is "-", it is this page -- reset the menu:
            if (newURL == "-") {
              resetMenu();
            }
            // else, send page to designated URL            
            else {
              document.location.href = newURL;
            }
          }
        }

        // resets the menu selection upon entry to this page:
        function resetMenu() {
          document.gomenu.selector.selectedIndex = 2;
        }
      </script>
    </body>

    </html>
<?php
  }
} else {
  header('location: logout.php');
}
ob_flush();
?>
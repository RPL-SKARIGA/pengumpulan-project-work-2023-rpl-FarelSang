<!DOCTYPE html>

<?php
include "connection/koneksi.php";
include "topbar.php";
session_start();
ob_start();

$id = $_SESSION['id_user'];

if (isset($_SESSION['edit_menu'])) {
  echo $_SESSION['edit_menu'];
  unset($_SESSION['edit_menu']);
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
      <title>Transaksi</title>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <script src="https://cdn.tailwindcss.com"></script>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
      <link href="template/dashboard/font-awesome/css/font-awesome.css" rel="stylesheet" />
      <script src="jquery.js"></script>
      <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
    </head>

    <body>

      <div id="content">
        <div class="container text-center">
          <div class="row-fluid">
            <?php
            if ($r['id_level'] == 1) {
              $id_order = $_SESSION['edit_order'];
              $query_pemesan = "select * from tb_order left join user on tb_order.id_pengunjung = user.id_user where id_order = $id_order";
              $sql_pemesan = mysqli_query($conn, $query_pemesan);
              $result_pemesan = mysqli_fetch_array($sql_pemesan);
              $id_pemesan = $result_pemesan['id_pengunjung'];
            ?>
              <div class="span7">
                <div class="widget-box">
                  <div class="my-7 text-2xl font-bold"><span class="icon"><i class="icon-th-large"></i></span>
                    <h5>Transaksi Pembayaran</h5>
                  </div>
                  <div class="widget-content nopadding">
                    <table class="border-y-2 border-gray-600 mx-80">
                      <thead class="bg-orange-500 border">
                        <tr>
                          <th class="" style="width: 100px;">No.</th>
                          <th class="" style="width: 200px;">Menu</th>
                          <th class="" style="width: 100px;">Jumlah</th>
                          <th class="" style="width: 200px;">Harga</th>
                          <th class="" style="width: 250px;">Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $no_order_fiks = 1;
                        $query_order_fiks = "select * from tb_pesan left join tb_masakan on tb_pesan.id_masakan = tb_masakan.id_masakan where id_user = $id_pemesan and status_pesan != 'sudah'";
                        $sql_order_fiks = mysqli_query($conn, $query_order_fiks);
                        //echo $query_order_fiks;
                        while ($r_order_fiks = mysqli_fetch_array($sql_order_fiks)) {
                        ?>
                          <tr class="border-b-2 border-gray-600">
                            <td>
                              <center><?php echo $no_order_fiks++; ?>. </center>
                            </td>
                            <td><?php echo $r_order_fiks['nama_masakan']; ?></td>
                            <td class="right">
                              <center><?php echo $r_order_fiks['jumlah']; ?></center>
                            </td>
                            <td class="right">Rp. <?php echo $r_order_fiks['harga']; ?>,-</td>
                            <td class="right">
                              <strong>
                                Rp.
                                <?php
                                $hasil = $r_order_fiks['harga'] * $r_order_fiks['jumlah'];
                                echo $hasil;
                                ?>,-
                              </strong>
                            </td>
                          </tr>
                        <?php
                        }
                        $query_harga = "select * from tb_order where id_pengunjung = $id_pemesan and status_order = 'belum bayar'";
                        $sql_harga = mysqli_query($conn, $query_harga);
                        $result_harga = mysqli_fetch_array($sql_harga);
                        ?>

                        <tr>
                          <td></td>
                          <td><strong>
                              <center>Total</center>
                            </strong></td>
                          <td class="right"></td>
                          <td class="right"></td>
                          <td class="right"><strong>Rp. <span id="total_biaya"><?php echo $result_harga['total_harga']; ?></span>,-</strong></td>
                        </tr>
                        <tr>
                          <td></td>
                          <td><strong>
                              <center>No. Meja</center>
                            </strong></td>
                          <td class="right"></td>
                          <td class="right"></td>
                          <td class="right">
                            <center><strong><?php echo $result_harga['no_meja']; ?></strong></center>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="widget-content nopadding">
                    <form action="#" method="post" class="form-horizontal">
                      <div class="my-5">
                        <div class="">
                          <label class="control-label">Membayar : Rp.</label>
                          <input type="number" id="uang_bayar" name="uang_bayar" class="border-2 border-gray-600" placeholder="" onchange="return operasi()" />
                        </div>
                      </div>
                      <div class="mb-5">
                        <div class="controls">
                          <label class="control-label">Kembalian : Rp.</label>
                          <input type="number" id="uang_kembali1" class="span11" placeholder="" disabled="" class="border-gray-600 border-2"/>
                          <input type="hidden" id="uang_kembali" name="uang_kembali" class="border-2 border-gray-600" placeholder="" />
                        </div>
                      </div>
                      <p></p>
                      <center>
                        <button type="submit" value="<?php echo $result_harga['id_order']; ?>" name="save_order" class="bg-blue-500 rounded text-white">
                          <i class='icon-print'></i>
                          &nbsp;&nbsp;Transaksi Selesai&nbsp;&nbsp;
                        </button>
                        <button type="submit" value="" name="back_order" class="bg-red-500 rounded text-white">
                          <i class='icon-remove'></i>
                          &nbsp;&nbsp;Kembali&nbsp;&nbsp;
                        </button>
                      </center>
                      <p></p><br>
                    </form>
                  </div>
                </div>
              </div>
            <?php
              if (isset($_REQUEST['back_order'])) {
                if (isset($_SESSION['edit_order'])) {
                  unset($_SESSION['edit_order']);
                  header('location: entri_transaksi.php');
                }
              }

              if (isset($_REQUEST['save_order'])) {
                if (isset($_SESSION['edit_order'])) {
                  unset($_SESSION['edit_order']);
                }
                $uang_bayar = $_POST['uang_bayar'];
                $uang_kembali = $_POST['uang_kembali'];
                $query_save_transaksi = "update tb_order set id_admin = $id, uang_bayar = $uang_bayar, uang_kembali = $uang_kembali, status_order = 'sudah bayar' where id_order = $id_order";
                echo $query_save_transaksi;
                $sql_save_transaksi = mysqli_query($conn, $query_save_transaksi);

                $query_selesai_pesan = "update tb_pesan set status_pesan = 'sudah' where id_user = $id_pemesan and status_pesan != 'sudah'";
                $sql_selesai_pesan = mysqli_query($conn, $query_selesai_pesan);
                if ($sql_selesai_pesan) {
                  header('location: entri_transaksi.php');
                }
              }
            }
            ?>
          </div>
          <!--End-Action boxes-->
        </div>
      </div>
      <script type="text/javascript">
        function operasi() {
          var total_biaya = $("#total_biaya").text();
          var uang_bayar = $("#uang_bayar").val();
          var kembalian = Number(uang_bayar - total_biaya);
          if (kembalian < 0) {
            alert("Uang pembayaran kurang !");
            return false;
          }
          $("#uang_kembali1").val(kembalian);
          $("#uang_kembali").val(kembalian);
        }
      </script>

      <script type="text/javascript">
        function goPage(newURL) {
          if (newURL != "") {
            if (newURL == "-") {
              resetMenu();
            } else {
              document.location.href = newURL;
            }
          }
        }

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
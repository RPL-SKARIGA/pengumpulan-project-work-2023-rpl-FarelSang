<!DOCTYPE html>
<html lang="en">
<?php
include "connection/koneksi.php";
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

    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
      <meta name="author" content="Creative Tim">
      <title>&nbsp;</title>

      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <script src="jquery.js"></script>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
      <script src="https://cdn.tailwindcss.com"></script>
      <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>

      <style>
        @page {
          size: auto;
        }

        body {
          background: rgb(204, 204, 204);
        }

        page {
          background: white;
          display: block;
          margin: 0 auto;
          margin-bottom: 0.5cm;
          box-shadow: 0 0 0.1cm rgba(0, 0, 0, 0.5);
        }

        page[size="A4"] {
          width: 29.7cm;
          height: 21cm;
        }

        page[size="A4"][layout="potrait"] {
          width: 29.7cm;
          height: 21cm;
        }

        page[size="A3"] {
          width: 29.7cm;
          height: 42cm;
        }

        page[size="A3"][layout="landscape"] {
          width: 42cm;
          height: 29.7cm;
        }

        page[size="A5"] {
          width: 14.8cm;
          height: 21cm;
        }

        page[size="A5"][layout="landscape"] {
          width: 21cm;
          height: 19.8cm;
        }

        page[size="dipakai"][layout="landscape"] {
          width: 20cm;
          height: 20cm;
        }

        @media print {

          body,
          page {
            margin: auto;
            box-shadow: 0;
          }
        }
      </style>


    </head>

    <body>

      <page size="dipakai" layout="landscape">
        <br>
        <div class="container w-[100px]">
          <span id="remove">
            <a class="bg-green-600 mt-0 ml-2 rounded" style="cursor: pointer;" id="ct"><span class="icon-print"></span>&nbsp; CETAK &nbsp;</a>
          </span>
        </div>
        <?php
        $id_order = $_REQUEST['konten'];
        $query_order = "select * from tb_order left join user on tb_order.id_pengunjung = user.id_user where id_order = $id_order";
        $sql_order = mysqli_query($conn, $query_order);
        $result_order = mysqli_fetch_array($sql_order);
        //echo $id_order
        ?>
        <center>
          <h4>
            STEAK AND MILK
          </h4>
          <span>
            Jl. Teyvat No. 103 Desa Mondstald, Kec. WolfVendom, Kab. DragonSpine, Genshin<br>
            Telp. +6200 0000 0000 || E-mail steakmilk@gmail.com
          </span>
        </center>
        <br><hr><br>
        <table style="width: 100%" class="ml-10">
          <tr>
            <td style="width: 15%">
              Nama Kasir
            </td>
            <td style="width: 5%">
              :
            </td>
            <td style="width: 80%">
              <?php echo $nama_user; ?>
            </td>
          </tr>
          <tr>
            <td>
              Waktu Pesan
            </td>
            <td>
              :
            </td>
            <td>
              <?php echo $result_order['waktu_pesan']; ?>
            </td>
          </tr>
          <tr>
            <td>
              No Meja
            </td>
            <td>
              :
            </td>
            <td>
              <?php echo $result_order['no_meja']; ?>
            </td>
          </tr>
        </table>
        <br>
        <hr>
        <br>
        <table class="ml-10 mb-10">
          <?php
          $no_order_fiks = 1;
          $query_order_fiks = "select * from tb_pesan natural join tb_masakan where id_order = $id_order";
          $sql_order_fiks = mysqli_query($conn, $query_order_fiks);
          //echo $query_order_fiks;
          while ($r_order_fiks = mysqli_fetch_array($sql_order_fiks)) {
          ?>
            <tr class="">
              <td class=" w-[155px] text-center"><?php echo $r_order_fiks['nama_masakan']; ?></td>
              <td class="text-center w-[100px]">
                <?php echo $r_order_fiks['jumlah']; ?>
              </td>
              <td class="text-center w-[200px]">Rp. <?php echo $r_order_fiks['harga']; ?>,-</td>
              <td class="text-right w-[200px]">
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
          $query_harga = "select * from tb_order where id_order = $id_order";
          $sql_harga = mysqli_query($conn, $query_harga);
          $result_harga = mysqli_fetch_array($sql_harga);
          ?>
        </table>
        <table class="ml-10">
          <tr>
            <td class="w-[100px]"></td>
            <td class="font-bold text-center" colspan="2">Total</td>
            <td class="w-[200px]"></td>
            <td class="text-right w-[250px]"><strong>Rp. <?php echo $result_harga['total_harga']; ?>,-</strong></td>
          </tr>
          <tr>
            <td></td>
            <td class="font-bold text-center" colspan="2">Uang Bayar</td>
            <td></td>
            <td class="text-right w-[250px]"><strong>Rp. <?php echo $result_harga['uang_bayar']; ?>,-</strong></td>
          </tr>
          <tr>
            <td></td>
            <td class="font-bold text-center" colspan="2">Uang Kembali</td>
            <td></td>
            <td class="text-right w-[250px]"><strong>Rp. <?php echo $result_harga['uang_kembali']; ?>,-</strong></td>
          </tr>
        </table>
        <br><br><br><hr><br>
        <center>
          <h5>
            TERIMAKASIH ATAS KUNJUNGANNYA
          </h5>
        </center>
        <br><hr>

      </page>
    </body>

<?php
  }
}
?>

<script type="text/javascript">
  document.getElementById('ct').onclick = function() {
    $("#remove").remove();
    window.print();
  }
  $(document).ready(function() {
    $("remove").remove();

  });
</script>
<!-- 
<script src="template/dashboard/js/excanvas.min.js"></script> 
<script src="template/dashboard/js/jquery.min.js"></script> 
<script src="template/dashboard/js/jquery.ui.custom.js"></script> 
<script src="template/dashboard/js/bootstrap.min.js"></script> 
<script src="template/dashboard/js/jquery.flot.min.js"></script> 
<script src="template/dashboard/js/jquery.flot.resize.min.js"></script> 
<script src="template/dashboard/js/jquery.peity.min.js"></script> 
<script src="template/dashboard/js/fullcalendar.min.js"></script> 
<script src="template/dashboard/js/matrix.js"></script> 
<script src="template/dashboard/js/matrix.dashboard.js"></script> 
<script src="template/dashboard/js/jquery.gritter.min.js"></script> 
<script src="template/dashboard/js/matrix.interface.js"></script> 
<script src="template/dashboard/js/matrix.chat.js"></script> 
<script src="template/dashboard/js/jquery.validate.js"></script> 
<script src="template/dashboard/js/matrix.form_validation.js"></script> 
<script src="template/dashboard/js/jquery.wizard.js"></script> 
<script src="template/dashboard/js/jquery.uniform.js"></script> 
<script src="template/dashboard/js/select2.min.js"></script> 
<script src="template/dashboard/js/matrix.popover.js"></script> 
<script src="template/dashboard/js/jquery.dataTables.min.js"></script> 
<script src="template/dashboard/js/matrix.tables.js"></script>  -->

</html>
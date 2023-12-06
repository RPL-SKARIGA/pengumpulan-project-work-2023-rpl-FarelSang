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
      <title>Entri Order</title>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <script src="https://cdn.tailwindcss.com"></script>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
      <link href="/your-path-to-fontawesome/css/fontawesome.css" rel="stylesheet">
      <link href="/your-path-to-fontawesome/css/brands.css" rel="stylesheet">
      <link href="/your-path-to-fontawesome/css/solid.css" rel="stylesheet">
      <script src="jquery.js"></script>
      <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
    </head>

    <body>

      <?php
      if ($r['id_level'] == 1 || $r['id_level'] == 2 || $r['id_level'] == 5) {
      ?>
        <?php
        $order = array();
        $query_lihat_order = "select * from tb_order";
        $sql_lihat_order = mysqli_query($conn, $query_lihat_order);
        while ($r_dt_order = mysqli_fetch_array($sql_lihat_order)) {
          if ($r_dt_order['status_order'] != 'sudah bayar') {
            array_push($order, $r_dt_order['id_pengunjung']);
          }
        }
        if (in_array($id, $order)) {
        ?>
          <div class="container text-center">
            <div class="">
              <div class="widget-box span12">
                <div class="widget-content">
                  <div class="my-5 font-bold text-lg">
                    Terimakasih, Anda telah melakukan pemesanan.<br>
                    Silahkan tunggu pesanan tiba di meja saudara. Apabila selesai menyantap hidangan, silahkan lakukan proses pembayaran di kasir !
                  </div>
                </div>
              </div>
            </div>
            <div class="">
              <div class="widget-box span12">
                <div class="mb-5 font-semibold text-lg">
                  <h5>Menu yang dipesan</h5>
                </div>
                <div class="justify-center">
                  <table class="border-black border-2 mx-56 justify-items-center">
                    <thead>
                      <tr>
                        <th class="border-black border-r-2 bg-orange-500" style="width: 150px">No.</th>
                        <th class="border-black border-r-2 bg-orange-500" style="width: 300px">Menu</th>
                        <th class="border-black border-r-2 bg-orange-500" style="width: 100px">Jumlah</th>
                        <th class="border-black border-r-2 bg-orange-500" style="width: 300px">Harga</th>
                        <th class="border-black border-r-2 bg-orange-500" style="width: 300px">Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no_order_fiks = 1;
                      $query_order_fiks = "select * from tb_pesan natural join tb_masakan where id_user = $id and status_pesan != 'sudah'";
                      $sql_order_fiks = mysqli_query($conn, $query_order_fiks);
                      //echo $query_order_fiks;
                      while ($r_order_fiks = mysqli_fetch_array($sql_order_fiks)) {
                      ?>
                        <tr class="border-black border-2 h-[50px]">
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
                      $query_harga = "select * from tb_order where id_pengunjung = $id and status_order = 'belum bayar'";
                      $sql_harga = mysqli_query($conn, $query_harga);
                      $result_harga = mysqli_fetch_array($sql_harga);
                      ?>
                      <tr class="border-black border-2 h-[50px] bg-gray-200">
                        <td></td>
                        <td><strong>
                            <center>Total</center>
                          </strong></td>
                        <td class="right"></td>
                        <td class="right"></td>
                        <td class="right"><strong>Rp. <?php echo $result_harga['total_harga']; ?>,-</strong></td>
                      </tr>
                        <tr class="border-black border-2 h-[50px]">
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
              </div>
            </div>
          </div>
        <?php
        } else {
        ?>
          <div class=" container grid grid-cols-2">
            <div class="container px-11 py-9 w-[900px]">
              <div class="grid grid-cols-3 content-center">
                <?php
                $pesan = array();

                $query_lihat_pesan = "select * from tb_pesan where id_user = $id and status_pesan != 'sudah'";
                $sql_lihat_pesan = mysqli_query($conn, $query_lihat_pesan);

                while ($r_dt_pesan = mysqli_fetch_array($sql_lihat_pesan)) {
                  array_push($pesan, $r_dt_pesan['id_masakan']);
                }

                $query_data_makanan = "select * from tb_masakan where stok > 0 order by id_masakan desc";
                $sql_data_makanan = mysqli_query($conn, $query_data_makanan);
                $no_makanan = 1;

                while ($r_dt_makanan = mysqli_fetch_array($sql_data_makanan)) {
                ?>
                  <table class="mb-3 font-mono text-xs">
                    <tbody class="rounded-lg">
                      <tr>
                        <td>
                          <div class="w-full h-full mb-3"><img class="object-fill object-center rounded-lg border-2 border-slate-500" style="min-height: 150px; min-width: 250px; max-height: 150px; max-width: 250px; " src="gambar/<?php echo $r_dt_makanan['gambar_masakan'] ?>" alt=""></div>
                        </td>
                      </tr>
                      <tr>
                        <td>Nama Masakan: <?php echo $r_dt_makanan['nama_masakan']; ?></td>
                      </tr>
                      <tr>
                        <td>Harga / Porsi: Rp. <?php echo $r_dt_makanan['harga']; ?>,-</td>
                      </tr>
                      <tr>
                        <td>Stok: <?php echo $r_dt_makanan['stok']; ?> Porsi</td>
                      </tr>
                      <form method="post">
                        <tr>
                          <td class="text-xs">
                            <?php
                            if (in_array($r_dt_makanan['id_masakan'], $pesan)) {
                            ?>
                              <button type="submit" value="<?php echo $r_dt_makanan['id_masakan']; ?>" name="tambah_pesan" class="bg-blue-700 rounded" disabled>
                                <i class='icon-shopping-cart'></i>&nbsp;Telah dipesan&nbsp;
                              </button>
                            <?php
                            } else {
                            ?>
                              <button type="submit" value="<?php echo $r_dt_makanan['id_masakan']; ?>" name="tambah_pesan" class="bg-green-500 rounded hover:bg-gray-500">
                                <i class='icon-shopping-cart'></i>&nbsp;Pesan&nbsp;
                              </button>
                            <?php
                            }
                            ?>
                          </td>
                        </tr>
                      </form>
                    </tbody>
                  </table>

                <?php
                }
                if (isset($_REQUEST['tambah_pesan'])) {
                  //echo $_REQUEST['hapus_menu'];
                  $id_masakan = $_REQUEST['tambah_pesan'];

                  $query_tambah_pesan = "insert into tb_pesan values('', '$id', '', '$id_masakan', '', '')";
                  $sql_tambah_pesan = mysqli_query($conn, $query_tambah_pesan);

                  $query_lihat_pesannya = "select * from tb_pesan order by id_pesan desc limit 1";
                  $sql_lihat_pesannya = mysqli_query($conn, $query_lihat_pesannya);
                  $result_lihat_pesannya = mysqli_fetch_array($sql_lihat_pesannya);

                  $id_pesannya = $result_lihat_pesannya['id_pesan'];

                  $query_olah_stok = "insert into tb_stok values('', '$id_pesannya', '', 'belum cetak')";
                  $sql_olah_stok = mysqli_query($conn, $query_olah_stok);

                  //echo $query_tambah_pesan;
                  if ($sql_tambah_pesan) {
                    header('location: entri_order.php');
                  }
                }
                ?>
              </div>
            </div>
            <div class="border-4 border-black rounded-md w-[650px] ml-[90px] mr-[100px] mt-8 bg-slate-100 shadow-2xl">
              <form action="" method="post">
                <div class="widget-box">
                  <div class="widget-title"> <span class="icon"> <i class="icon-shopping-cart"></i> </span>
                    <h5 class="text-center my-[25px] text-3xl font-bold">Keranjang Pemesanan</h5>
                  </div>
                  <div class="container mx-3">
                    <table class="border-2 border-black rounded-sm">
                      <thead class="border-2 border-black rounded-sm bg-orange-500">
                        <tr>
                          <th style="width: 50%" class="border-r-2 border-black rounded-sm">Menu Pesanan</th>
                          <th style="width: 30%" class="border-r-2 border-black rounded-sm">Jumlah</th>
                          <th style="width: 10%" class="border-r-2 border-black rounded-sm">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $query_draft_pesan = "select * from tb_pesan natural join tb_masakan where id_user = $id and status_pesan != 'sudah'";
                        $sql_draft_pesan = mysqli_query($conn, $query_draft_pesan);

                        while ($r_draft_pesan = mysqli_fetch_array($sql_draft_pesan)) {
                        ?>
                          <tr>
                            <td class="border-r-2 border-b-2 border-black rounded-sm text-center"><span id="<?php echo "nama" . $r_draft_pesan['id_pesan']; ?>"><?php echo $r_draft_pesan['nama_masakan']; ?></span></td>
                            <input required id="<?php echo "harga" . $r_draft_pesan['id_pesan']; ?>" class="span8" type="hidden" value="<?php echo $r_draft_pesan['harga']; ?>" />
                            <td class="border-r-2 border-b-2 border-black rounded-sm">
                              <center>
                                <input req id="<?php echo "jumlah" . $r_draft_pesan['id_pesan']; ?>" class="span8" name="jumlah<?php echo $r_draft_pesan['id_masakan']; ?>" type="number" value="" placeholder="" onchange="operasi()" />
                              </center>
                            </td>
                            <td class="border-r-2 border-b-2 border-black text-center">
                              <form action="" method="post" class="center">
                                <button type="submit" value="<?php echo $r_draft_pesan['id_pesan']; ?>" name="hapus_pesan" class="bg-red-500 rounded w-7 hover:bg-slate-400">
                                  <span class="material-symbols-outlined">delete</span>
                                </button>
                              </form>
                            </td>
                          </tr>
                        <?php
                        }
                        ?>
                        <tr class="odd gradeX">
                          <td class="border-r-2 border-b-2 border-black rounded-sm text-center">No. Meja</td>
                          <td class="border-r-2 border-b-2 border-black rounded-sm my-8">
                            <center>
                              <input required name="no_meja" type="number" value="" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nomor Meja" />
                            </center>
                          </td>
                          <td></td>
                        </tr>
                        <tr class="odd gradeX">
                          <td class="font-bold text-center">Total Harga :</td>
                          <td>
                            <center>
                              <span class="bg-orange-400 rounded">&nbsp;Rp. <span id="total_harga">0</span>,-&nbsp;</span>
                              <input class="" id="tot" name="total_harga" type="hidden" value="" placeholder="" />
                            </center>
                          </td>
                          <td>

                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <br>
                <button type="submit" value="" name="proses_pesan" class="bg-orange-500 w-[100px] rounded-md ml-[530px] hover:bg-slate-400">
                  <i class="text-white">Proses Pesanan</i>
                </button>
            </div>
            </form>
        <?php
        }
        if (isset($_POST['hapus_pesan'])) {
          $id_pesan = $_POST['hapus_pesan'];
          $query_hapus_pesan = "delete from tb_pesan where id_pesan = $id_pesan";
          $sql_hapus_pesan = mysqli_query($conn, $query_hapus_pesan);

          if ($sql_hapus_pesan) {
            header('location: entri_order.php');
          }
        }

        if (isset($_POST['proses_pesan'])) {
          $id_admin = '';
          $id_pengunjung = $id;
          $no_meja = $_POST['no_meja'];
          $total_harga = $_POST['total_harga'];
          $uang_bayar = '';
          $uang_kembali = '';
          $status_order = 'belum bayar';

          date_default_timezone_set('Asia/Jakarta');
          $time = Date('YmdHis');
          echo $time;
          $query_simpan_order = "insert into tb_order values('', '$id_admin', '$id_pengunjung', $time, '$no_meja', '$total_harga', '$uang_bayar', '$uang_kembali', '$status_order')";
          $sql_simpan_order = mysqli_query($conn, $query_simpan_order);

          $query_tampil_order = "select * from tb_order where id_pengunjung = $id order by id_order desc limit 1";
          $sql_tampil_order = mysqli_query($conn, $query_tampil_order);
          $result_tampil_order = mysqli_fetch_array($sql_tampil_order);

          $id_ordernya = $result_tampil_order['id_order'];

          $query_ubah_jumlah = "select * from tb_pesan left join tb_masakan on tb_pesan.id_masakan = tb_masakan.id_masakan where id_user = $id and status_pesan != 'sudah'";
          $sql_ubah_jumlah = mysqli_query($conn, $query_ubah_jumlah);
          while ($r_ubah_jumlah = mysqli_fetch_array($sql_ubah_jumlah)) {
            $tahu = $r_ubah_jumlah['id_masakan'];
            $tempe = $_POST['jumlah' . $tahu];
            $id_pesan = $r_ubah_jumlah['id_pesan'];
            $query_stok = "select * from tb_masakan where id_masakan = $tahu";
            $sql_stok = mysqli_query($conn, $query_stok);
            $result_stok = mysqli_fetch_array($sql_stok);
            $sisa_stok = $result_stok['stok'] - $tempe;
            //echo $tempe;
            $query_proses_ubah = "update tb_pesan set jumlah = $tempe, id_order = $id_ordernya where id_masakan = $tahu and id_user = $id and status_pesan != 'sudah'";
            $query_kurangi_stok = "update tb_masakan set stok = $sisa_stok where id_masakan = $tahu";

            $query_kelola_stok = "update tb_stok set jumlah_terjual = $tempe where id_pesan = $id_pesan";

            $sql_kelola_stok = mysqli_query($conn, $query_kelola_stok);
            $sql_kurangi_stok = mysqli_query($conn, $query_kurangi_stok);
            $sql_proses_ubah = mysqli_query($conn, $query_proses_ubah);
          }

          if ($sql_simpan_order) {
            header('location: entri_order.php');
          }
        }
      }
        ?>
          </div>
          <script type="text/javascript">
            function operasi() {
              var pesan = new Array();
              var jumlah = new Array();
              var total = 0;
              for (var a = 0; a < 1000; a++) {
                pesan[a] = $("#harga" + a).val();
                jumlah[a] = $("#jumlah" + a).val();
              }
              for (var a = 0; a < 1000; a++) {
                if (pesan[a] == null || pesan[a] == "") {
                  pesan[a] = 0;
                  jumlah[a] = 0;
                }
                total += Number(pesan[a] * jumlah[a]);
              }

              //alert(total);
              $("#total_harga").text(total);
              $("#tot").val(total);
            }
          </script>



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
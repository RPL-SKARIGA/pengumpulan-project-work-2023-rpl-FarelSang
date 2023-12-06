<!DOCTYPE html>

<?php
include "connection/koneksi.php";
include "topbar.php";
session_start();
ob_start();

$id = $_SESSION['id_user'];


if(isset($_SESSION['edit_order'])){
  //echo $_SESSION['edit_order'];
  unset($_SESSION['edit_order']);

}

if(isset ($_SESSION['username'])){
  
  $query = "select * from user natural join tb_level where id_user = $id";

  mysqli_query($conn, $query);
  $sql = mysqli_query($conn, $query);

  while($r = mysqli_fetch_array($sql)){
    
    $nama_user = $r['nama_user'];
    $uang = 0;

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

<div id="content">  
  <div class="container-fluid">
    <?php
      if($r['id_level'] == 1 || $r['id_level'] == 2 || $r['id_level'] == 3 || $r['id_level'] == 4){
    ?>

    <div class="my-5">
      <div class="span9">
        <div class="widget-box">
          <div class="text-center mb-5 font-serif text-2xl">
            <h5>Laporan Hari Ini</h5>
          </div>
          <div class="mx-[300px]" >
            <table class="border-2 border-black">
              <thead>
                <tr class="bg-orange-500">
                  <th class="w-16  border-r-2 border-black">No.</th>
                  <th class="w-[300px] border-r-2 border-black">Nama Menu</th>
                  <th class="w-[90px] border-r-2 border-black">Sisa Stok</th>
                  <th class="w-[150px] border-r-2 border-black">Jumlah Terjual</th>
                  <th class="w-[150px] border-r-2 border-black">Harga</th>
                  <th class="w-[150px] border-r-2 border-black">Total Masukan</th>
                </tr>
              </thead>
              <?php
                $no = 1;
                

                $query_lihat_menu = "select * from tb_masakan";
                $sql_lihat_menu = mysqli_query($conn, $query_lihat_menu);

              ?>
              <tbody class="border-black border-2">
              <?php
                while($r_lihat_menu = mysqli_fetch_array($sql_lihat_menu)){
              ?>
                <tr>
                  <td><center><?php echo $no++;?>.</center></td>
                  <td class="text-center border-x-2 border-black"><?php echo $r_lihat_menu['nama_masakan'];?></td>
                  <td class="text-center border-x-2 border-black"><center><?php echo $r_lihat_menu['stok'];?></center></td>
                  <td class="text-center border-x-2 border-black">
                    <center>
                      <?php
                        $id_masakan = $r_lihat_menu['id_masakan'];
                        $query_lihat_stok = "select * from tb_stok left join tb_pesan on tb_stok.id_pesan = tb_pesan.id_pesan left join tb_masakan on tb_pesan.id_masakan = tb_masakan.id_masakan where status_cetak = 'belum cetak'";
                        $query_jumlah = "select sum(jumlah_terjual) as jumlah_terjual from tb_stok left join tb_pesan on tb_stok.id_pesan = tb_pesan.id_pesan where id_masakan = $id_masakan and status_cetak = 'belum cetak'";
                        $sql_jumlah = mysqli_query($conn, $query_jumlah);
                        $result_jumlah = mysqli_fetch_array($sql_jumlah);

                        $jml = 0;

                        if($result_jumlah['jumlah_terjual'] != 0 || $result_jumlah['jumlah_terjual'] != null || $result_jumlah['jumlah_terjual'] != ""){
                          //echo $result_jumlah['jumlah_terjual'];
                          $jml = $result_jumlah['jumlah_terjual'];
                          echo $jml;
                        } else {
                          $jml = 0;
                          echo $jml;
                        }
                      ?>
                    </center>
                  </td>
                  <td style="text-align: right" class="text-center border-x-2 border-black">Rp. <?php echo $r_lihat_menu['harga'];?> ,-</td>
                  <td style="text-align: right" class="text-center border-x-2 border-black">Rp. 
                    
                      <?php

                        $id_masakan = $r_lihat_menu['id_masakan'];
                        $query_lihat_stok = "select * from tb_stok left join tb_pesan on tb_stok.id_pesan = tb_pesan.id_pesan left join tb_masakan on tb_pesan.id_masakan = tb_masakan.id_masakan where status_cetak = 'belum cetak'";
                        $query_jumlah = "select sum(jumlah_terjual) as jumlah_terjual from tb_stok left join tb_pesan on tb_stok.id_pesan = tb_pesan.id_pesan where id_masakan = $id_masakan and status_cetak = 'belum cetak'";
                        $sql_jumlah = mysqli_query($conn, $query_jumlah);
                        $result_jumlah = mysqli_fetch_array($sql_jumlah);

                        $jml = 0;

                        if($result_jumlah['jumlah_terjual'] != 0 || $result_jumlah['jumlah_terjual'] != null || $result_jumlah['jumlah_terjual'] != ""){
                          //echo $result_jumlah['jumlah_terjual'];
                          $jml = $result_jumlah['jumlah_terjual'] * $r_lihat_menu['harga'];
                          echo $jml;
                        } else {
                          $jml = $result_jumlah['jumlah_terjual'] * $r_lihat_menu['harga'];
                          echo $jml;
                        }
                        $uang += $jml;
                      ?>
                    
                   ,-</td>
                </tr>
              <?php
                }
                //echo $uang;
              ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <?php
      }
    ?>
  </div>
</div>


<!-- <div class="row-fluid">
  <div id="footer" class="span12"> <?php echo date('Y'); ?> &copy; Restaurant <a href="#">by henscorp</a> </div>
</div> -->


<script type="text/javascript">
  // This function is called from the pop-up menus to transfer to
  // a different page. Ignore if the value returned is a null string:
  function goPage (newURL) {

      // if url is empty, skip the menu dividers and reset the menu selection to default
      if (newURL != "") {
      
          // if url is "-", it is this page -- reset the menu:
          if (newURL == "-" ) {
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
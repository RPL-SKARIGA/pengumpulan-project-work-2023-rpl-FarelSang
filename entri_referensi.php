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
      <title>Entri Menu</title>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <!-- <script src="https://cdn.tailwindcss.com"></script> -->
      <script src="tailwind.js"></script>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
      <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
    </head>

    <body>
      <div class="container mx-full ">
        <div class="container mx-auto">
          <div class="flex flex-row px-4 py-6 gap-24 place-content-end">
            <!-- <div class="flex w-64 gap-16">
              <button class="bg-blue-600 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded text-center item-center mt-2">
                <a href="tambah_menu.php" class="flex"><span class="material-symbols-outlined flex">add</span>&nbsp;Tambah Data</a>
              </button>
            </div> -->
          </div>
        </div>
        <div class="container">
          <div>
            <div>
              <?php
              if ($r['id_level'] == 1) {
              ?>
                <div class="container px-6 py-4">
                  <div class="">
                    <div class="grid grid-cols-3 gap-5">
                      <?php
                      $query_data_makanan = "select * from tb_masakan order by id_masakan desc";
                      $sql_data_makanan = mysqli_query($conn, $query_data_makanan);
                      

                      while ($r_dt_makanan = mysqli_fetch_array($sql_data_makanan)) {
                      ?>
                        <table class="mb-5 font-mono text-lg ">
                          <tbody class="">
                            <tr>
                              <td>
                                <div class="w-full h-full mb-3"><img class="object-fill object-center rounded-lg border-2 border-slate-500" style="min-height: 290px; min-width: 470px; max-height: 290px; max-width: 470px; " src="gambar/<?php echo $r_dt_makanan['gambar_masakan'] ?>" alt=""></div>
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
                            <!-- <form method="post">
                              <tr class="container">
                                <td class="">
                                  <button class="bg-blue-600 hover:bg-gray-500 text-white rounded font-extralight mx-5 my-4 w-[130px] text-center" type="submit" value="<?php echo $r_dt_makanan['id_masakan']; ?>" name="edit_menu"><span class="material-symbols-outlined">edit</span>&nbsp; Edit &nbsp;</button>
                                  <button class="bg-red-600 hover:bg-gray-500 text-white rounded font-bold mx-5 my-4 w-[130px]" type="submit" value="<?php echo $r_dt_makanan['id_masakan']; ?>" name="hapus_menu"><span class="material-symbols-outlined">delete</span>&nbsp; Hapus &nbsp;</button>
                                </td>
                              </tr>
                            </form> -->
                          </tbody>
                        </table>

                      <?php
                      }
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
                    </div>
                  </div>

                </div>
              <?php
              }
              ?>
            </div>
          </div>
        </div>
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
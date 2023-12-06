<!DOCTYPE html>

<?php
include "../connection/koneksi.php";
include "../admin/sidebar.php";
$id = $_SESSION['id_user'];

if (isset($_SESSION['id_user'])) {

  $query = "select * from user natural join tb_level where id_user = $id";

  mysqli_query($conn, $query);
  $sql = mysqli_query($conn, $query);

  $id_masakan = "";
  $nama_masakan = "";
  $harga = "";
  $stok = "";
  $gambar_masakan = "no_image.png";

  if (isset($_SESSION['edit_menu'])) {
    $id = $_SESSION['edit_menu'];
    $query_data_edit = "select * from tb_masakan where id_masakan = $id";
    $sql_data_edit = mysqli_query($conn, $query_data_edit);
    $result_data_edit = mysqli_fetch_array($sql_data_edit);

    $id_masakan = $result_data_edit['id_masakan'];
    $nama_masakan = $result_data_edit['nama_masakan'];
    $harga = $result_data_edit['harga'];
    $stok = $result_data_edit['stok'];
    $gambar_masakan = $result_data_edit['gambar_masakan'];
  }

  while ($r = mysqli_fetch_array($sql)) {

    $nama_user = $r['nama_user'];

?>

    <html lang="en">

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
            <?php
            if ($r['id_level'] == 1) {
            ?>
              <div class="font-mono">
                <?php 
                  if (isset($_SESSION['edit_menu'])) {?>
                    <div class="text-4xl font-bold ml-3 mt-4 mb-4">
                      <h5 class="ml-10"><span class="material-symbols-outlined">edit</span>Edit Menu</h5>
                    </div>
                  <?php
                  }else {
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
                        <?php
                        if (isset($_SESSION['edit_menu'])) {
                        ?>
                          <input name="" type="text" value="<?php echo $nama_masakan; ?>" class="span11" placeholder="Nama Masakan" />
                          <input name="nama_masakan" type="hidden" value="<?php echo $nama_masakan; ?>" class="span11" placeholder="Nama Masakan" />
                        <?php
                        } else {
                        ?>
                          <input required name="nama_masakan" type="text" value="" class="span11" placeholder="  Nama Masakan" />
                        <?php
                        }
                        ?>
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
                          <input  value="" name="gambar" type="file" accept="image/*" onchange="preview(this,'previewne')" />
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
                      <?php
                      if (isset($_SESSION['edit_menu'])) {
                      ?>
                        <button type="submit" name="ubah_menu" class="bg-blue-500 hover:bg-blue-800 items-center text-center rounded mb-5"><span class="material-symbols-outlined">save</span>&nbsp; Simpan Perubahan</button>
                      <?php
                      } else {
                      ?>
                        <div class="container w-60 mb-5">
                          <button type="submit" name="tambah_menu" class="bg-blue-500 hover:bg-blue-800 items-center text-center rounded"><span class="material-symbols-outlined">add_box</span>&nbsp;Tambahkan</button>
                        <?php
                      }
                        ?>
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
                  if (isset($_POST['tambah_menu'])) {
                    $nama_masakan = $_POST['nama_masakan'];
                    $harga = $_POST['harga'];
                    $stok = $_POST['stok'];
                    //$gambar = file($_POST['gambar']);

                    $direktori = "../gambar/";

                    $tmp_name = $_FILES["gambar"]["tmp_name"];
                    $name = pathinfo($_FILES["gambar"]["name"], PATHINFO_EXTENSION);
                    $nama_baru = $_POST['nama_masakan'] . "." . $name;
                    move_uploaded_file($tmp_name, $direktori . "/" . $nama_baru);
                    $gambar = $nama_baru;

                    //echo $nama_baru;

                    if ($stok > 0) {
                      $status_masakan = 'tersedia';
                    } else {
                      $status_masakan = 'habis';
                    }
                    //echo "<br>";
                    //echo $nama_user . " || " . $username . " || " . $password . " || " . $id_level . " || " . $status;
                    //echo "<br></br>";
                    $query_tambah_masakan = "insert into tb_masakan values ('','$nama_masakan','$harga','$stok','$status_masakan','$gambar')";
                    $sql_tambah_masakan = mysqli_query($conn, $query_tambah_masakan);
                    if ($sql_tambah_masakan) {
                      echo "<script>alert('Menu Berhasil Di Tambah');window.location.href='../admin/menu.php'</script>";
                    }
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
            <?php
            }
            ?>
          </div>
        </div>
      </div>

      <script type="text/javascript">
        function preview(gambar, idpreview) {
          var gb = gambar.files;
          for (var i = 0; i < gb.length; i++) {
            var gbPreview = gb[i];
            var imageType = /image.*/;
            var preview = document.getElementById(idpreview);
            var reader = new FileReader();
            if (gbPreview.type.match(imageType)) {
              preview.file = gbPreview;
              reader.onload = (function(element) {
                return function(e) {
                  element.src = e.target.result;
                };
              })(preview);
              reader.readAsDataURL(gbPreview);
            } else {
              alert("Type file tidak sesuai. Khusus image.");
            }

          }
        }
      </script>
<script type="text/javascript">
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
  // header('location: logout.php');
  echo "gabisa mas";
}
?>
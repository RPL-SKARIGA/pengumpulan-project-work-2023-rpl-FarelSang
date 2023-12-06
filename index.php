<!DOCTYPE html>
<?php
include "connection/koneksi.php";
session_start();
if (isset($_SESSION['username'])) {
	header('location: entri_referensi.php');
} else {
?>
	<html lang="en">

	<head>
		<title>Masuk || Restoran</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- <script src="https://cdn.tailwindcss.com"></script> -->
		<script src="tailwind.js"></script>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" /> 
	</head>

	<body class="h-screen flex align-middle content-center items-center justify-items-center-center" background="./gambar/Cincau.jpg">
		<div class="blurry-bg flex flex-col bg-transparent mx-auto w-[570px] h-auto p-6 border-4 rounded-xl text-center shadow-md items-center backdrop-blur-md">
			<div class="">
				<div class="">
					<form action="" method="post" class="">
						<div class="mb-4">
							<img src="gambar/logo2.png" class="w-40 mx-20 bg-white rounded-full">
							<span class="text-3xl text-black font-bold">
								STEAK AND MILK
							</span>
						</div>
						<?php
						if (isset($_SESSION['eror'])) {
						?>
							<div class='container'>
								<div class='bg-red-500 rounded-md mb-[30px] w-[335px]'>
									<span>
										<center class="text-white">Mungkin Username Atau Password Anda Salah</center>
									</span>
								</div>
							</div>
						<?php
							unset($_SESSION['eror']);
						}
						?>
						<div class="mb-6">
							<div class="mb-5" data-validate="Username is required">
								<input class="border-b-4 bg-white placeholder-slate-500 w-[300px]" type="text" name="username" placeholder="   Username">
							</div>

							<div class="" data-validate="Password is required">
								<input class="border-b-4 bg-white placeholder-slate-500 w-[300px]" type="password" name="password" placeholder="  Password">
							</div>
						</div>

						<div class="py-2 px-4">
							<button type="submit" name="login" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md text-center item-center mt-2">
								<span class="mt-0">LOGIN</span>
							</button>
						</div>
						<!-- <?php
								if (isset($_SESSION['username'])) {
								?>
					<div class="text-center w-full">
						<a class="txt1" href="logout.php">
							Log Out
							<i class="fa fa-long-arrow-right"></i>						
						</a>
					</div>
					<?php
								} else {
					?> -->
					<?php
								}
					?>
					</form>
				</div>
			</div>
		</div>

		<?php
		if (isset($_REQUEST['login'])) {
			$arr_level = array();
			$c_level = mysqli_query($conn, "select * from tb_level");

			while ($r = mysqli_fetch_array($c_level)) {
				array_push($arr_level, $r['nama_level']);
			}
			foreach ($arr_level as $kontens) {
				//echo $kontens." || ";
			}
			$username = $_REQUEST['username'];
			$password = $_REQUEST['password'];

			$akun = mysqli_query($conn, "select * from user natural join tb_level");
			echo mysqli_error($conn);
			while ($r = mysqli_fetch_array($akun)) {
				if ($r['username'] == $username and $r['password'] == $password and $r['status'] == 'aktif') {
					$_SESSION['username'] = $username;
					$_SESSION['id_user'] = $r['id_user'];
					$_SESSION['level'] = $r['id_level'];
					$_SESSION['role'] = $r['role'];
					if (isset($_SESSION['eror'])) {
						unset($_SESSION['eror']);
					}
					if ($r['role'] == "admin") {
						header('location: ./admin/index.php');
					}elseif ($r['role'] == "kasir") {
						header('location: entri_referensi.php');
					}
					
					//echo "<br>";
					//echo $r['username'] . " || " . $r['password'] . " || " . $r['id_level'] . " || " . $r['nama_level'];
					//echo "<br></br>";
					break;
				} else {
					$_SESSION['eror'] = 'salah';
					header('location: index.php');
				}
			}
		}
		?>





	</body>

	</html>
<?php
}
?>
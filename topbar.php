<head>
  <title>Entri Menu</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="tailwind.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>

<body>

  <header class="bg-orange-400 sticky top-0 w-full h-[100px] rounded">
    <nav class=" flex item-center py-1 px-14">
      <div class="container w-[650px]">
        <div class="flex mx-12 pt-2 gap-4">
          <img class="rounded-full w-20 h-20 border-[3px] border-orange-500 bg-white  " src="gambar/Logojpg.jpg" alt="">
          <h1 class="font-bold text-2xl mt-6 text-white">STEAK AND MILK</h1>
        </div>
      </div>
      <div class="flex ml-[100px] mt-4 text-xl">

        <ul class="flex gap-16 text-center item-center">
          <li class="text-center item-center">
            <a href="entri_referensi.php" class="text-white hover:text-gray-500">
              <span class="material-symbols-outlined">add_circle</span><br>
              <span class="font-bold text-center">Menu</span>
            </a>
          </li>
          <li class="text-center item-center">
            <a href="entri_order.php" class="text-white hover:text-gray-500">
              <span class="material-symbols-outlined">shopping_cart</span><br>
              <span class="font-bold text-center">Pesan</span>
            </a>
          </li>
          <li class="text-center item-center">
            <a href="entri_transaksi.php" class="text-white hover:text-gray-500">
              <span class="material-symbols-outlined">attach_money</span><br>
              <span class="font-bold text-center">Transaksi</span>
            </a>
          </li>
          <li class="text-center item-center">
            <a href="generate_laporan.php" class="text-white hover:text-gray-500">
              <span class="material-symbols-outlined">print</span><br>
              <span class="font-bold text-center">Laporan</span>
            </a>
          </li>
          <li class="text-center items-center">
            <a href="logout.php" class="text-white hover:text-gray-500">
              <span class="material-symbols-outlined">logout</span><br>
              <span class="font-bold text-center">Logout</span>
            </a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
</body>


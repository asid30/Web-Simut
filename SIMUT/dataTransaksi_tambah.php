<?php
    ob_start();
    include "koneksi.php";
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Data Transaksi Pengeluaran - SIMUT</title>
    <link rel="icon" href="icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  </head>
  <body>
    <style>
        .container {
            padding-top: 50px;
        }

        .container h1 {
            padding-bottom: 50px;
        }
    </style>

    <!-- Navbar & Sidebar -->
    <?php include 'navbar.php';
    include 'sidebar.php'?>

    <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
        <div class="offcanvas-header">
            <h4 class="offcanvas-title" id="offcanvasScrollingLabel">Menu</h4>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="list-group">
                <a href="index.php" class="list-group-item list-group-item-action">Dashboard</a>
                <a href="stokBahan.php" class="list-group-item list-group-item-action">Stok Bahan</a>
                <a href="dataTransaksi.php" class="list-group-item list-group-item-action">Transaksi</a>
            </div>
        </div>
    </div>

    <div id="home" class="container">
        <!-- Judul -->
        <figure>
            <h1>Tambah Transaksi</h1>
        </figure>

        <!-- form -->
        <form method="post" action="">
            <div class="mb-3 row">
            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
            <div class="col-sm-10">
            <select class="form-select" name="nama" aria-label=".form-select-lg example">
                <option hidden selected>Pilih Bahan</option>
                <?php 
                $query_select = mysqli_query($conn, "SELECT * FROM `kategori_bahan`");
                while ($result5 = mysqli_fetch_assoc($query_select)) {
                    $namaKategori = $result5['nama_kategori'];?>
                    <option value="<?php echo $namaKategori;?>"><?php echo $namaKategori;?></option>
                <?php } ?>
            </select>
            </div>
            </div>
            
            <div class="mb-3 row">
            <label for="jumlah" class="col-sm-2 col-form-label">Jumlah Barang</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" name="jumlah">
            </div>
            </div>

            <div class="mb-3 row">
            <label for="harga" class="col-sm-2 col-form-label">Harga Bahan</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" name="harga">
            </div>
            </div>

            <div class="mb-3 row">
            <label for="tanggal" class="col-sm-2 col-form-label">Tanggal Transaksi</label>
            <div class="col-sm-10">
            <input type="date" class="form-control" name="tanggal">
            </div>
            </div>

            <button type="submit" class="btn btn-primary" name="insert">Tambah Data</button>
            <a href="dataTransaksi.php" class="btn btn-danger">Kembali</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>

<?php
    if (isset($_POST['insert'])) {
        $nama = $_POST['nama'];
        $jumlah = $_POST['jumlah'];
        $harga = $_POST['harga'];
        $tanggal = $_POST['tanggal'];

        if($jumlah > 0){
            $status = 1;
        }else{
            $status = 2;
        }

        $sql = mysqli_query($conn, "SELECT * FROM `kategori_bahan`");
        $kondisi = 0;

        while($result = mysqli_fetch_assoc($sql)) {
            //kalo udah ada kategori/nama bahan yang sama
            if($nama == $result['nama_kategori']){
                $id_kategori = $result['id_kategori'];
                //mencari nilai jumlah stok yang lama
                $sql2 = mysqli_query($conn, "SELECT * FROM `stok_bahan` WHERE `id_kategori` = $id_kategori");
                while($result2 = mysqli_fetch_assoc($sql2)) {
                    $jumlah_lama = $result2['jumlah'];
                    $jumlah_baru = $jumlah_lama + $jumlah;
                }

                //update harga
                mysqli_query($conn, "UPDATE `kategori_bahan` SET `harga`='$harga' WHERE `id_kategori`= $id_kategori") or die(mysqli_error($conn));

                //update jumlah stok bahan
                mysqli_query($conn, "UPDATE `stok_bahan` SET `jumlah`='$jumlah_baru',`id_status`='$status' WHERE `id_kategori`= $id_kategori") or die(mysqli_error($conn));

                //tambah data transaksi
                mysqli_query($conn, "INSERT INTO transaksi(id_transaksi, id_kategori, jumlah_bahan, harga_bahan, tanggal_transaksi) VALUES (NULL, '$id_kategori', '$jumlah', '$harga', '$tanggal');") or die(mysqli_error($conn));

                $kondisi=1;
                header('Location: dataTransaksi.php');

            //kalo belum ada kategori/nama bahan yang sama
            }
        }
        if($kondisi==0){
            //buat mencari id kategori bahan tertinggi
            $sql3 = mysqli_query($conn, "SELECT * FROM `kategori_bahan` WHERE id_kategori = (SELECT MAX(id_kategori) FROM `kategori_bahan`);");
            while($result3 = mysqli_fetch_assoc($sql3)) {
                $id_kategori = $result3['id_kategori']+1;
            }

            //tambah kategori bahan baru
            mysqli_query($conn, "INSERT INTO `kategori_bahan`(`id_kategori`, `nama_kategori`, `harga`) VALUES ('$id_kategori','$nama','$harga')") or die(mysqli_error($conn));

            //tambah stok bahan baru
            mysqli_query($conn, "INSERT INTO `stok_bahan`(`id_stok`, `jumlah`, `id_status`, `id_kategori`) VALUES (NULL,'$jumlah','$status','$id_kategori')") or die(mysqli_error($conn));

            //tambah data transaksi
            mysqli_query($conn, "INSERT INTO transaksi(id_transaksi, id_kategori, jumlah_bahan, harga_bahan, tanggal_transaksi) VALUES (NULL, '$id_kategori', '$jumlah', '$harga', '$tanggal');") or die(mysqli_error($conn));
            
            header('Location: dataTransaksi.php');
        }
    }
?>

<?php
ob_end_flush();
?>
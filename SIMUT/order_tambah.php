<?php
ob_start();
include "koneksi.php";
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Order - SIMUT</title>
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

    <div id="home" class="container">
        <!-- Judul -->
        <figure>
            <h1>Tambah Order Baru</h1>
        </figure>

        <!-- form -->
        <form method="post" action="">
            <div class="mb-3 row">
                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nama">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                <div class="col-sm-10">
                    <textarea type="text" class="form-control" id="deskripsi" name="deskripsi"></textarea>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="atasNama" class="col-sm-2 col-form-label">Atas Nama</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="atasNama">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="jumlahPesanan" class="col-sm-2 col-form-label">Jumlah Pesanan</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="jumlahPesanan">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="tenggat" class="col-sm-2 col-form-label">Tenggat</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" name="tenggat">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="kategoriBahan" class="col-sm-2 col-form-label">Bahan yang dibutuhkan</label>
                <div class="col-sm-10">
                    <select class="form-select" name="kategoriBahan" aria-label=".form-select-lg example">
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

            <button type="submit" class="btn btn-primary" name="insert">Tambah Data</button>
            <a href="index.php" class="btn btn-danger">Kembali</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>

<?php
    if (isset($_POST['insert'])) {
        $nama = $_POST['nama'];
        $deskripsi = $_POST['deskripsi'];
        $atasNama = $_POST['atasNama'];
        $jumlahPesanan = $_POST['jumlahPesanan'];
        $tenggat = $_POST['tenggat'];
        $kategoriBahan = strval($_POST['kategoriBahan']);

        if($jumlahPesanan == null){
            $jumlahPesanan = 0;
        }
        if($deskripsi == null){
            $deskripsi = "Tidak ada deskripsi";
        }
        if($atasNama == null){
            $atasNama = "";
        }
        //mencari id kategori
        $sql2 = mysqli_query($conn, "SELECT * FROM `kategori_bahan` WHERE `nama_kategori` = '$kategoriBahan';");
        while($result2 = mysqli_fetch_assoc($sql2)) {
            $id_kategori = $result2['id_kategori'];
        }
        //mencari id stok
        $sql3 = mysqli_query($conn, "SELECT * FROM `stok_bahan` WHERE `id_kategori` = '$id_kategori';");
        while($result3 = mysqli_fetch_assoc($sql3)) {
            $id_stok= $result3['id_stok'];
        }
        //tambah data order
        mysqli_query($conn, "INSERT INTO `tabel_order`(`nama_pemesan`, `nama_order`, `jumlah_pesanan`, `id_stok`, `deskripsi`, `tenggat`) VALUES ('$atasNama','$nama','$jumlahPesanan','$id_stok','$deskripsi','$tenggat')") or die(mysqli_error($conn));
        
        header('Location: index.php');
    }
ob_end_flush();
?>
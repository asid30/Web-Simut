<?php
  include "koneksi.php";
  
  $sql = mysqli_query($conn, "SELECT stok_bahan.id_kategori, kategori_bahan.nama_kategori, stok_bahan.jumlah, status.nama_status, kategori_bahan.harga FROM kategori_bahan, stok_bahan, status WHERE kategori_bahan.id_kategori = stok_bahan.id_kategori AND stok_bahan.id_status = status.id_status AND stok_bahan.id_kategori = '$_GET[update]'");

  $result = mysqli_fetch_array($sql);

  if (isset($_POST['update'])) {
    $jumlah = $_POST['jumlah'];
    if($jumlah > 0){
        $status = 1;
    }else{
        $status = 2;
    }

    mysqli_query($conn, "UPDATE `kategori_bahan` SET `nama_kategori`='$_POST[nama]' WHERE id_kategori = '$_GET[update]'") or die(mysqli_error($conn));
    mysqli_query($conn, "UPDATE `stok_bahan` SET `jumlah`='$jumlah', `id_status`='$status' WHERE id_kategori = '$_GET[update]'") or die(mysqli_error($conn));

    echo "<script>alert('Perubahan Berhasil Disimpan');document.location='stokBahan.php'</script>";
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Stok Bahan - SIMUT</title>
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
            <h1>Edit Stok Bahan</h1>
        </figure>

        <!-- form -->
        <form method="post" action="">
            <div class="mb-3 row">
                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" name="nama" value="<?php echo $result['nama_kategori'];?>">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="nama" class="col-sm-2 col-form-label">Jumlah Barang</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" name="jumlah" value="<?php echo $result['jumlah'];?>">
                </div>
            </div>

            <button type="submit" class="btn btn-primary" name="update">Simpan</button>
            <a href="stokBahan.php" class="btn btn-danger">Kembali</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>
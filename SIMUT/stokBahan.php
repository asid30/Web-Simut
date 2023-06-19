<?php
    include 'koneksi.php';

    $query = "SELECT stok_bahan.id_kategori, kategori_bahan.nama_kategori, stok_bahan.jumlah, status.nama_status, kategori_bahan.harga FROM kategori_bahan, stok_bahan, status WHERE kategori_bahan.id_kategori = stok_bahan.id_kategori AND stok_bahan.id_status = status.id_status ORDER BY stok_bahan.id_stok;";
    $sql = mysqli_query($conn, $query);
    $no = 1;

    if (isset($_POST['hapus'])) {
        $id = $_POST['hapus'];
        $sql = "DELETE FROM stok_bahan WHERE id_kategori = '$id'; ";
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Stok Bahan - SIMUT</title>
    <link rel="icon" href="icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  </head>
  <body>
    <style>
        .container {
            padding-top: 50px;
            background-image: url("");
        }

        .table-responsive {
            padding-top: 50px;
        }

        #stokHabis{
            color: red;
        }
    </style>

    <!-- Navbar & Sidebar -->
    <?php include 'navbar.php';
    include 'sidebar.php'?>

    <div id="stok_bahan" class="container">
        <!-- Judul -->
        <figure>
            <h1>Stok Bahan</h1>
        <blockquote class="blockquote">
            <p>Informasi Dari Setiap Barang</p>
        </blockquote>
        </figure>

        <a href="stokBahan_tambah.php" type="button" class="btn btn-primary">Tambah</a>

        <!-- Tabel -->
        <div class="table-responsive" id="models">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Jumlah Barang</th>
                        <th>Status</th>
                        <th>Harga</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($result = mysqli_fetch_assoc($sql)) { ?>
                        <tr>
                            <td><?php echo $no++?></td>
                            <td><?= $result['nama_kategori'];?></td>
                            <?php if($result['jumlah']<1){ ?>
                                <td id="stokHabis"><?= $result['jumlah'];?></td>
                                <td id="stokHabis"><?= $result['nama_status'];?></td>
                            <?php }else{ ?>
                                <td><?= $result['jumlah'];?></td>
                                <td><?= $result['nama_status'];?></td>
                            <?php } ?>
                            <td><?php echo "Rp ".$result['harga'];?></td>
                            <td>
                                <a href="stokBahan_edit.php?update=<?php echo $result['id_kategori']; ?>" type="button" class="btn btn-warning">
                                    Edit
                                </a>
                                <a href="?hapus=<?php echo $result['id_kategori']; ?>" onclick="return confirm('Hapus Data?');" type="button" class="btn btn-danger">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>

<?php
    if (isset($_GET['hapus'])) {
        $sql = mysqli_query($conn, "DELETE FROM stok_bahan WHERE id_kategori = '$_GET[hapus]'") or die(mysqli_error($conn));
        mysqli_query($conn, "DELETE FROM kategori_bahan WHERE `kategori_bahan`.`id_kategori` = '$_GET[hapus]'") or die(mysqli_error($conn));
        echo "<script>alert('Data Telah Dihapus')</script>";
        echo "<meta http-equiv=refresh content=2;URL='stokBahan.php'>";
    }
?>
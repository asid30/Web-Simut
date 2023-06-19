<?php
    include "koneksi.php";

    $query = "SELECT tabel_order.id_order, tabel_order.nama_pemesan, tabel_order.nama_order, tabel_order.jumlah_pesanan, tabel_order.id_stok, tabel_order.deskripsi, DATE_FORMAT(tabel_order.tenggat, '%d %M %Y') AS tenggat FROM tabel_order, stok_bahan WHERE stok_bahan.id_stok = tabel_order.id_stok ORDER BY tabel_order.id_order;";
    $sql = mysqli_query($conn, $query);

    if (isset($_POST['hapus'])) {
        $id = $_POST['hapus'];
        $sql = "DELETE FROM tabel_order WHERE `tabel_order`.`id_order` = $_GET[hapus]";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="icon.png">
    <title>Dashboard - SIMUT</title>
</head>
<body>
    <style>
        .container {
            padding-top: 50px;
        }

        .row.row-cols-1.row-cols-md-2.g-4 {
            padding-top: 50px;
            padding-bottom: 50px;
        }

        .card.h-100 h1 {
            padding-top: 20px;
            padding-left: 15px;
            padding-bottom: 10px;
        }

        #stokHabis{
            color: red;
        }
    </style>

    <!-- Navbar & Sidebar -->
    <?php include 'navbar.php';
    include 'sidebar.php'?>

    <div class="container">
        <!-- Judul -->
        <figure>
                <h1>Dashboard</h1>
            <blockquote class="blockquote">
                <p>Pesanan Yang Diterima</p>
            </blockquote>
        </figure>

        <a href="order_tambah.php" type="button" class="btn btn-primary">Tambah</a>

        <!-- Konten -->
        <div class="row row-cols-1 row-cols-md-2 g-4">
        <?php while ($result = mysqli_fetch_assoc($sql)) { ?>
            <div class="col">
                <div class="card h-100">
                    <h1>Pesanan <?php echo $result['id_order'];?></h1>
                    <div class="card-body">
                        <?php 
                            //mencari id kategori bahan
                            $sql2 = mysqli_query($conn, "SELECT * FROM `stok_bahan`");
                            while($result1 = mysqli_fetch_assoc($sql2)) {
                                if($result1['id_stok'] == $result['id_stok']){
                                    $id_kategori = $result1['id_kategori'];
                                    $sisa = $result1['jumlah'];
                                }
                            }
                            //mencari nama stok
                            $sql3 = mysqli_query($conn, "SELECT * FROM `kategori_bahan`");
                            while($result2 = mysqli_fetch_assoc($sql3)) {
                                if($result2['id_kategori'] == $id_kategori){
                                    $nama_bahan = $result2['nama_kategori'];
                                }
                            }
                        ?>
                        <h5 class="card-title"><?php echo $result['nama_order']?></h5>
                        <p class="card-text"><?php echo $result['deskripsi']?>.</p>
                        <p class="card-text">
                            <table>
                                <tr>
                                    <td>Atas Nama</td>
                                    <td> : <?php echo $result['nama_pemesan']?></td>
                                </tr>
                                <tr>
                                    <td>Jumlah Pesanan</td>
                                    <td> : <?php echo $result['jumlah_pesanan']?></td>
                                </tr>
                            </table>
                        </p>
                        <hr style="border: 1px solid black;">
                        <p class="card-text">
                            <table>
                                <?php if($sisa < 1){ ?>
                                <tr>
                                    <td>Stok Bahan</td>
                                    <td id="stokHabis"> : <?php echo $nama_bahan?></td>
                                </tr>
                                <tr>
                                    <td>Sisa Bahan</td>
                                    <td id="stokHabis"> : <?php echo $sisa?></td>
                                </tr>
                                <?php } else { ?>
                                <tr>
                                    <td>Stok Bahan</td>
                                    <td> : <?php echo $nama_bahan?></td>
                                </tr>
                                <tr>
                                    <td>Sisa Bahan</td>
                                    <td> : <?php echo $sisa?></td>
                                </tr>
                                <?php }?>
                            </table>
                        </p>
                    </div>
                    <div class="card-footer">
                        <small class="text-body-secondary">Tenggat Pesanan <?php echo $result['tenggat']?></small><br><br>
                        <?php if ($sisa < 1){?>
                            <button type="button" class="btn btn-success" disabled>Selesai</button>
                        <?php }else{ ?>
                            <a href="?hapus=<?php echo $result['id_order']; ?>" onclick="return confirm('Yakin order selesai?');" type="button" class="btn btn-success">Selesai</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>

<?php
    if (isset($_GET['hapus'])) {
        mysqli_query($conn, "DELETE FROM tabel_order WHERE `tabel_order`.`id_order` = $_GET[hapus]") or die(mysqli_error($conn));
        echo "<script>alert('Pesanan sudah selesai')</script>";
        echo "<meta http-equiv=refresh content=2;URL='index.php'>";
    }
?>
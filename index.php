<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "db_barang";

$koneksi    = mysqli_connect($host, $user, $pass, $db);

//Cek koneksi
if (!$koneksi) { 
    die("Tidak bisa terkoneksi ke database");
}

// Variabel untuk menyimpan
$kd_brg        = "";
$nama_brg      = "";
$jenis_brg     = "";
$stok          = "";
$satuan        = "";
$sukses        = "";
$error         = "";

// Memeriksa apakah 'op' (operasi) ada dalam URL
if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
// Jika operasi adalah 'delete', menghapus data berdasarkan ID
if($op == 'delete'){
    $id         = $_GET['id'];
    $sql1       = "delete from barang where id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
// Jika operasi adalah 'edit', mengambil data barang berdasarkan ID untuk proses edit
if ($op == 'edit') {
    $id         = $_GET['id'];
    $sql1       = "select * from barang where id = '$id'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $kd_brg     = $r1['kd_brg'];
    $nama_brg   = $r1['nama_brg'];
    $jenis_brg  = $r1['jenis_brg'];
    $stok       = $r1['stok'];
    $satuan     = $r1['satuan'];

    // Jika kode barang kosong, menampilkan pesan error
    if ($kd_brg == '') {
        $error = "Data tidak ditemukan";
    }
}

if (isset($_POST['simpan'])) { //Memeriksa apakah form disubmit untuk create/update data

    // Mengambil nilai variabel
    $kd_brg        = $_POST['kd_brg'];
    $nama_brg      = $_POST['nama_brg'];
    $jenis_brg     = $_POST['jenis_brg'];
    $stok          = $_POST['stok'];
    $satuan        = $_POST['satuan'];

    // Memeriksa apakah semua field diisi sebelum melakukan operasi
    if ($kd_brg && $nama_brg && $jenis_brg && $stok && $satuan) {
        if ($op == 'edit') { // Jika operasi adalah edit, lakukan update data
            $sql1       = "update barang set kd_brg = '$kd_brg',nama_brg='$nama_brg',jenis_brg = '$jenis_brg',stok='$stok',satuan='$satuan' where id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate"; // Pesan sukses jika update berhasil
            } else {
                $error  = "Data gagal diupdate"; // Pesan error jika update gagal
            }
        } else { // Jika operasi adalah insert, lakukan penambahan data baru
            $sql1   = "insert into barang(kd_brg,nama_brg,jenis_brg,stok,satuan) values ('$kd_brg','$nama_brg','$jenis_brg','$stok','$satuan')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru"; // Pesan sukses jika penambahan data berhasil
            } else {
                $error      = "Gagal memasukkan data"; // Pesan error jika penambahan data gagal
            }
        }
    } else {
        $error = "Silakan masukkan semua data"; // Pesan error jika ada field yang kosong
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Data Barang</title> <!--Judul halaman web yang ditampilkan di tab browser.-->
    <!-- Memanggil file CSS Bootstrap dari CDN untuk styling. -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <!--Bagian untuk menambahkan gaya CSS internal. -->
    <style>
        /* Mengatur latar belakang halaman. */
        body {
            background: #1d2630; 
           
        }
        /* Mengatur lebar konten agar tetap responsif.*/
        .mx-auto {
            width: 800px
        }
        /* Mengatur margin atas pada elemen card.*/
        .card {
            margin-top: 10px;
        }
        /* Mengatur tampilan garis/border pada suatu elemen.*/
        .garis {
            border: solid white;
        }
    </style>
</head>

<body>
    </div>
    <!-- Container untuk konten utama -->
    <div class="mx-auto" >
    <br>
    <!-- Judul Aplikasi -->
    <h1 class="text-white text-center">Aplikasi CRUD Data Barang</h1>
    <hr class="garis">
        <!-- Form untuk memasukkan data -->
        <div class="card">
            <!-- Header Form -->
            <div class="card-header text-white bg-secondary">
                Input Barang
            </div>

             <!-- Body Form -->
            <div class="card-body">
                <?php
                // Menampilkan pesan error 
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php"); // Refresh halaman setelah 5 detik
                }
                ?>
                <?php
                // Menampilkan pesan sukses
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php"); // Refresh halaman setelah 5 detik
                }
                ?>

                <!-- Form untuk input data -->
                <form action="" method="POST">
                    <!-- Input ID Barang -->
                    <div class="mb-3 row">
                        <label for="kd_brg" class="col-sm-2 col-form-label">ID Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kd_brg" name="kd_brg" value="<?php echo $kd_brg ?>">
                        </div>
                    </div>
                     <!-- Input Nama Barang -->
                    <div class="mb-3 row">
                        <label for="nama_brg" class="col-sm-2 col-form-label">Nama Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama_brg" name="nama_brg" value="<?php echo $nama_brg ?>">
                        </div>
                    </div>
                     <!-- Input Jenis Barang -->
                    <div class="mb-3 row">
                        <label for="jenis_brg" class="col-sm-2 col-form-label">Jenis Barang</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="jenis_brg" name="jenis_brg" value="<?php echo $jenis_brg ?>">
                        </div>
                    </div>
                     <!-- Input Stok -->
                    <div class="mb-3 row">
                        <label for="stokt" class="col-sm-2 col-form-label">Stok</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="stok" name="stok" value="<?php echo $stok ?>">
                        </div>
                    </div>
                     <!-- Input Satuan -->
                    <div class="mb-3 row">
                        <label for="satuan" class="col-sm-2 col-form-label">Satuan</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="satuan" id="satuan">
                                <option value="">- Pilih Satuan -</option>
                                <option value="Pack" <?php if ($satuan == "Pack") echo "selected" ?>>Pack</option>
                                <option value="Pcs" <?php if ($satuan == "Pcs") echo "selected" ?>>Pcs</option>
                                <option value="Dus" <?php if ($satuan == "Dus") echo "selected" ?>>Dus</option>
                            </select>
                        </div>
                    </div>
                    <!-- Tombol Simpan Data -->
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-success" />
                    </div>
                </form>
            </div>
        </div>
        
        <hr class="garis"> <!-- Garis pembatas -->

        <!-- Form untuk menampilkan data -->
        <div class="card">
            <!-- Header untuk menampilkan data -->
            <div class="card-header text-white bg-secondary">
                Data Barang
            </div>

            <!-- Body untuk menampilkan data -->
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                             <!-- Kolom-kolom untuk header tabel -->
                            <th scope="col">No.#</th>
                            <th scope="col">Kode Barang</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Jenis Barang</th>
                            <th scope="col">Stok</th>
                            <th scope="col">Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Query untuk mengambil data dari database
                        $sql2   = "select * from barang order by id desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        // Looping untuk menampilkan data per baris
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id         = $r2['id'];
                            $kd_brg     = $r2['kd_brg'];
                            $nama_brg   = $r2['nama_brg'];
                            $jenis_brg  = $r2['jenis_brg'];
                            $stok       = $r2['stok'];
                            $satuan     = $r2['satuan'];

                        ?>
                            <!-- Baris data untuk setiap entry di database -->
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $kd_brg ?></td>
                                <td scope="row"><?php echo $nama_brg ?></td>
                                <td scope="row"><?php echo $jenis_brg ?></td>
                                <td scope="row"><?php echo $stok ?></td>
                                <td scope="row"><?php echo $satuan ?></td>
                                <td scope="row">

                                    <!-- Tombol untuk edit dan delete data -->
                                    <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-primary">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>            
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</body>

</html>
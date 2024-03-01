<?php
include "koneksi.php";
session_start();

if (isset($_POST['update'])) {
  $fotoid = $_POST['fotoid'];
  $judulfoto = $_POST['judulfoto'];
  $deskripsifoto = $_POST['deskripsifoto'];
  $albumid = $_POST['albumid'];

  //Jika Upload gambar baru
  if ($_FILES['lokasifile']['name'] != "") {
    $rand = rand();
    $ekstensi =  array('png', 'jpg', 'jpeg', 'gif');
    $filename = $_FILES['lokasifile']['name'];
    $ukuran = $_FILES['lokasifile']['size'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);

    if (!in_array($ext, $ekstensi)) {
      echo "<script>
        alert('format file foto tidak sesuai');
        location.href='foto.php';
        </script>";
    } else {
      if ($ukuran < 1044070) {
        $xx = $rand . '_' . $filename;
        move_uploaded_file($_FILES['lokasifile']['tmp_name'], 'gambar/' . $rand . '_' . $filename);
        mysqli_query($conn, "UPDATE foto set judulfoto='$judulfoto',deskripsifoto='$deskripsifoto',lokasifile='$xx',albumid='$albumid' WHERE fotoid='$fotoid'");
        echo "<script>
            alert('update foto berhasil');
            location.href='foto.php';
            </script>";
      } else {
        echo "<script>
            alert('update foto gagal');
            location.href='foto.php';
            </script>";
      }
    }
  } else {
    mysqli_query($conn, "UPDATE foto set judulfoto='$judulfoto',deskripsifoto='$deskripsifoto',albumid='$albumid' WHERE fotoid='$fotoid'");
    echo "<script>
            alert('edit foto berhasil');
            location.href='foto.php';
            </script>";
  }
}

if (isset($_GET['fotoid'])) {
  $fotoidedit = $_GET['fotoid'];
  $userid2 = $_SESSION['userid'];
  $sql2 = mysqli_query($conn, "SELECT * FROM foto,album WHERE foto.fotoid = '$fotoidedit' AND foto.albumid = album.albumid");

  while ($data2 = mysqli_fetch_array($sql2)) {
    $fotoid2 = $data2['fotoid'];
    $judulfoto2 = $data2['judulfoto'];
    $deskripsi2 = $data2['deskripsifoto'];
    $album2 = $data2['albumid'];
    $albumnama2 = $data2['namaalbum'];
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>web galery foto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
<?php 
include "layout/header.html";
?>

<main class="flex-shrink-0">
  <div class="container">
    <h1 class="mt-2">Selamat datang <?= $_SESSION['namalengkap'] ?> </h1>
    <hr>

    <div class="row">
      <div class="col-sm-3 bg-body-tertiary">
        <h3>Foto</h3>
        <form action="foto_edit.php" method="POST" enctype="multipart/form-data">
          <div class="mb-3 mt-3">
            <label for="judulfoto">Judul Foto</label>
            <input type="text" name="fotoid" value="<?= $fotoid2 ?>" hidden>
            <input type="text" class="form-control" id="judulfoto" placeholder="Enter Judul Foto" name="judulfoto" value="<?= $judulfoto2 ?>">
          </div>
          <div class="mb-3">
            <label for="deskripsifoto">Deskripsi Foto</label>
            <textarea name="deskripsifoto" id="deskripsifoto" class="form-control" rows="5" placeholder="enter deskripsi foto"><?= $deskripsi2 ?></textarea>
          </div>
          <div class="mb-3">
            <label for="lokasifile">Upload Foto</label>
            <input type="file" name="lokasifile" id="lokasifile" class="form-control">
          </div>
          <div class="mb-3">
            <label for="albumid">Album</label>
            <select name="albumid" id="albumid" class="form-control">
              <option value="<?= $album2 ?>"><?= $albumnama2 ?></option>
              <?php
              $userid = $_SESSION['userid'];
              $sql = mysqli_query($conn, "select * from album where userid='$userid'");
              while ($data = mysqli_fetch_array($sql)) {
              ?>
                <option value="<?= $data['albumid'] ?>"><?= $data['namaalbum'] ?></option>
              <?php
              }

              ?>
            </select>
          </div>

          <button type="submit" class="btn btn-primary" name="update">edit</button>
        </form>
      </div>
      <div class="col-sm-9">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Judul Foto</th>
              <th>Deskripsi</th>
              <th>Tanggal Upload</th>
              <th>Foto</th>
              <th>Nama Album</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $urut = 1;
            $userid = $_SESSION['userid'];
            $sql = mysqli_query($conn, "select * from foto,album where foto.userid='$userid' and foto.albumid=album.albumid");
            while ($data = mysqli_fetch_array($sql)) {
            ?>
              <tr>
                <td><?= $urut++ ?></td>
                <td><?= $data['judulfoto'] ?></td>
                <td><?= $data['deskripsifoto'] ?></td>
                <td><?= $data['tanggalunggah'] ?></td>
                <td><img src="gambar/<?= $data['lokasifile'] ?>" width="100px"></td>
                <td><?= $data['namaalbum'] ?></td>
                <td>
                  <a href="foto.php?fotoid=<?= $data['fotoid'] ?>" onclick="return confirm('Yakin menghapus data?')"><button type="button" class="btn btn-danger">Delete</button></a>
                  <a href="foto_edit.php?fotoid=<?= $data['fotoid'] ?>"><button type="button" class="btn btn-warning">Edit</button></a>
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
</main>

  <?php 
include "layout/footer.html";
  ?> 

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
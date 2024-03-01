<?php
include "koneksi.php";
session_start();

if (isset($_POST['logout'])) {
 session_unset();
 session_destroy();
 echo "<script>
      alert('');
      location.href='index.php';
    </script>";
}
if (isset($_GET['fotoid'])) {
  // echo "<script>
  //           alert('tombol like ditekan');
  //           location.href='admin.php';
  //           </script>";

  $fotoid = $_GET['fotoid'];
  $userid = $_SESSION['userid'];
  //Cek apakah user sudah pernah like foto ini apa belum

  $sql = mysqli_query($conn, "select * from likefoto where fotoid='$fotoid' and userid='$userid'");

  if (mysqli_num_rows($sql) == 1) {
    //User sudah pernah like foto ini
    header("location:admin.php");
  } else {
    $tanggallike = date("Y-m-d");
    mysqli_query($conn, "insert into likefoto values('','$fotoid','$userid','$tanggallike')");
    header("location:admin.php");
  }
}



?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>website galery foto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
<?php 
include "layout/header_admin.html";
?>

<!-- Begin page content -->
<main class="flex-shrink-0">
  <div class="container">
    <h1 class="mt-2">Selamat datang <?= $_SESSION['namalengkap'] ?> </h1>

    <div class="row justify-content-center">
      <?php
      $sql = mysqli_query($conn, "select * from foto,user where foto.userid=user.userid");
      while ($data = mysqli_fetch_array($sql)) {
      ?>
        <div class="col-sm-3 my-1">
          <div class="card">
            <div class="card-header">
              <h3><?= $data['judulfoto'] ?></h3>
            </div>
            <div class="card-body">
              <img src="gambar/<?= $data['lokasifile'] ?>" alt="foto" width="150px">
              <hr>
              <i><?= $data['deskripsifoto'] ?></i>
              <h5>upload by <?= $data['namalengkap'] ?></h5>
            </div>
            <div class="card-footer">
              <?php
              $fotoid = $data['fotoid'];
              $sql2 = mysqli_query($conn, "select * from likefoto where fotoid='$fotoid'");
              $sql3 = mysqli_query($conn, "select * from komentarfoto where fotoid='$fotoid'");
              ?>
              <a href="admin.php?fotoid=<?= $data['fotoid'] ?>"><button type="button" class="btn btn-danger">like (<?= mysqli_num_rows($sql2) ?>)</button></a>
              <a href="komentar.php?fotoid=<?= $data['fotoid'] ?>"><button type="button" class="btn btn-warning">Komentar (<?= mysqli_num_rows($sql3) ?>)</button></a>
            </div>
          </div>
        </div>
      <?php
      }
      ?>
      <div class="col-sm-3 my-1">
        <div class="card">
          <div class="card-header">Header</div>
          <div class="card-body">Content</div>
          <div class="card-footer">Footer</div>
        </div>
      </div>
      <div class="col-sm-3 my-1">
        <div class="card">
          <div class="card-header">Header</div>
          <div class="card-body">Content</div>
          <div class="card-footer">Footer</div>
        </div>
      </div>
      <div class="col-sm-3 my-1">
        <div class="card">
          <div class="card-header">Header</div>
          <div class="card-body">Content</div>
          <div class="card-footer">Footer</div>
        </div>
      </div>
      <div class="col-sm-3 my-1">
        <div class="card">
          <div class="card-header">Header</div>
          <div class="card-body">Content</div>
          <div class="card-footer">Footer</div>
        </div>
      </div>

    </div>
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
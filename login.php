<?php
include "koneksi.php";
session_start();

if (isset($_POST['login'])) {
  $username=$_POST['username'];
  $password=$_POST['password'];
  

  $sql=mysqli_query($conn,"select * from user where username='$username' and password='$password'");

  $cek=mysqli_num_rows($sql);

  if($cek==1){
      while($data=mysqli_fetch_array($sql)){
          $_SESSION['userid']=$data['userid'];
          $_SESSION['namalengkap']=$data['namalengkap'];
          $_SESSION['login'] =true;
          $nama =$data['namalengkap'];

      }
    echo "<script>
    alert('login succes, welcome $nama');
    location.href='admin.php';
  </script>";
  }else{
    echo "<script>
    alert('login fail, username or password wrong :(');
    location.href='login.php';
  </script>";
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cantika</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php 
    include "layout/header.html";
    ?>
    
    <main class="container">
      <div class="row justify-content-center">
        <div class="col-sm-4 mt-4">
     <h1 class="text-info-emphasis mb-4 text-center">Sign in</h1>
     <form action="login.php" method="POST">
  <div class="mb-3 mt-3">
    <label for="username" class="form-label">Username:</label>
    <input type="username" class="form-control" id="username" name="username">
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password:</label>
    <input type="password" class="form-control" id="password" name="password">
  </div>
  <div class="form-check mb-3">
    <label class="form-check-label">
      <input class="form-check-input" type="checkbox" name="remember"> Remember me
    </label>
  </div>
  <div class="text-center">
  <button type="submit" class="btn btn-primary text" name="login">Sign in</button>
  </div>
</form>
    </div>
      </div>
    </main>

    <?php 
    include "layout/footer.html";
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
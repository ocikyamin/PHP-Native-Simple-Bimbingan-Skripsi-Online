<?php 
session_start();
include "../config/databases.php";
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="../logo.png" rel="icon">
  <title>BIMTA - Login</title>
  <link href="../apl/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../apl/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../apl/css/admin.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-login">
  <!-- Login Content -->
  <div class="container-login">
    <div class="row justify-content-center">
      <div class="col-xl-4 col-lg-4 col-md-3">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                  	<img src="../logo.png" class="img-fluid" width="100">
                    <h1 class="h4 text-gray-900 mb-4">Administrator</h1>
                  </div>
                  <p>
<!-- Script Proses Login -->
<?php  
// tampilkan pesan jika inputan kosong                
if (@$_SESSION['err']=='empty') {
echo '<div class="alert alert-danger" id="alert">
Email / Password Belum diisi ...
</div>';
}
// tampilkan pesan jika email dan password tidak ada dalam database
if (@$_SESSION['err']=='notfound') {
echo '<div class="alert alert-danger" id="alert">
Email / Password tidak ditemukan ...
</div>';
}
// jika tombol login di klik
if (isset($_POST['ubtn'])) {
$mail = mysqli_escape_string($con,$_POST['umail']);
$pass = sha1(mysqli_escape_string($con,$_POST['upass']));
// cek jika email dan password tidak diisi
if ($mail=="" || $pass=="") {
$_SESSION['err']="empty";
echo " <script>window.location='./';</script>";
}else{
  // query untuk menampilkan data admin berdaskan username dan password dan status Y
$sql = mysqli_query($con,"SELECT `id`,`username`,`password` FROM tb_admin WHERE `username`='{$mail}' AND `password`='{$pass}' AND status='Y' ");
$cekUser = mysqli_num_rows($sql);
$d = mysqli_fetch_assoc($sql);
// Jika data admin tidak ada dalam database
if ($cekUser < 1) {
$_SESSION['err']="notfound";
echo "<script>window.location='./';</script>";
}else{

  // jika data admin ada dalam databases maka login sukses dan hapus session pesan, dan buat session baru untuk admin
  // lalu arahkan ke halaman admin : ../web-admin/
unset($_SESSION['err']);
$_SESSION['ADMIN_SESS']= $d['id'];
echo "<script>window.location='../web-admin/';</script>";
}
}
}
?>
<!-- End Script Proses Login -->
                  	
                  </p>
                  <form method="POST" class="user">
                    <div class="form-group">
                      <input type="email" name="umail" class="form-control" aria-describedby="emailHelp"
                        placeholder="Email">
                    </div>
                    <div class="form-group">
                      <input type="password" name="upass" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <button type="submit" name="ubtn" class="btn btn-primary btn-block"><i class="fa fa-sign-in-alt"></i> Login</button>
                    </div>
                  </form>
                  <!--<hr>-->
                  <!--<div class="text-center">-->
                  <!--  <a class="font-weight-bold small" href="">Akun Admin</a>-->
                  <!--  <hr>-->
                  <!--  email : admin@bimta <br>-->
                  <!--  password : admin@bimta-->
                  <!--</div>-->
                  <!--<div class="text-center">-->
                  <!--</div>-->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Login Content -->
  <script src="../apl/vendor/jquery/jquery.min.js"></script>
  <script src="../apl/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../apl/vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- <script src="../apl/js/ruang-admin.min.js"></script> -->
  <script>
$(document).ready(function () {
// romove alert
window.setTimeout(function () {
$("#alert").fadeTo(500,0).slideUp(500,function () {
$(this).remove();
});
}, 1500);



});
</script>
</body>

</html>
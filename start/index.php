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

<body class="bg-gradient-primary">
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
                    <hr>
                    <h1 class="h4 text-gray-900 mb-4">Login <b>Bim</b>TA</h1>
                  </div>
                  <p>
            <?php 
        if ($_SERVER['REQUEST_METHOD']=='POST') {
        $userKey = mysqli_real_escape_string($con,$_POST['userkey']);
        $userPin= sha1(mysqli_real_escape_string($con,$_POST['userpin']));
        $userType = intval($_POST['role']);
        if ($userKey=="" || $userPin=="" || $userType=="") {
        echo ' <div class="alert alert-danger" id="alert">
        Username / Password belum diisi ..
        </div>';
        }else{
        if ($userType==1) {
        // Dosen
        $sql = mysqli_query($con,"SELECT `id_dsn`,`nip`,`password` FROM tb_dsn WHERE nip='$userKey' AND password='$userPin' AND stt_akun='Y' ");
        $cekRow = mysqli_num_rows($sql);
        if ($cekRow < 1) {
        echo ' <div class="alert alert-danger" id="alert">
        Username / Password Tidak ditemukan ..
        </div>';
        }else{
        $ds = mysqli_fetch_assoc($sql);
        $_SESSION['upload_gambar']= TRUE;
        $_SESSION['LECT_SES']= $ds['id_dsn'];
        echo "
        <script>
        window.location.replace('../lecture/');  
        </script>";
        }

        }elseif ($userType==2) {
        // Mahasiswa

        // Dosen
        $sql = mysqli_query($con,"SELECT `id_mhs`,`nim`,`password` FROM tb_mhs WHERE nim='$userKey' AND password='$userPin' AND status_akun='Y' ");
        $cekRow = mysqli_num_rows($sql);
        if ($cekRow < 1) {
        echo ' <div class="alert alert-danger" id="alert">
        Username / Password Tidak ditemukan / atau akun tidak aktif..
        </div>';
        }else{
        $dm = mysqli_fetch_assoc($sql);
        $_SESSION['upload_gambar']= TRUE;
        $_SESSION['MHS_SES']= $dm['id_mhs'];
        echo "
        <script>
        window.location.replace('../student/'); 
        </script>";
        }


        }else{
        echo 'Not Found User Type';
        }

        }

        }
        ?>
                  	
                  </p>
                  <form method="POST" class="user">
                    <div class="form-group">
                      <input type="number" name="userkey" class="form-control"
                        placeholder="NIM/NIDN">
                    </div>
                    <div class="form-group">
                      <input type="password" name="userpin" class="form-control" placeholder="Password">
                    </div>
                    <div class="input-group mt-3">
                    <select name="role" class="form-control">
                    <option value="">Akun Type</option>
                    <option value="1">Dosen</option>
                    <option value="2">Mahasiswa</option>
                    </select>
                    </div>
                    <div class="form-group mt-3">
                      <button type="submit" name="ubtn" class="btn btn-primary btn-block"><i class="fa fa-sign-in-alt"></i> Login</button>
                    </div>
                  </form>
                 
                  <div class="text-center">
                    <a class="font-weight-bold small" href="../?pages=register">Belum Punya Akun ?</a>
                  
                  </div>
                  <div class="text-center">
                    <a href="../">Back To Home</a>
                  </div>
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
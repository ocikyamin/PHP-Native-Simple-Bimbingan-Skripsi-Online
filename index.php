<?php 
session_start();
include "config/databases.php";
$result = mysqli_query($con,"SELECT * FROM tb_info ORDER BY info_id ASC ");
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>BimTA - Sekolah Tinggi Teknik Malang</title>
  <meta content="Sistem Informasi Bimbingan Skripsi Online | Sistem Informasi Bimbingan Tugas Akhir  " name="description">
  <meta content="Sistem Informasi Bimbingan Skripsi Online | Sistem Informasi Bimbingan Tugas Akhir" name="keywords">

  <!-- Favicons -->
  <link href="logo.png" rel="icon">
  <link href="logo.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Scaffold - v4.1.0
  * Template URL: https://bootstrapmade.com/scaffold-bootstrap-metro-style-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center">

      <div class="logo me-auto">
        <!-- <h1><a href="./"><b style="color: #3F51B5">Bim</b>TA</a></h1> -->
        <!-- Uncomment below if you prefer to use an image logo -->
         <h1><a href="./"><img src="logo.png"class="img-fluid"> <b style="color: #3F51B5">Bim</b>TA</a></h1>
      </div>

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link scrollto active" href="./">Home</a></li>
            <?php            
            if (@$_GET['pages'] !=='register') {
            ?>
            <li><a class="nav-link scrollto" href="#about">About</a></li>
            <li><a class="nav-link scrollto " href="#services">Syarat Bimbingan</a></li>
            <?php
            }
            ?>          
          <li><a class="nav-link scrollto" href="?pages=register">Register</a></li>
          <li><a class="nav-link scrollto" href="./start/">Login</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

<!--       <div class="header-social-links d-flex align-items-center">
        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></i></a>
      </div> -->

    </div>
  </header><!-- End Header -->
  <?php 
  if (isset($_GET['pages'])) {
    $page = mysqli_escape_string($con,$_GET['pages']);
    if ($page=='register') {
      include "public/register.php";
    }elseif ($page=='login') {
      
    }
  }else{
    include 'public/homepage.php';
  }

   ?>

  

  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="container">
      <div class="copyright">
        &copy; 2021 <strong><span>bimTA</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/scaffold-bootstrap-metro-style-template/ -->
        Dev by <a href="">Fahad</a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <!-- <script src="assets/vendor/php-email-form/validate.js"></script> -->
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Template Main JS File -->
          <script src="assets/js/main.js"></script>
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
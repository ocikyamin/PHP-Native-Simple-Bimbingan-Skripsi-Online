<?php
session_start();
// cek jika ada session admin
if (isset($_SESSION['ADMIN_SESS'])) {
  include '../config/databases.php';
  // vriable untuk id admin yg login
  $userID = intval($_SESSION['ADMIN_SESS']);
  $user   = mysqli_fetch_assoc(mysqli_query($con, "SELECT `id`,`username`,`password`,`nama_admin`,`img` FROM tb_admin WHERE `id`='{$userID}' AND status='Y' "));
  // manampilakan tahun akademik yg aktif
  $tp = mysqli_fetch_assoc(mysqli_query($con, "SELECT periode_id,th_periode FROM tm_periode WHERE stt_periode='on' "));
  // Notif User Baru
  $new_user = mysqli_query($con, "SELECT tb_mhs.nama,tb_mhs.fotomhs,tb_mhs.create_at FROM tb_mhs WHERE status_akun='new' ORDER BY id_mhs DESC LIMIT 5 ");
  // Notif Judul baru
  $new_judul = mysqli_query($con, "SELECT tb_mhs.id_mhs,tb_mhs.nama,tb_mhs.fotomhs,pengajuan.pengajuan_id,pengajuan.tgl_pengajuan,pengajuan.judul FROM pengajuan JOIN tb_mhs ON pengajuan.id_mhs=tb_mhs.id_mhs WHERE disetujui_kajur='new'  ORDER BY pengajuan_id DESC LIMIT 6");
  // Notif Perpanjang SK
  $new_sk = mysqli_query($con, "SELECT tb_mhs.id_mhs,tb_mhs.nama,tb_mhs.fotomhs,pengajuan.pengajuan_id,pengajuan.tgl_pengajuan,pengajuan.judul FROM pengajuan JOIN tb_mhs ON pengajuan.id_mhs=tb_mhs.id_mhs WHERE status_perpanjangan_sk='new'  ORDER BY pengajuan_id DESC LIMIT 6");
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
    <title>Administrator - Dashboard</title>
    <link href="../apl/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../apl/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <!-- datatables -->
    <link href="../apl/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <!-- Select2 -->
    <link href="../apl/vendor/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css">
    <link href="../apl/css/admin.min.css" rel="stylesheet">
    <style>
    .mid>tbody>tr>td {
        vertical-align: middle;
    }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
            <a class="sidebar-brand bg-gradient-primary d-flex align-items-center justify-content-center" href="./">
                <div class="sidebar-brand-icon">
                    <img src="../logo.png">
                </div>
                <div class="sidebar-brand-text mx-3"><b>STT MALANG</b></div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item">
                <a class="nav-link" href="./">
                    <i class="fas fa-fw fa-home"></i>
                    <span>Dashboard</span></a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Features
            </div>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
                    aria-expanded="true" aria-controls="collapseBootstrap">
                    <i class="fa fa-fw fa-graduation-cap"></i>
                    <span>Akademik</span>
                </a>
                <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Akademik</h6>
                        <a class="collapse-item" href="?pages=periode"><i class="far fa-circle"></i> Periode
                            Akademik</a>
                        <a class="collapse-item" href="?pages=fakultas"><i class="far fa-circle"></i> Fakultas</a>
                        <a class="collapse-item" href="?pages=prodi"><i class="far fa-circle"></i> Prodi</a>
                        <a class="collapse-item" href="?pages=dosen"><i class="far fa-circle"></i> Dosen</a>
                        <a class="collapse-item" href="?pages=mahasiswa"><i class="far fa-circle"></i> Mahasiswa</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseForm"
                    aria-expanded="true" aria-controls="collapseForm">
                    <i class="fa fa-fw fa-users"></i>
                    <span> Bimbingan</span>
                </a>
                <div id="collapseForm" class="collapse" aria-labelledby="headingForm" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Bimbingan Settings</h6>
                        <a class="collapse-item" href="?pages=fix_judul"><i class="far fa-circle"></i> Atur
                            Pembimbing</a>
                        <a class="collapse-item" href="?pages=list_pembing"><i class="far fa-circle"></i> Status
                            Pembimbing</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="?pages=list_judul_revisi">
                    <i class="fas fa-fw fa-file-alt"></i>
                    <span>Revisi Judul</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="?pages=list_perpanjangan_sk">
                    <i class="fa fa-fw fa-file-alt"></i>
                    <span>Perpanjangan SK</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#report" aria-expanded="true"
                    aria-controls="report">
                    <i class="fa fa-fw fa-print"></i>
                    <span> Report</span>
                </a>
                <div id="report" class="collapse" aria-labelledby="headingForm" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Report</h6>
                        <a class="collapse-item" href="?pages=report"><i class="far fa-circle"></i> Lap. Bimbingan</a>
                        <a class="collapse-item" href="?pages=report_sk"><i class="far fa-circle"></i> Lap.
                            Pembimbing</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?pages=settings">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Administrator
            </div>
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <div class="version" id="version-ruangadmin"></div>
        </ul>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <nav class="navbar navbar-expand navbar-light bg-navbar bg-gradient-primary topbar mb-4 static-top">
                    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <span class="text-white">BimTA</span>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">

                            <a class="nav-link" href="?pages=periode" style="font-size: 12px;">
                                <i class="fa fa-calendar mr-2"></i> TA. <?php if (empty($tp)) {
                                                            echo "Periode Tidak Aktif";
                                                          } else {
                                                            echo $tp['th_periode'];
                                                          }

                                                          ?>
                            </a>
                        </li>
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <span class="badge badge-danger badge-counter"><?php $jmlJudulBaru = mysqli_num_rows($new_judul);
                                                                  echo number_format($jmlJudulBaru); ?></span>
                            </a>
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    NOTIFIKASI JUDUL BARU
                                </h6>

                                <?php
                  foreach ($new_judul as $infoNewJudul) : ?>
                                <a class="dropdown-item d-flex align-items-center"
                                    href="?pages=list_judul&details=<?= $infoNewJudul['pengajuan_id'] ?>">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <img src="../apl/img/<?= $infoNewJudul['fotomhs'] ?>" class="img-profile"
                                                style="width: 30px;height: 30px;border-radius: 100%">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">
                                            <?= date('d-m-Y - H:i:s', strtotime($infoNewJudul['tgl_pengajuan'])) ?>
                                        </div>
                                        <span class="font-weight-bold"><?= $infoNewJudul['nama'] ?> <br>
                                            <small>Mengajukan : <?= $infoNewJudul['judul'] ?></small></span>
                                    </div>
                                </a>
                                <?php endforeach; ?>
                                <a class="dropdown-item text-center small text-gray-500"
                                    href="?pages=list_judul">Selengkapnya</a>

                            </div>
                        </li>
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user-plus fa-fw"></i>
                                <span class="badge badge-warning badge-counter"><?php $jmlUserBaru = mysqli_num_rows($new_user);
                                                                  echo number_format($jmlUserBaru); ?></span>
                            </a>
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    NOTIFKASI USER BARU
                                </h6>
                                <?php
                  foreach ($new_user as $infoNewUser) : ?>
                                <a class="dropdown-item d-flex align-items-center" href="?pages=list_account">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <img src="../apl/img/<?= $infoNewUser['fotomhs'] ?>" class="img-profile"
                                                style="width: 30px;height: 30px;border-radius: 100%">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">
                                            <?= date('d-m-Y - H:i:s', strtotime($infoNewUser['create_at'])) ?></div>
                                        <span class="font-weight-bold"><?= $infoNewUser['nama'] ?> <br> <small>Membuat
                                                Akun Baru</small></span>
                                    </div>
                                </a>
                                <?php endforeach; ?>

                                <a class="dropdown-item text-center small text-gray-500"
                                    href="?pages=list_account">Selengkapnya</a>
                            </div>
                        </li>
                        <!-- <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-tasks fa-fw"></i>
                <span class="badge badge-success badge-counter">3</span>
              </a>
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                  Task
                </h6>
                <a class="dropdown-item align-items-center" href="#">
                  <div class="mb-3">
                    <div class="small text-gray-500">Design Button
                      <div class="small float-right"><b>50%</b></div>
                    </div>
                    <div class="progress" style="height: 12px;">
                      <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="50"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </a>
                <a class="dropdown-item align-items-center" href="#">
                  <div class="mb-3">
                    <div class="small text-gray-500">Make Beautiful Transitions
                      <div class="small float-right"><b>30%</b></div>
                    </div>
                    <div class="progress" style="height: 12px;">
                      <div class="progress-bar bg-warning" role="progressbar" style="width: 30%" aria-valuenow="30"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </a>
                <a class="dropdown-item align-items-center" href="#">
                  <div class="mb-3">
                    <div class="small text-gray-500">Create Pie Chart
                      <div class="small float-right"><b>75%</b></div>
                    </div>
                    <div class="progress" style="height: 12px;">
                      <div class="progress-bar bg-danger" role="progressbar" style="width: 75%" aria-valuenow="75"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">View All Taks</a>
              </div>
            </li> -->
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img-profile rounded-circle" src="../apl/img/<?= $user['img'] ?>"
                                    style="max-width: 60px">
                                <span class="ml-2 d-none d-lg-inline text-white small"><?= $user['nama_admin'] ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal"
                                    data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    <!-- SCRIPT HALAMAN DINAMIS/CONTENT DINAMIS -->
                    <?php
            if (isset($_GET['pages'])) {
              $page = mysqli_escape_string($con, $_GET['pages']);
              // Menu Periode
              if ($page == 'periode') {
                include "pages/akademik/data_periode.php";
                // Menu Fakultas
              } elseif ($page == 'fakultas') {
                include "pages/akademik/data_fakultas.php";
              }
              // Menu Prodi
              elseif ($page == 'prodi') {
                include "pages/akademik/data_prodi.php";
              }
              // Menu Dosen
              elseif ($page == 'dosen') {
                include "pages/akademik/data_dosen.php";
              }
              // Menu Mahasiswa
              elseif ($page == 'mahasiswa') {
                include "pages/akademik/data_mahasiwa.php";
              }

              // user baru
              elseif ($page == 'list_account') {
                include "pages/news/list_account.php";
              }
              // judul baru
              elseif ($page == 'list_judul') {
                include "pages/news/list_judul.php";
              }
              // judul diterima
              elseif ($page == 'fix_judul') {
                include "pages/pembing/list_fix_judul.php";
              }
              // daftar pembimbing dipilih
              elseif ($page == 'list_pembing') {
                include "pages/pembing/list_pembing.php";
              }
              // Menu Settings
              elseif ($page == 'settings') {
                include "pages/setting.php";
              }
              // Menu Report Bimbingan
              elseif ($page == 'report') {
                include "pages/report/list_report.php";
              }
              // Menu Report Pembimbing
              elseif ($page == 'report_sk') {
                include "pages/report/list_report_sk.php";
              }

              // Menu Revisi Judul
              elseif ($page == 'list_judul_revisi') {
                include "pages/news/list_judul_revisi.php";
              }
              // Menu Perpanjang SK
              elseif ($page == 'list_perpanjangan_sk') {
                include "pages/news/list_perpanjangan_sk.php";
              }

              // Detail Revisi Judul
              elseif ($page == 'detail_judul_revisi') {
                include "pages/news/detai_judul_revisi.php";
              }
              // detail Perpanjang SK
              elseif ($page == 'detail_sk') {
                include "pages/news/detail_perpanjanganSK.php";
              } elseif ($page == '') {
              } else {
                echo 'Opps ! Not Found Pages';
              }
            } else {
              // echo 'Halaman Utama';
              include "pages/home.php";
            }

            ?>
                    <!-- END SCRIPT HALAMAN DINAMIS/CONTENT DINAMIS -->

                    <!-- Modal Logout -->
                    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <center>
                                        <h5 class="modal-title mt-4">Keluar Aplikasi !</h5>
                                        <p>Are you sure you want to logout ?</p>
                                        <button type="button" class="btn btn-outline-danger btn-sm mt-2"
                                            data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                                        <a href="../login/logout.php"
                                            class="btn btn-primary bg-gradient-primary btn-sm mt-2"><i
                                                class="fa fa-sign-out-alt"></i> Logout</a>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!---Container Fluid-->
            </div>
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; <script>
                            document.write(new Date().getFullYear());
                            </script> - Developed by
                            <b><a href="https://bimta.ypcode.my.id/" target="_blank">Yamin</a></b>
                        </span>
                    </div>
                </div>
            </footer>
            <!-- Footer -->
        </div>
    </div>

    <!-- Scroll to top -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="../apl/vendor/jquery/jquery.min.js"></script>
    <script src="../apl/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../apl/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- datatables -->
    <script src="../apl/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../apl/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Select2 -->
    <script src="../apl/vendor/select2/dist/js/select2.min.js"></script>
    <script src="../apl/js/ruang-admin.min.js"></script>
    <script src="../apl/js/custom.js"></script>
    <script>
    $(document).ready(function() {
        $('#data').DataTable();
    });
    </script>


</body>

</html>
<?php
} else {
  // arahkan ke halaman login jika tidak ada user yg login
?> <script>
alert('Anda Belum Login !!');
window.location = '../login/';
</script>
<?php
}


?>
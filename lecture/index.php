<?php
session_start();
error_reporting(1);
// cek jika ada session dosen
if (isset($_SESSION['LECT_SES'])) {
    include '../config/databases.php';
    // vriable untuk id dosen yg login
    $userID = intval($_SESSION['LECT_SES']);
    // manampilakan data dosen yg sedang login
    $user   = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM tb_dsn
WHERE id_dsn={$userID}"));
    // manampilakan tahun akademik yg aktif
    $tp = mysqli_fetch_assoc(mysqli_query($con, "SELECT periode_id,th_periode FROM tm_periode WHERE stt_periode='on' "));
    // QUERY INFO PESAN BARU DARI MAHASISWA
    $infoPesanBaru = mysqli_query($con, "SELECT
tb_mhs.id_mhs,
tb_mhs.nama,
tb_mhs.fotomhs,
tb_pesan.id_pesan,
tb_pesan.topik,
tb_pesan.isi_pesan,
tb_pesan.wkt
FROM tb_pesan
JOIN tm_periode ON tb_pesan.tahun_bimbingan=tm_periode.periode_id
JOIN tb_mhs ON tb_pesan.pengirim_id=tb_mhs.id_mhs
WHERE tb_pesan.penerima_id=$userID
AND tb_pesan.user_pengirim='mhs'
AND tb_pesan.status_pesan='new'
AND tm_periode.stt_periode='on'
ORDER BY tb_pesan.id_pesan ASC ");
    // jumlah pesan baru
    $jmlInfoPesanBaru = mysqli_num_rows($infoPesanBaru);
    // END QUERY INFO PESAN BARU DARI MAHASISWA 

    // QUERY INFO MAHASISWA MENGAJUKAN JUDUL PENELITIAN
    $infoNewjudul = mysqli_query($con, "SELECT tb_mhs.id_mhs,
tb_mhs.nim,
tb_mhs.nama,
tb_mhs.fotomhs,
tb_mhs.dosen_pa,
pengajuan.pengajuan_id,
pengajuan.tgl_pengajuan,
pengajuan.judul
FROM pengajuan
JOIN tb_mhs ON pengajuan.id_mhs=tb_mhs.id_mhs
JOIN tm_periode ON pengajuan.periode_id=tm_periode.periode_id
WHERE tb_mhs.dosen_pa='$userID'
AND pengajuan.rekomendasi_pa='new'
AND tm_periode.stt_periode='on'
ORDER BY pengajuan.pengajuan_id ASC");
    // END QUERY INFO MAHASISWA MENGAJUKAN JUDUL PENELITIAN

    // QUERY PERMINTAAN JADI PEMBIMBING
    $infoNewPembing = mysqli_query($con, "SELECT
tb_mhs.nim,
tb_mhs.nama,
pembing.pembing_id,
pembing.create_at,
pengajuan.pengajuan_id,
pengajuan.judul
FROM pembing 
JOIN tb_mhs ON pembing.id_mhs=tb_mhs.id_mhs
JOIN pengajuan ON pembing.pengajuan_id=pengajuan.pengajuan_id
JOIN tm_periode ON pengajuan.periode_id=tm_periode.periode_id
WHERE pembing.dosen='$userID'
 AND pembing.kesediaan='new'
  AND tm_periode.stt_periode='on'
ORDER BY pembing.pembing_id ASC
");
    // END QUERY PERMINTAAN JADI PEMBIMBING

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
    <title>Lecture - Home</title>
    <link href="../apl/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../apl/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../apl/css/admin.min.css" rel="stylesheet">
    <!-- Select2 -->
    <link href="../apl/vendor/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css">
    <link href="../apl/css/admin.min.css" rel="stylesheet">
    <script src="../apl/vendor/jquery/jquery.min.js"></script>
    <link href="../apl/vendor/toastr/toastr.min.css" rel="stylesheet" type="text/css">
    <link href="../apl/vendor/summernote/summernote-bs4.min.css" rel="stylesheet" type="text/css">
    <script src="../apl/vendor/toastr/toastr.min.js"></script>
    <link href="../apl/css/style.css" rel="stylesheet">
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
            <a class="sidebar-brand d-flex align-items-center justify-content-center bg-gradient-primary" href="./">
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
                Main Menu
            </div>
            <!--         <li class="nav-item">
        <a class="nav-link" href="?pages">
        <i class="fas fa-fw fa-calendar"></i>
        <span>Schedule</span>
        </a>
        </li> -->
            <li class="nav-item">
                <a class="nav-link" href="?pages=consult">
                    <i class="fa fa-fw fa-comments"></i>
                    <span>Bimbingan</span>
                </a>

            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" href="?pages=history">
                    <i class="fa fa-fw fa-users"></i>
                    <span>Hsitory</span>
                </a>
            </li> -->
            <li class="nav-item">
                <a class="nav-link" href="?pages=status">
                    <i class="fa fa-fw fa-tasks"></i>
                    <span>Status </span>
                </a>
            </li>


            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Session
            </div>
            <li class="nav-item">
                <a class="nav-link" href="?pages=change_pwd">
                    <i class="fa fa-fw fa-key"></i>
                    <span> Password </span>
                </a>
            </li>

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
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <span class="badge badge-danger badge-counter"><?php
                                                                                    $jm1 = mysqli_num_rows($infoNewjudul);
                                                                                    $jm2 = mysqli_num_rows($infoNewPembing);
                                                                                    echo $jm1 + $jm2;

                                                                                    ?></span>
                            </a>
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    NOTIFIKASI
                                </h6>
                                <?php
                                    foreach ($infoNewjudul as $newInfoJudul) : ?>
                                <a class="dropdown-item d-flex align-items-center"
                                    href="?pages=list_judul&details=<?= $newInfoJudul['pengajuan_id'] ?>">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="../apl/img/<?= $newInfoJudul['fotomhs'] ?>"
                                            style="max-width: 60px" alt="">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500"><?= $newInfoJudul['nama'] ?></div>
                                        <span class="font-weight-bold"><?= $newInfoJudul['judul'] ?></span>
                                    </div>
                                </a>
                                <?php endforeach; ?>
                                <?php
                                    foreach ($infoNewPembing as $newPembing) : ?>
                                <a class="dropdown-item d-flex align-items-center"
                                    href="?pages=list_permintaan&read=<?= $newPembing['pembing_id'] ?>">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-users text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">Administrator</div>
                                        <span class="font-weight-bold">Permohonan Kesediaan Membimbing Skripsi/TA</span>
                                    </div>
                                </a>
                                <?php endforeach; ?>

                            </div>
                        </li>
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <span class="badge badge-warning badge-counter"><?= $jmlInfoPesanBaru ?></span>
                            </a>
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    INFORMASI PESAN BARU
                                </h6>
                                <?php
                                    foreach ($infoPesanBaru as $newInfoPesan) : ?>
                                <a class="dropdown-item d-flex align-items-center"
                                    href="?pages=consult&topic=<?= base64_encode($newInfoPesan['topik']); ?>">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="../apl/img/<?= $newInfoPesan['fotomhs'] ?>"
                                            style="max-width: 60px" alt="">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">
                                            <?= htmlspecialchars_decode($newInfoPesan['isi_pesan']) ?></div>
                                        <div class="small text-gray-500"><?= $newInfoPesan['nama'] ?> ·
                                            <?= date('d-m-Y H:i:s', strtotime($newInfoPesan['fotomhs'])) ?></div>
                                    </div>
                                </a>
                                <?php endforeach; ?>

                                <a class="dropdown-item text-center small text-gray-500"
                                    href="?pages=consult">Selengkapnya</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img-profile rounded-circle" src="../apl/img/dosen/<?= $user['foto'] ?>"
                                    style="max-width: 60px">
                                <span class="ml-2 d-none d-lg-inline text-white small"><?= $user['nama_dosen'] ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="?pages=change_pwd">
                                    <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Change Password
                                </a>
                                <a class="dropdown-item" href="?pages=profile">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="?pages=consult">
                                    <i class="fas fa-comments fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Bimbingan
                                </a>
                                <!-- <a class="dropdown-item" href="?pages=history">
                                    <i class="fas fa-clock fa-sm fa-fw mr-2 text-gray-400"></i>
                                    History
                                </a> -->
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
                            if ($page == 'list_judul') {
                                include "pages/news/list_judul.php";
                            } elseif ($page == 'list_permintaan') {
                                include "pages/news/list_permintaan.php";
                            }

                            // Menu Bimbingan
                            elseif ($page == 'consult') {
                                include "pages/consult/list_konsult.php";
                            }
                            // History Bimbingan
                            // elseif ($page == 'history') {
                            //     include "pages/consult/list_history_konsult.php";
                            // }

                            // Menu Status Bimbingan
                            elseif ($page == 'status') {
                                include "pages/consult/list_status_konsult.php";
                            }

                            //   Menu Profile
                            elseif ($page == 'profile') {
                                include "pages/profile.php";
                            }

                            // Menu Ganti Password
                            elseif ($page == 'change_pwd') {
                                include "pages/change_password.php";
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
                                        <a href="../start/logout.php"
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
    <script src="../apl/vendor/summernote/summernote-bs4.min.js"></script>
    <!-- Select2 -->

    <script src="../apl/vendor/select2/dist/js/select2.min.js"></script>
    <script src="../apl/js/ruang-admin.min.js"></script>
    <script src="../apl/js/custom.js"></script>
    <!-- CKEDITOR -->
    <!-- <script type="text/javascript" src="../apl/ckeditor/ckeditor.js"></script>  -->
    <script>
    $(document).ready(function() {
        $('.summernote').summernote()
        $('#pilih').select2();
        // romove alert
        window.setTimeout(function() {
            $("#alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 2000);
        const url = new URL(location);
        const ok = url.searchParams.get("ok");
        if (ok == 0) {
            url.searchParams.delete('ok');
            window.history.replaceState({}, document.title, url);
        }

        // CKEDITOR.replace('ckedtor1',{
        // uiColor:'#FAFAFA',
        // filebrowserImageBrowseUrl : '../apl/kcfinder'
        // });



    });

    // Modal Balas Pesan
    function modalBalasPesan() {
        $(document).on('click', '#select', function() {
            $('#modalReply').modal('show', {
                backdrop: 'static'
            });
            var id = $(this).data('id');
            var judul = $(this).data('judul');
            var topik = $(this).data('topik');
            var subyek = $(this).data('subyek');
            var pengirim = $(this).data('pengirim');
            var penerima = $(this).data('penerima');
            var pembing = $(this).data('pembing');
            var jenis_pemb = $(this).data('jenis_pemb');
            var periode = $(this).data('periode');

            $('#id').val(id);
            $('#judul').val(judul);
            $('#topik').val(topik);
            $('#subyek').val(subyek);
            $('#pengirim').val(pengirim);
            $('#penerima').val(penerima);
            $('#pembing').val(pembing);
            $('#periode').val(periode);
        })
    }
    </script>
    <!-- PROFIL MODAL -->
    <script type="text/javascript">
    function EnableDisableTextBox(chkPassport) {
        var txtPassportNumber = document.getElementById("txtPassportNumber");
        txtPassportNumber.disabled = chkPassport.checked ? false : true;
        if (!txtPassportNumber.disabled) {
            txtPassportNumber.focus();
        }
    }
    </script>

</body>

</html>
<?php } else {
    echo "<script>window.location='../';</script>";
} ?>
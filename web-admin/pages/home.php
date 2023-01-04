<?php 
$jmlMhs = mysqli_num_rows(mysqli_query($con,"SELECT id_mhs FROM tb_mhs "));
$jmlDsn = mysqli_num_rows(mysqli_query($con,"SELECT id_dsn FROM tb_dsn "));
$jmlJudul = mysqli_num_rows(mysqli_query($con,"SELECT pengajuan_id FROM pengajuan WHERE disetujui_kajur='Y' "));
$on = mysqli_num_rows(mysqli_query($con,"SELECT pembing_id FROM pembing WHERE status_bimbingan='proses' "));
 ?>
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </div>

          <div class="row mb-3">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100 bg-gradient-primary text-white">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Jumlah Dosen</div>
                      <div class="h5 mb-0 font-weight-bold text-white"> <?= $jmlDsn ?> </div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-warning mr-2"><i class="fa fa-user"></i> <?= $jmlDsn ?> </span>
                        <span class="text-white">Jumlah Data Dosen</span>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-user fa-3x text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Earnings (Annual) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100 bg-gradient-dark text-white">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">JUMLAH MAHASISWA</div>
                      <div class="h5 mb-0 font-weight-bold text-warning"> <?= $jmlMhs ?> </div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-warning mr-2"><i class="fas fa-users"></i> <?= $jmlMhs ?></span>
                        <span class="text-white">Jumlah Data Mahasiwa</span>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-3x text-warning"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- New User Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100 bg-gradient-warning text-white">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">JUMLAH SKRIPSI/TA</div>
                      <div class="h5 mb-0 mr-3 font-weight-bold text-black"> <?= $jmlJudul ?> </div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-white mr-2"><i class="fas fa-file-alt"></i> <?= $jmlJudul ?></span>
                        <span class='text-white'>Jumlah Data Skripsi/TA</span>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-file-alt fa-3x text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100 bg-gradient-success text-white">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">SEDANG BIMBINGAN</div>
                      <div class="h5 mb-0 font-weight-bold text-white"><?= $on ?></div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-white mr-2"><i class="fas fa-comments"></i> <?= $on ?></span>
                        <span class="text-white">Jumlah Mahasiswa Bimbingan</span>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-comments fa-3x text-warning"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- end row 1 -->
          <!-- row 2 -->
          <div class="row">
            <div class="col-xl-8 col-lg-8">
                <!-- Informasi Judul Baru-->
                <div class="card">
                <div class="card-header py-2 bg-gradient-primary text-white d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold"><i class="fa fa-info"></i> Informasi Judul Baru</h6>
                </div>
                <div>
                <?php 
                if (mysqli_num_rows($new_judul)< 1) {                
                echo "<center><p>Belum ada informasi ...</p></center>";
                }else{
                ?>
                <?php 
                foreach ($new_judul as $nj) :?>
                <div class="customer-message align-items-center">
                <a class="font-weight-bold" href="?pages=list_judul&details=<?= $nj['pengajuan_id'] ?>">
                <div class="text-truncate message-title"><?= $nj['judul'] ?></div>
                <div class="small text-gray-500 message-time font-weight-bold"><?= $nj['nama'] ?>  · Mengajukan judul penelitian - <?= date('d-m-Y H:i:s',strtotime($nj['tgl_pengajuan'])) ?></div>
                </a>
                </div>
                <?php endforeach; ?>


                <div class="card-footer text-center">
                <a class="m-0 small text-primary card-link" href="?pages=list_judul">View More <i
                class="fas fa-chevron-right"></i></a>
                </div>

                <?php
                }
                ?>
                </div>
                </div>

                <!-- end judul baru -->
    <!-- Informasi Revisi Judul -->
    <div class="card mt-2 mb-2">
    <div class="card-header py-2 bg-gradient-warning text-white d-flex flex-row align-items-center justify-content-between">
    <h6 class="m-0 font-weight-bold"><i class="fa fa-info"></i> Informasi Revisi Judul </h6>
    </div>
    <div>

    <!-- Revisi Judul -->
    <?php 
    $cekJudulRevisi = mysqli_query($con,"SELECT 
    tb_mhs.id_mhs,
    tb_mhs.nim,
    tb_mhs.nama,
    pengajuan.pengajuan_id,
    pengajuan.revisi_judul
    FROM pengajuan
    JOIN tb_mhs ON pengajuan.id_mhs=tb_mhs.id_mhs
    WHERE pengajuan.stt_revisi='new' ");
    if (mysqli_num_rows($cekJudulRevisi) < 1) {
      echo "<center><p>Belum ada informasi ...</p></center>";
    }
    foreach ($cekJudulRevisi as $nRev):?>
    <div class="customer-message align-items-center">
    <a class="font-weight-bold" href="?pages=detail_judul_revisi&details=<?= $nRev['pengajuan_id'] ?>">
    <div class="text-truncate message-title"><?= $nRev['revisi_judul'] ?></div>
    <div class="small text-gray-500 message-time font-weight-bold"><?= $nRev['nama'] ?>  · Mengajukan Revisi Judul</div>
    </a>
    </div>
    <?php endforeach; ?>


    <!-- end revisi judu -->
    </div>
    </div>

    <!-- end Revisi judul -->

        <!-- Informasi Perpanjangan SK -->
    <div class="card mt-2 mb-4">
    <div class="card-header py-2 bg-gradient-success text-white d-flex flex-row align-items-center justify-content-between">
    <h6 class="m-0 font-weight-bold"><i class="fa fa-info"></i> Informasi Perpanjangan SK</h6>
    </div>
    <div>

    <!-- Revisi Judul -->
    <?php 
    $cekPerpanjanganSK = mysqli_query($con,"SELECT 
    tb_mhs.id_mhs,
    tb_mhs.nim,
    tb_mhs.nama,
    pengajuan.pengajuan_id,
    pengajuan.tgl_pengajuan_sk,
    pengajuan.alasan_perpanjangan_sk
    FROM pengajuan
    JOIN tb_mhs ON pengajuan.id_mhs=tb_mhs.id_mhs
    WHERE pengajuan.status_perpanjangan_sk='new' ");
    if (mysqli_num_rows($cekPerpanjanganSK) < 1) {
      echo "<center><p>Belum ada informasi ...</p></center>";
    }
    foreach ($cekPerpanjanganSK as $nSk):?>
    <div class="customer-message align-items-center">
    <a class="font-weight-bold" href="?pages=detail_sk&details=<?= $nSk['pengajuan_id'] ?>">
    <div class="text-truncate message-title"><?= date('d-m-Y', strtotime($nSk['tgl_pengajuan_sk'])) ?> <code>
      <?= $nSk['alasan_perpanjangan_sk'] ?>
    </code></div>
    <div class="small text-gray-500 message-time font-weight-bold"><?= $nSk['nama'] ?>  · Mengajukan Perpanjangan SK Bimbingan</div>
    </a>
    </div>
    <?php endforeach; ?>


    <!-- end perpanjangan SK-->
    </div>
    </div>

  



            </div>
            <div class="col-xl-4 col-lg-4">

              <!-- informasi user baru -->
                <?php 
               
                if (mysqli_num_rows($new_user)> 0) {
                ?>
                <div class="col-xl-12 col-lg-12">
                <div class="card mb-4">
                <div class="card-header bg-gradient-primary text-white py-2 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold"><i class="fa fa-user"></i> User Baru</h6>
                </div>
                <div class="card-body">
                <?php 
                foreach ($new_user as $nu) :?>
                <div class="mt-1">
                <a class="dropdown-item" href="#">
                <div class="dropdown-list-image">
                <img class="rounded-circle" src="../apl/img/<?= $nu['fotomhs'] ?>" style="max-width: 30px" alt="">
                <div class="status-indicator">
                <?= $nu['nama'] ?>
                </div>
                </div>
                <div class="small text-gray-500">Tanggal · <?= date('d-m-Y H:i:s',strtotime($nu['create_at'])) ?></div>
                </a>
                </div>
                <?php endforeach; ?>                  
                </div>
                <div class="card-footer text-center">
                <a class="m-0 small text-primary card-link" href="?pages=list_account">View More <i
                class="fas fa-chevron-right"></i></a>
                </div>
                </div>
                </div>
                <?php              
                }
                ?>            
                <!-- end user baru -->


            </div>
          </div>
          <!-- end row 2 -->
          
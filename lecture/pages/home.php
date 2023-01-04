<?php 
$jmlMhs = mysqli_num_rows(mysqli_query($con,"SELECT pembing_id FROM pembing WHERE dosen=$userID AND kesediaan='Y' "));
$jmlMhsSelesai = mysqli_num_rows(mysqli_query($con,"SELECT pembing_id FROM pembing WHERE dosen=$userID AND kesediaan='Y' AND status_bimbingan='selesai' "));
 ?>
<!--           <div class="d-sm-flex align-items-center justify-content-between">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </div> -->
              <div class="row">
    <div class="col-lg-12">
      <center>
        <img src="../logo.png" style="max-height: 90px">
      <h3>Selamat Datang ! <br>
        <b> <?= $user['nama_dosen'] ?> </b>
      </h3>
    </center> 
    </div>   
  </div>
<div class="row mb-4">
  <div class="col-xl-8 col-lg-8">

    <div class="row">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-6 col-md-6 mb-4">
              <div class="card h-100 bg-gradient-primary text-white">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Mahasiswa Bimbingan</div>
                      <div class="h5 mb-0 font-weight-bold text-warning"> <?=$jmlMhs?> Mahasiswa</div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-white mr-2"><i class="fa fa-users"></i> <?=$jmlMhs?></span>
                        <span class="text-white">Jumlah Mahasiswa Bimbingan</span>
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
            <div class="col-xl-6 col-md-6 mb-4">
              <div class="card h-100 bg-gradient-success text-white">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">SELESAI BIMBINGAN</div>
                      <div class="h5 mb-0 mr-3 font-weight-bold text-white"><?=$jmlMhsSelesai?> Mahasiswa</div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-white mr-2"><i class="fas fa-check"></i> <?=$jmlMhsSelesai?> </span>
                        <span class="text-white">Jumlah Selesai Bimbingan</span>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-check fa-3x text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>    
  </div>
  

</div>
  <div class="col-xl-4 col-lg-4">
    <div class="row">
      <!-- Informasi Judul Baru-->
                <?php 
                $new_judul = mysqli_query($con,"SELECT
                tb_mhs.id_mhs,
                tb_mhs.nama,
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
                GROUP BY pengajuan.id_mhs
                ORDER BY pengajuan.pengajuan_id
                DESC LIMIT 4");
                if (mysqli_num_rows($new_judul) > 0) {
                ?>
                <div class="col-xl-12 col-lg-12 ">
                <div class="card">
                <div class="card-header py-2 bg-gradient-primary text-white d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold"><i class="fa fa-check"></i> Rekomendasi Topik Berikut</h6>
                </div>
                <div>
                <?php 
                foreach ($new_judul as $nj) :?>
                <div class="customer-message align-items-center">
                <a class="font-weight-bold" href="?pages=list_judul&details=<?= $nj['pengajuan_id'] ?>">
                <div class="text-truncate message-title"><?= $nj['judul'] ?></div>
                <div class="small text-gray-500 message-time font-weight-bold"><?= $nj['nama'] ?> · <?= date('d-m-Y H:i:s',strtotime($nj['tgl_pengajuan'])) ?></div>
                </a>
                </div>
                <?php endforeach; ?>
                <div class="card-footer text-center">
                <a class="m-0 small text-primary card-link" href="?pages=list_judul">View More <i
                class="fas fa-chevron-right"></i></a>
                </div>
                </div>
                </div>
                </div>

                <?php

                }
                ?>
            
            <!-- end judul baru -->

            <!-- kesediaan jadi dosen pembimbing -->
                <?php 
                $pembing = mysqli_query($con,"SELECT
                pembing.pembing_id,
                pembing.create_at,
                pembing.kesediaan,
                pembing.jenis,
                pengajuan.pengajuan_id,
                pengajuan.judul
                FROM pembing 
                JOIN pengajuan ON pembing.pengajuan_id=pengajuan.pengajuan_id
                JOIN tm_periode ON pengajuan.periode_id=tm_periode.periode_id
                WHERE pembing.dosen='$userID'
                 AND pembing.kesediaan='new'
                  AND tm_periode.stt_periode='on'
                ORDER BY pembing.pembing_id ASC LIMIT 4
                ");
                if (mysqli_num_rows($pembing)> 0) {
                ?>
                <div class="col-xl-12 col-lg-12 mt-3">
                <div class="card mb-4">
                <div class="card-header py-2 bg-gradient-info text-white d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold"><i class="fa fa-envelope"></i> Permintaan Pembimbing</h6>
                </div>
                <div>
                <?php 
                foreach ($pembing as $np) :?>
                <div class="customer-message align-items-center">
                <a class="font-weight-bold" href="?pages=list_permintaan&read=<?= $np['pembing_id'] ?>">
                <div class="text-truncate message-title"><?= $np['judul'] ?></div>
                <div class="small text-gray-500 message-time font-weight-bold">Admin· <?= date('d-m-Y H:i:s',strtotime($np['create_at'])) ?></div>
                </a>
                </div>
                <?php endforeach; ?>
                <div class="card-footer text-center">
                <a class="m-0 small text-primary card-link" href="?pages=list_permintaan">View More <i
                class="fas fa-chevron-right"></i></a>
                </div>
                </div>
                </div>
                </div>
                <?php

                }
                ?>
                     
            <!-- end kesediaan -->
      
    </div>    
  </div>
</div>




         
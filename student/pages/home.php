<div class="text-center">
<img src="../logo.png" style="max-height: 90px">
<h4 class="pt-3">Selamat Datang ! <br> <b><?= $user['nama'] ?></b></h4>
</div>
    <?php 
    // tampilkan form untuk memilih dosen PA jika belum ada dosen PA dipilih mahasiswa
    if ($user['dosen_pa']==0) {
    ?>
    <div class="row mb-4 mt-3">
    <div class="col-lg-12">
          <div class="alert alert-light bg-gradient-light alert-dismissible" role="alert">
          <h6><i class="fas fa-exclamation-triangle"></i><b> Pemberitahuan </b></h6>
          Silahkan Memilih Dosen Pembimbing Akademik, untuk memulai mengajukan Judul Penelitian, agar dosen bersangkutan dapat merekomendasikan judul penelitian yang kamu ajukan !
          </div>
    <div class="card">
    <div class="card-header bg-gradient-primary text-white">
    <h6>#1 Pembimbing Akademik</h6>
    </div>
    <div class="card-body">
    <div class="row">
    <div class="col-lg-6">
    <form method="POST">
    <div class="input-group mt-3">
    <select class="form-control form-control-sm" name="pa" id="pilih">
    <option value="">Pilih Dosen Pembimbing Akademik</option>
    <?php 
    $i=1;
    $pa = mysqli_query($con,"SELECT tb_dsn.id_dsn,tb_dsn.nip,tb_dsn.nama_dosen FROM tb_dsn ORDER BY id_dsn ASC ");
    foreach ($pa as $dpa) {?>
    <option value="<?= $dpa['id_dsn'] ?>"><?= $i++ ?>. <?= $dpa['nip'] ?> <?= $dpa['nama_dosen'] ?></option>
    <?php } ?>

    </select>
    <div class="input-group-append">
    <button type="submit" name="add" class="btn btn-dark btn-sm bg-gradient-dark btn-icon-split">
    <span class="icon text-white-50">
    <i class="fas fa-plus"></i>
    </span>
    <span class="text">SIMPAN</span>
    </button>

    </div>
    </div> 
    </form>
<?php
// menyimpan data dosen PA
if (isset($_POST['add'])) {
$pa = intval($_POST['pa']);
mysqli_query($con,"UPDATE tb_mhs SET dosen_pa='$pa' WHERE id_mhs=$userID ");
echo "<script>
  alert('Sukses ! Dosen Pembimbing Akademik telah ditambahkan, silahkan buat judul penelitian anda !');
  window.location='./';
</script>";
} 
?>


    </div>

    </div>   

    </div>
    </div>
    </div>
    </div>

    <?php
    }else{
      // manampilakan data daftar judul
      $ta = mysqli_query($con,"SELECT * FROM pengajuan WHERE id_mhs=$userID ORDER BY pengajuan_id ASC ");
      //  informasi jika belum ada judul penelitian
      if (mysqli_num_rows($ta) < 1) {
      ?>
      <div class="row mb-4 mt-3">
      <div class="col-lg-12">
      <div class="alert alert-light bg-gradient-light alert-dismissible" role="alert">
      <h6><i class="fas fa-exclamation-triangle"></i><b> Pemberitahuan !</b></h6>
      Saat ini anda belum pernah mengajukan topik penelitian, Silahkan mengajukan Topik Penelitian maksimal 3  Pembahasan, klik <a href="?pages=add_judul">disini ?</a> atau pada menu <b>"Usulkan Topik"</b>.
      </div>
      </div>
      </div>
      <?php

      // end informasi jika belum ada judul penelitian
      }else{
        // dashboard
        ?>
        <div class="row">
            <!-- Earnings (Monthly) Card Example -->
            <a href="?pages=doc" class="col-xl-4 col-md-4 mb-4" style="text-decoration: none;">
              <div class="card h-100 bg-gradient-primary text-white">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Dokumen</div>
                      <div class="h5 mb-0 font-weight-bold text-white"> FILE SKRIPSI/TA</div>
                     
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-file-alt fa-4x text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </a>
            
            <!-- New User Card Example -->
            <a href="?pages=consult" class="col-xl-4 col-md-4 mb-4" style="text-decoration: none;">
              <div class="card h-100 bg-gradient-success text-white">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">BIMBINGAN</div>
                      <div class="h5 mb-0 mr-3 font-weight-bold text-white">KONSULTASI SKRIPSI/TA</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-comments fa-4x text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </a> 
                        <!-- New User Card Example -->
            <a href="?pages=history" class="col-xl-4 col-md-4 mb-4" style="text-decoration: none;">
              <div class="card h-100 bg-gradient-danger text-white">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">HISTORY</div>
                      <div class="h5 mb-0 mr-3 font-weight-bold text-white">BUKTI BIMBINGAN SKRIPSI/TA</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clock fa-4x text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </a>    
  </div>
        <?php

        // end dashboard

      }


    }


    ?>




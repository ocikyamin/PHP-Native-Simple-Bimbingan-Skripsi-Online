  <?php 
if (isset($_SESSION['ADMIN_SESS'])) {
// Aktifkan akun
if (isset($_GET['active'])) {
$id =intval($_GET['active']);
$is_actived=mysqli_query($con,"UPDATE tb_mhs SET status_akun='Y' WHERE id_mhs={$id} ");
if ($is_actived) {
  echo "
<script>
alert('Akun diaktifkan !')
window.location ='?pages=list_account';   
</script>";
}else{
  echo "
<script>
alert('Oppss ! Gagal diaktifkan !')
window.location ='?pages=list_account#';   
</script>";
}
}
}
?>
  <!-- tampilkan detail judul -->
  <?php 
  if (isset($_GET['details'])) {
    $detailID= intval($_GET['details']);
    $detail = mysqli_fetch_assoc(mysqli_query($con,"SELECT tb_mhs.id_mhs,tb_mhs.nim,tb_mhs.nama,pengajuan.judul,pengajuan.masalah,pengajuan.rekomendasi_pa,pengajuan.disetujui_kajur,pengajuan.pengajuan_id FROM pengajuan JOIN tb_mhs ON pengajuan.id_mhs=tb_mhs.id_mhs WHERE pengajuan.pengajuan_id=$detailID"));

    if (isset($_GET['confirm'])) {
        $konfirm= mysqli_escape_string($con,$_GET['confirm']); 
        $tglacc = date('Y-m-d H:i:s');
        if ($konfirm=='ok') {
          $cekJudulIsOK = mysqli_num_rows(mysqli_query($con,"SELECT pengajuan_id FROM pengajuan WHERE id_mhs=$detail[id_mhs] AND disetujui_kajur='Y' "));
          if ($cekJudulIsOK < 1) {
             mysqli_query($con,"UPDATE pengajuan SET disetujui_kajur='Y',tgl_acc='$tglacc' WHERE pengajuan_id=$detailID ");
              echo " <script>
              alert('Judul disetujui');
              window.location='?pages=fix_judul';
              </script>";            
          }else{
             mysqli_query($con,"UPDATE pengajuan SET disetujui_kajur='N',tgl_acc='$tglacc' WHERE pengajuan_id=$detailID ");
              echo " <script>
              alert('Judul ditolak karna sudah ada yg disetuji ..');
              window.location='?pages=list_judul';
              </script>";
          }


           
        }elseif ($konfirm=='no') {
              mysqli_query($con,"UPDATE pengajuan SET disetujui_kajur='N',tgl_acc='$tglacc' WHERE pengajuan_id=$detailID ");
              echo " <script>
              alert('Judul ditolak');
              window.location='?pages=list_judul';
              </script>";
        }
    }

     
    ?>
   
      <div class="row mb-4">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header bg-gradient-primary text-white" style="text-transform: uppercase;">
              <div class="row">
                <div class="col-lg-10">
                    <div class="row" style="border-bottom: 2px solid;">
                    <div class="col-lg-3">Nim</div>
                    <div class="col-lg-9"><?= $detail['nim'] ?></div>
                    </div>
                    <div class="row" style="border-bottom: 2px solid;">
                    <div class="col-lg-3">Nama</div>
                    <div class="col-lg-9"><?= $detail['nama'] ?></div>
                    </div>
                    <div class="row" style="border-bottom: 2px solid;">
                    <div class="col-lg-3">Judul</div>
                    <div class="col-lg-9"><?= $detail['judul'] ?></div>
                    </div>
                  
                </div>
                <div class="col-lg-2">
                  <a href="?pages=list_judul&details=<?= $detailID ?>&confirm=ok" onclick="return confirm('Apakah Yakin ?')" class="btn btn-primary bg-gradient-primary btn-block btn-sm text-white mt-3"><i class="fa fa-check"></i> Terima</a>
                  <a href="?pages=list_judul&details=<?= $detailID ?>&confirm=no" onclick="return confirm('Apakah Yakin ?')" class="btn btn-danger bg-gradient-danger btn-block btn-sm text-white"><i class="fa fa-times"></i> Tolak</a>
                </div>
              </div>                                
            </div>
            <div class="card-body">
              <h3>Pokok Masalah</h3>
              <?= $detail['masalah'] ?>
            </div>
          </div>
        </div>        
      </div>
    <?php
  }else{
    // tampilkan daftar judul baru
    ?>
    <div class="d-sm-flex align-items-center justify-content-between">
<h1 class="h3 mb-0 text-gray-800">Judul Baru</h1>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="./">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Judul Baru</li>
</ol>
</div>
    <div class="row">
          <div class="col-lg-12 mb-4">
          <!-- Simple Tables -->
          <div class="card">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Daftar Judul Baru</h6>
          </div>
          <div class="table-responsive">
          <table class="table table-sm align-items-center table-flush">
          <thead class="thead-light">
          <tr>
          <th>#</th>
          <th>TANGGAL</th>
          <th>NIM</th>
          <th>NAMA</th>
          <th></th>
          </tr>
          </thead>
          <tbody>
          <?php 
          $i=1;
          $new_judul = mysqli_query($con,"SELECT tb_mhs.id_mhs,tb_mhs.nim,tb_mhs.nama,pengajuan.tgl_pengajuan,pengajuan.judul FROM pengajuan JOIN tb_mhs ON pengajuan.id_mhs=tb_mhs.id_mhs WHERE disetujui_kajur='new' GROUP BY id_mhs ORDER BY pengajuan_id ASC");
          foreach ($new_judul as $djb):?>
          <tr class='header1 expand' style="cursor: pointer;">
          <td><a href="#"><?= $i++ ?></a></td>
          <td><?= date('d-m-Y H:i:s',strtotime($djb['tgl_pengajuan'])) ?></td>
          <td><?= $djb['nim'] ?></td>
          <td><?= $djb['nama'] ?></td>             
          <td>
            <a href="#" class="btn btn-dark btn-sm bg-gradient-dark text-white expand"><i class="fa fa-plus"></i></a>
          </td>
          </tr>
          <tr>
          <td colspan="5">
          <table class="table table-sm mid">
          <thead class="bg-gradient-primary text-white">
          <tr>
          <th>Action</th>
          <th>Judul</th>
          <th>Rekomendasi PA ?</th>
          <th>Status</th>
          </tr>
          </thead>
          <?php 
          $ii=1;
          $list = mysqli_query($con,"SELECT tb_mhs.id_mhs,pengajuan.judul,pengajuan.rekomendasi_pa,pengajuan.disetujui_kajur,pengajuan.pengajuan_id FROM pengajuan JOIN tb_mhs ON pengajuan.id_mhs=tb_mhs.id_mhs WHERE pengajuan.id_mhs=$djb[id_mhs] ORDER BY pengajuan_id ASC");
          foreach ($list as $dj):?>
          <tr>
          <!-- <td><?= $ii++ ?>.</td> -->
          <td><a href="?pages=list_judul&details=<?= $dj['pengajuan_id'] ?>" class="btn btn-primary btn-sm bg-gradient-primary text-white">Konfirmasi</a></td>
          <td><?= $dj['judul'] ?></td>
          <td>
          <?php if ($dj['rekomendasi_pa']=='Y') {
          echo '<span class="badge badge-success">Ya</span>';
          }elseif ($dj['rekomendasi_pa']=='new') {
          echo '<span class="badge badge-warning">Belum ada tanggapan PA</span>';
          }else{
            echo '<span class="badge badge-danger">Ditolak PA</span>';
          } ?>                    
          </td>
          <td>
          <?php if ($dj['disetujui_kajur']=='Y') {
          echo '<span class="badge badge-success">Disetujui Prodi</span>';
          }elseif ($dj['disetujui_kajur']=='new') {
          echo '<span class="badge badge-warning">Belum ada tanggapan Prodi</span>';
          }else{
           echo '<span class="badge badge-danger">Ditolak Prodi</span>'; 
          } ?>
          </td>
          </tr>
          <?php endforeach; ?>
          </table>

          </td>
          </tr>
          <?php endforeach; ?>
          </tbody>
          </table>
          </div>
          </div>
          </div>
          </div>


    <?php

  }

   ?>
  <!-- end detail judul -->
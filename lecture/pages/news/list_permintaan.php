<?php 
if (isset($_SESSION['LECT_SES'])) {
// cek sebelum hapus data
if (isset($_GET['info'])) {
$id =intval($_GET['info']);
if ($_GET['confirm']=='yes') {
mysqli_query($con,"UPDATE pembing SET kesediaan='Y',status_bimbingan='proses' WHERE pembing_id={$id} ");
echo "
<script>
alert('Permohonan disetujui !')
window.location ='?pages=list_permintaan';   
</script>";
}
if ($_GET['confirm']=='no') {
mysqli_query($con,"UPDATE pembing SET kesediaan='N' WHERE pembing_id={$id} ");
echo "
<script>
alert('Permohonan ditolak !')
window.location ='?pages=list_permintaan';   
</script>";
}

}
}

?>


<?php 
// menampilkan data permintaan pembimbing 
if (isset($_GET['read'])) {
  $readID =intval($_GET['read']);
$detail = mysqli_fetch_assoc(mysqli_query($con,"SELECT tb_mhs.id_mhs, tb_mhs.nim, tb_mhs.nama, tb_mhs.fotomhs, tb_mhs.tahun_angkatan, tm_prodi.prodi, tm_fakultas.fakultas, tb_dsn.nama_dosen, pengajuan.judul, pengajuan.rekomendasi_pa, pengajuan.disetujui_kajur, pengajuan.pengajuan_id, pembing.pembing_id FROM pembing 
  JOIN tm_periode ON pembing.periode=tm_periode.periode_id
  JOIN pengajuan ON pembing.pengajuan_id=pengajuan.pengajuan_id
   JOIN tb_mhs ON pembing.id_mhs=tb_mhs.id_mhs
    JOIN tm_prodi ON tb_mhs.prodi_id=tm_prodi.prodi_id
     JOIN tm_fakultas ON tm_prodi.fakultas_id=tm_fakultas.fakultas_id 
     JOIN tb_dsn ON tb_mhs.dosen_pa=tb_dsn.id_dsn 
WHERE pembing.pembing_id=$readID AND tm_periode.stt_periode='on' "));
  ?>

      <div class="row mb-4">
        <div class="col-lg-12">

  
          <div class="card">
            <div class="card-header">
              <table width="100%" style="border-bottom: 5px double;">
                  <tr>
                  <td align="center"> <img src="../logo.png"/ class="img-fluid" width="90"></td>
                  </tr>
                  <tr>
                  <td align="center">
                  <h4><strong style="text-transform: uppercase;">FAKULTAS <?= $detail['fakultas'] ?></strong></h4>
                  <h5><strong style="text-transform: uppercase;">PRODI DAN KONSENTRASI <?= $detail['prodi'] ?></strong></h5>
                  <p align="center"><em>Alamat : Jl. Soekarno Hatta No.94, Mojolangu, Kec. Lowokwaru,Kota Malang, Jawa Timur 65142</em></p>
                  </td>
                  </tr>
                  </table>

                  <table cellpadding="1" cellspacing="1" style="width:100%">
                  <tbody>
                  <tr>
                  <td>Lamp</td>
                  <td>: 1 (Satu) Rangkap</td>
                  </tr>
                  <tr>
                  <td>Hal</td>
                  <td>: <strong>Mohon Kesediaan Jadi Pembimbing</strong></td>
                  </tr>
                  </tbody>
                  </table>
                  <p>Yth : Bapak / Ibu <br> <strong><?php echo $user['nama_dosen']; ?></strong><br>
                  Di Tempat
                  </p>

                  <p>&nbsp; &nbsp;Sesuai dengan usulan Pembimbing Skripsi yang dia ajukan oleh Mahasiswa Prodi <?= $detail['prodi'] ?> <br>
                  Fakultas <?= $detail['fakultas'] ?> Sekolah Tinggi Tekni Malang, Maka bersama ini dimohon kesediaan Bapak/Ibu sebagai pembimbing Skripsi Mahasiswa dibawah ini :
                  </p>
            </div>
            <div class="card-header bg-gradient-light text-black" style="text-transform: uppercase;color: black">
              <div class="row">
                <div class="col-lg-10">
                    <div class="row" style="border-bottom: 1px solid;">
                    <div class="col-lg-3">Nim</div>
                    <div class="col-lg-9"><?= $detail['nim'] ?></div>
                    </div>
                    <div class="row" style="border-bottom: 1px solid;">
                    <div class="col-lg-3">Nama</div>
                    <div class="col-lg-9"><?= $detail['nama'] ?></div>
                    </div>
                      <div class="row" style="border-bottom: 1px solid;">
                    <div class="col-lg-3">TAHUN MASUK</div>
                    <div class="col-lg-9"><?= $detail['tahun_angkatan'] ?></div>
                    </div>
                      <div class="row" style="border-bottom: 1px solid;">
                    <div class="col-lg-3">Prodi</div>
                    <div class="col-lg-9"><?= $detail['prodi'] ?></div>
                    </div>
                    <div class="row" style="border-bottom: 1px solid;">
                    <div class="col-lg-3">Dosen PA</div>
                    <div class="col-lg-9"><?= $detail['nama_dosen'] ?></div>
                    </div>
                    <div class="row">
                    <div class="col-lg-3">Judul</div>
                    <div class="col-lg-9"><?= $detail['judul'] ?></div>
                    </div>
                  
                </div>
                <div class="col-lg-2">
                   <center>
                     <img class="img-profile rounded-circle" src="../apl/img/<?= $detail['fotomhs'] ?>" style="max-width: 100px">
                   </center>
                  
                </div>
              </div>                               
            </div>
            <div class="card-body">
              <p>&nbsp; &nbsp; &nbsp;Demikian permohonan ini kami sampaikan atas perhatian dan kerjasamanya di ucapkan terimakasih.</p>
              <center>
                  <a href="?pages=list_permintaan&info=<?= $detail['pembing_id'] ?>&confirm=yes" onclick="return confirm('Apakah Yakin ?')" class="btn btn-primary bg-gradient-primary text-white btn-sm btn-icon-split mt-2">
                    <span class="icon text-white-50">
                      <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Saya Bersedia</span>
                  </a>
                    <a href="?pages=list_permintaan&info=<?= $detail['pembing_id'] ?>&confirm=no" onclick="return confirm('Apakah Yakin ?')" class="btn btn-danger bg-gradient-danger text-white btn-sm btn-icon-split mt-2">
                    <span class="icon text-white-50">
                      <i class="fas fa-times"></i>
                    </span>
                    <span class="text">Saya Tidak Bersedia</span>
                  </a>
              </center>
            </div>
          </div>
        </div>
      </div>

  <!-- end manampilkan pembimbing yang telah dipilih -->
      

  <?php
}else{
  // tampilkan Daftar Permintaan
  ?>
  <div class="d-sm-flex align-items-center justify-content-between">
<h1 class="h3 mb-0 text-gray-800">Permintaan</h1>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="./">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Permintaan</li>
</ol>
</div>
      <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Daftar Permintaan Pembimbing</h6>
                </div>
                <div class="table-responsive">
                  <table class="table table-sm align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>TANGGAL</th>
                        <th>NIM</th>
                        <th>NAMA</th>
                        <th>JUDUL</th>
                        <th>ACTION</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $i=1;
                        $permintaan = mysqli_query($con,"SELECT
                        tb_mhs.nim,
                        tb_mhs.nama,
                        pembing.pembing_id,
                        pembing.create_at,
                        pengajuan.pengajuan_id,
                        pengajuan.judul
                        FROM pembing
                        JOIN tm_periode ON pembing.periode=tm_periode.periode_id 
                        JOIN tb_mhs ON pembing.id_mhs=tb_mhs.id_mhs
                        JOIN pengajuan ON pembing.pengajuan_id=pengajuan.pengajuan_id
                        WHERE pembing.dosen='$userID' 
                        AND pembing.kesediaan='new'
                        AND tm_periode.stt_periode='on'
                        ORDER BY pembing.pembing_id ASC
                        ");
                      foreach ($permintaan as $dp):?>
                      <tr>
                        <td><a href="#"><?= $i++ ?></a></td>
                        <td><?= date('d-m-Y H:i:s',strtotime($dp['create_at'])) ?></td>
                        <td><?= $dp['nim'] ?></td>
                        <td><?= $dp['nama'] ?></td>
                        <td><?= $dp['judul'] ?></td>
                        <td>
                          <a href="?pages=list_permintaan&read=<?= $dp['pembing_id'] ?>" class="btn btn-sm btn-primary bg-gradient-primary text-white"><i class="fa fa-envelope"></i> Read</a>

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
  // end permintaan
}

 ?>


  
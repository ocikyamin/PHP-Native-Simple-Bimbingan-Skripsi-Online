  <!-- Tampilkan daftar judul yg telah di acc prodi -->

  <div class="d-sm-flex align-items-center justify-content-between">
<h1 class="h3 mb-0 text-gray-800">Report</h1>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="./">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Report</li>
</ol>
</div>
    <div class="row">
          <div class="col-lg-12 mb-4">
          <!-- Simple Tables -->
          <div class="card">
          <div class="card-header bg-gradient-primary text-white py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-white">Daftar SK Pembimbing</h6>
             <a href="../apl/report/SK.php?ta=<?=$tp['periode_id'] ?>&tp=<?=$tp['th_periode'] ?>" target="_blank" class="btn btn-outline-light text-white btn-sm btn-icon-split mt-2">
              <span class="icon text-white-50">
                <i class="fas fa-print"></i>
              </span>
              <span class="text">Print</span>
            </a>
          </div>
          <div class="table-responsive">
          <table class="table table-sm align-items-center table-flush mid">
          <!-- <table width="100%" cellpadding="3" border="1" style="border-collapse: collapse;"> -->
  <tr>
    <th>NO</th>
    <th>NAMA</th>
    <th>NIM</th>
    <th>PROGRAM STUDI</th>
    <th>KONSENTRASI</th>
    <th>JUDUL</th>
    <th>PEMBIMBING</th>
  </tr>
<?php
$i=1;
$daftarPembing = mysqli_query($con,"SELECT 
  tb_mhs.nim,
  tb_mhs.nama,
  tm_prodi.prodi,
  tm_prodi.konsen,
  tb_dsn.nama_dosen,
  pengajuan.judul
  FROM pembing
  JOIN tb_mhs ON pembing.id_mhs=tb_mhs.id_mhs
  JOIN tm_prodi ON tb_mhs.prodi_id=tm_prodi.prodi_id
  JOIN pengajuan ON pembing.pengajuan_id=pengajuan.pengajuan_id
  JOIN tb_dsn ON pembing.dosen=tb_dsn.id_dsn
  WHERE pembing.kesediaan='Y'
  ORDER BY pembing.pembing_id ASC");
foreach ($daftarPembing as $d):?>
  <tr>
    <td><?= $i++ ?>.</td>
    <td><?= $d['nama'] ?> </td>
    <td><?= $d['nim'] ?> </td>
    <td><?= $d['prodi'] ?> </td>
    <td><?= $d['konsen'] ?> </td>
    <td><?= $d['judul'] ?> </td>
    <td><?= $d['nama_dosen'] ?> </td>
  </tr>
<?php endforeach; ?>

</table>
          </div>
          </div>
          </div>
          </div>

  <!-- end acc prodi -->


 

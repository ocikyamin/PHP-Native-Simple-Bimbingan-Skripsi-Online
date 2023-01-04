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
          <h6 class="m-0 font-weight-bold text-white">Daftar Mahasiswa Bimbingan</h6>
             <a href="../apl/report/mahasiswa_bimbingan.php" target="_blank" class="btn btn-outline-light text-white btn-sm btn-icon-split mt-2">
              <span class="icon text-white-50">
                <i class="fas fa-print"></i>
              </span>
              <span class="text">Print</span>
            </a>
          </div>
          <div class="table-responsive">
          <table class="table table-sm align-items-center table-flush mid">
          <thead class="thead-light">
          <tr>
          <th>NO</th>
         
          <th>MAHASISWA</th>
          <th>PEMBIMBING</th>
          <th>MULAI BIMBINGAN</th>
          <th>SELESAI BIMBINGAN</th>
          <!-- <th>ACTION</th> -->
          </tr>
          </thead>
          <tbody>
          <?php 
          $i=1;
          $new_judul = mysqli_query($con,"SELECT tb_mhs.id_mhs,tb_mhs.nim,tb_mhs.nama,tm_prodi.prodi,
            pengajuan.pengajuan_id, 
            pengajuan.tgl_pengajuan,
          pengajuan.judul,
          pembing.status_bimbingan  
              FROM pembing 
              JOIN pengajuan ON pembing.pengajuan_id=pengajuan.pengajuan_id
              JOIN tb_mhs ON pembing.id_mhs=tb_mhs.id_mhs
              JOIN tm_prodi ON tb_mhs.prodi_id=tm_prodi.prodi_id
              JOIN tm_periode ON pembing.periode=tm_periode.periode_id
              WHERE pembing.kesediaan='Y'
              AND pengajuan.disetujui_kajur='Y'
              AND tm_periode.stt_periode='on'
              GROUP BY pembing.id_mhs
              ORDER BY pembing.pembing_id ASC
               ");
          foreach ($new_judul as $djb):?>
          <tr>
          <td><a href="#"><?= $i++ ?></a></td>
          <!-- <td><?= date('d-m-Y',strtotime($djb['tgl_pengajuan'])) ?></td> -->
          <td>
<a href="#" class="font-weight-bold" style="text-decoration: none;">
<div class="small" style="font-size: 12px;text-transform: uppercase;"><i class="fa fa-user"></i> NAMA : <b><?= $djb['nama'] ?> - NIM.<?= $djb['nim'] ?></b> <br>
<span style="font-size: 12px;"><i class="fa fa-graduation-cap"></i> PRODI : <b><?= $djb['prodi'] ?></b></span> <br>
<span style="font-size: 12px;"><i class="fa fa-check"></i> JUDUL : <b><?= $djb['judul'] ?></b></span>
</div>
</a>
</td>

          <td>
            <?php 
            $cekPemb = mysqli_query($con,"SELECT tb_dsn.nip,tb_dsn.nama_dosen,tb_dsn.foto,pembing.pembing_id,pembing.create_at,pembing.kesediaan,pembing.jenis FROM pembing 
            JOIN tb_dsn ON pembing.dosen=tb_dsn.id_dsn
            WHERE pembing.id_mhs=$djb[id_mhs] ORDER BY pembing.jenis ASC
            ");
            if (mysqli_num_rows($cekPemb) < 1) {
            echo 'Belum Ada Pembimbing';
            }else{
            $nop = 1;
            foreach ($cekPemb as $lp) {
            echo "<li style='list-style:none;'>".$nop++.". $lp[nama_dosen]</li style='list-style:none;'>";
            }

            }

            ?>
          </td>
          <td>
            <?php 
            $cekPemb = mysqli_query($con,"SELECT tb_dsn.nip,tb_dsn.nama_dosen,tb_dsn.foto,pembing.pembing_id,pembing.create_at,pembing.kesediaan,pembing.jenis FROM pembing 
            JOIN tb_dsn ON pembing.dosen=tb_dsn.id_dsn
            WHERE pembing.id_mhs=$djb[id_mhs] ORDER BY pembing.jenis ASC
            ");
            if (mysqli_num_rows($cekPemb) < 1) {
            echo 'Belum Ada Pembimbing';
            }else{
            $nop = 1;
            foreach ($cekPemb as $lp) {
            $tglMulai = mysqli_fetch_assoc(mysqli_query($con,"SELECT wkt FROM tb_pesan WHERE pengajuan_id=$djb[pengajuan_id] AND pembing_id=$lp[pembing_id] ORDER BY wkt ASC LIMIT 1 "));

            if (empty($tglMulai['wkt'])) {
            echo "Belum ada tanggal bimbingan.. <br>";
            }else{
            echo date('d-m-Y',strtotime($tglMulai['wkt']))."<br>";
            }
 
            }

            }

            ?>


          </td>  
          <td>
<?php 
$cekPemb = mysqli_query($con,"SELECT tb_dsn.id_dsn,tb_dsn.nip,tb_dsn.nama_dosen,tb_dsn.foto,pembing.pembing_id,pembing.create_at,pembing.kesediaan,pembing.jenis FROM pembing 
JOIN tb_dsn ON pembing.dosen=tb_dsn.id_dsn
WHERE pembing.id_mhs=$djb[id_mhs] ORDER BY pembing.jenis ASC
");
if (mysqli_num_rows($cekPemb) < 1) {
echo 'Belum Ada Pembimbing <br>';
}else{
$nop = 1;
foreach ($cekPemb as $lp) {
    $tglSelesai = mysqli_fetch_assoc(mysqli_query($con,"SELECT tb_pesan.wkt
    FROM pembing
    JOIN pengajuan ON pembing.pengajuan_id=pengajuan.pengajuan_id
    JOIN tb_pesan ON pembing.pengajuan_id=pengajuan.pengajuan_id
    JOIN tm_periode ON pembing.periode=tm_periode.periode_id
    WHERE tb_pesan.pengajuan_id=$djb[pengajuan_id]
    AND pembing.dosen=$lp[id_dsn]
    AND pembing.id_mhs=$djb[id_mhs]
    AND pembing.status_bimbingan='selesai'
    AND tm_periode.stt_periode='on'
    ORDER BY tb_pesan.wkt DESC  "));

    if (empty($tglSelesai['wkt'])) {
    echo "Belum ada tanggal Selasai.. <br>";
    }else{
    echo date('d-m-Y',strtotime($tglSelesai['wkt']))."<br>";
    }

}

}

?>
            
          </td> 

       <!--    <td>
            <a href="#" class="btn btn-primary bg-gradient-primary text-white btn-sm"><i class="fa fa-print"></i></a>
          </td> -->
          
          </tr>
          <?php endforeach; ?>
          </tbody>
          </table>
          </div>
          </div>
          </div>
          </div>

  <!-- end acc prodi -->


 

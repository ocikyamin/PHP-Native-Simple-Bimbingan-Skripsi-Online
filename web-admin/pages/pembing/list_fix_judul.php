  <?php 
if (isset($_SESSION['ADMIN_SESS'])) {
// Aktifkan akun
if (isset($_GET['remv'])) {
$id =intval($_GET['remv']);
$is_actived=mysqli_query($con,"DELETE FROM pembing  WHERE pembing_id={$id} ");
if ($is_actived) {
  echo "
<script>
alert('Dibatalkan !')
window.location ='?pages=fix_judul&set_pembing=$_GET[set_pembing]';   
</script>";
}else{
  echo "
<script>
alert('Oppss ! Gagal Dibatalkan !')
window.location ='?pages=fix_judul&set_pembing=$_GET[set_pembing]';   
</script>";
}
}
}
?>
<!-- pengatutran pembing -->
<?php 
if (isset($_GET['set_pembing'])) {
$idSet =intval($_GET['set_pembing']);
$detail = mysqli_fetch_assoc(mysqli_query($con,"SELECT
tb_mhs.id_mhs,
tb_mhs.nim,
tb_mhs.nama,
tb_mhs.fotomhs,
tb_mhs.tahun_angkatan,
tm_prodi.prodi,
tb_dsn.nama_dosen,
pengajuan.judul,
pengajuan.rekomendasi_pa,
pengajuan.disetujui_kajur,
pengajuan.pengajuan_id 
FROM pengajuan
JOIN tm_periode ON pengajuan.periode_id=tm_periode.periode_id
JOIN tb_mhs ON pengajuan.id_mhs=tb_mhs.id_mhs
JOIN tm_prodi ON tb_mhs.prodi_id=tm_prodi.prodi_id
JOIN tb_dsn ON tb_mhs.dosen_pa=tb_dsn.id_dsn
WHERE pengajuan.pengajuan_id=$idSet AND tm_periode.stt_periode='on' "));
?>
<div class="d-sm-flex align-items-center justify-content-between">
<h1 class="h3 mb-0 text-gray-800">Setting Pembimbing</h1>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="./">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Setting Pembimbing</li>
</ol>
</div>
      <div class="row mb-4">
        <div class="col-lg-12">
<?php 
// tampilkan data informasi pembing
$pembing = mysqli_query($con,"SELECT tb_dsn.nip,tb_dsn.nama_dosen,tb_dsn.foto,pembing.pembing_id,pembing.create_at,pembing.kesediaan,pembing.jenis FROM pembing 
JOIN tm_periode ON pembing.periode=tm_periode.periode_id
JOIN tb_dsn ON pembing.dosen=tb_dsn.id_dsn
WHERE pembing.pengajuan_id=$idSet AND tm_periode.stt_periode='on' ORDER BY pembing.jenis ASC
");
// pesan alert
if (isset($_GET['ok'])) {
echo '  <div class="alert alert-success bg-gradient-success text-white alert-dismissible" id="alert" role="alert">
<h6><i class="fas fa-check"></i><b> Sukses !</b></h6>
Pembimbing Telah dipilih, selnajutnya menunggu Konfirmasi dari dosen bersangkitan ..
</div>';
}
if (isset($_GET['ops'])) {
echo '  <div class="alert alert-danger bg-gradient-danger text-white alert-dismissible" id="alert" role="alert">
<h6><i class="fas fa-times"></i><b> Opps !</b></h6>
Dosen Pembimbing <b>'.$_GET['ops'].'</b> Sudah ada ..
</div>';
}


?>
          <div class="card">
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
            <?php 
            // cek jika belum ada pembimbing, maka tampilkan inputan untuk menambhkan pembimbing
            if (mysqli_num_rows($pembing)<2) {
              ?>
              <!-- tampilkan form inputan memilih dosen pembimbing -->
                       <div class="card-body">
              <h3>Tentukan Pembimbing</h3>
                <div class="row">
                <div class="col-lg-6">
                <form method="POST">
                  <input type="hidden" name="periode" value="<?= $tp['periode_id'] ?>">
                  <input type="hidden" name="mhs" value="<?= $detail['id_mhs'] ?>">
                   <input type="hidden" name="skripsi" value="<?= $idSet ?>">
                <div class="input-group mt-3">
                <select class="form-control form-control-sm" name="dosen" id="pilih">
                <option value="">Pilih Dosen </option>
                <?php 
                $i=1;
                $list_doesn = mysqli_query($con,"SELECT tb_dsn.id_dsn,tb_dsn.nip,tb_dsn.nama_dosen FROM tb_dsn ORDER BY id_dsn ASC ");
                foreach ($list_doesn as $dpa) {?>
                <option value="<?= $dpa['id_dsn'] ?>"><?= $i++ ?>. <?= $dpa['nip'] ?> <?= $dpa['nama_dosen'] ?></option>
                <?php } ?>

                </select>
                <select class="form-control form-control-sm" name="jenis" required>
                <option value="">Jenis Pembimbing</option>
                <option value="1">Pembimbing 1</option>
                <option value="2">Pembimbing 2</option>

                </select>
                <div class="input-group-append">
                <button type="submit" name="add" class="btn btn-dark btn-sm bg-gradient-dark btn-icon-split">
                <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
                </span>
                <span class="text">PILIH</span>
                </button>

                </div>
                </div> 
                </form>
                <?php
                // menyimpan data dosen Pembing Skripsi
                if (isset($_POST['add'])) {

                $periode     = intval($_POST['periode']);            
                $mhs     = intval($_POST['mhs']);
                $skripsi = intval($_POST['skripsi']);
                $dosen   = intval($_POST['dosen']);
                $jenis   = intval($_POST['jenis']);
                $tgl     = date('Y-m-d H:i:s');
                $cekPembing = mysqli_num_rows(mysqli_query($con,"SELECT pembing_id FROM pembing WHERE id_mhs='$mhs' AND jenis='$jenis' "));
                if ($cekPembing < 1) {
                    mysqli_query($con,"INSERT INTO pembing (periode,id_mhs,pengajuan_id,create_at,dosen,jenis) VALUES('$periode','$mhs','$skripsi','$tgl','$dosen','$jenis') ");
                    echo " <script>
                    window.location='?pages=fix_judul&set_pembing=$idSet&ok';
                    </script>";
                }else{
                   echo " <script>
                    window.location='?pages=fix_judul&set_pembing=$idSet&ops=$jenis';
                    </script>";
                }

              
                } 
                ?>

                </div>
               

                </div>  
                

            </div>
              <!-- end  -->
              <?php
              
            }

             ?>
   
          </div>
        </div>        
      </div>
      <div class="row mt-3 mb-4">
                  <!-- manampilkan pembimbing yang telah dipilih -->
                    <?php 
                    if (mysqli_num_rows($pembing)< 1) {
                      // pesan jika belum ada tanggapan oleh dosen
                    echo '<div class="col-lg-12"><div class="alert alert-warning bg-gradient-warning text-white">
                    <h6><i class="fas fa-info"></i><b> Info !</b></h6>
                    Belum ada Pembimbing
                    </div></div>';
                    }else{
                      // tampilkan dosen pembing terpilih
                    ?>
                    <?php foreach ($pembing as $dp):?>
                    <div class="col-lg-6">
                    <div class="card">
                    <div class="card-header bg-gradient-dark text-white">
                    <div class="row" style="border-bottom: 1px solid;">
                    <div class="col-lg-3"><img class="img-profile rounded-circle" src="../apl/img/dosen/<?= $dp['foto'] ?>" style="width: 65px;height: 65px;border-radius: 100%"></div>
                    <div class="col-lg-9">
                        <h6 style="text-transform: uppercase;"> Pembimbing <?= $dp['jenis'] ?> </h6>
                    <a href="?pages=fix_judul&set_pembing=<?= $idSet ?>&remv=<?= $dp['pembing_id'] ?>" onclick="return confirm('Apakah Yakin ?')" class="btn btn-danger bg-gradient-danger btn-sm"><i class="fa fa-times"></i> Batalkan</a>
                    </div>
                    </div>
                    <div class="row" style="border-bottom: 1px solid;">
                    <div class="col-lg-3">Nama Dosen</div>
                    <div class="col-lg-9"><?= $dp['nama_dosen'] ?></div>
                    </div>
                    <div class="row">
                    <div class="col-lg-3">Nip</div>
                    <div class="col-lg-9"><?= $dp['nip'] ?></div>
                    </div>
                    </div>
                    <div class="card-body">
                    <?php 
                    if ($dp['kesediaan']=='new') {
                    echo '<div class="alert alert-warning bg-gradient-warning text-white">
                    Menunggu Tanggapan !
                    </div>';
                    }elseif ($dp['kesediaan']=='Y') {
                    echo '<div class="alert alert-success bg-gradient-success text-white">
                    BERSEDIA
                    </div>';
                    }elseif ($dp['kesediaan']=='N') {
                    echo '<div class="alert alert-danger bg-gradient-danger text-white">
                   TIDAK BERSEDIA
                    </div>';
                    }

                    ?>

                    </div>
                    </div>
                    </div>
                    <?php endforeach; ?>
                    <?php

                    }
                    ?>

                   <!-- end manampilkan pembimbing yang telah dipilih -->
                </div>
<?php
// end pengatutran pembing
}else{
  ?>
  <!-- Tampilkan daftar judul yg telah di acc prodi -->

  <div class="d-sm-flex align-items-center justify-content-between">
<h1 class="h3 mb-0 text-gray-800">Judul Acc</h1>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="./">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Judul Acc</li>
</ol>
</div>
    <div class="row">
          <div class="col-lg-12 mb-4">
          <!-- Simple Tables -->
          <div class="card">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Daftar Judul diterima</h6>
          </div>
          <div class="table-responsive">
          <table class="table table-sm align-items-center table-flush mid">
          <thead class="thead-light">
          <tr>
          <th>NO</th>
          <th>ACC</th>
          <th>MAHASISWA</th>
          <th>PEMBIMBING</th>
          <th>ACTION</th>
          </tr>
          </thead>
          <tbody>
          <?php 
          $i=1;
          $new_judul = mysqli_query($con,"SELECT tb_mhs.id_mhs,tb_mhs.nim,tb_mhs.nama,tm_prodi.prodi,
            pengajuan.pengajuan_id,pengajuan.tgl_pengajuan,pengajuan.judul FROM pengajuan
           JOIN tb_mhs ON pengajuan.id_mhs=tb_mhs.id_mhs
           JOIN tm_prodi ON tb_mhs.prodi_id=tm_prodi.prodi_id
            JOIN tm_periode ON pengajuan.periode_id=tm_periode.periode_id

            WHERE pengajuan.disetujui_kajur='Y' AND tm_periode.stt_periode='on'  ORDER BY pengajuan_id ASC");
          foreach ($new_judul as $djb):?>
          <tr>
          <td><a href="#"><?= $i++ ?></a></td>
          <td><?= date('d-m-Y',strtotime($djb['tgl_pengajuan'])) ?></td>
          <td>
<a href="#" class="font-weight-bold" style="text-decoration: none;">
<div class="small" style="font-size: 12px;text-transform: uppercase;"><i class="fa fa-user"></i> NAMA : <b><?= $djb['nama'] ?> - NIM.<?= $djb['nim'] ?></b> <br>
<span style="font-size: 11px;"><i class="fa fa-graduation-cap"></i> PRODI : <b><?= $djb['prodi'] ?></b></span> <br>
<span style="font-size: 11px;"><i class="fa fa-check"></i> JUDUL : <b><?= $djb['judul'] ?></b></span>
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
                
                      if ($lp['kesediaan']=='new') {
                      echo "<span class='badge badge-warning bg-gradient-warning text-white'>Belum ada tanggapan</span>";
                      }elseif ($lp['kesediaan']=='Y') {
                      echo "<span class='badge badge-success bg-gradient-success text-white'>BERSEDIA</span>";
                      }elseif ($lp['kesediaan']=='N') {
                      echo "<span class='badge badge-danger bg-gradient-danger text-white'>TIDAK BERSEDIA</span>";
                      }
              }

            }

             ?>
          </td>
          <td>
            <a href="?pages=fix_judul&set_pembing=<?= $djb['pengajuan_id'] ?>" class="btn btn-primary bg-gradient-primary text-white btn-sm"><i class="fa fa-cog"></i> Set Pembing</a>
          </td>
          
          </tr>
          <?php endforeach; ?>
          </tbody>
          </table>
          </div>
          </div>
          </div>
          </div>

  <!-- end acc prodi -->
  <?php
}
?>
 

<?php 
include "../../config/databases.php";
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title> Mahasiswa Bimbingan - <?= time(); ?></title>
<style>
body{
  font-family: Verdana, Geneva, Tahoma, sans-serif;
  font-size: 12px;
}
.tabel{
  border-collapse: collapse;
  font-size: 11px;

}
  
</style>
</head>
<body>
	<center>
		<h3>DATA MAHASISWA BIMBINGAN</h3>
	</center>
<table width="100%" border="" class="tabel">
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

</body>
</html>
<script>
  window.print();
</script>
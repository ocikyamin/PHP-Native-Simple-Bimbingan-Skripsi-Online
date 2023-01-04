<?php
session_start();
if (empty($_SESSION)) {
  echo "<script>
  window.location='https://www.google.com/';
</script>";
}
include "../../config/databases.php"; 

$user   = mysqli_fetch_assoc(mysqli_query($con,"SELECT `id`,`username`,`password`,`nama_admin`,`img` FROM tb_admin "));


$pengajuanID = intval($_GET['print']);
$dr = mysqli_fetch_assoc(mysqli_query($con,"SELECT 
tb_mhs.id_mhs,
tb_mhs.nim,
tb_mhs.nama,
tm_prodi.prodi,
tm_prodi.konsen,
tb_dsn.nama_dosen,
pembing.jenis,
tb_mhs.tmp_lahir,
tb_mhs.tg_lahir,
pengajuan.pengajuan_id,
pengajuan.judul,
pengajuan.revisi_judul,
pengajuan.jenis
FROM pembing
JOIN tb_mhs ON pembing.id_mhs=tb_mhs.id_mhs
JOIN tm_prodi ON tb_mhs.prodi_id=tm_prodi.prodi_id
JOIN pengajuan ON pembing.pengajuan_id=pengajuan.pengajuan_id
JOIN tb_dsn ON pembing.dosen=tb_dsn.id_dsn
WHERE pengajuan.pengajuan_id=$pengajuanID
"));

?>
<title>
  FORMULIR PERBAIKAN JUDUL - <?= time() ?>
</title>
<style>
  body{
    font-family: arial;
  }
</style>
<table width="100%" style="border-bottom: 3px solid">
  <tr>
    <td><img src="../../logo.png" width="100"></td>
    <td>
      <center>
        <h2><b>SEKOLAH TINGGI TEKNIK MALANG</b> <br>
          <small style="font-size: 14px;">
          Jl. Soekarno Hatta No. 94 Malang, Telp/Fax.(0341)412611, Web : www.stt.ac.id
        </small>
        </h2>
        
      </center>
    </td>
  </tr>
  
</table>
<h4>I . FORMULIR PENDAFTARAN PERBAIKAN JUDUL SKRIPSI/TUGAS AKHIR</h4>
			<table width="100%">
  <tr>
    <td>1.</td>
    <td>Nama Mahasiswa </td>
    <td>:</td>
    <td><?= $dr['nama'] ?></td>
  </tr>
  <tr>
    <td>2.</td>
    <td>NIM</td>
    <td>:</td>
    <td><?= $dr['nim'] ?></td>
  </tr>
  <tr>
    <td>3.</td>
    <td>Tempat/Tanggal Lahir </td>
    <td>:</td>
    <td><?= $dr['tmp_lahir'] ?>/ <?= $dr['tg_lahir'] ?></td>
  </tr>
  <tr>
    <td>4.</td>
    <td>Jenjang Prodi / Konsentrasi </td>
    <td>:</td>
    <td><?= $dr['prodi'] ?>/ <?= $dr['konsen'] ?></td>
  </tr>
  <tr>
    <td>5</td>
    <td>Jenis Skripsi / TA </td>
    <td>:</td>
    <td><?= $dr['jenis'] ?></td>
  </tr>
  <tr>
    <td>6</td>
    <td>Judul Skripsi / TA </td>
    <td>:</td>
    <td><?= $dr['judul'] ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>PERBAIKAN JUDUL </td>
    <td>:</td>
    <td><?= $dr['revisi_judul'] ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>................................................................................................................</td>
  </tr>
  <tr>
    <td>7.</td>
    <td>Pembimbing</td>
    <td>:</td>
    <td><?= $dr['nama_dosen'] ?></td>
  </tr>
</table>
<br>
<br>
<p>
	<center>
		Mengetahui dan Mengijinkan <br>
		Calon Tersebut Untuk Mengajukan Perbaikan Judul Skripsi/TA <br>
		Pada Tanggal : <?= date('d F Y') ?>
	</center>
</p>
<p>
<table width="100%">
  <tr>
    <td><div align="left">Pembimbing Skripsi/TA </div></td>
    <td><div align="center"></div></td>
    <td><div align="center">Mahasiswa</div></td>
  </tr>
  <tr>
    <td><div align="left"></div></td>
    <td><div align="center"></div></td>
    <td><div align="center"></div></td>
  </tr>
  <tr>
    <td><div align="left"><br /><br /><br /> <br> <br><u><b>(<?= $dr['nama_dosen'] ?>)</b></u></div></td>
    <td><div align="center"></div></td>
    <td><div align="center"><br /><br /><br /> <br> <br><b><u>(<?= $dr['nama'] ?>)</u></b></div></td>
  </tr>
  <tr>
    <td><div align="left"></div></td>
    <td><div align="center"></div></td>
    <td><div align="center"></div></td>
  </tr>
  <tr>
    <td><div align="left"></div></td>
    <td><div align="center"> <br> <br> Biro Administrasi Akdemik </div></td>
    <td><div align="center"></div></td>
  </tr>
  <tr>
    <td><div align="left"></div></td>
    <td><div align="center"><br /><br /><br /> <br><b><u>(<?= $user['nama_admin'] ?>)</u></b></div></td>
    <td><div align="center"></div></td>
  </tr>
</table>
</p>

<script>
  window.print();
</script>


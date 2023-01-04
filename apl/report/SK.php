<?php 
session_start();
error_reporting(0);
include "../../config/databases.php";
if (empty($_SESSION)) {
	
}

if (isset($_GET['ta'])) {
	$tp = mysqli_real_escape_string($con,$_GET['ta']);
}

if (isset($_GET['/'])) {
	$sttSk = addslashes($_GET['/']);
}


 ?>



<!-- <img src="../files/0001.jpg" width="100%"> -->

<P>
	<img src="../../files/0001.jpg" width="100%">
</P>
<br>
<br>

<P>
	<center>
	<h3><b>LAMPIRAN DAFTAR PEMBIMBING TA/SKRIPSI TAHUN AKADEMIK <?= $_GET['tp'] ?></b></h3>
</center>
</P>      	

        	<table width="100%" cellpadding="3" border="1" style="border-collapse: collapse;">
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
	AND pembing.periode='$tp' AND pengajuan.status_sk='$sttSk'
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
<script>
	window.print();
</script>
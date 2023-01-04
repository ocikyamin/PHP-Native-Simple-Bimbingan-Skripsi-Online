<?php 
include "../../config/databases.php";
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Data Mahasiswa</title>
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
		<h3>DATA MAHASISWA</h3>
	</center>

<table width="100%" border="" class="tabel">
<thead class="table-flush">
<tr style="text-transform: uppercase;">
<th>NO</th>
<th>NIM</th>
<th>NAMA</th>
<th>PRODI</th>
<th>TAHUN MASUK</th>
<th>IMG</th>
<th>AKUN</th>
</tr>
</thead>
<tbody>
<?php 
$no=1;
$sql = mysqli_query($con,"SELECT
tb_mhs.id_mhs,
tb_mhs.nim,
tb_mhs.nama,
tb_mhs.fotomhs,
tb_mhs.tahun_angkatan,
tb_mhs.prodi_id,
tb_mhs.status_akun,
tm_prodi.prodi
FROM tb_mhs
JOIN tm_prodi
ON tb_mhs.prodi_id=tm_prodi.prodi_id
ORDER BY tb_mhs.nim ASC");
foreach ($sql as $d) {?>
<tr>
<td><?=$no++?></td>
<td><b><?=$d['nim'] ?></b></td>
<td><?=$d['nama'] ?></td>
<td><?=$d['prodi'] ?></td>
<td><?=$d['tahun_angkatan'] ?></td>
<td><img src="../img/<?=$d['fotomhs'] ?>" class="img-thumbnail" style="width: 50px;height: 50px;border-radius: 100%;"></td>
<td>
<?php 
if ($d['status_akun']=='Y') {
echo "<span class='badge badge-success'>Aktif</span>";
}elseif ($d['status_akun']=='N') {
echo "<span class='badge badge-danger'>Non Aktif</span>";
}else{
echo "<span class='badge badge-warning'>Belum dikonfirmasi</span>";
}

?>
</td>
</tr>
<?php } ?>


</tbody>
</table> 


</body>
</html>
<script>
  window.print();
</script>
<div class="d-sm-flex align-items-center justify-content-between">
<h1 class="h3 mb-0 text-gray-800">Revisi Judul</h1>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="./">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Revisi Judul</li>
</ol>
</div>
<?php 
$pengajuanID = intval($_GET['details']);
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
<div class="row mb-4">
		<div class="col-lg-12">
		<div class="card">
		<div class="card-header bg-gradient-primary text-white">
			<div class="row">
				<div class="col-lg-8">
					<h6 class="mt-3 font-weight-bold"><i class="fa fa-file-alt"></i> FORMULIR PENDAFTARAN PERBAIKAN JUDUL SKRIPSI/TUGAS AKHIR</h6>
				</div>
				<div class="col-lg-4">
					<form method="post">
						<input type="hidden" name="id" value="<?= $pengajuanID ?>">
						<input type="hidden" name="newjudul" value="<?= $dr['revisi_judul'] ?>">
						<input type="hidden" name="oldjudul" value="<?= $dr['judul'] ?>">
					<button type="submit" name="ok" class="btn btn-success"><i class="fa fa-check"></i> SETUJUI</button>
					<button type="submit" name="no" class="btn btn-danger"><i class="fa fa-times"></i> TOLAK</button>
					<a href="../apl/report/revisi_judul_print.php?print=<?= $pengajuanID ?>" target="_blank" class="btn btn-light"><i class="fa fa-print"></i> PRINT</a>
					</form>
					<?php 
					if (isset($_POST['ok'])) {
					

					   $id = intval($_POST['id']);
						$newJudul = $_POST['newjudul'];
						$oldJudul = $_POST['oldjudul'];
						mysqli_query($con,"UPDATE pengajuan SET judul='$newJudul',revisi_judul='$oldJudul', stt_revisi='Y' WHERE pengajuan_id=$id ");
						echo "<script>alert('Permintaan diterima ...');window.location='?pages=list_judul_revisi';</script>";
					}

					if (isset($_POST['no'])) {
						$id = intval($_POST['id']);
						mysqli_query($con,"UPDATE pengajuan SET stt_revisi='N' WHERE pengajuan_id=$id ");
						echo "<script>alert('Permintaan ditolak ...');window.location='?pages=list_judul_revisi';</script>";
					}


					 ?>
				</div>
			</div>

		
		
		</div>
		<div class="card-body">


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
    <td><div align="left"><br /><br /><br />(<?= $dr['nama_dosen'] ?>)</div></td>
    <td><div align="center"></div></td>
    <td><div align="center"><br /><br /><br />(<?= $dr['nama'] ?>)</div></td>
  </tr>
  <tr>
    <td><div align="left"></div></td>
    <td><div align="center"></div></td>
    <td><div align="center"></div></td>
  </tr>
  <tr>
    <td><div align="left"></div></td>
    <td><div align="center">Biro Administrasi Akdemik </div></td>
    <td><div align="center"></div></td>
  </tr>
  <tr>
    <td><div align="left"></div></td>
    <td><div align="center"><br /><br /><br />(<?= $user['nama_admin'] ?>)</div></td>
    <td><div align="center"></div></td>
  </tr>
</table>
</p>



		</div>
	</div>
</div>
</div>
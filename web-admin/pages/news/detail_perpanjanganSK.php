<div class="d-sm-flex align-items-center justify-content-between">
<h1 class="h3 mb-0 text-gray-800">Perpanjangan SK</h1>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="./">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Perpanjangan SK</li>
</ol>
</div>
<?php 
$pengajuanID = intval($_GET['details']);
$dr = mysqli_fetch_assoc(mysqli_query($con,"SELECT 
tb_mhs.id_mhs,
tb_mhs.nim,
tb_mhs.nama,
tb_mhs.dosen_pa,
tm_prodi.prodi,
tm_prodi.konsen,
tb_dsn.nama_dosen,
pembing.jenis,
tb_mhs.tmp_lahir,
tb_mhs.tg_lahir,
pengajuan.pengajuan_id,
pengajuan.judul,
pengajuan.tgl_pengajuan_sk,
pengajuan.alasan_perpanjangan_sk,
pengajuan.status_bimbingan,
pengajuan.status_perpanjangan_sk,
pengajuan.status_sk,
pengajuan.jenis
FROM pembing
JOIN tb_mhs ON pembing.id_mhs=tb_mhs.id_mhs
JOIN tm_prodi ON tb_mhs.prodi_id=tm_prodi.prodi_id
JOIN pengajuan ON pembing.pengajuan_id=pengajuan.pengajuan_id
JOIN tb_dsn ON pembing.dosen=tb_dsn.id_dsn
WHERE pengajuan.pengajuan_id=$pengajuanID
"));
$pa = mysqli_fetch_assoc(mysqli_query($con,"SELECT nama_dosen FROM tb_dsn WHERE id_dsn=$dr[dosen_pa] "));

?>
<div class="row mb-4">
		<div class="col-lg-12">
		<div class="card">
		<div class="card-header bg-gradient-primary text-white">
			<div class="row">
				<div class="col-lg-8">
					<h6 class="mt-3 font-weight-bold"><i class="fa fa-file-alt"></i>FORMULIR PERPANJANGAN SK BIMBINGAN SKRIPSI/TA</h6>
				</div>
				<div class="col-lg-4">
					<form method="post">
						<input type="hidden" name="id" value="<?= $pengajuanID ?>">
						<input type="hidden" name="newjudul" value="<?= $dr['revisi_judul'] ?>">
						<input type="hidden" name="oldjudul" value="<?= $dr['judul'] ?>">
					<button type="submit" name="ok" class="btn btn-success"><i class="fa fa-check"></i> SETUJUI</button>
					<button type="submit" name="no" class="btn btn-danger"><i class="fa fa-times"></i> TOLAK</button>
					<a href="../apl/report/perpanjangansk_print.php?print=<?= $pengajuanID ?>" target="_blank" class="btn btn-light"><i class="fa fa-print"></i> PRINT</a>
					</form>
					<?php 
					if (isset($_POST['ok'])) {
					

					   $id = intval($_POST['id']);
						$newJudul = $_POST['newjudul'];
						$oldJudul = $_POST['oldjudul'];
						mysqli_query($con,"UPDATE pengajuan SET status_perpanjangan_sk='Y',status_sk='New' WHERE pengajuan_id=$id ");
						echo "<script>alert('Permintaan diterima ...');window.location='?pages=list_perpanjangan_sk';</script>";
					}

					if (isset($_POST['no'])) {
						$id = intval($_POST['id']);
						mysqli_query($con,"UPDATE pengajuan SET status_perpanjangan_sk='N',status_sk='old' WHERE pengajuan_id=$id ");
						echo "<script>alert('Telah Konfirmasi...');window.location='?pages=list_perpanjangan_sk';</script>";
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
    <tr>
    <td>8</td>
    <td>Alasan Perpanjangan</td>
    <td>:</td>
    <td><?= $dr['alasan_perpanjangan_sk'] ?></td>
  </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
    <td>
<span>
        Dimana pelaksanaan penulisan san konsultasi bimbingan Skripsi/TA sampai dengan ?
      </span>
    <div class="custom-control custom-radio">
    <input type="radio" id="konsultasiJudul" name="status_bimbingan" value="Konsultasi Judul" class="custom-control-input" <?php if ($dr['status_bimbingan']=='Konsultasi Judul') { echo 'checked';
      
    } ?> >
    <label class="custom-control-label" for="konsultasiJudul">Konsultasi Judul</label>
    </div>

        <div class="custom-control custom-radio">
    <input type="radio" id="BAB I" name="status_bimbingan" value="BAB I" class="custom-control-input" <?php if ($dr['status_bimbingan']=='BAB I') { echo 'checked';
      
    } ?> >
    <label class="custom-control-label" for="BAB I">BAB I</label>
    </div>

        <div class="custom-control custom-radio">
    <input type="radio" id="BAB II" name="status_bimbingan" value="BAB II" class="custom-control-input" <?php if ($dr['status_bimbingan']=='BAB II') { echo 'checked';
      
    } ?> >
    <label class="custom-control-label" for="BAB II">BAB II</label>
    </div>

        <div class="custom-control custom-radio">
    <input type="radio" id="BAB III" name="status_bimbingan" value="BAB III" class="custom-control-input" <?php if ($dr['status_bimbingan']=='BAB III') { echo 'checked';
      
    } ?> >
    <label class="custom-control-label" for="BAB III">BAB III</label>
    </div>
        <div class="custom-control custom-radio">
    <input type="radio" id="BAB IV" name="status_bimbingan" value="BAB IV" class="custom-control-input" <?php if ($dr['status_bimbingan']=='BAB IV') { echo 'checked';
      
    } ?> >
    <label class="custom-control-label" for="BAB IV">BAB IV</label>
    </div>
</td>
  </tr>
</table>
<p>
	<center>
		Mengetahui dan Mengijinkan <br>
		Mahasiswa Tersebut Untuk Mengajukan Perpanjangan Skripsi/TA <br>
		Pada Tanggal : <?= date('d F Y',strtotime($dr['tgl_pengajuan_sk'])) ?>
	</center>
</p>
<p>
<table width="100%">
  <tr>
    <td><div align="left">Pembimbing Skripsi/TA </div></td>
    <td><div align="center"></div></td>
    <td><div align="center">Pembimbing Akademik</div></td>
  </tr>
  <tr>
    <td><div align="left"></div></td>
    <td><div align="center"></div></td>
    <td><div align="center"></div></td>
  </tr>
  <tr>
    <td><div align="left"><br /><br /><br />(<?= $dr['nama_dosen'] ?>)</div></td>
    <td><div align="center"></div></td>
    <td><div align="center"><br /><br /><br />(<?= $pa['nama_dosen'] ?>)</div></td>
  </tr>
  <tr>
    <td><div align="left"></div></td>
    <td><div align="center"></div></td>
    <td><div align="center"></div></td>
  </tr>

</table>
</p>



		</div>
	</div>
</div>
</div>
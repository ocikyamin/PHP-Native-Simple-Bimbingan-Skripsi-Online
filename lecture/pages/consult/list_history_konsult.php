<?php 
$mhsBimbingan = mysqli_query($con,"SELECT
tb_mhs.id_mhs,
tb_mhs.nim,
tb_mhs.nama,
tb_mhs.fotomhs,
tm_prodi.prodi,
pengajuan.judul
FROM pembing
JOIN tm_periode ON pembing.periode=tm_periode.periode_id
JOIN tb_mhs ON pembing.id_mhs=tb_mhs.id_mhs
JOIN tm_prodi ON tb_mhs.prodi_id=tm_prodi.prodi_id
JOIN pengajuan ON pembing.pengajuan_id=pengajuan.pengajuan_id
WHERE pembing.dosen=$userID
 AND pembing.kesediaan='Y'
  AND pengajuan.disetujui_kajur='Y'
  AND tm_periode.stt_periode='on'
 ORDER BY pembing.pembing_id ASC ");
// jumlah pesan lama
$jmlMhsBimbingan = mysqli_num_rows($mhsBimbingan);
?>


<div class="d-sm-flex align-items-center justify-content-between">
<h1 class="h3 mb-0 text-gray-800">History</h1>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="./">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">History</li>
</ol>
</div>
<div class="row">
	<div class="col-lg-5">
		<!-- list mahasiswa bimbingan-->
		<div class="card mb-2">
			<div class="card-header bg-gradient-primary text-white">
				<h6><i class="fa fa-users"></i> Mahasiswa Bimbingan</h6>
			</div>
			<div class="card-body">
				<div class="table-responsive">
				<table class="table table-sm">
				<thead>
				<tr>
				<th>NO.</th>
				<th colspan="2">MAHASISWA</th>
				</tr>
				</thead>
				<tbody>
				<?php 
				if ($jmlMhsBimbingan < 1) {
				echo '<center>Belum ada percakapan ..</center>';
				}else{
				// tampilkan daftar pesan
				?>
				<?php 
				$i=1;
				foreach ($mhsBimbingan as $lm):?>
				<tr class='header1 expand bg-gradient-primary text-white' style="cursor: pointer;">
					<td><?= $i++ ?>.</td>
				<td><img class="img-fluid" src="../apl/img/<?= $lm['fotomhs'] ?>" style="width: 45px;height: 45px;border-radius: 100%"></td>
				<td>

				<div class="font-weight-bold">
				<div class="small" style="font-size: 12px;text-transform: uppercase;"><?= $lm['nama'] ?> · NIM<?= $lm['nim'] ?> <br>
				<span class="text-warning" style="font-size: 11px;"><i class="fa fa-graduation-cap"></i> PRODI <?= $lm['prodi'] ?></span>
				</div>
				</div>

				</td>
				</tr>
				<tr>
					<td colspan="3">
						<p>Judul : <b class="text-primary"><?= $lm['judul'] ?></b></p>
					<?php 
					$listBimbingan = mysqli_query($con,"SELECT
					tb_mhs.id_mhs,
					tb_mhs.nim,
					tb_mhs.nama,
					tb_mhs.fotomhs,
					tm_prodi.prodi,
					tb_pesan.id_pesan,
					tb_pesan.document,
					tb_pesan.pengajuan_id,
					tb_pesan.pengirim_id,
					tb_pesan.user_pengirim,
					tb_pesan.user_penerima,
					tb_pesan.topik,
					tb_pesan.subyek,
					tb_pesan.isi_pesan,
					tb_pesan.pembing_id,
					tb_pesan.jenis_pemb,
					tb_pesan.wkt
					FROM tb_pesan
					JOIN tm_periode ON tb_pesan.tahun_bimbingan=tm_periode.periode_id
					JOIN tb_mhs ON tb_pesan.pengirim_id=tb_mhs.id_mhs
					JOIN tm_prodi ON tb_mhs.prodi_id=tm_prodi.prodi_id
					WHERE tb_pesan.penerima_id=$userID
					AND tb_pesan.pengirim_id=$lm[id_mhs]
					AND tb_pesan.user_pengirim='mhs'
					-- AND tb_pesan.status_pesan='Y'
					AND tm_periode.stt_periode='on'
					GROUP BY tb_pesan.topik
					ORDER BY tb_pesan.id_pesan ASC ");
					// jumlah pesan lama
					$jmlListPesan = mysqli_num_rows($listBimbingan);
					?>

						

		<?php 
		if ($jmlListPesan < 1) {
		echo '<center>Belum ada percakapan ..</center>';
		}else{
		// tampilkan daftar pesan
		?>
		<?php 
		foreach ($listBimbingan as $lb):?>

		<a href="?pages=history&read=<?= $lb['pembing_id'] ?>&topic=<?= $lb['topik'] ?>" style="cursor: pointer;">
		<div class="font-weight-bold">
		<div class="text-truncate" style="max-width: 30rem;"><?= strtoupper($lb['subyek']) ?> </div>
		<div class="small text-success" style="font-size: 12px;"><i class="fa fa-clock"></i> <?= date('d-m-Y H:i:s',strtotime($lb['wkt'])) ?> <br>
		<span class="text-danger" style="font-size: 11px;"><i class="fa fa-share"></i> <?= $lb['topik'] ?></span>
		</div>
		</div>
		</a>
		<hr>

		<?php endforeach; ?>
		<?php
		}


		?>

						
					</td>
				</tr>
				<?php endforeach; ?>
				<?php
				}


				?>

				</tbody>
				</table>
				</div>
			</div>
		</div>

		<!-- end mahasiswa -->
	</div>
	<div class="col-lg-7">
		<?php 
			// pesan
			if (isset($_GET['info'])) {
			if ($_GET['info']=='ok') {
			echo '<div class="alert alert-success bg-gradient-success text-white" id="alert">Pesan Terkirim..</div>';
			}
			if ($_GET['info']=='err') {
			echo '<div class="alert alert-danger bg-gradient-danger text-white" id="alert">PESAN TIDAK TERKIRIM: Periksa kembali isi pesan anda ..</div>';
			}		
			if ($_GET['info']=='errbig') {
			echo '<div class="alert alert-danger bg-gradient-danger text-white" id="alert">ERROR: Ukuran File terlalu besar, Maksimal 2 MB</div>';
			}	
			if ($_GET['info']=='errfile') {
			echo '<div class="alert alert-danger bg-gradient-danger text-white" id="alert">ERROR: Ekstensi file tidak di izinkan!</div>';
			}
			}
			// end pesan


			?>
				<!-- tampilkan kotak chat untuk dibaca -->
		<?php 
		if (isset($_GET['read'])) {
		$readID = intval($_GET['read']);
		$topik = mysqli_escape_string($con,$_GET['topic']);
		// mendapatkan Informasi Pesan Baru
		$historyBimbingan = mysqli_query($con,"SELECT
		tb_mhs.id_mhs,
		tb_mhs.nim,
		tb_mhs.nama,
		tb_mhs.fotomhs,
		tm_prodi.prodi,
		tb_pesan.id_pesan,
		tb_pesan.document,
		tb_pesan.pengajuan_id,
		tb_pesan.pengirim_id,
		tb_pesan.user_pengirim,
		tb_pesan.user_penerima,
		tb_pesan.topik,
		tb_pesan.subyek,
		tb_pesan.isi_pesan,
		tb_pesan.pembing_id,
		tb_pesan.jenis_pemb,
		tb_pesan.wkt,
		tb_pesan.tahun_bimbingan
		FROM tb_pesan
		JOIN tm_periode ON tb_pesan.tahun_bimbingan=tm_periode.periode_id
		JOIN tb_mhs ON tb_pesan.pengirim_id=tb_mhs.id_mhs
		JOIN tm_prodi ON tb_mhs.prodi_id=tm_prodi.prodi_id
		WHERE tb_pesan.penerima_id=$userID
		AND tb_pesan.pembing_id=$readID
		AND tb_pesan.topik='$topik'
		AND tb_pesan.status_pesan !='new'
		AND tm_periode.stt_periode ='on'
		ORDER BY tb_pesan.id_pesan ASC ");
		// jumlah pesan baru
		$jmlHistory = mysqli_num_rows($historyBimbingan);
		?>
		<!-- // cek jika ada pesan baru yg dikirim oleh dosen -->
		<?php 
		if ($jmlHistory > 0) {
		// menampilkan daftar			
		?>
		<div class="card mb-4">
			<div class="card-header bg-gradient-success text-white">
	<h6 class="m-0 font-weight-bold text-light"><i class="fa fa-comments fa-2x"></i> Percakapan <b>(<?= $jmlHistory ?>)</b></h6>
	</div>
		<div class="card-body">
			<?php 
			error_reporting(0);
			// tampilkan user yag membuat topik pembahasan..
			$first = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM tb_pesan
			WHERE pembing_id='$readID'
			AND topik='$topik'
			AND pengirim_id=$userID
			AND user_pengirim='dsn'
			AND user_penerima='mhs'
			AND reply_to=0
			ORDER BY id_pesan ASC "));
			if ($first['pengirim_id']==$userID) {
			?>
			<p>
			<div class="alert alert-primary bg-gradient-primary text-white">
			<img class="rounded-circle" src="../apl/img/dosen/<?= $user['foto'] ?> " style="width: 40px;height: 40px; border: 2px solid;border-radius: 100%">
			<span class="" style="border: 1px;padding: 4px;"><i class="fas fa-comments fa-2x text-warning"></i> Anda Membuka Percakapan untuk Topik ini ..			
			</span>
			<br>
			<b> <span><i class="fas fa-comments fa-1x"></i> <b>Topik : </b> <?= $first['subyek'] ?>  </span> </b>
			<p><h5>" <?= $first['isi_pesan'] ?> "</h5></p>
			<span style="font-size: 12px;"><i class="fa fa-clock"></i> <?= date('d-m-Y - H:i:s',strtotime($first['wkt'])) ?> </span>
			</div>

			</p>

			<?php
			}


			?>

		<?php 
		foreach ($historyBimbingan as $hm) :?>
			<div>
				<span class="" style="border: 1px;padding: 4px;border-radius: 20px;"><i class="fas fa-share fa-2x"></i> Pengirim </span>
		<a class="dropdown-item d-flex align-items-center bg-gradient-danger text-white" href="#" style="cursor: pointer;border-radius: 50px;">
		<div class="dropdown-list-image mr-3">

		<img class="rounded-circle" src="../apl/img/<?= $hm['fotomhs'] ?> " style="width: 40px;height: 40px; border: 2px solid;border-radius: 100%">
		
		</div>
		<div class="font-weight-bold">
		<div class="text-truncate"><?= $hm['nama'] ?> </div>
		<div class="small text-gray-500">
			<i class="fa fa-user"></i> NIM.<?= $hm['nim'] ?>  - <i class="fa fa-graduation-cap"></i> <?= $hm['prodi'] ?> </div>
		<span style="font-size: 12px;">
				</span>
		</div>
		</a>

			
		<span class="mt-3">
		<div class="alert alert-light mt-2">
			<span class="bg-gradient-light text-black" style="border: 1px;padding: 4px;border-radius: 20px;"><i class="fas fa-comments fa-1x"></i> <b>Topik : </b> </span><span> <?= $hm['subyek'] ?> </span>
		<p class="mt-2"><?= $hm['isi_pesan'] ?></p>
		</div>

			<button type="button" id="select" onclick="modalBalasPesan()" data-id="<?= $hm['id_pesan'] ?>" data-judul="<?= $hm['pengajuan_id'] ?>" data-topik="<?= $hm['topik'] ?>" data-subyek="<?= $hm['subyek'] ?>" data-pengirim="<?= $userID ?>" data-penerima="<?= $hm['id_mhs'] ?>" data-pembing="<?= $hm['pembing_id'] ?>" data-jenis_pemb="<?= $hm['jenis_pemb'] ?>" data-periode="<?= $hm['tahun_bimbingan'] ?>" class="bg-gradient-dark text-white" style="border: 1px;padding: 4px;border-radius: 20px;cursor: pointer;text-decoration: none;"><i class="fas fa-reply fa-1x"></i> Balas </button>

			<!-- tombol area -->
			<?php
			if ($hm['document'] !=='nofile') {
			?>
			File :
			<a href="../files/<?= $hm['document'] ?>" target="_blank" class="text-success" style="cursor: pointer;text-decoration: none;"><i class="fa fa-file-alt"></i> Dokumen</a>
			<?php			 	
			} 
			?>
			<!-- edn tombol -->
	
		</span> <br>

	<!-- menanmpilkan balasan pesan -->
	<?php 
	$reply = mysqli_query($con,"SELECT * FROM tb_pesan WHERE reply_to=$hm[id_pesan] ");
	if (mysqli_num_rows($reply)< 1) {
		echo "Tidak ada balasan ..";
	}else{
		?>
		<?php
		foreach ($reply as $rm):?>
			<span class="" style="border: 1px;padding: 4px;border-radius: 20px;"><i class="fas fa-comments fa-2x"></i> Pesan Balasan : <b> <?= $user['nama_dosen'] ?> </b> 						<!-- tombol area -->
			<?php
			if ($rm['document'] !=='nofile') {
			?>
			File :
			<a href="../files/<?= $rm['document'] ?>" target="_blank" class="text-success mb-3" style="border: 1px;padding: 4px;border-radius: 20px;cursor: pointer;text-decoration: none;"> <i class="fa fa-file-alt"></i> Download</a> <br>
			<?php			 	
			} 
			?>
			<!-- edn tombol --></span>
			<div class="alert alert-success bg-gradient-success" style="background: #E1F5FE;border-radius:50px;border:1px dashed;">
				<p style="color: black"><?= $rm['isi_pesan'] ?></p>
			</div>

		<?php endforeach; ?>
		<?php
	}

	 ?>

	


			</div>

		<?php endforeach; ?>
		</div>
		</div>


		<?php
		// end daftar pesan
		}

		?>

		<?php
		}


		?>

		<!-- end tampilkan kotak chat untuk dibaca -->



	</div>
</div>


<!-- TAMPILKAN FORM UNTUK BALS PESAN -->

         <!-- Modal -->
          <div class="modal fade" id="modalReply" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-reply"></i> Balas Pesan</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
						<p>
						<form method="POST" enctype="multipart/form-data">
						<div class="form-group mt-3">
						<input type="hidden" id="periode" name="periode">
						<input type="hidden" id="id" name="id">
						<input type="hidden" id="judul" name="judul">
						<input type="hidden" id="topik" name="topik">
						<input type="hidden" id="subyek" name="subyek">
						<input type="hidden" id="pengirim" name="pengirim">
						<input type="hidden" id="penerima" name="penerima">
						<input type="hidden" id="pembing" name="pembing">
						<input type="hidden" id="jenis_pemb" name="jenis_pemb">
						<textarea name="pesan" class="form-control" placeholder="Tuliskan disini .."></textarea>
						</div>

						<div class="form-group">
						<div class="custom-file">
						<input name="file" type="file" class="custom-file-input" id="customFile">
						<label class="custom-file-label" for="customFile">Choose file</label>
						</div>
						</div>

						<div class="form-group mt-3">
						<button type="submit" name="balas" class="btn btn-outline-primary btn-sm"><i class="fa fa-reply"></i> Balas</button>
						<a class="btn btn-outline-warning btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Btal</a>
						</div>				
						</form>
						<!-- SCRIPT / PROSES BALAS PESAN DARI PEMBIMBING -->
			<?php 
			if (isset($_POST['balas'])) {
			$array  = array('jpg','jpeg','png','doc','docx','ppt','pptx','pdf','zip','rar','xls','xlsx',);
			$periode            = intval($_POST['periode']);
			$id            = intval($_POST['id']);
			$judul         = intval($_POST['judul']);
			$topik        = htmlspecialchars($_POST['topik']);
			$subyek        = htmlspecialchars($_POST['subyek']);
			$pesan         = htmlspecialchars($_POST['pesan']);
			$pengirim      = intval($_POST['pengirim']);
			$penerima      = intval($_POST['penerima']);

			$pembing       = intval($_POST['pembing']);
			$jenis_pemb    = htmlspecialchars($_POST['jenis_pemb']);
			$wkt           = date('Y-m-d H:i:s');
			// Post file
			$filenama = $pengirim.'_'.time();
			$file_name    = $_FILES['file']['name'];
			@$file_ext     = strtolower(end(explode('.', $file_name)));
			$file_size    = $_FILES['file']['size'];
			$file_tmp     = $_FILES['file']['tmp_name'];
			$dok = $filenama.'.'.$file_ext;

			if ($file_name=="") {
			// jika pesan tanpa file
			$is_send= mysqli_query($con,"INSERT INTO tb_pesan (pengajuan_id,pengirim_id,user_pengirim,penerima_id,user_penerima,topik,subyek,isi_pesan,pembing_id,jenis_pemb,wkt,reply_to,tahun_bimbingan) VALUES ('$judul','$pengirim','dsn','$penerima','mhs','$topik','$subyek','$pesan','$pembing','$jenis_pemb','$wkt','$id','$periode')  ");
			// $reply = mysqli_query($con,"INSERT INTO reply (id_pesan,user_id,user_tipe,tipe_pesan)  ");
			if ($is_send) {
			mysqli_query($con,"UPDATE tb_pesan SET status_pesan='Y' WHERE id_pesan=$id ");
			echo "<script>
			window.location='?pages=history&read=$readID&topic=$topik&info=ok';
			</script>";
			}else{
				echo "<script>
				window.location='?pages=history&read=$readID&topic=$topik&info=err';
				</script>";
			}
			}else{

			// jika pesan melampirkan file
			if(in_array($file_ext, $array) === true){
			if($file_size < 2000000){
			$lokasi = '../files/'.$filenama.'.'.$file_ext;
			move_uploaded_file($file_tmp, $lokasi);
			$is_send= mysqli_query($con,"INSERT INTO tb_pesan (pengajuan_id,pengirim_id,user_pengirim,penerima_id,user_penerima,topik,subyek,isi_pesan,document,pembing_id,jenis_pemb,wkt,reply_to,tahun_bimbingan) VALUES ('$judul','$pengirim','dsn','$penerima','mhs','$topik','$subyek','$pesan','$dok','$pembing','$jenis_pemb','$wkt','$id','$periode')  ");
			if ($is_send) {
			mysqli_query($con,"UPDATE tb_pesan SET status_pesan='Y' WHERE id_pesan=$id ");
			echo "<script>
				window.location='?pages=history&read=$readID&topic=$topik&info=ok';
				</script>";
			}else{
				echo "<script>
				window.location='?pages=history&read=$readID&topic=$topik&info=err';
				</script>";
				
			}

			}else{
				echo "<script>
				window.location='?pages=history&read=$readID&topic=$topik&info=errbig';
				</script>";
	
			}
			}else{
				echo "<script>
				window.location='?pages=history&read=$readID&topic=$topik&info=errfile';
				</script>";
			
			}
			}


			}
			?>
			<!-- end SCRIPT / PROSES BALAS PESAN DARI PEMBIMBING -->

						</p>
                </div>
                <!-- <div class="modal-footer">
                  <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary">Save changes</button>
                </div> -->
              </div>
            </div>
          </div>
	


		<!-- END FORM BALAS PESAN -->
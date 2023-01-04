<div class="row">
    <div class="col-lg-4">
        <?php
		// query tampilkan mahasiswa bimbingan dengan dosen yg login pada Periode aktif
		$mhsBimbingan = mysqli_query($con, "SELECT tb_mhs.nim,
tb_mhs.nama,
tb_mhs.tahun_angkatan,
tb_mhs.fotomhs,
tm_prodi.prodi,
pembing.pembing_id,
pembing.create_at,
pembing.kesediaan,
pembing.jenis FROM pembing 

JOIN tm_periode ON pembing.periode=tm_periode.periode_id
JOIN tb_mhs ON pembing.id_mhs=tb_mhs.id_mhs
JOIN tm_prodi ON tb_mhs.prodi_id=tm_prodi.prodi_id
WHERE pembing.dosen=$userID
AND pembing.kesediaan='Y'
AND tm_periode.stt_periode='on'
ORDER BY pembing.pembing_id ASC
");
		?>

        <div class="card mb-2">
            <div class="card-header bg-gradient-primary text-white">
                <h6 class="m-0 font-weight-bold text-light"><i class="fa fa-users"></i> Mahasiswa Bimbingan</h6>
            </div>
            <div class="mb-3 mt-3">
                <?php foreach ($mhsBimbingan as $lb) : ?>

                <a class="dropdown-item d-flex align-items-center" href="?pages=consult&start=<?= $lb['pembing_id'] ?>"
                    style="cursor: pointer;">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="../apl/img/<?= $lb['fotomhs'] ?>"
                            style="width: 40px;height: 40px; border: 2px;border-radius: 100%">
                        <div class="status-indicator bg-success"></div>
                    </div>
                    <div class="font-weight-bold">
                        <div class="text-truncate"><?= $lb['nama'] ?> </div>
                        <div class="small" style="font-size: 12px;">NIM.<?= $lb['nim'] ?> - PRODI - <?= $lb['prodi'] ?>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- // Tampilkan daftar pesan terkirim -->
        <?php
		$pesanTerkirim = mysqli_query($con, "SELECT
tb_mhs.id_mhs,
tb_mhs.nama,
tb_mhs.fotomhs,
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
JOIN tb_mhs ON tb_pesan.penerima_id=tb_mhs.id_mhs
WHERE tb_pesan.pengirim_id=$userID
AND tb_pesan.user_pengirim='dsn'
AND tb_pesan.user_penerima='mhs'
-- AND tb_pesan.status_pesan='new'
AND tm_periode.stt_periode='on'
-- AND tb_pesan.reply_to=0
ORDER BY tb_pesan.id_pesan DESC 
 ");
		// jumlah pesan lama
		$jmlPesanTerkirim = mysqli_num_rows($pesanTerkirim);
		?>
        <div class="card mb-2">
            <div class="card-header bg-gradient-info text-white">
                <h6 class="m-0 font-weight-bold text-light"><i class="fa fa-envelope"></i> Pesan Terkirim
                    <b>(<?= $jmlPesanTerkirim ?>)</b>
                </h6>
            </div>
            <div class="mb-3 mt-3">
                <?php
				if ($jmlPesanTerkirim < 1) {
					echo '<center>Kotak terkirim kosong ..</center>';
				} else {
					// tampilkan daftar pesan
				?>
                <?php
					foreach ($pesanTerkirim as $lt) : ?>
                <a class="dropdown-item d-flex align-items-center" href="" style="cursor: pointer;">
                    <div class="dropdown-list-image mr-3">
                        <img class="img-fluid" src="../apl/img/<?= $lt['fotomhs'] ?>"
                            style="width: 35px;height: 35px;border-radius: 100%">
                        <div class="status-indicator bg-success"></div>
                    </div>
                    <div class="font-weight-bold">
                        <div class="text-truncate" style="max-width: 20rem;"><?= $lt['isi_pesan'] ?> </div>
                        <div class="small text-success" style="font-size: 12px;"><i class="fa fa-user"></i> Kepada :
                            <b><?= $lt['nama'] ?></b><br>
                            <span class="text-primary" style="font-size: 11px;"><i class="fa fa-clock"></i>
                                <?= date('d-m-Y- H:i:s', strtotime($lt['wkt'])) ?></span>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
                <?php
				}
				?>



            </div>
        </div>
        <!-- // end daftar pesan terkirim -->

    </div>
    <!-- end col-lg 4 -->

    <div class="col-lg-8">
        <?php
		if (isset($_GET['close'])) {
			$closeID = intval($_GET['close']);
			mysqli_query($con, "UPDATE tb_pesan SET status_pesan='R' WHERE id_pesan=$closeID  ");
			echo "<script>
	window.location='?pages=consult';
</script>";
		}

		// tampilkan pesan sukses didkirim
		if (isset($_GET['ok'])) {
			echo '<div class="alert alert-success alert-dismissible" id="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">×</span>
		</button>
		<h6><i class="fas fa-check"></i><b> Success!</b></h6>
		Pesan dikirim ..
		</div>';
		}

		// MENGIRIM PESAN KEPADA Mahasiswa
		if (isset($_GET['start'])) {
			$bimbinganID = intval($_GET['start']);
			// mendapatkan identitas mahasiswa bimbingan
			$mhs = mysqli_fetch_assoc(mysqli_query($con, "
			SELECT
			tb_mhs.id_mhs,
			tb_mhs.nim,
			tb_mhs.nama,
			tb_mhs.tahun_angkatan,
			tb_mhs.fotomhs,
			tm_prodi.prodi,
			pengajuan.pengajuan_id,
			pengajuan.judul,
			pembing.pembing_id,
			pembing.create_at,
			pembing.kesediaan,
			pembing.jenis FROM pembing 
			JOIN tm_periode ON pembing.periode=tm_periode.periode_id
			JOIN tb_mhs ON pembing.id_mhs=tb_mhs.id_mhs
			JOIN tm_prodi ON tb_mhs.prodi_id=tm_prodi.prodi_id
			JOIN pengajuan ON pembing.pengajuan_id=pengajuan.pengajuan_id
			WHERE pembing.dosen=$userID
			AND pembing.pembing_id=$bimbinganID
			AND pembing.kesediaan='Y'
			AND pengajuan.disetujui_kajur='Y'
			AND tm_periode.stt_periode='on'
			ORDER BY pembing.pembing_id ASC
			"));

		?>
        <div class="card mb-4">
            <div class="card-header bg-gradient-primary text-white">
                <h6 class="m-0 font-weight-bold text-light"><i class="fas fa-comments fa-2x text-white"></i> Chatting
                </h6>
            </div>
            <div class="card-body">
                <div>
                    <span class="" style="border: 1px;padding: 4px;border-radius: 20px;"><i
                            class="fas fa-share fa-2x"></i> Kepada </span>
                    <a class="dropdown-item d-flex align-items-center bg-gradient-primary text-white" href="#"
                        style="cursor: pointer;border-radius: 50px;">
                        <div class="dropdown-list-image mr-3">

                            <img class="rounded-circle" src="../apl/img/<?= $mhs['fotomhs'] ?>"
                                style="width: 40px;height: 40px; border: 2px solid;border-radius: 100%">

                        </div>
                        <div class="font-weight-bold">
                            <div class="text-truncate"><?= $mhs['nama'] ?></div>
                            <div class="small text-gray-500">
                                <i class="fa fa-user"></i> NIM.<?= $mhs['nim'] ?> - <i class="fa fa-graduation-cap"></i>
                                <?= $mhs['prodi'] ?>
                            </div>
                            <span style="font-size: 12px;">
                                Judul : <?= $mhs['judul'] ?>
                            </span>
                        </div>
                    </a>
                </div>
                <span class="" style="border: 1px;padding: 4px;border-radius: 20px;"><i
                        class="fas fa-file-alt fa-2x mt-2"></i> DOKUMEN SKRIPSI/TA </span>

                <div class="row">
                    <!-- Tampilkan file skripsi mahasiswa -->
                    <?php
						$file = mysqli_query($con, "SELECT * FROM tb_fileskripsi WHERE id_mhs=$mhs[id_mhs] ORDER BY id_file ASC ");
						if (mysqli_num_rows($file) < 1) {
							echo "<center><b>Tidak dokumen</b></center>";
						} else {
						?>
                    <?php

							foreach ($file as $df) : ?>
                    <a href="../apl/file_skripsi/<?= $df['file'] ?>" target="_blank" class="col-lg-2 mt-2"
                        style="text-decoration: none;">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <span style="font-size: 10px;"><?= $df['nama_file'] ?></span>
                            </div>
                            <div class="card-body">
                                <center>
                                    <?php
												if ($df['tipe_file'] == 'doc') {
													echo "<i class='fas fa-file-word fa-4x'></i> ";
												} elseif ($df['tipe_file'] == 'docx') {
													echo "<i class='fas fa-file-word fa-4x'></i> ";
												} elseif ($df['tipe_file'] == 'xls') {
													echo "<i class='fas fa-file-excel fa-4x text-success'></i> ";
												} elseif ($df['tipe_file'] == 'xlsx') {
													echo "<i class='fas fa-file-excel fa-4x text-success'></i> ";
												} elseif ($df['tipe_file'] == 'ppt') {
													echo "<i class='fas fa-file-powerpoint fa-4x'></i> ";
												} elseif ($df['tipe_file'] == 'pptx') {
													echo "<i class='fas fa-file-powerpoint fa-4x'></i> ";
												} elseif ($df['tipe_file'] == 'pdf') {
													echo "<i class='fas fa-file-pdf fa-4x text-danger'></i> ";
												} elseif ($df['tipe_file'] == 'rar') {
													echo "<i class='fas fa-file-archive fa-4x'></i>";
												} elseif ($df['tipe_file'] == 'zip') {
													echo "<i class='fas fa-file-zip fa-4x'></i> ";
												}
												?>
                                    <!-- <i class="fa fa-file-alt fa-4x"></i> -->
                                    <br>
                                    <span style="font-size: 9px;text-transform: uppercase;"><?= $df['tipe_file'] ?> -
                                        <?= $df['ukuran_file'] ?> KB</span>
                                </center>


                            </div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                    <?php
						}


						?>

                    <!-- end file skripsi -->
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group mt-3">
                        <label for="">Subject/Topik Pembahasan</label>
                        <input name="subyek" type="text" class="form-control" placeholder="Subject" required="">
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="periode" value="<?= $tp['periode_id'] ?>">
                        <input type="hidden" name="judul" value="<?= $mhs['pengajuan_id'] ?>">
                        <input type="hidden" name="pengirim" value="<?= $userID ?>">
                        <input type="hidden" name="penerima" value="<?= $mhs['id_mhs'] ?>">
                        <input type="hidden" name="pembing" value="<?= $mhs['pembing_id'] ?>">
                        <input type="hidden" name="jenis_pemb" value="<?= $mhs['jenis'] ?>">
                        <textarea name="pesan" class="form-control" placeholder="Tuliskan disini .."
                            required></textarea>
                    </div>

                    <div class="form-group">
                        <div class="custom-file">
                            <input name="file" type="file" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" name="send_new_message" class="btn btn-outline-primary btn-sm"><i
                                class="fa fa-comment"></i> Kirim Pesan</button>
                    </div>
                </form>
                <!-- SCRIPT / PROSES MENGIRIM PESAN BARU -->
                <?php
					if (isset($_POST['send_new_message'])) {
						$array  = array('jpg', 'jpeg', 'png', 'doc', 'docx', 'ppt', 'pptx', 'pdf', 'zip', 'rar', 'xls', 'xlsx',);
						$periode         = intval($_POST['periode']);
						$judul         = intval($_POST['judul']);
						$subyek        = htmlspecialchars($_POST['subyek']);
						$topik         = 'DSN-TOPIK' . '-' . time();
						$pesan         = htmlspecialchars($_POST['pesan']);
						$pengirim      = intval($_POST['pengirim']);
						$penerima      = intval($_POST['penerima']);
						$pembing       = intval($_POST['pembing']);
						$jenis_pemb    = htmlspecialchars($_POST['jenis_pemb']);
						$wkt           = date('Y-m-d H:i:s');
						// Post file
						$filenama = $pengirim . '_' . time();
						$file_name    = $_FILES['file']['name'];
						@$file_ext     = strtolower(end(explode('.', $file_name)));
						$file_size    = $_FILES['file']['size'];
						$file_tmp     = $_FILES['file']['tmp_name'];
						$dok = $filenama . '.' . $file_ext;

						if ($file_name == "") {
							// jika pesan tanpa file
							$is_send = mysqli_query($con, "INSERT INTO tb_pesan (pengajuan_id,pengirim_id,user_pengirim,penerima_id,user_penerima,topik,subyek,isi_pesan,pembing_id,jenis_pemb,wkt,tahun_bimbingan) VALUES ('$judul','$pengirim','dsn','$penerima','mhs','$topik','$subyek','$pesan','$pembing','$jenis_pemb','$wkt','$periode')  ");
							if ($is_send) {
								echo "<script>
window.location='?pages=consult&start=$bimbinganID&ok';
</script>";
							}
						} else {

							// jika pesan melampirkan file
							if (in_array($file_ext, $array) === true) {
								if ($file_size < 2000000) {
									$lokasi = '../files/' . $filenama . '.' . $file_ext;
									move_uploaded_file($file_tmp, $lokasi);
									$is_send = mysqli_query($con, "INSERT INTO tb_pesan (pengajuan_id,pengirim_id,user_pengirim,penerima_id,user_penerima,topik,subyek,isi_pesan,document,pembing_id,jenis_pemb,wkt,tahun_bimbingan) VALUES ('$judul','$pengirim','dsn','$penerima','mhs','$topik','$subyek','$pesan','$dok','$pembing','$jenis_pemb','$wkt','$periode')  ");
									if ($is_send) {
										echo "<script>
window.location='?pages=consult&start=$bimbinganID&ok';
</script>";
									}
								} else {
									echo '<div class="alert alert-danger bg-gradient-danger text-white" id="alert">ERROR: Ukuran File terlalu besar, Maksimal 2 MB</div>';
								}
							} else {
								echo '<div class="alert alert-danger bg-gradient-danger text-white" id="alert">ERROR: Ekstensi file tidak di izinkan!</div>';
							}
						}
					}
					?>
                <!-- end SCRIPT / PROSES MENGIRIM PESAN BARU -->

            </div>
        </div>
        <?php

		} else {
			// QUERY PESAN BARU DARI MAHASISWA
			$newPesan = mysqli_query($con, "SELECT
			tb_mhs.id_mhs,
			tb_mhs.nama,
			tb_mhs.fotomhs,
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
			JOIN tb_mhs ON tb_pesan.pengirim_id=tb_mhs.id_mhs
			JOIN tm_periode ON tb_pesan.tahun_bimbingan=tm_periode.periode_id
			WHERE tb_pesan.penerima_id=$userID
			AND tb_pesan.user_pengirim='mhs'
			AND tb_pesan.status_pesan='new'
			AND tm_periode.stt_periode='on'
			ORDER BY tb_pesan.id_pesan ASC ");
			// jumlah pesan baru
			$jmlPesan = mysqli_num_rows($newPesan);
			// QUERY PESAN BARU DARI MAHASISWA 
		?>
        <!-- // cek jika ada pesan baru yg dikirim oleh dosen -->
        <?php
			if ($jmlPesan > 0) {
				// menampilkan daftar pesan baru		
			?>
        <div class="card mb-3">
            <div class="card-header bg-gradient-success text-white">
                <h6 class="m-0 font-weight-bold text-light"><i class="fa fa-envelope-open"></i> Pesan Masuk
                    <b>(<?= $jmlPesan ?>)</b>
                </h6>
            </div>
            <div class="card-body">
                <?php
						foreach ($newPesan as $nm) : ?>
                <form method="POST" enctype="multipart/form-data">
                    <i class="fas fa-share fa-2x text-success mr-2"></i><b> Pesan Baru Dari ..</b>
                    <a class="header1 expand dropdown-item d-flex align-items-center bg-primary text-white mb-2"
                        href="#" style="cursor: pointer;border-radius: 50px;">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="../apl/img/<?= $nm['fotomhs'] ?>"
                                style="width: 45px;height: 45px; border: 2px solid;border-radius: 100%">
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div class="font-weight-bold">
                            <div class="text-truncate">
                                <i class="fa fa-user"> </i> <?= $nm['nama'] ?>
                            </div>
                            <div class="small text-white" style="text-transform: uppercase;">
                                Pembimbing <?= $nm['jenis_pemb'] ?> . <i class="fa fa-clock"></i>
                                <?= date('d-m-Y H:i:s', strtotime($nm['wkt'])) ?> <br>
                                <span style="font-size: 9px;"><i class="fa fa-share"></i> <?= $nm['topik'] ?></span>
                            </div>
                        </div>
                    </a>
                    <div class="header1">

                        <span class="mt-3">
                            <div class="alert alert-light mt-2 mb-2">
                                <span> <b>Topik : </b> <?= $nm['subyek'] ?> </span>
                                <p class="mt-2"><?= $nm['isi_pesan'] ?></p>
                            </div>
                            <!-- tombol area -->
                            <center>
                                <?php
											if ($nm['document'] !== 'nofile') {
											?>
                                <a href="../files/<?= $nm['document'] ?>" target="_blank"
                                    class='btn btn-success bg-gradient-success btn-sm'><i class="fa fa-file-alt"></i>
                                    Dokumen</a>
                                <?php
											}
											?>
                            </center>
                            <!-- edn tombol -->

                        </span>


                        <div class="form-group mt-3">
                            <input type="hidden" name="periode" value="<?= $nm['tahun_bimbingan'] ?>">
                            <input type="hidden" name="id" value="<?= $nm['id_pesan'] ?>">
                            <input type="hidden" name="judul" value="<?= $nm['pengajuan_id'] ?>">
                            <input type="hidden" name="topik" value="<?= $nm['topik'] ?>">
                            <input type="hidden" name="subyek" value="<?= $nm['subyek'] ?>">
                            <input type="hidden" name="pengirim" value="<?= $userID ?>">
                            <input type="hidden" name="penerima" value="<?= $nm['id_mhs'] ?>">
                            <input type="hidden" name="pembing" value="<?= $nm['pembing_id'] ?>">
                            <input type="hidden" name="jenis_pemb" value="<?= $nm['jenis_pemb'] ?>">
                            <textarea name="pesan" class="form-control" placeholder="Tuliskan disini .."></textarea>
                        </div>

                        <div class="form-group">
                            <div class="custom-file">
                                <input name="file" type="file" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" name="balas" class="btn btn-outline-primary btn-sm"><i
                                    class="fa fa-reply"></i> Balas</button>
                            <a href="?pages=consult&close=<?= $nm['id_pesan'] ?>"
                                class="btn btn-outline-warning btn-sm"><i class="fa fa-times"></i> Balas Nanti</a>
                        </div>
                    </div>


                </form>

                <?php endforeach; ?>
                <!-- SCRIPT / PROSES BALAS PESAN DARI MAHASISWASS -->
                <?php
						if (isset($_POST['balas'])) {
							$array  = array('jpg', 'jpeg', 'png', 'doc', 'docx', 'ppt', 'pptx', 'pdf', 'zip', 'rar', 'xls', 'xlsx',);
							$periode = intval($_POST['periode']);
							$id      = intval($_POST['id']);
							$judul   = intval($_POST['judul']);
							$topik  = htmlspecialchars($_POST['topik']);
							$subyek = htmlspecialchars($_POST['subyek']);
							$pesan  = htmlspecialchars($_POST['pesan']);
							$pengirim      = intval($_POST['pengirim']);
							$penerima      = intval($_POST['penerima']);

							$pembing       = intval($_POST['pembing']);
							$jenis_pemb    = htmlspecialchars($_POST['jenis_pemb']);
							$wkt           = date('Y-m-d H:i:s');
							// Post file
							$filenama = $pengirim . '_' . time();
							$file_name    = $_FILES['file']['name'];
							@$file_ext     = strtolower(end(explode('.', $file_name)));
							$file_size    = $_FILES['file']['size'];
							$file_tmp     = $_FILES['file']['tmp_name'];
							$dok = $filenama . '.' . $file_ext;

							if ($file_name == "") {
								// jika pesan tanpa file
								$is_send = mysqli_query($con, "INSERT INTO tb_pesan (pengajuan_id,pengirim_id,user_pengirim,penerima_id,user_penerima,topik,subyek,isi_pesan,pembing_id,jenis_pemb,wkt,reply_to,tahun_bimbingan) VALUES ('$judul','$pengirim','dsn','$penerima','mhs','$topik','$subyek','$pesan','$pembing','$jenis_pemb','$wkt','$id','$periode')  ");
								// $reply = mysqli_query($con,"INSERT INTO reply (id_pesan,user_id,user_tipe,tipe_pesan)  ");
								if ($is_send) {
									mysqli_query($con, "UPDATE tb_pesan SET status_pesan='Y' WHERE id_pesan=$id ");
									echo "<script>
			window.location='?pages=consult&ok';
			</script>";
								} else {
									echo '<div class="alert alert-danger bg-gradient-danger text-white" id="alert">PESAN TIDAK TERKIRIM: Periksa kembali isi pesan anda ..</div>';
								}
							} else {

								// jika pesan melampirkan file
								if (in_array($file_ext, $array) === true) {
									if ($file_size < 2000000) {
										$lokasi = '../files/' . $filenama . '.' . $file_ext;
										move_uploaded_file($file_tmp, $lokasi);
										$is_send = mysqli_query($con, "INSERT INTO tb_pesan (pengajuan_id,pengirim_id,user_pengirim,penerima_id,user_penerima,topik,subyek,isi_pesan,document,pembing_id,jenis_pemb,wkt,reply_to,tahun_bimbingan) VALUES ('$judul','$pengirim','dsn','$penerima','mhs','$topik','$subyek','$pesan','$dok','$pembing','$jenis_pemb','$wkt','$id','$periode')  ");
										if ($is_send) {
											mysqli_query($con, "UPDATE tb_pesan SET status_pesan='Y' WHERE id_pesan=$id ");
											echo "<script>
			window.location='?pages=consult&ok';
			</script>";
										} else {
											echo '<div class="alert alert-danger bg-gradient-danger text-white" id="alert">PESAN TIDAK TERKIRIM: Periksa kembali isi pesan anda ..</div>';
										}
									} else {
										echo '<div class="alert alert-danger bg-gradient-danger text-white" id="alert">ERROR: Ukuran File terlalu besar, Maksimal 2 MB</div>';
									}
								} else {
									echo '<div class="alert alert-danger bg-gradient-danger text-white" id="alert">ERROR: Ekstensi file tidak di izinkan!</div>';
								}
							}
						}
						?>
                <!-- end SCRIPT / PROSES BALAS PESAN DARI MAHASISWA -->
            </div>
        </div>
        <?php
				// end daftar pesan baru
			}

			?>

        <?php
		}


		?>



        <!-- tampilkan kotak chat untuk dibaca -->
        <?php
		if (isset($_GET['read'])) {
			$readID = intval($_GET['read']);
			$topik = mysqli_escape_string($con, $_GET['topic']);
			// mendapatkan Informasi Pesan Baru
			$historyBimbingan = mysqli_query($con, "SELECT
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
		JOIN tb_mhs ON tb_pesan.pengirim_id=tb_mhs.id_mhs
		JOIN tm_periode ON tb_pesan.tahun_bimbingan=tm_periode.periode_id
		JOIN tm_prodi ON tb_mhs.prodi_id=tm_prodi.prodi_id
		WHERE tb_pesan.penerima_id=$userID
		AND tb_pesan.pembing_id=$readID
		AND tb_pesan.topik='$topik'
		AND tb_pesan.status_pesan !='new'
		AND tm_periode.stt_periode='on'
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
            <div class="card-header bg-gradient-danger text-white">
                <h6 class="m-0 font-weight-bold text-light"><i class="fa fa-history"></i> Hsitosry Bimbingan
                    <b>(<?= $jmlHistory ?>)</b>
                </h6>
            </div>
            <div class="card-body">
                <?php
						foreach ($historyBimbingan as $hm) : ?>
                <div>
                    <span class="" style="border: 1px;padding: 4px;border-radius: 20px;"><i
                            class="fas fa-share fa-2x"></i> Pengirim </span>
                    <a class="dropdown-item d-flex align-items-center bg-gradient-danger text-white" href="#"
                        style="cursor: pointer;border-radius: 50px;">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="../apl/img/<?= $hm['fotomhs'] ?> "
                                style="width: 40px;height: 40px; border: 2px solid;border-radius: 100%">
                        </div>
                        <div class="font-weight-bold">
                            <div class="text-truncate"><?= $hm['nama'] ?> </div>
                            <div class="small text-gray-500">
                                <i class="fa fa-user"></i> NIM.<?= $hm['nim'] ?> - <i class="fa fa-graduation-cap"></i>
                                <?= $hm['prodi'] ?>
                            </div>
                            <span style="font-size: 12px;">
                            </span>
                        </div>
                    </a>


                    <span class="mt-3">
                        <div class="alert alert-light mt-2">
                            <span class="bg-gradient-light text-black"
                                style="border: 1px;padding: 4px;border-radius: 20px;"><i
                                    class="fas fa-comments fa-1x"></i> Pesan </span>
                            <span> <b>Topik : </b> <?= $hm['subyek'] ?> </span>
                            <p class="mt-2"><?= $hm['isi_pesan'] ?></p>
                        </div>
                        <!-- tombol area -->
                        <center>
                            <?php
										if ($hm['document'] !== 'nofile') {
										?>
                            <a href="../files/<?= $hm['document'] ?>" target="_blank"
                                class='btn btn-success bg-gradient-success btn-sm'><i class="fa fa-file-alt"></i>
                                Dokumen</a>
                            <?php
										}
										?>
                        </center>
                        <!-- edn tombol -->

                    </span>

                    <!-- menanmpilkan balasan pesan -->
                    <?php
								$reply = mysqli_query($con, "SELECT * FROM tb_pesan WHERE reply_to=$hm[id_pesan] ");
								if (mysqli_num_rows($reply) < 1) {
									echo "Tidak ada balasan ..";
								} else {
								?>
                    <?php
									foreach ($reply as $rm) : ?>
                    <span class="" style="border: 1px;padding: 4px;border-radius: 20px;"><i
                            class="fas fa-comments fa-2x"></i> Pesan Balasan </span>
                    <div class="alert alert-success bg-gradient-success"
                        style="background: #E1F5FE;border-radius:50px;border:1px dashed;">
                        <p style="color: black"><?= $rm['isi_pesan'] ?></p>
                    </div>
                    <!-- tombol area -->
                    <center>
                        <?php
											if ($rm['document'] !== 'nofile') {
											?>
                        <a href="../files/<?= $rm['document'] ?>" target="_blank"
                            class='btn btn-success bg-gradient-success btn-sm'><i class="fa fa-file-alt"></i>
                            Dokumen</a>
                        <?php
											}
											?>
                    </center>
                    <!-- edn tombol -->
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
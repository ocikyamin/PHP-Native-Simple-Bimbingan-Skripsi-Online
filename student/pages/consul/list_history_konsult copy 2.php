<div class="row">
    <div class="col-lg-4">
        <div class="dropdown-list shadow animated--grow-in show" aria-labelledby="messagesDropdown">
            <h6 class="bg-gradient-danger dropdown-header text-white">
                <i class="fa fa-history"></i> Riwayat Bimbingan
            </h6>
            <?php
			// tampilkan pesan berdasarkan topik pembahasan
			$topikPembahasan = mysqli_query($con, "SELECT * FROM tb_pesan WHERE pengajuan_id='$judulKu[pengajuan_id]' GROUP BY topik ORDER BY id_pesan ASC ");
			foreach ($topikPembahasan as $gt) {
				// cek identitas user pembuat 
				if ($gt['pengirim_id'] == $userID && $gt['user_pengirim'] == 'mhs') {
					// echo "Itu Saya mahasiswa";
			?>
            <a class="dropdown-item d-flex align-items-center"
                href="?pages=history&topic=<?= base64_encode($gt['topik']) ?>">
                <div class="dropdown-list-image mr-3">
                    <img class="img-fluid" src="../apl/img/<?= $user['fotomhs'] ?>"
                        style="width: 35px;height: 35px;border-radius: 100%">
                    <div class="status-indicator bg-success"></div>
                </div>
                <div class="font-weight-bold">
                    <div class="text-truncate"><?= $gt['subyek']; ?> </div>
                    <div class="small text-gray-500"><?= $user['nama']; ?> ·
                        <?= date('H:i', strtotime($gt['wkt'])) ?></div>
                </div>
            </a>
            <?php
				} else {
					// echo "Itu dosen";
					$dosen = mysqli_fetch_array(mysqli_query($con, "SELECT tb_dsn.id_dsn,
	tb_dsn.nama_dosen,
	tb_dsn.foto FROM tb_dsn WHERE id_dsn=$gt[pengirim_id] "));
				?>
            <a class="dropdown-item d-flex align-items-center"
                href="?pages=history&topic=<?= base64_encode($gt['topik']) ?>">
                <div class="dropdown-list-image mr-3">
                    <img class="img-fluid" src="../apl/img/dosen/<?= $dosen['foto'] ?>"
                        style="width: 35px;height: 35px;border-radius: 100%">
                    <div class="status-indicator bg-success"></div>
                </div>
                <div class="font-weight-bold">
                    <div class="text-truncate"><?= $gt['subyek']; ?> </div>
                    <div class="small text-gray-500"><?= $dosen['nama_dosen']; ?> ·
                        <?= date('H:i', strtotime($gt['wkt'])) ?></div>
                </div>
            </a>
            <?php
				}
				?>


            <?php
			}
			?>



            <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-gradient-success text-white">
                <h6 class="m-0 font-weight-bold text-light"><i class="fa fa-comments fa-2x"></i> Percakapan</h6>
            </div>
            <div class="card-body">
                <?php
				if (isset($_GET['topic'])) {
					$topikCode = base64_decode(mysqli_escape_string($con, $_GET['topic']));
					$getTopik = mysqli_query($con, "SELECT * FROM tb_pesan WHERE topik='$topikCode' ORDER BY topik  ");
					foreach ($getTopik as $lt) {
						// tampilkan identitas pengirim 
						if ($lt['pengirim_id'] == $userID && $lt['user_pengirim'] == 'mhs') {
							// echo "mhs punya <hr>";
				?>
                <span class="alert alert-success" style="border: 1px dotted;padding: 4px;border-radius: 50px;"><i
                        class="fas fa-share"></i>
                    <i class="fa fa-user small"> </i> <?= $user['nama'] ?> . <i class="fa fa-clock small"></i>
                    <?= date('H:i', strtotime($lt['wkt'])) ?>
                </span>
                <div class="alert alert-light mb-2" style="border-radius: 20px;">

                    <div class="table-responsive">
                        <div class="pesan-view">
                            <?= htmlspecialchars_decode($lt['isi_pesan']) ?>
                        </div>
                        <!-- tombol area -->
                        <?php
									if ($lt['document'] !== 'nofile') {
									?>
                        File :
                        <a href="../files/<?= $lt['document'] ?>" target="_blank" class="btn btn-success btn-sm"
                            style="cursor: pointer;text-decoration: none;"><i class="fas fa-cloud-download-alt"></i>
                            Download</a>
                        <?php
									}
									?>
                        <!-- end tombol -->
                    </div>

                </div>
                <?php
						} else {
							// echo "Dosen punya <hr> ";
							$dosen = mysqli_fetch_array(mysqli_query($con, "SELECT tb_dsn.id_dsn,
	tb_dsn.nama_dosen,
	tb_dsn.foto FROM tb_dsn WHERE id_dsn=$lt[pengirim_id] "));
						?>
                <span class="alert alert-primary" style="border: 1px dotted;padding: 4px;border-radius: 50px;"><i
                        class="fas fa-share"></i>
                    <i class="fa fa-user small"> </i> <?= $dosen['nama_dosen'] ?> . <i class="fa fa-clock small"></i>
                    <?= date('H:i', strtotime($lt['wkt'])) ?>
                </span>
                <div class="alert alert-light mb-2" style="border-radius: 20px;">

                    <div class="table-responsive">
                        <div class="pesan-view">
                            <?= htmlspecialchars_decode($lt['isi_pesan']) ?>

                        </div>
                        <!-- tombol area -->
                        <?php
									if ($lt['document'] !== 'nofile') {
									?>
                        File :
                        <a href="../files/<?= $lt['document'] ?>" target="_blank" class="btn btn-success btn-sm"
                            style="cursor: pointer;text-decoration: none;"><i class="fas fa-cloud-download-alt"></i>
                            Download</a>
                        <?php
									}
									?>
                        <!-- end tombol -->
                    </div>

                </div>

                <?php
						}

						// tampilkan pesan balasan 
						$getReplyMsg = mysqli_query($con, "SELECT * FROM tb_pesan WHERE reply_to=$lt[id_pesan] ORDER BY id_pesan ASC ");
						// Jika belum ada balas pesan 
						if (mysqli_num_rows($getReplyMsg) < 1) {
							echo "<span class='text-danger'>Belum ada balasan</span>";
						}
					}
				}

				?>
            </div>
        </div>
    </div>
</div>
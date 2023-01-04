<?php
if (isset($_SESSION['LECT_SES'])) {
	if (isset($_GET['set'])) {
		$setID = intval($_GET['set']);
		$todo  = mysqli_escape_string($con, $_GET['to']);
		if ($todo == 'finish') {
			mysqli_query($con, "UPDATE pembing SET status_bimbingan='selesai' WHERE pembing_id=$setID ");
			echo "<script>alert('Bimbingan Selesai ..');window.location='?pages=status';</script>";
		} else {
			mysqli_query($con, "UPDATE pembing SET status_bimbingan='proses' WHERE pembing_id=$setID ");
			echo "<script>alert('Selesai dibatalkan ..');window.location='?pages=status';</script>";
		}
	}
} else {
	echo "<script>window.location='../';</script>";
}

$mhsBimbingan = mysqli_query($con, "SELECT
tb_mhs.id_mhs,
tb_mhs.nim,
tb_mhs.nama,
tb_mhs.fotomhs,
tm_prodi.prodi,
pengajuan.pengajuan_id,
pengajuan.judul,
pembing.pembing_id,
pembing.status_bimbingan
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
    <h1 class="h3 mb-0 text-gray-800">Status Bimbingan</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="./">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Status Bimbingan</li>
    </ol>
</div>
<div class="row">
    <div class="col-lg-12">
        <!-- list mahasiswa bimbingan-->
        <div class="card mb-2">
            <div class="card-header bg-gradient-primary text-white">
                <h6><i class="fa fa-users"></i> Mahasiswa Bimbingan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-sm mid">
                        <thead>
                            <tr>
                                <th>NO.</th>
                                <th>MAHASISWA</th>
                                <th>MULAI BIMBINGAN</th>
                                <th>SELESAI BIMBINGAN</th>
                                <th>STATUS</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
							if ($jmlMhsBimbingan < 1) {
								echo '<center>Belum ada percakapan ..</center>';
							} else {
								// tampilkan daftar pesan
							?>
                            <?php
								$i = 1;
								foreach ($mhsBimbingan as $lm) : ?>
                            <tr>
                                <td><?= $i++ ?>.</td>
                                <td>

                                    <div class="font-weight-bold">
                                        <div class="small" style="font-size: 12px;text-transform: uppercase;"><i
                                                class="fa fa-user"></i> NAMA : <b><?= $lm['nama'] ?> ·
                                                NIM<?= $lm['nim'] ?></b> <br>
                                            <span style="font-size: 11px;"><i class="fa fa-graduation-cap"></i> PRODI :
                                                <b><?= $lm['prodi'] ?></b></span> <br>
                                            <span style="font-size: 11px;"><i class="fa fa-check"></i> JUDUL :
                                                <b><?= $lm['judul'] ?></b></span>
                                        </div>
                                    </div>

                                </td>
                                <td>
                                    <!-- tgl mulai bimbingan -->
                                    <?php
											$tglMulai = mysqli_fetch_assoc(mysqli_query($con, "SELECT wkt FROM tb_pesan WHERE pengajuan_id=$lm[pengajuan_id] ORDER BY wkt ASC LIMIT 1 "));

											if (empty($tglMulai['wkt'])) {
												echo "Belum ada tanggal..";
											} else {
												echo date('d-m-Y', strtotime($tglMulai['wkt']));
											}

											?>
                                    <!-- end mulai bimbingan -->
                                </td>
                                <td>
                                    <!-- tgl mulai bimbingan -->
                                    <?php
											$tglSelesai = mysqli_fetch_assoc(mysqli_query($con, "SELECT tb_pesan.wkt
					 FROM pembing
					 JOIN pengajuan ON pembing.pengajuan_id=pengajuan.pengajuan_id
					 JOIN tb_pesan ON pembing.pengajuan_id=pengajuan.pengajuan_id
					 JOIN tm_periode ON pembing.periode=tm_periode.periode_id
					  WHERE tb_pesan.pengajuan_id=$lm[pengajuan_id]
					   AND pembing.dosen=$userID
					   AND pembing.id_mhs=$lm[id_mhs]
					    AND pembing.status_bimbingan='selesai'
					     AND tm_periode.stt_periode='on'
					     ORDER BY tb_pesan.wkt DESC  "));

											if (empty($tglSelesai['wkt'])) {
												echo "Belum ada tanggal Selasai..";
											} else {
												echo date('d-m-Y', strtotime($tglSelesai['wkt']));
											}

											?>
                                    <!-- end mulai bimbingan -->
                                </td>
                                <td>
                                    <?php
											if ($lm['status_bimbingan'] == 'selesai') {
												echo "<span class='badge badge-success bg-gradient-success text-white'><i class='fa fa-check'></i> SELESAI</span>";
											} elseif ($lm['status_bimbingan'] == 'proses') {
												echo "<span class='badge badge-warning bg-gradient-warning text-white'><i class='fa fa-undo'></i> PROSES</span>";
											} elseif ($lm['status_bimbingan'] == 'new') {
												echo "<span class='badge badge-danger bg-gradient-danger text-white'><i class='fa fa-clock'></i> BELUM BIMBINGAN</span>";
											}

											?>
                                </td>
                                <td>
                                    <?php
											if ($lm['status_bimbingan'] == 'selesai') {
											?>
                                    <a href="?pages=status&set=<?= $lm['pembing_id'] ?>&to=cancel"
                                        onclick="return confirm('Apakah Yakin ?')"
                                        class="btn bg-gradient-danger text-white btn-sm mb-1 btn-block"><i
                                            class="fa fa-times"></i> Batal </a>
                                    <?php

											} elseif ($lm['status_bimbingan'] == 'proses') {
											?>
                                    <a href="?pages=status&set=<?= $lm['pembing_id'] ?>&to=finish"
                                        onclick="return confirm('Apakah Yakin ?')"
                                        class="btn bg-gradient-success text-white btn-sm mb-1 btn-block"><i
                                            class="fa fa-check"></i> Selesai </a>
                                    <?php
											} elseif ($lm['status_bimbingan'] == 'new') {
											?>
                                    <a href="?pages=status&set=<?= $lm['pembing_id'] ?>&to=finish"
                                        onclick="return confirm('Apakah Yakin ?')"
                                        class="btn bg-gradient-success text-white btn-sm mb-1 btn-block"><i
                                            class="fa fa-check"></i> Selesai </a>
                                    <?php
											}

											?>
                                    <a href="../apl/report/bukti_bimbingan.php?print=<?= base64_encode($lm['pembing_id']) ?>"
                                        target="_blank" class="btn bg-gradient-dark text-white btn-sm mb-1 btn-block"><i
                                            class="fa fa-print"></i> Print</a>
                                </td>
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
</div>
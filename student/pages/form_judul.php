<?php
if (empty($tp)) {
	echo "  <script>
  	alert('Tahun Akaedmik Belum diaktifkan Admin');
  	window.location='./';
  </script>";
}
if ($user['dosen_pa'] == 0) {
	echo "  <script>
  	alert('Tentukan Dosen Pembimbing Akaedmik');
  	window.location='./';
  </script>";
}


// cek judul yg disetuji
$cekJudul = mysqli_query($con, "SELECT pengajuan_id FROM pengajuan WHERE id_mhs=$userID AND disetujui_kajur='Y' ORDER BY pengajuan_id ASC");
?>

<div class="d-sm-flex align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Usulkan Topik</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="./">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Usulkan Topik</li>
    </ol>
</div>

<div class="row mb-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-gradient-primary text-white">
                <h6 class="mt-3 font-weight-bold"><i class="fa fa-check"></i> Pengajuan Judul</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- proses pengajuan judul skripsi -->
                        <?php
						if (isset($_POST['add'])) {
							$id      = intval($_POST['id']);
							$tp      = intval($_POST['tp']);
							$judul   = ucwords(htmlspecialchars($_POST['judul']));
							$jenis   = htmlspecialchars($_POST['jenis']);
							$masalah = $_POST['masalah'];
							$tgl = date('Y-m-d H:i:s');

							// cek jika sudah ada judul yg disetujui
							if (mysqli_num_rows($cekJudul) < 1) {
								$cekJmlJudul = mysqli_num_rows(mysqli_query($con, "SELECT pengajuan_id FROM pengajuan WHERE id_mhs=$userID "));
								if ($cekJmlJudul >= 3) {
									echo "<script>alert('Maaf Pengajuan Judul hanya 3 Judul  !');window.location='?pages=list_judul'</script>";
								} else {
									mysqli_query($con, "INSERT INTO pengajuan (periode_id,id_mhs,tgl_pengajuan,judul,jenis,masalah) VALUES('$tp','$id','$tgl','$judul','$jenis','$masalah') ");

									echo "<script>alert('Judul berhasil ditambahkan !');window.location='?pages=list_judul'</script>";
								}
							} else {
								echo "<script>alert('Tidak perlu mengajukan topik, karena sudah ada judul yang disetuji !');window.location='?pages=list_judul'</script>";
							}
						}
						?>
                        <!-- end proses -->
                        <form method="POST">
                            <input type="hidden" name="id" value="<?= $userID ?>">
                            <input type="hidden" name="tp" value="<?= $tp['periode_id'] ?>">
                            <div class="form-group">
                                <label for="">Judul Pembahasan/Proposal</label>
                                <input type="text" name="judul"
                                    placeholder="Ex : Sistem Informasi Bimbingan Skripsi Online" class="form-control"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="">Jenis Skripsi / TA</label>
                                <select name="jenis" class="form-control">
                                    <?php
									$jenis = mysqli_query($con, "SELECT * FROM `tm_jenis` ORDER BY id ASC");
									var_dump($jenis);
									foreach ($jenis as $js) {
										echo "<option value='$js[jenis]'>" . $js['jenis'] . "</option>";
									}

									?>


                                </select>
                            </div>


                            <div class="form-group">
                                <label for="">Pokok Masalah</label>
                                <textarea name="masalah" rows="3" class="form-control summernote" required></textarea>
                            </div>
                            <div class="form-group">
                                <center>
                                    <a href="javascript:history.back()" class="btn btn-outline-danger btn-sm mt-2"><i
                                            class="fa fa-times"></i> Cancel</a>
                                    <button type="submit" name="add"
                                        class="btn btn-primary bg-gradient-primary btn-sm mt-2"><i
                                            class="fa fa-check"></i> Ajukan</button>
                                </center>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
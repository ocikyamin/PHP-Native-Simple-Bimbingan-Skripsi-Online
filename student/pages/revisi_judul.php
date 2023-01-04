<div class="d-sm-flex align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Revisi Judul</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="./">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Revisi Judul</li>
    </ol>
</div>

<!-- end proses -->
<?php
$myJudul = mysqli_fetch_assoc($cekJudul);
if ($myJudul['stt_revisi'] == 'Y') {
?>
<div class="alert alert-success bg-gradient-success text-white">
    Perbaikan judul telah disetujui .. <br>
    Judul Baru <b><?= $myJudul['judul'] ?> </b>
</div>
<p>
    <a href="../apl/report/revisi_judul_print.php?print=<?= $myJudul['pengajuan_id'] ?>" target="_blank"
        class="btn btn-primary bg-gradient-primary text-white"><i class="fa fa-print"></i> PRINT FORMULIR</a>
</p>

<?php

} elseif ($myJudul['stt_revisi'] == 'N') {
?>
<div class="alert alert-danger bg-gradient-danger text-white">
    Maaf Pengajuan Revisi Judul <b> <?= $myJudul['revisi_judul'] ?> </b> Ditolak
</div>


<div class="row mb-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-gradient-primary text-white">
                <h6 class="mt-3 font-weight-bold"><i class="fa fa-check"></i> Formulir Revisi Judul Skripsi/TA</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- proses pengajuan judul skripsi -->
                        <?php
							if (isset($_POST['add'])) {
								$id      = intval($_POST['id']);
								$judul   = ucwords(htmlspecialchars($_POST['newjudul']));
								mysqli_query($con, "UPDATE pengajuan SET revisi_judul='$judul',stt_revisi='new' WHERE pengajuan_id=$id ");
								echo "<script>alert('Pengajuan dikirim !');window.location='?pages=revisi'</script>";
							}
							?>

                        <form method="POST">
                            <input type="hidden" name="id" value="<?= $myJudul['pengajuan_id'] ?>">
                            <div class="form-group">
                                <label for="">Judul Skripsi/TA</label>
                                <input type="text" name="judul" value="<?= $myJudul['judul'] ?>" class="form-control"
                                    disabled>
                            </div>

                            <div class="form-group">
                                <label for="">Judul Skripsi/TA Baru</label>
                                <input type="text" name="newjudul" value="<?= $myJudul['revisi_judul'] ?>"
                                    placeholder="Judul Baru .." class="form-control">
                            </div>


                            <div class="form-group">
                                <center>
                                    <a href="javascript:history.back()" class="btn btn-outline-danger btn-sm mt-2"><i
                                            class="fa fa-times"></i> Cancel</a>
                                    <button type="submit" name="add" class="btn btn-warning btn-sm mt-2"><i
                                            class="fa fa-check"></i> Ajukan Revisi Kembali</button>
                                </center>
                            </div>
                        </form>
                        <!-- proses pengajuan judul skripsi -->
                        <?php
							if (isset($_POST['add'])) {
								$id      = intval($_POST['id']);
								$judul   = ucwords(htmlspecialchars($_POST['newjudul']));
								mysqli_query($con, "UPDATE pengajuan SET revisi_judul='$judul',stt_revisi='new' WHERE pengajuan_id=$id ");
								echo "<script>alert('Pengajuan dikirim !');window.location='?pages=revisi'</script>";
							}
							?>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php

} else {

?>
<div class="alert alert-light bg-gradient-light" style="color: black;">
    Modul ini digunakan untuk anda yang ingin melakukan revisi judul penelitian ..
</div>
<div class="row mb-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-gradient-primary text-white">
                <h6 class="mt-3 font-weight-bold"><i class="fa fa-check"></i> Formulir Revisi Judul Skripsi/TA</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- proses pengajuan judul skripsi -->
                        <?php
							if (isset($_POST['add'])) {
								$id      = intval($_POST['id']);
								$judul   = ucwords(htmlspecialchars($_POST['newjudul']));
								mysqli_query($con, "UPDATE pengajuan SET revisi_judul='$judul',stt_revisi='new' WHERE pengajuan_id=$id ");
								echo "<script>alert('Pengajuan dikirim !');window.location='?pages=revisi'</script>";
							}
							?>

                        <form method="POST">
                            <input type="hidden" name="id" value="<?= $myJudul['pengajuan_id'] ?>">
                            <div class="form-group">
                                <label for="">Judul Skripsi/TA</label>
                                <input type="text" name="judul" value="<?= $myJudul['judul'] ?>" class="form-control"
                                    disabled>
                            </div>

                            <div class="form-group">
                                <label for="">Judul Skripsi/TA Baru</label>
                                <input type="text" name="newjudul" value="<?= $myJudul['revisi_judul'] ?>"
                                    placeholder="Judul Baru .." class="form-control">
                            </div>


                            <div class="form-group">
                                <center>
                                    <a href="javascript:history.back()" class="btn btn-outline-danger btn-sm mt-2"><i
                                            class="fa fa-times"></i> Cancel</a>
                                    <button type="submit" name="add"
                                        class="btn btn-primary bg-gradient-primary btn-sm mt-2"><i
                                            class="fa fa-check"></i> Ajukan Revisi</button>
                                </center>
                            </div>
                        </form>


                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php

}

?>
<div class="d-sm-flex align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Perpajangan SK</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="./">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Perpajangan SK</li>
    </ol>
</div>

<!-- end proses -->
<?php
$myJudul = mysqli_fetch_assoc($cekJudul);
if ($myJudul['status_perpanjangan_sk'] == 'Y') {
?>
<div class="alert alert-success bg-gradient-success text-white">
    Perpanjangan SK telah disetujui..</b>
</div>
<p>
    <a target="_blank" href="../apl/report/SK.php?ta=<?= $tp['periode_id'] ?>&tp=<?= $tp['th_periode'] ?>&/=old"
        class="btn btn-warning"><i class="fa fa-print"></i> SK LAMA</a>

    <a target="_blank" href="../apl/report/SK.php?ta=<?= $tp['periode_id'] ?>&tp=<?= $tp['th_periode'] ?>&/=new"
        class="btn btn-primary bg-gradient-primary text-white"><i class="fa fa-print"></i> SK BARU</a>
    <?php
		$nRev = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM pengajuan WHERE id_mhs=$userID AND disetujui_kajur='Y' ORDER BY pengajuan_id ASC"));


		?>
    <a href="../apl/report/perpanjangansk_print.php?print=<?= $nRev['pengajuan_id'] ?>" target="_blank"
        class="btn btn-light"><i class="fa fa-print"></i> SK SAYA</a>
</p>

<?php

} elseif ($myJudul['status_perpanjangan_sk'] == 'N') {
?>
<div class="alert alert-danger">
    Maaf ! Perpanjangan SK Bimbingan ditolak
</div>
<?php

} else {

?>
<div class="alert alert-light bg-gradient-light" style="color: black;">
    Modul ini digunakan untuk anda yang ingin melakukan Pengajuan Perpanjangan SK ..
</div>
<div class="row mb-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-gradient-primary text-white">
                <h6 class="mt-3 font-weight-bold"><i class="fa fa-check"></i> FORMULIR PERPANJANGAN SK BIMBINGAN
                    SKRIPSI/TA</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- proses pengajuan judul skripsi -->
                        <?php
							if (isset($_POST['add'])) {
								$id      = intval($_POST['id']);
								$tgl = $_POST['tgl'];
								$alasanSK = addslashes($_POST['alasanSK']);
								$sttBimbingan = $_POST['status_bimbingan'];
								mysqli_query($con, "UPDATE pengajuan SET tgl_pengajuan_sk='$tgl',alasan_perpanjangan_sk='$alasanSK',status_bimbingan='$sttBimbingan',status_perpanjangan_sk='New' WHERE pengajuan_id=$id ");
								echo "<script>alert('Pengajuan Perpanjangan SK dikirim !');window.location='?pages=sk'</script>";
							}
							?>

                        <form method="POST">
                            <input type="hidden" name="id" value="<?= $myJudul['pengajuan_id'] ?>">
                            <div class="form-group row">
                                <label class="col-lg-3">Tanggal Pengajuan</label>
                                <div class="col-lg-9">
                                    <input type="date" name="tgl" class="form-control" value="<?= date('Y-m-d') ?>"
                                        readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3">Alasan Perpanjangan SK</label>
                                <div class="col-lg-9">
                                    <textarea name="alasanSK" rows="6" class="form-control summernote"
                                        placeholder="Tuliskan Alasan disini..."></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3"></label>
                                <div class="col-lg-9">
                                    <span>
                                        Dimana pelaksanaan penulisan san konsultasi bimbingan Skripsi/TA sampai dengan ?
                                    </span>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="konsultasiJudul" name="status_bimbingan"
                                            value="Konsultasi Judul" class="custom-control-input">
                                        <label class="custom-control-label" for="konsultasiJudul">Konsultasi
                                            Judul</label>
                                    </div>

                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="BAB I" name="status_bimbingan" value="BAB I"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="BAB I">BAB I</label>
                                    </div>

                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="BAB II" name="status_bimbingan" value="BAB II"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="BAB II">BAB II</label>
                                    </div>

                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="BAB III" name="status_bimbingan" value="BAB III"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="BAB III">BAB III</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="BAB IV" name="status_bimbingan" value="BAB IV"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="BAB IV">BAB IV</label>
                                    </div>

                                </div>
                            </div>


                            <div class="form-group">
                                <center>
                                    <a href="javascript:history.back()" class="btn btn-outline-danger btn-sm mt-2"><i
                                            class="fa fa-times"></i> Cancel</a>
                                    <button type="submit" name="add"
                                        class="btn btn-primary bg-gradient-primary btn-sm mt-2"><i
                                            class="fa fa-check"></i> Ajukan Perpanjangan SK</button>
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
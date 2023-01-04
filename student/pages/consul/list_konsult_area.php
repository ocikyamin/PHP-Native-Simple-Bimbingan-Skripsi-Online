<div class="row">
    <div class="col-lg-4">
        <?php
        session_start();
        $userID = intval($_SESSION['MHS_SES']);
        var_dump($userID);
        include '../../../config/databases.php';
        // tampilkan data informasi pembing
        $pembing = mysqli_query($con, "SELECT tb_dsn.nip,
		tb_dsn.nama_dosen,
		tb_dsn.foto,
		pembing.pembing_id,
		pembing.create_at,
		pembing.kesediaan,
		pembing.jenis
		FROM pembing 
		JOIN tm_periode ON pembing.periode=tm_periode.periode_id
		JOIN tb_dsn ON pembing.dosen=tb_dsn.id_dsn
		WHERE pembing.id_mhs=$userID
		AND tm_periode.stt_periode='on' AND
		pembing.kesediaan='Y' ORDER BY pembing.jenis ASC
		");
        $jmlPembing = mysqli_num_rows($pembing);

        $pa = mysqli_fetch_assoc(mysqli_query($con, "SELECT tb_dsn.id_dsn,tb_dsn.nip,
		tb_dsn.nama_dosen,
		tb_dsn.foto
		FROM tb_dsn 
		JOIN tb_mhs ON tb_dsn.id_dsn=tb_mhs.dosen_pa
		WHERE tb_mhs.id_mhs=$userID
		"));

        ?>

        <div class="card mb-2">
            <div class="card-header bg-gradient-primary text-white">
                <h6 class="m-0 font-weight-bold text-light"><i class="fa fa-users"></i> Daftar Pembimbing</h6>
            </div>
            <div class="mb-3 mt-3">
                <!-- dosen PA  -->
                <?php
                if ($pa == NULL) {
                    echo "<center class='alert alert-danger ml-3 mr-3'>Pembimbing Akademik Belum ditentukan </center>";
                } else {
                ?>
                <a class="dropdown-item d-flex align-items-center"
                    href="?pages=consult&chat=<?= base64_encode($pa['id_dsn']) ?>" style="cursor: pointer;">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="../apl/img/dosen/<?= $pa['foto'] ?: 'user.png' ?>"
                            style="width: 40px;height: 40px; border: 2px;border-radius: 100%">
                        <div class="status-indicator bg-success"></div>
                    </div>
                    <div class="font-weight-bold">
                        <div class="text-truncate"><?= $pa['nama_dosen'] ?></div>
                        <div class="small badge badge-secondary" style="font-size: 12px;">Pembimbing Akademik</div>
                    </div>
                </a>
                <?php
                }
                ?>

                <!-- End Dosen PA  -->
                <!-- pemb TA  -->
                <?php
                if ($jmlPembing < 1) {
                    echo "<center>Belum ada Dosen Pembimbing .. </center>";
                }
                ?>
                <?php foreach ($pembing as $dp) : ?>

                <a class="dropdown-item d-flex align-items-center"
                    href="?pages=consult&start=<?= base64_encode($dp['pembing_id']) ?>" style="cursor: pointer;">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="../apl/img/dosen/<?= $dp['foto'] ?>"
                            style="width: 40px;height: 40px; border: 2px;border-radius: 100%">
                        <div class="status-indicator bg-success"></div>
                    </div>
                    <div class="font-weight-bold">
                        <div class="text-truncate"><?= $dp['nama_dosen'] ?> </div>
                        <div class="small badge badge-primary" style="font-size: 12px;">
                            <!-- NIP.<?= $dp['nip'] ?> - -->
                            Pembimbing Tugas Akhir [ <?= $dp['jenis'] ?> ]
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
                <!-- EndPemb TA -->
            </div>
        </div>

        <!-- // Tampilkan daftar pesan terkirim -->
        <?php
        $pesanTerkirim = mysqli_query($con, "SELECT
tb_dsn.id_dsn,
tb_dsn.nama_dosen,
tb_dsn.foto,
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
JOIN tb_dsn ON tb_pesan.penerima_id=tb_dsn.id_dsn
WHERE tb_pesan.pengirim_id=$userID
AND tb_pesan.user_pengirim='mhs'
AND tb_pesan.user_penerima='dsn'
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
                        <img class="img-fluid" src="../apl/img/dosen/<?= $lt['foto'] ?>"
                            style="width: 35px;height: 35px;border-radius: 100%">
                        <!-- 	<div class="status-indicator bg-success"></div> -->
                    </div>
                    <div class="font-weight-bold">
                        <div class="text-truncate" style="max-width: 18rem;"><?= $lt['isi_pesan'] ?> </div>

                        <div class="small text-success" style="font-size: 12px;"><i class="fa fa-user"></i> Kepada
                            <b><?= $lt['nama_dosen'] ?> <br>
                                <span class="text-primary" style="font-size: 11px;"><i class="fa fa-clock"></i>
                                    <?= date('d-m-Y- H:i:s', strtotime($lt['wkt'])) ?></span>
                            </b>
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

    <div class="col-lg-8">

        <?php
        // tampilkan pesan sukses didkirim
        if (isset($_GET['ok'])) {
            echo "<script>
			toastr.success('Pesan Terkirim.', 'Sukses', {
			    positionClass: 'toast-top-right'
			})
			</script>";


            // 	echo '<div class="alert alert-success alert-dismissible" id="alert">
            // <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            // <span aria-hidden="true">×</span>
            // </button>
            // <h6><i class="fas fa-check"></i><b> Success!</b></h6>
            // Pesan dikirim ..
            // </div>';
        }
        // form chat dosen PA 
        if (isset($_GET['chat'])) {
            // echo "Chat area";
        ?>
        <div class="card mb-5">
            <div class="card-body">
                <div>
                    <span class="" style="border: 1px;padding: 4px;border-radius: 20px;"><i
                            class="fas fa-share fa-2x"></i> Kepada </span>
                    <a class="dropdown-item d-flex align-items-center bg-gradient-secondary text-white" href="#"
                        style="cursor: pointer;border-radius: 50px;">
                        <div class="dropdown-list-image mr-3">

                            <img class="rounded-circle" src="../apl/img/dosen/<?= $pa['foto'] ?>"
                                style="width: 40px;height: 40px; border: 2px solid;border-radius: 100%">

                        </div>
                        <div class="font-weight-bold">
                            <div class="text-truncate"><?= $pa['nama_dosen'] ?></div>
                            <div class="small text-white"><i class="fa fa-user"></i> Pembimbing Akademik <i
                                    class="fa fa-clock"></i> <?= date('H:i:s') ?></div>
                        </div>
                    </a>
                </div>
                <form method="POST" id="chatwithpa" enctype="multipart/form-data">

                    <input type="hidden" name="user_id" value=" <?= $userID; ?>">
                    <div class="form-group mt-3">
                        <textarea name="pesan" id="pesan_pa" class="form-control" placeholder="Tuliskan disini .."
                            required></textarea>
                    </div>

                    <div class="form-group">
                        <div class="custom-file">
                            <input name="file" type="file" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" id="send_new_message_to_pa" name="send_new_message_to_pa"
                            class="btn btn-outline-primary btn-sm"><i class="fa fa-comment"></i> Kirim Pesan</button>
                    </div>
                </form>
            </div>
        </div>

        <?php
        }
        // end chat doesn PA 
        // form bimbingan with dospem ta 
        if (isset($_GET['start'])) {
            $pembingID = intval(base64_decode($_GET['start']));
            // mendapatkan identitas dosen pembimbing
            $pemb = mysqli_fetch_assoc(mysqli_query($con, "SELECT
		tb_dsn.id_dsn,
		tb_dsn.nip,
		tb_dsn.nama_dosen,
		tb_dsn.foto,
		pembing.id_mhs,
		pembing.pengajuan_id,
		pembing.pembing_id,
		pembing.kesediaan,
		pembing.jenis
		FROM pembing
		 JOIN tm_periode ON pembing.periode=tm_periode.periode_id
		 JOIN tb_dsn ON pembing.dosen=tb_dsn.id_dsn
		WHERE pembing.id_mhs=$userID
		AND pembing.pembing_id=$pembingID
		AND pembing.kesediaan='Y'
		AND tm_periode.stt_periode='on'
		ORDER BY pembing.jenis ASC
		"));

        ?>
        <div class="card mb-5">
            <!-- 		<div class="card-header bg-gradient-primary text-white">
		<h6 class="m-0 font-weight-bold text-light"><i class="fas fa-comments fa-2x text-white"></i> Chatting</h6>
		</div> -->
            <div class="card-body">
                <div>
                    <span class="" style="border: 1px;padding: 4px;border-radius: 20px;"><i
                            class="fas fa-share fa-2x"></i> Kepada </span>
                    <a class="dropdown-item d-flex align-items-center <?php if ($pemb['jenis'] == '1') {
                                                                                echo 'bg-gradient-primary';
                                                                            } else {
                                                                                echo 'bg-gradient-info';
                                                                            } ?> text-white" href="#"
                        style="cursor: pointer;border-radius: 50px;">
                        <div class="dropdown-list-image mr-3">

                            <img class="rounded-circle" src="../apl/img/dosen/<?= $pemb['foto'] ?>"
                                style="width: 40px;height: 40px; border: 2px solid;border-radius: 100%">

                        </div>
                        <div class="font-weight-bold">
                            <div class="text-truncate"><?= $pemb['nama_dosen'] ?></div>
                            <div class="small text-gray-500"><i class="fa fa-user"></i> Pembimbing <?= $pemb['jenis'] ?>
                                - <i class="fa fa-clock"></i> <?= date('d-m-Y H:i:s') ?></div>
                        </div>
                    </a>
                </div>
                <form method="POST" id="chatWithDospem" enctype="multipart/form-data">
                    <div class="form-group mt-3">
                        <label for="">Subject/Topik Pembahasan</label>
                        <input name="subyek" type="text" class="form-control" placeholder="Subject" required="">
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="periode" value="<?= $tp['periode_id'] ?>">
                        <input type="hidden" name="judul" value="<?= $pemb['pengajuan_id'] ?>">
                        <input type="hidden" name="pengirim" value="<?= $userID ?>">
                        <input type="hidden" name="penerima" value="<?= $pemb['id_dsn'] ?>">
                        <input type="hidden" name="pembing" value="<?= $pemb['pembing_id'] ?>">
                        <input type="hidden" name="jenis_pemb" value="<?= $pemb['jenis'] ?>">
                        <textarea name="pesan" id="pesan_dospem" class="form-control" placeholder="Tuliskan disini .."
                            required></textarea>
                    </div>

                    <div class="form-group">
                        <div class="custom-file">
                            <input name="file" type="file" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" id="send_new_message" name="send_new_message"
                            class="btn btn-outline-primary btn-sm"><i class="fa fa-comment"></i> Kirim Pesan</button>
                    </div>
                </form>

            </div>
        </div>
        <?php

        } else {

            // QUERY PESAN BARU
            $newPesan = mysqli_query($con, "SELECT
			tb_dsn.id_dsn,
			tb_dsn.nama_dosen,
			tb_dsn.foto,
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
			JOIN tb_dsn ON tb_pesan.pengirim_id=tb_dsn.id_dsn
			WHERE tb_pesan.penerima_id=$userID 
			AND tb_pesan.user_pengirim='dsn'
			 AND tb_pesan.status_pesan='new'
			  AND tm_periode.stt_periode='on'
			  ORDER BY tb_pesan.id_pesan ASC ");
            // jumlah pesan baru
            $jmlPesan = mysqli_num_rows($newPesan);
            // END PESAN BARU
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
                    <a class="header1 expand dropdown-item d-flex align-items-center <?php if ($nm['jenis_pemb'] == 1) {
                                                                                                        echo 'bg-primary';
                                                                                                    } else {
                                                                                                        echo 'bg-info';
                                                                                                    } ?> text-white mb-2"
                        href="#" style="cursor: pointer;border-radius: 50px;">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="../apl/img/dosen/<?= $nm['foto'] ?>"
                                style="width: 45px;height: 45px; border: 2px solid;border-radius: 100%">
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div class="font-weight-bold">
                            <div class="text-truncate">
                                <i class="fa fa-user"> </i> <?= $nm['nama_dosen'] ?>
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
                            <input type="hidden" name="penerima" value="<?= $nm['id_dsn'] ?>">
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
                            <a href="" class="btn btn-outline-warning btn-sm"><i class="fa fa-times"></i> Balas
                                Nanti</a>
                        </div>
                    </div>


                </form>

                <?php endforeach; ?>
                <!-- SCRIPT / PROSES BALAS PESAN DARI PEMBIMBING -->
                <?php
                        if (isset($_POST['balas'])) {
                            $array  = array('jpg', 'jpeg', 'png', 'doc', 'docx', 'ppt', 'pptx', 'pdf', 'zip', 'rar', 'xls', 'xlsx',);
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
                            $filenama = $pengirim . '_' . time();
                            $file_name    = $_FILES['file']['name'];
                            @$file_ext     = strtolower(end(explode('.', $file_name)));
                            $file_size    = $_FILES['file']['size'];
                            $file_tmp     = $_FILES['file']['tmp_name'];
                            $dok = $filenama . '.' . $file_ext;

                            if ($file_name == "") {
                                // jika pesan tanpa file
                                $is_send = mysqli_query($con, "INSERT INTO tb_pesan (pengajuan_id,pengirim_id,user_pengirim,penerima_id,user_penerima,topik,subyek,isi_pesan,pembing_id,jenis_pemb,wkt,reply_to,tahun_bimbingan) VALUES ('$judul','$pengirim','mhs','$penerima','dsn','$topik','$subyek','$pesan','$pembing','$jenis_pemb','$wkt','$id','$periode')  ");
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
                                        $is_send = mysqli_query($con, "INSERT INTO tb_pesan (pengajuan_id,pengirim_id,user_pengirim,penerima_id,user_penerima,topik,subyek,isi_pesan,document,pembing_id,jenis_pemb,wkt,reply_to,tahun_bimbingan) VALUES ('$judul','$pengirim','mhs','$penerima','dsn','$topik','$subyek','$pesan','$dok','$pembing','$jenis_pemb','$wkt','$id','$periode')  ");
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
                <!-- end SCRIPT / PROSES BALAS PESAN DARI PEMBIMBING -->
            </div>
        </div>
        <?php
                // end daftar pesan baru
            }

            ?>

        <?php
        }


        ?>



    </div>
</div>
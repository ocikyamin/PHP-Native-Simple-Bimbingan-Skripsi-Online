<div class="row" id="load">
    <!-- <?= isset($_GET['chat']) ? 'd-none' : ''; ?> -->
    <div class="col-lg-4">
        <?php

        $jmlPembing = mysqli_num_rows($pembing);



        ?>

        <div class="card mb-2 animated--grow-in">
            <div class=" card-header bg-gradient-primary text-white">
                <h6 class="m-0 font-weight-bold text-light"><i class="fa fa-users"></i> Daftar Pembimbing</h6>
            </div>
            <div class="mb-3 mt-3">
                <!-- dosen PA  -->
                <?php
                if ($pa == NULL) {
                    echo "<center class='alert alert-danger ml-3 mr-3'>Pembimbing Akademik Belum ditentukan </center>";
                } else {

                    // dapatkan pesan baru dari mhs
                    $getInbox = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(id) AS jmlInbox FROM tb_forum WHERE user_id=$pa[id_dsn] AND user_type='dsn' AND  user_id_to=$userID AND user_type='dsn' AND pesan_status='new' "));

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
                        <i class="fa fa-envelope-open"></i>
                        <span class="badge badge-success badge-counter"><?= $getInbox['jmlInbox'] ?></span>
                    </div>
                </a>
                <?php
                }
                ?>

                <!-- End Dosen PA  -->
                <!-- pemb TA  -->
                <?php
                if ($jmlPembing < 1) {
                    // echo "<center>Belum ada Dosen Pembimbing .. </center>";
                    echo "<center class='alert alert-danger mt-3 ml-3 mr-3'>Pembimbing Tugas Akhir Belum ditentukan </center>";
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
AND tm_periode.stt_periode='on'
ORDER BY tb_pesan.id_pesan DESC 
 ");
        $list_pesanKePA = mysqli_query($con, "SELECT * FROM tb_forum WHERE user_id=$userID AND user_type='mhs' ");
        // jumlah pesan Terkirim ke Dospem
        $jmlPesanTerkirim = mysqli_num_rows($pesanTerkirim);
        // Jumlah Pesan Terkirim ke PA 
        $jmlPesanTerkirimPa = mysqli_num_rows($list_pesanKePA);
        ?>
        <div class="mb-2">
            <!-- inbox  -->
            <?php
            if (isset($_GET['start']) || isset($_GET['chat'])) {
            ?>

            <div style="cursor: pointer;" onclick="showNewMassage()" class="dropdown-list shadow animated--grow-in show"
                aria-labelledby="messagesDropdown">
                <h6 class="bg-gradient-success dropdown-header text-white">
                    <i class="fas fa-inbox"></i> Pesan Masuk
                    <b>(<?= $jmlPesan ?>)</b>
                </h6>
            </div>
            <?php
            }

            ?>

            <!-- end inbox  -->
            <div style="cursor: pointer;" id="showSendMassage" onclick="showSendMassage()"
                class="dropdown-list shadow animated--grow-in show" aria-labelledby="messagesDropdown">
                <h6 class="bg-gradient-warning dropdown-header text-white">
                    <i class="fa fa-envelope"></i> Pesan Terkirim
                    <b>(<?= $jmlPesanTerkirim + $jmlPesanTerkirimPa ?>)</b>
                </h6>
            </div>



            <div id="areaPesanTerkirim" class="d-none mb-3 mt-3">
                <?php
                $ttPesanTerkirim = $jmlPesanTerkirim + $jmlPesanTerkirimPa;
                if ($ttPesanTerkirim < 1) {
                    echo '<center>Pesan terkirim kosong ..</center>';
                } else {
                    // tampilkan daftar pesan
                ?>
                <?php
                    foreach ($pesanTerkirim as $lt) : ?>
                <div class="alert alert-default shadow-sm my-1" style="cursor: pointer;">
                    <div class="small text-black-50">
                        <?= htmlspecialchars_decode($lt['subyek']) ?>
                    </div>
                    <div class="small text-gray-500 my-0"><i class="fas fa-share"></i>
                        <?= $lt['nama_dosen'] ?> .
                        <?= date('H:i', strtotime($lt['wkt'])) ?>
                    </div>

                    <!-- <a onclick="return confirm('Yakin menghapus file ?')" href="" class="text-danger small"><i
                            class="fa fa-trash"></i> Hapus
                    </a> -->

                </div>

                <?php endforeach; ?>
                <?php
                }


                ?>


                <!-- pesan terkirim ke PA  -->

                <?php

                foreach ($list_pesanKePA as $ltpa) {
                ?>
                <div class="alert alert-light my-1" style="cursor: pointer;">
                    <div class="small">
                        <?= htmlspecialchars_decode($ltpa['pesan']) ?>
                    </div>
                    <div class="small text-gray-500"><i class="fas fa-share"></i>
                        <?= $pa['nama_dosen'] ?> .
                        <?= date('H:i', strtotime($ltpa['wkt'])) ?>
                    </div>
                    <!-- <a onclick="return confirm('Yakin menghapus file ?')" href="" class="text-danger small"><i
                            class="fa fa-trash"></i> Hapus
                    </a> -->

                </div>

                <?php
                }
                ?>


            </div>

            <!-- // end daftar pesan terkirim -->
            <div class="dropdown-list shadow animated--grow-in show mt-2" aria-labelledby="messagesDropdown">
                <h6 class="bg-gradient-danger dropdown-header text-white">
                    <i class="fa fa-history"></i> Riwayat Percakapan
                </h6>
                <?php
                // tampilkan pesan berdasarkan topik pembahasan
                $judulKu = mysqli_fetch_assoc($cekJudul);
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



                <!-- <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a> -->
            </div>

        </div>



    </div>

    <div class="col-lg-8">
        <!-- daftar pesan baru  -->
        <?php
        if (isset($_GET['chat']) || isset($_GET['start'])) {
            // echo "pesan baru";
        ?>
        <?php
            // form chat dosen PA 
            if (isset($_GET['chat'])) {
                $paId = intval(base64_decode($_GET['chat']));
                // echo "Chat area";
                $getKode = mysqli_query($con, "SELECT kode FROM tb_forum WHERE user_id=$userID AND user_type='mhs' OR user_id_to=$userID AND user_type='dsn'");
                if (mysqli_num_rows($getKode) < 1) {
                    $kodePesan = 'MHS-' . time();
                } else {
                    $oldKode = mysqli_fetch_assoc($getKode);
                    $kodePesan = $oldKode['kode'];
                }
            ?>
        <div class="card mb-5">
            <div class="card-header bg-gradient-success text-white">
                <h6 class="m-0 font-weight-bold text-light"><i class="fa fa-comments fa-2x"></i> Percakapan</h6>
            </div>
            <div class="card-body">
                <!-- manampilkan percakapan dengan dosen PA  -->
                <?php
                        // Tampilkan percakapan berdasarkan kode
                        $chatWithPa = mysqli_query($con, "SELECT * FROM tb_forum WHERE kode='$kodePesan' ORDER BY id ASC ");
                        foreach ($chatWithPa as $cwpa) {

                            // looping pesan pa 
                        ?>
                <div <?= $cwpa['user_type'] == 'mhs' ? '' : 'style="float:right;border-radius:30px;"'; ?>>

                    <img class="img-profile rounded-circle shadow"
                        src="../apl/<?= $cwpa['user_type'] == 'mhs' ? 'img/' . $user['fotomhs'] . '' : '/img/dosen/' . $pa['foto']; ?>"
                        style="width: 40px;height: 40px;border:none">
                    <span class="alert <?= $cwpa['user_type'] == 'mhs' ? 'alert-success' : 'alert-danger'; ?> shadow-sm"
                        style="border: 1px dotted;padding: 4px;border-radius: 50px;"><i class="fas fa-share"></i>
                        <?= $cwpa['user_type'] == 'mhs' ? 'Anda' : $pa['nama_dosen']; ?>
                    </span>
                    <span class="alert alert-light" style="padding: 4px;border-radius: 50px;">
                        <?= date('H:i', strtotime($cwpa['wkt'])) ?>
                    </span>

                    <!-- btn aksi  -->
                    <?php
                                if ($cwpa['user_id'] == $userID && $cwpa['user_type'] == 'mhs') {
                                ?>
                    <span>
                        <button onclick="delMyMessegePa(<?= $cwpa['id'] ?>)" class="btn btn-default btn-sm "><i
                                class="fa fa-trash text-danger"></i>
                        </button>
                    </span>
                    <?php
                                }
                                ?>
                </div>

                <div class="alert <?= $cwpa['user_type'] == 'mhs' ? 'alert-light' : 'shadow-sm'; ?> mb-2"
                    style="border-radius: 20px;">

                    <?php
                                if ($cwpa['user_id'] == $userID && $cwpa['user_type'] == 'mhs') {
                                } else {
                                    if ($cwpa['pesan_status'] == 'new') {
                                        echo "<button onclick='tandai($cwpa[id])' class='btn btn-default btn-sm'><i class='fa fa-envelope-open text-warning'></i> Pesan Baru</button>";
                                    }
                                }
                                ?>
                    <div class="table-responsive">
                        <div class="pesan-view text-black-50 my-3 ">
                            <?= htmlspecialchars_decode($cwpa['pesan']) ?>
                        </div>
                        <!-- tombol area -->
                        <?php
                                    if ($cwpa['document'] !== 'nofile') {
                                    ?>
                        <b class="text-black-50"><i class="fas fa-paperclip"></i> Lampiran</b>
                        <br>
                        <a href="../files/<?= $cwpa['document'] ?>" target="_blank"
                            class="btn btn-secondary btn-sm shadow"
                            style="cursor: pointer;text-decoration: none;border-radius:20px"><i
                                class="fas fa-cloud-download-alt"></i>
                            Download</a>
                        <?php
                                    }
                                    ?>
                        <!-- end tombol -->
                    </div>


                </div>

                <?php
                            // end looping pesan pa 
                        }
                        ?>

                <div>
                    <span style="border: 1px;padding: 4px;border-radius: 20px;"><i class="fas fa-share fa-2x"></i>
                        Kepada </span>
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
                    <?php
                            if (mysqli_num_rows($chatWithPa)) {
                                // ambil pesan terakhir untuk dibalas
                                $lastMsg = mysqli_fetch_assoc(mysqli_query($con, "SELECT id FROM tb_forum WHERE kode='$kodePesan' AND user_type='dsn' ORDER BY id DESC "));
                                if ($lastMsg) {
                                    $lastId = $lastMsg['id'];
                                }
                            }
                            ?>
                    <input type="hidden" name="pesan_id" value="<?= $lastId; ?>">
                    <input type="hidden" name="kode" value="<?= $kodePesan; ?>">
                    <input type="hidden" name="user_id" value="<?= $userID; ?>">
                    <input type="hidden" name="user_id_to" value="<?= $paId; ?>">
                    <div class="form-group mt-3">
                        <textarea name="pesan" id="pesan_pa" class="isi_pesan_untuk_pa form-control summernote"
                            placeholder="Tuliskan disini .." required></textarea>
                    </div>

                    <div class="form-group">

                        <div class="btn btn-light btn-sm btn-file">
                            <i class="fas fa-paperclip"></i> Attachment
                            <input type="file" name="file" id="customFile">
                        </div>
                        <label>
                            <b>Max.2MB</b>
                            <code>(jpg,jpeg,png,doc,docx,ppt,pptx,pdf,zip,rar, xls, xlsx)</code></label>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="send_new_message_to_pa" name="send_new_message_to_pa"
                            class="btn btn-success bg-gradient-success btn-sm"><i class="fa fa-comment"></i> Kirim
                            Pesan</button>
                        <a href="?pages=consult" class="btn btn-outline-warning btn-sm"><i class="fa fa-times"></i>
                            Kembali</a>

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
            <div class="card-body">
                <div>
                    <span class="" style="border: 1px;padding: 4px;border-radius: 20px;"><i
                            class="fas fa-share fa-2x"></i>
                        Kepada </span>
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
                            <div class="small text-gray-500"><i class="fa fa-user"></i> Pembimbing
                                <?= $pemb['jenis'] ?>
                                - <i class="fa fa-clock"></i> <?= date('H:i:s') ?></div>
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
                        <textarea name="pesan" id="pesan_dospem" class="form-control summernote"
                            placeholder="Tuliskan disini .." required></textarea>
                    </div>
                    <div class="form-group">
                        <div class="btn btn-light btn-sm btn-file">
                            <i class="fas fa-paperclip"></i> Attachment
                            <input type="file" name="file" id="customFile">
                        </div>
                        <label>
                            <b>Max.2MB</b>
                            <code>(jpg,jpeg,png,doc,docx,ppt,pptx,pdf,zip,rar, xls, xlsx)</code></label>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="send_new_message" name="send_new_message"
                            class="btn btn-success bg-gradient-success btn-sm"><i class="fa fa-comment"></i> Kirim
                            Pesan</button>
                        <a href="?pages=consult" class="btn btn-outline-warning btn-sm"><i class="fa fa-times"></i>
                            Kembali</a>
                    </div>
                </form>

            </div>
        </div>
        <?php

            }


            ?>
        <?php
        } else {
            // echo "pesan baru";
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
                <form method="POST" id="formBalasPesanDospem" enctype="multipart/form-data">
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
                                <?= date('H:i', strtotime($nm['wkt'])) ?> <br>
                                <span style="font-size: 9px;"><i class="fa fa-share"></i> <?= $nm['topik'] ?></span>
                            </div>
                        </div>
                    </a>
                    <div class="header1">

                        <span class="mt-3">
                            <div class="alert alert-light mt-2 mb-2">
                                <span> <b>Topik : </b> <?= $nm['subyek'] ?> </span>
                                <p class="mt-2"><?= htmlspecialchars_decode($nm['isi_pesan']) ?></p>
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
                            <textarea name="pesan" id="bls_pesan_dospem" class="form-control summernote"
                                placeholder="Tuliskan disini .."></textarea>
                        </div>

                        <div class="form-group">
                            <div class="btn btn-default btn-sm btn-file">
                                <i class="fas fa-paperclip"></i> Attachment
                                <input type="file" name="file" id="customFile">
                            </div>


                        </div>
                        <div class="form-group">
                            <button type="submit" name="balas" id="btn_balas_pesan_dospem"
                                class="btn btn-success bg-gradient-success btn-sm"><i class="fa fa-reply"></i>
                                Balas</button>
                        </div>


                        <!-- <div class="form-group mt-3">
                           
                        </div> -->
                    </div>


                </form>

                <?php endforeach; ?>
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

<!-- pean baru untuk dosen PA  -->
<script>
function showSendMassage() {
    $('#areaPesanTerkirim').removeClass('d-none');

}

function showNewMassage() {
    window.location = '?pages=consult';
}



function delMyMessegePa(idPesan) {
    // alert('terhapus');
    $.ajax({
        type: "post",
        url: "Models/del_pesan_pa.php",
        data: {
            idPesan: idPesan
        },
        dataType: "json",
        success: function(response) {
            //  cek jika sukses 
            if (response.sukses) {
                toastr.success(response.sukses, 'Sukses', {
                    positionClass: 'toast-top-right'
                })
            } else {
                toastr.warning(response.sukses, 'Warning', {
                    positionClass: 'toast-top-right'
                })
            }


            window.setTimeout(function() {
                window.location.reload()
            }, 1000);

        }
    });
}

$(function() {
    // consult_area()
    $('#send_new_message_to_pa').click(function(e) {
        e.preventDefault();
        let formData = new FormData($("#chatwithpa")[0]);
        $.ajax({
            type: "post",
            url: "Models/chat_with_pa.php",
            data: formData,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function() {
                $('#send_new_message_to_pa').prop('disabled', true);
                $('#send_new_message_to_pa').html(
                    `<div class="fa fa-spin fa-spinner"></div> Please Wait...`
                );
            },
            complete: function() {
                $('#send_new_message_to_pa').prop('disabled', false);
                $('#send_new_message_to_pa').html(
                    `<i class="fa fa-comment"></i> Kirim Pesan`);
            },
            success: function(response) {
                if (response.error) {
                    toastr.warning(response.error, 'Warning', {
                        positionClass: 'toast-top-right'
                    })
                } else {
                    toastr.success(response.sukses, 'Sukses', {
                        positionClass: 'toast-top-right'
                    })

                    window.setTimeout(function() {
                        window.location.reload()
                    }, 1500);

                }


            }
        });
        // return false;
    })

})
</script>
<!-- pesan baru untuk dospen  -->
<script>
$(function() {
    $('#send_new_message').click(function(e) {
        e.preventDefault();
        let formDataDospem = new FormData($("#chatWithDospem")[0]);
        $.ajax({
            type: "post",
            url: "Models/chat_with_dospem.php",
            data: formDataDospem,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function() {
                $('#send_new_message').prop('disabled', true);
                $('#send_new_message').html(
                    `<div class="fa fa-spin fa-spinner"></div> Please Wait...`
                );
            },
            complete: function() {
                $('#send_new_message').prop('disabled', false);
                $('#send_new_message').html(
                    `<i class="fa fa-comment"></i> Kirim Pesan`);
            },
            success: function(response) {
                if (response.error) {
                    toastr.warning(response.error, 'Warning', {
                        positionClass: 'toast-top-right'
                    })
                } else {
                    toastr.success(response.sukses, 'Sukses', {
                        positionClass: 'toast-top-right'
                    })
                    window.setTimeout(function() {
                        window.location.reload()
                    }, 1500);

                    //




                }


            }
        });
        // return false;
    })

})
</script>

<!-- balas pesan dospem  -->
<script>
$(function() {
    $('#btn_balas_pesan_dospem').click(function(e) {
        e.preventDefault();
        let formDataDospem = new FormData($("#formBalasPesanDospem")[0]);
        $.ajax({
            type: "post",
            url: "Models/reply_chat_dospem.php",
            data: formDataDospem,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function() {
                $('#send_new_message').prop('disabled', true);
                $('#send_new_message').html(
                    `<div class="fa fa-spin fa-spinner"></div> Please Wait...`
                );
            },
            complete: function() {
                $('#send_new_message').prop('disabled', false);
                $('#send_new_message').html(
                    `<i class="fa fa-reply"></i>
                                Balas`);
            },
            success: function(response) {
                if (response.error) {
                    toastr.warning(response.error, 'Warning', {
                        positionClass: 'toast-top-right'
                    })
                } else {
                    toastr.success(response.sukses, 'Sukses', {
                        positionClass: 'toast-top-right'
                    })
                    window.setTimeout(function() {
                        window.location.reload()
                    }, 1500);

                    //




                }


            }
        });
        // return false;
    })

})

function tandai(id) {
    // tandai pesan terbaca 
    $.ajax({
        type: "post",
        url: "Models/tandai_pesan.php",
        data: {
            idPesan: id
        },
        dataType: "json",
        success: function(response) {
            //  cek jika sukses 
            if (response.sukses) {
                toastr.success(response.sukses, 'Sukses', {
                    positionClass: 'toast-top-right'
                })
            } else {
                toastr.warning(response.sukses, 'Warning', {
                    positionClass: 'toast-top-right'
                })
            }


            window.setTimeout(function() {
                window.location.reload()
            }, 1000);

        }
    });
}
</script>
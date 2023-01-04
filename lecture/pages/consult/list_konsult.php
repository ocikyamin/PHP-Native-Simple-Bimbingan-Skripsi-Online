<div class="row">
    <div class="col-lg-4">
        <?php
        // tampilkan mahasiswa bimbingan Skripsi Periode aktif
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

        // mahasiswa bimbingan Akademik 
        $mhsAkademik = mysqli_query($con, "SELECT tb_mhs.id_mhs,tb_mhs.nim,tb_mhs.nama,tb_mhs.fotomhs,tm_prodi.prodi FROM tb_mhs
    JOIN tm_prodi ON tb_mhs.prodi_id=tm_prodi.prodi_id
    WHERE tb_mhs.dosen_pa=$userID ORDER BY tb_mhs.id_mhs ASC ");
        ?>

        <div class="card mb-2">
            <div class="card-header bg-gradient-primary text-white">
                <h6 class="m-0 font-weight-bold text-light"><i class="fa fa-users"></i> Mahasiswa Bimbingan Akademik
                </h6>
            </div>
            <div class="mb-3 mt-3">
                <?php
                foreach ($mhsAkademik as $lmpa) : ?>
                <?php
                    // dapatkan pesan baru dari mhs
                    $getInbox = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(id) AS jmlInbox FROM tb_forum WHERE user_id=$lmpa[id_mhs] AND user_type='mhs' AND  user_id_to=$userID AND user_type='mhs' AND pesan_status='new' "));

                    ?>

                <a class="dropdown-item d-flex align-items-center"
                    href="?pages=consult&chat=<?= base64_encode($lmpa['id_mhs']) ?>" style="cursor: pointer;">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="../apl/img/<?= $lmpa['fotomhs'] ?>"
                            style="width: 40px;height: 40px; border: 2px;border-radius: 100%">
                        <div class="status-indicator bg-success"></div>
                    </div>
                    <div class="font-weight-bold">
                        <div class="text-truncate"><?= $lmpa['nama'] ?> </div>
                        <div class="small" style="font-size: 12px;">NIM.<?= $lmpa['nim'] ?> - PRODI -
                            <?= $lmpa['prodi'] ?>
                        </div>
                        <i class="fa fa-envelope-open"></i>
                        <span class="badge badge-warning badge-counter"><?= $getInbox['jmlInbox'] ?></span>

                    </div>
                </a>
                <?php endforeach; ?>
            </div>
            <div class="card-header bg-gradient-primary text-white">
                <h6 class="m-0 font-weight-bold text-light"><i class="fa fa-users"></i> Mahasiswa Bimbingan Skripsi</h6>
            </div>
            <div class="mb-3 mt-3">
                <?php foreach ($mhsBimbingan as $lb) : ?>

                <a class="dropdown-item d-flex align-items-center"
                    href="?pages=consult&start=<?= base64_encode($lb['pembing_id']) ?>" style="cursor: pointer;">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="../apl/img/<?= $lb['fotomhs'] ?>"
                            style="width: 40px;height: 40px; border: 2px;border-radius: 100%">
                        <div class="status-indicator bg-success"></div>
                    </div>
                    <div class="font-weight-bold">
                        <div class="text-truncate"><?= $lb['nama'] ?> </div>
                        <div class="small" style="font-size: 12px;">NIM.<?= $lb['nim'] ?> - PRODI - <?= $lb['prodi'] ?>
                        </div>
                        <!-- <i class="fa fa-envelope-open"></i>
                        <span class="badge badge-warning badge-counter"><?= $getInbox['jmlInbox'] ?></span>
                        <i class="fa fa-envelope"></i>
                        <span class="badge badge-success badge-counter"><?= $getInbox['jmlInbox'] ?></span> -->
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>


    </div>
    <!-- end col-lg 4 -->

    <div class="col-lg-8">
        <?php
        // jika form chat dipilh, maka buka form chat
        if (isset($_GET['chat']) || isset($_GET['start']) || isset($_GET['topic'])) {
            // tampilkan form untuk bimbingan akademik 
            if (isset($_GET['chat'])) {

                $mhsId = intval(base64_decode($_GET['chat']));

                // informasi MHS
                $mhs = mysqli_fetch_assoc(mysqli_query($con, "SELECT
                                tb_mhs.nim,
                                tb_mhs.nama,
                                tb_mhs.tahun_angkatan,
                                tb_mhs.fotomhs,
                                tm_prodi.prodi
                                FROM tb_mhs
                                JOIN tm_prodi ON tb_mhs.prodi_id=tm_prodi.prodi_id
                                WHERE tb_mhs.id_mhs=$mhsId
                                "));

                // dapatkan info kode pesan
                $getKode = mysqli_query($con, "SELECT kode FROM tb_forum WHERE user_id=$mhsId AND user_type='mhs' OR user_id_to=$mhsId AND user_type='dsn'");
                if (mysqli_num_rows($getKode) < 1) {
                    $kodePesan = 'DSN-' . time();
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
                <!-- manampilkan percakapan dengan dosen Mhs  -->
                <?php
                        // Tampilkan percakapan berdasarkan kode
                        $chatWithPa = mysqli_query($con, "SELECT * FROM tb_forum WHERE kode='$kodePesan' ORDER BY id ASC ");
                        foreach ($chatWithPa as $cwpa) {


                            // looping pesan 
                        ?>
                <div <?= $cwpa['user_type'] == 'dsn' ? '' : 'style="float:right;border-radius:30px;"'; ?>>


                    <img class="img-profile rounded-circle shadow"
                        src="../apl/<?= $cwpa['user_type'] == 'dsn' ? 'img/dosen/' . $user['foto'] . '' : '/img/' . $mhs['fotomhs']; ?>"
                        style="width: 40px;height: 40px;border:none">
                    <span
                        class="alert <?= $cwpa['user_type'] == 'dsn' ? 'alert-success' : 'alert-secondary'; ?> shadow-sm"
                        style="border: 1px dotted;padding: 4px;border-radius: 50px;"><i class="fas fa-share"></i>
                        <?= $cwpa['user_type'] == 'dsn' ? 'Anda' : $mhs['nama']; ?>
                    </span>
                    <span class="alert alert-light" style="padding: 4px;border-radius: 50px;">
                        <?= date('H:i', strtotime($cwpa['wkt'])) ?>
                    </span>
                    <!-- btn aksi  -->
                    <?php
                                if ($cwpa['user_id'] == $userID && $cwpa['user_type'] == 'dsn') {
                                ?>
                    <span>
                        <button class="btn btn-default btn-sm" onclick="delMyMessegePa(<?= $cwpa['id'] ?>)"><i
                                class="fa fa-trash text-danger"></i>
                        </button>
                    </span>
                    <?php
                                }
                                ?>

                </div>

                <div class="alert <?= $cwpa['user_type'] == 'dsn' ? 'alert-light' : 'shadow-sm '; ?> mb-2"
                    style="border-radius: 20px;">

                    <?php
                                if ($cwpa['user_id'] == $userID && $cwpa['user_type'] == 'dsn') {
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

                            <img class="rounded-circle" src="../apl/img/<?= $mhs['fotomhs'] ?>"
                                style="width: 40px;height: 40px; border: 2px solid;border-radius: 100%">

                        </div>
                        <div class="font-weight-bold">

                            <div class="text-truncate"><?= $mhs['nama'] ?></div>
                            <div class="small text-white"><i class="fa fa-user"></i> Mahasiswa <i
                                    class="fa fa-clock"></i> <?= date('H:i:s') ?></div>
                        </div>
                    </a>
                </div>
                <form method="POST" id="chatwithpa" enctype="multipart/form-data">
                    <?php
                            if (mysqli_num_rows($chatWithPa)) {
                                // ambil pesan terakhir untuk dibalas
                                $lastMsg = mysqli_fetch_assoc(mysqli_query($con, "SELECT id FROM tb_forum WHERE kode='$kodePesan' AND user_type='mhs' ORDER BY id DESC "));
                                if ($lastMsg) {
                                    $lastId = $lastMsg['id'];
                                }
                            }
                            ?>
                    <input type="hidden" name="pesan_id" value="<?= $lastId; ?>">
                    <input type="hidden" name="kode" value="<?= $kodePesan; ?>">
                    <input type="hidden" name="user_id" value="<?= $userID; ?>">
                    <input type="hidden" name="user_id_to" value="<?= $mhsId; ?>">
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
                        <button type="submit" id="send_to_mhs" name="send_to_mhs"
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
            // tampilkan form untuk bimbingan skripsi 
            if (isset($_GET['start'])) {
                $bimbinganID = intval(base64_decode($_GET['start']));
                // mendapatkan identitas mahasiswa bimbingan
                $mhs = mysqli_fetch_assoc(mysqli_query($con, "SELECT
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
                <div class="mt-3">
                    <div class="py-2">
                        <span class="badge badge-success shadow py-2"><i class="fas fa-paperclip"></i> LAMPIRAN :</span>
                        <!-- <span><i class="fas fa-stream"></i> Topik Bimbingan : </span> -->
                    </div>
                </div>


                <div class="row">

                    <ul class="mailbox-attachments d-flex align-items-stretch clearfix mt-2">



                        <!-- Tampilkan file skripsi mahasiswa -->
                        <?php
                                $file = mysqli_query($con, "SELECT * FROM tb_fileskripsi WHERE id_mhs=$mhs[id_mhs] ORDER BY id_file ASC ");
                                if (mysqli_num_rows($file) < 1) {
                                    echo "<center><b>Tidak dokumen</b></center>";
                                } else {
                                ?>
                        <?php


                                    foreach ($file as $df) : ?>


                        <li>
                            <span class="mailbox-attachment-icon"> <?php
                                                                                    if ($df['tipe_file'] == 'doc') {
                                                                                        echo "<i class='fas fa-file-word'></i> ";
                                                                                    } elseif ($df['tipe_file'] == 'docx') {
                                                                                        echo "<i class='fas fa-file-word'></i> ";
                                                                                    } elseif ($df['tipe_file'] == 'xls') {
                                                                                        echo "<i class='fas fa-file-excel text-success'></i> ";
                                                                                    } elseif ($df['tipe_file'] == 'xlsx') {
                                                                                        echo "<i class='fas fa-file-excel text-success'></i> ";
                                                                                    } elseif ($df['tipe_file'] == 'ppt') {
                                                                                        echo "<i class='fas fa-file-powerpoint'></i> ";
                                                                                    } elseif ($df['tipe_file'] == 'pptx') {
                                                                                        echo "<i class='fas fa-file-powerpoint'></i> ";
                                                                                    } elseif ($df['tipe_file'] == 'pdf') {
                                                                                        echo "<i class='fas fa-file-pdf text-danger'></i> ";
                                                                                    } elseif ($df['tipe_file'] == 'rar') {
                                                                                        echo "<i class='fas fa-file-archive'></i>";
                                                                                    } elseif ($df['tipe_file'] == 'zip') {
                                                                                        echo "<i class='fas fa-file-zip'></i> ";
                                                                                    }
                                                                                    ?></span>

                            <div class="mailbox-attachment-info">

                                <a href="#" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i>
                                    <?= $df['nama_file'] ?></a>
                                <span class="mailbox-attachment-size clearfix mt-1">
                                    <span><?= $df['ukuran_file'] ?> KB</span>

                                    <a href="<?= $df['file'] == 'nofile' ? $df['doc'] : '../apl/file_skripsi/' . $df['file'] . ''  ?>"
                                        target="_blank" class="btn btn-default btn-sm float-right"><i
                                            class="fas fa-cloud-download-alt"></i> View</a>

                                </span>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php
                                }


                        ?>

                    <!-- end file skripsi -->
                </div>
                <div class="mt-3">

                    <div class="py-3" style="border-bottom: 1px dashed;">
                        <span><i class="fas fa-stream"></i> Topik Bimbingan : </span>
                        <ul style="list-style: none;">
                            <?php
                                    // dapatkan topik sebelumnya 
                                    $getTopic = mysqli_query($con, "SELECT topik,subyek FROM tb_pesan WHERE pengajuan_id=$mhs[pengajuan_id] AND pembing_id=$bimbinganID GROUP BY topik ORDER BY id_pesan ASC  ");
                                    foreach ($getTopic as $gt) {
                                    ?>
                            <li><a href="?pages=consult&topic=<?= base64_encode($gt['topik']); ?>"
                                    class="badge badge-primary bg-gradient-primary py-2 mb-1 shadow-sm block"
                                    style="border-radius: 30px;">#
                                    <?= strtoupper($gt['subyek']); ?> <small><?= $gt['topik']; ?> </small></a></li>
                            <?php
                                    }

                                    ?>
                        </ul>


                    </div>
                </div>
                <form id="form_new_message" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="periode" value="<?= $tp['periode_id'] ?>">
                    <input type="hidden" name="judul" value="<?= $mhs['pengajuan_id'] ?>">
                    <input type="hidden" name="pengirim" value="<?= $userID ?>">
                    <input type="hidden" name="penerima" value="<?= $mhs['id_mhs'] ?>">
                    <input type="hidden" name="pembing" value="<?= $mhs['pembing_id'] ?>">
                    <input type="hidden" name="jenis_pemb" value="<?= $mhs['jenis'] ?>">
                    <div class="form-group mt-3">
                        <label for="">Subject/Topik Pembahasan Baru</label>
                        <input name="subyek" type="text" class="form-control" placeholder="Subject" required="">
                    </div>
                    <div class="form-group">

                        <textarea name="pesan" class="form-control summernote" placeholder="Tuliskan disini .."
                            required></textarea>
                    </div>

                    <div class="form-group">
                        <div class="custom-file">
                            <input name="file" type="file" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" name="send_new_message" id="send_new_message"
                            class="btn btn-outline-primary btn-sm"><i class="fa fa-comment"></i> Kirim Pesan</button>
                    </div>
                </form>

            </div>
        </div>
        <?php


            }


            // <!-- area history bimbingan skripsi  -->

            if (isset($_GET['topic'])) {
                $topikCode = base64_decode(mysqli_escape_string($con, $_GET['topic']));
                $getTopik = mysqli_query($con, "SELECT * FROM tb_pesan WHERE topik='$topikCode' ORDER BY topik  ");
                $topikName = mysqli_fetch_assoc($getTopik);
                $dosen = mysqli_fetch_assoc($pembing);
                $mhs = mysqli_fetch_assoc(mysqli_query($con, "SELECT
			tb_mhs.id_mhs,
			tb_mhs.nim,
			tb_mhs.nama,
			tb_mhs.tahun_angkatan,
			tb_mhs.fotomhs,
			tm_prodi.prodi,
			pengajuan.judul,
			pembing.jenis FROM pembing 
			JOIN tm_periode ON pembing.periode=tm_periode.periode_id
			JOIN tb_mhs ON pembing.id_mhs=tb_mhs.id_mhs
			JOIN tm_prodi ON tb_mhs.prodi_id=tm_prodi.prodi_id
			JOIN pengajuan ON pembing.pengajuan_id=pengajuan.pengajuan_id
			WHERE pembing.dosen=$userID
			AND pembing.pembing_id=$topikName[pembing_id]
			AND pembing.kesediaan='Y'
			AND pengajuan.disetujui_kajur='Y'
			ORDER BY pembing.pembing_id ASC
			"));

            ?>
        <!-- area chat -->
        <div class="row">
            <div class="col-lg-12">


                <div class="card mb-4">
                    <div class="card-header bg-gradient-success text-white">

                        <h6 class="m-0 font-weight-bold text-light"><i class="fa fa-comments fa-2x"></i> Percakapan</h6>
                    </div>
                    <div class="card-body">
                        <div class="my-3"><i class="fas fa-stream"></i> Topik : <b> <?= $topikName['subyek']; ?> </b>
                        </div>
                        <?php
                                foreach ($getTopik as $lt) {

                                ?>
                        <div <?= $lt['user_pengirim'] == 'mhs' ? 'style="float: right;"' : '' ?>>
                            <img class="img-profile rounded-circle shadow"
                                src="../apl/<?= $lt['user_pengirim'] == 'dsn' ? 'img/dosen/' . $user['foto'] . '' : '/img/' . $mhs['fotomhs']; ?>"
                                style="width: 40px;height: 40px;border:none">
                            <span
                                class="alert <?= $lt['user_pengirim'] == 'dsn' ? 'alert-success' : 'alert-danger'; ?> shadow-sm"
                                style="border: 1px dotted;padding: 4px;border-radius: 50px;"><i
                                    class="fas fa-share"></i>
                                <?= $lt['user_pengirim'] == 'dsn' ? 'Anda' : $mhs['nama']; ?>
                            </span>
                            <span class="alert alert-light" style="padding: 4px;border-radius: 50px;">
                                <?= date('H:i', strtotime($lt['wkt'])) ?>
                            </span>
                            <!-- btn aksi  -->
                            <?php
                                        if ($lt['pengirim_id'] == $userID && $lt['user_pengirim'] == 'dsn') {
                                        ?>
                            <span>
                                <button onclick="delMyMessege(<?= $lt['id_pesan'] ?>)" class="btn btn-default btn-sm"><i
                                        class="fa fa-trash text-danger"></i>
                                </button>
                            </span>
                            <?php
                                        }
                                        ?>
                        </div>

                        <div class="alert <?= $lt['user_pengirim'] == 'dsn' ? 'alert-light' : 'shadow-sm'; ?> mb-2"
                            style="border-radius: 20px;">
                            <?php
                                        if ($lt['penerima_id'] == $userID && $lt['user_penerima'] == 'dsn') {
                                        } else {
                                            if ($lt['status_pesan'] == 'new') {
                                                echo "<button onclick='tandai($lt[id])' class='btn btn-default btn-sm'><i class='fa fa-envelope-open text-warning'></i> Pesan Baru</button>";
                                            }
                                        }
                                        ?>



                            <div class="table-responsive">
                                <div class="pesan-view text-black-50 my-3 ">
                                    <?= htmlspecialchars_decode($lt['isi_pesan']) ?>
                                </div>
                                <!-- tombol area -->
                                <?php
                                            if ($lt['document'] !== 'nofile') {
                                            ?>
                                <b class="text-black-50"><i class="fas fa-paperclip"></i> Lampiran</b>
                                <br>
                                <a href="../files/<?= $lt['document'] ?>" target="_blank"
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

                                }
                                ?>




                        <!-- form balas pesan  -->
                        <form id="form_reply_to_mhs_bimbingan" method="POST" id="formReplyToDospem"
                            enctype="multipart/form-data">

                            <div class="form-group mt-3">
                                <input type="hidden" id="periode" name="periode" value="<?= $lt['tahun_bimbingan'] ?>">
                                <input type="hidden" id="id" name="id" value="<?= $lt['id_pesan'] ?>">
                                <input type="hidden" id="judul" name="judul" value="<?= $lt['pengajuan_id'] ?>">
                                <input type="hidden" id="topik" name="topik" value="<?= $lt['topik'] ?>">
                                <input type="hidden" id="subyek" name="subyek" value="<?= $lt['subyek'] ?>">
                                <input type="hidden" id="pengirim" name="pengirim" value="<?= $userID ?>">
                                <input type="hidden" id="penerima" name="penerima" value="<?= $lt['penerima_id'] ?>">
                                <input type="hidden" id="pembing" name="pembing" value="<?= $lt['pembing_id'] ?>">
                                <input type="hidden" id="jenis_pemb" name="jenis_pemb" value="<?= $lt['jenis_pemb'] ?>">
                                <textarea name="pesan" id="pesan_balas_dospem" class="form-control summernote"
                                    placeholder="Tuliskan disini .." required></textarea>
                            </div>
                            <div class="form-group">
                                <div class="btn btn-light btn-sm btn-file">
                                    <i class="fas fa-paperclip"></i> Attachment
                                    <input type="file" name="file" id="customFile">

                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" id="btn_reply_to_mhs" name="btn_reply_to_mhs"
                                    class="btn btn-success bg-gradient-success btn-sm"><i class="fa fa-reply"></i>
                                    Kirim Pesan </button>
                                <a href="?pages=consult" class="btn btn-outline-warning btn-sm"><i
                                        class="fa fa-times"></i>
                                    Kembali</a>
                            </div>


                        </form>
                        <!-- end form balas pesan  -->
                    </div>
                </div>




            </div>
        </div>
        <!-- end area chat  -->
        <?php
            }


            // <!-- end area history bimbingan skripsi  -->
        } else {
            // echo "Informasi Pesan Masuk";
        }

        ?>




    </div>
</div>

<script>
$(function() {
    // consult_area()
    $('#send_to_mhs').click(function(e) {
        e.preventDefault();
        let formData = new FormData($("#chatwithpa")[0]);
        $.ajax({
            type: "post",
            url: "Models/send_mhs_pa.php",
            data: formData,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function() {
                $('#send_to_mhs').prop('disabled', true);
                $('#send_to_mhs').html(
                    `<div class="fa fa-spin fa-spinner"></div> Please Wait...`
                );
            },
            complete: function() {
                $('#send_to_mhs').prop('disabled', false);
                $('#send_to_mhs').html(
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


    // send new msg to mhs bimbingan ta 
    $('#send_new_message').click(function(e) {
        e.preventDefault();
        let formData = new FormData($("#form_new_message")[0]);
        $.ajax({
            type: "post",
            url: "Models/send_new_msg_mhs.php",
            data: formData,
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

                }


            }
        });
        // return false;
    })

    // balas pesan ke mhs bimbingan 
    $('#btn_reply_to_mhs').click(function(e) {
        e.preventDefault();
        let formData = new FormData($("#form_reply_to_mhs_bimbingan")[0]);
        $.ajax({
            type: "post",
            url: "Models/reply_msg_mhs.php",
            data: formData,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function() {
                $('#btn_reply_to_mhs').prop('disabled', true);
                $('#btn_reply_to_mhs').html(
                    `<div class="fa fa-spin fa-spinner"></div> Please Wait...`
                );
            },
            complete: function() {
                $('#btn_reply_to_mhs').prop('disabled', false);
                $('#btn_reply_to_mhs').html(
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

// hapus pesan mhs akademik 
function delMyMessegePa(idPesan) {
    // alert('terhapus');
    $.ajax({
        type: "post",
        url: "Models/del_pesan_mhs_bimbingan.php",
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

// hapus pesan mhs bimbingan 
function delMyMessege(idPesan) {
    $.ajax({
        type: "post",
        url: "Models/del_pesan_mhs_bimbingan.php",
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
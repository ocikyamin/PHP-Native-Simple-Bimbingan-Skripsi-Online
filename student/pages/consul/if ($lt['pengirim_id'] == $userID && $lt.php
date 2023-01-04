if ($lt['pengirim_id'] == $userID && $lt['user_pengirim'] == 'mhs') {
// echo "mhs punya
<hr>";
?>
<img class="img-profile rounded-circle shadow" src="../apl/img/<?= $user['fotomhs'] ?>"
    style="width: 40px;height: 40px;border:none">
<span class="alert alert-success shadow-sm" style="border: 1px dotted;padding: 4px;border-radius: 50px;"><i
        class="fas fa-share"></i>
    <?= $user['nama'] ?>
</span>
<span class="alert alert-light" style="padding: 4px;border-radius: 50px;">
    <?= date('H:i', strtotime($lt['wkt'])) ?>
</span>
<div class="alert shadow-sm mb-2" style="border-radius: 20px;">

    <div class="table-responsive">
        <div class="pesan-view text-black-50 ">
            <?= htmlspecialchars_decode($lt['isi_pesan']) ?>
        </div>
        <!-- tombol area -->
        <?php
                                    if ($lt['document'] !== 'nofile') {
                                    ?>
        <b class="text-black-50"><i class="fas fa-paperclip"></i> Lampiran</b>
        <br>
        <a href="../files/<?= $lt['document'] ?>" target="_blank" class="btn btn-secondary btn-sm shadow"
            style="cursor: pointer;text-decoration: none;border-radius:20px"><i class="fas fa-cloud-download-alt"></i>
            Download</a>
        <?php
                                    }
                                    ?>
        <!-- end tombol -->
    </div>

</div>
<?php
                            // tampilkan pesan balasan 
                            $getReplyMsgFromDosen = mysqli_query($con, "SELECT * FROM tb_pesan WHERE reply_to=$lt[id_pesan] AND user_pengirim='dsn' ORDER BY id_pesan ASC ");
                            // Jika belum ada balas pesan 
                            if (mysqli_num_rows($getReplyMsgFromDosen) < 1) {
                                // echo "<span class='text-danger'>Belum ada balasan</span>";
                            } else {
                                // echo "ada balasannya dari dosen";
                            ?>
<?php
                                foreach ($getReplyMsgFromDosen as $rm) : ?>

<?php
                                    // echo "Dosen punya <hr> ";
                                    $dosen = mysqli_fetch_array(mysqli_query($con, "SELECT tb_dsn.id_dsn,
tb_dsn.nama_dosen,
tb_dsn.foto FROM tb_dsn WHERE id_dsn=$lt[pengirim_id] "));
                                    ?>





<img class="img-profile rounded-circle shadow" src="../apl/img/dosen/<?= $dosen['foto'] ?>"
    style="width: 40px;height: 40px;border:none">
<span class="alert alert-danger shadow-sm" style="border: 1px dotted;padding: 4px;border-radius: 50px;"><i
        class="fas fa-share"></i>
    <?= $dosen['nama_dosen'] ?>
</span>
<span class="alert alert-light" style="padding: 4px;border-radius: 50px;">
    <?= date('H:i', strtotime($lt['wkt'])) ?>
</span>

<div id="reply_to_dospem" onclick="reply_to_dospem()" data-id="<?= $lt['id_pesan'] ?>"
    data-judul="<?= $lt['pengajuan_id'] ?>" data-topik="<?= $lt['topik'] ?>" data-subyek="<?= $lt['subyek'] ?>"
    data-pengirim="<?= $userID ?>" data-penerima="<?= $lt['id_dsn'] ?>" data-pembing="<?= $lt['pembing_id'] ?>"
    data-jenis_pemb="<?= $lt['jenis_pemb'] ?>" data-periode="<?= $lt['tahun_bimbingan'] ?>"
    class="alert alert-light mb-2" style="border-radius: 20px;">

    <div class="table-responsive">
        <div class="pesan-view">
            <?= htmlspecialchars_decode($lt['isi_pesan']) ?>

        </div>
        <!-- tombol area -->
        <?php
                                            if ($lt['document'] !== 'nofile') {
                                            ?>
        <b><i class="fas fa-paperclip"></i> Lampiran</b>
        <br>
        <a href="../files/<?= $lt['document'] ?>" target="_blank" class="btn btn-secondary btn-sm shadow"
            style="cursor: pointer;text-decoration: none;border-radius:20px"><i class="fas fa-cloud-download-alt"></i>
            Download</a>
        <?php
                                            }
                                            ?>
        <!-- end tombol -->
    </div>

</div>


<?php endforeach; ?>


<?php
                            }
                        } else {

                            // tampilkan pesan balasan 
                            $getReplyMsg = mysqli_query($con, "SELECT * FROM tb_pesan WHERE reply_to=$lt[id_pesan] AND user_pengirim='mhs' ORDER BY id_pesan ASC ");
                            // Jika belum ada balas pesan 
                            if (mysqli_num_rows($getReplyMsg) < 1) {
                                // echo "<span class='text-danger'>Belum ada balasan</span>";
                            } else {
                                // echo "ada balasannya dari mhs";
                            ?>
<?php
                                foreach ($getReplyMsg as $rm) : ?>
<span style="border: 1px;padding: 4px;border-radius: 20px;"><i class="fas fa-comments fa-2x"></i> Pesan
    Balasan : <b><?= $rm['user_pengirim'] ?> </b> <!-- tombol area -->
    <?php
                                        if ($rm['document'] !== 'nofile') {
                                        ?>
    File :
    <a href="../files/<?= $rm['document'] ?>" target="_blank" class="text-success mb-3"
        style="border: 1px;padding: 4px;border-radius: 20px;cursor: pointer;text-decoration: none;"> <i
            class="fa fa-file-alt"></i> Download</a> <br>
    <?php
                                        }
                                        ?>
    <!-- edn tombol -->
</span>
<div class="alert alert-success bg-gradient-success" style="background: #E1F5FE;border-radius:50px;border:1px dashed;">
    <p style="color: black"><?= $rm['isi_pesan'] ?></p>
</div>


<?php endforeach; ?>
<?php

                            }
                        }
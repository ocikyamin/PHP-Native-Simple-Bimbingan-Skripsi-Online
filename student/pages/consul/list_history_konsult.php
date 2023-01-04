<div class="row">
    <div class="col-lg-12">
        <?php
        if (isset($_GET['topic'])) {
            $topikCode = base64_decode(mysqli_escape_string($con, $_GET['topic']));
            $getTopik = mysqli_query($con, "SELECT * FROM tb_pesan WHERE topik='$topikCode' ORDER BY topik  ");
            $topikName = mysqli_fetch_assoc($getTopik);
            $dosen = mysqli_fetch_assoc($pembing);
        ?>
        <div class="card mb-4">
            <div class="card-header bg-gradient-success text-white">

                <h6 class="m-0 font-weight-bold text-light"><i class="fa fa-comments fa-2x"></i> Percakapan</h6>
            </div>
            <div class="card-body">
                <div class="my-3"><i class="fas fa-stream"></i> Topik : <b> <?= $topikName['subyek']; ?> </b></div>
                <?php
                    foreach ($getTopik as $lt) {

                    ?>
                <div <?= $lt['user_pengirim'] == 'dsn' ? 'style="float:right"' : ''; ?>>
                    <img class="img-profile rounded-circle shadow"
                        src="../apl/<?= $lt['user_pengirim'] == 'mhs' ? 'img/' . $user['fotomhs'] . '' : '/img/dosen/' . $dosen['foto']; ?>"
                        style="width: 40px;height: 40px;border:none">
                    <span
                        class="alert <?= $lt['user_pengirim'] == 'mhs' ? 'alert-success' : 'alert-danger'; ?> shadow-sm"
                        style="border: 1px dotted;padding: 4px;border-radius: 50px;"><i class="fas fa-share"></i>
                        <?= $lt['user_pengirim'] == 'mhs' ? 'Anda' : $dosen['nama_dosen']; ?>
                    </span>
                    <span class="alert alert-light" style="padding: 4px;border-radius: 50px;">
                        <?= date('H:i', strtotime($lt['wkt'])) ?>
                    </span>
                    <!-- btn aksi  -->
                    <?php
                            if ($lt['pengirim_id'] == $userID && $lt['user_pengirim'] == 'mhs') {
                            ?>
                    <span>
                        <button onclick="delMyMessege(<?= $lt['id_pesan'] ?>)" style="text-decoration: none;"
                            class="btn btn-default btn-sm"><i class="fa fa-trash text-danger"></i>
                        </button>
                    </span>
                    <?php
                            }
                            ?>
                </div>

                <div class="alert <?= $lt['user_pengirim'] == 'mhs' ? 'alert-light' : 'shadow-sm'; ?> mb-2"
                    style="border-radius: 20px;">


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
                <form method="POST" id="formReplyToDospem" enctype="multipart/form-data">

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
                        <button type="submit" id="btn_reply_to_dospem" name="btn_reply_to_dospem"
                            class="btn btn-success bg-gradient-success btn-sm"><i class="fa fa-reply"></i>
                            Kirim Pesan </button>
                        <a href="?pages=consult" class="btn btn-outline-warning btn-sm"><i class="fa fa-times"></i>
                            Kembali</a>
                    </div>


                </form>
                <!-- end form balas pesan  -->
            </div>
        </div>
        <?php
        }

        ?>



    </div>
</div>


<!-- TAMPILKAN FORM UNTUK BALS PESAN -->


<script>
// function reply_to_dospem() {
//     $(document).on('click', '#reply_to_dospem', function() {
//         $('#modalReply').modal('show');
//         $('#id').val($(this).data('id'));
//         $('#judul').val($(this).data('judul'));
//         $('#topik').val($(this).data('topik'));
//         $('#subyek').val($(this).data('subyek'));
//         $('#pengirim').val($(this).data('pengirim'));
//         $('#penerima').val($(this).data('penerima'));
//         $('#pembing').val($(this).data('pembing'));
//         $('#jenis_pemb').val($(this).data('jenis_pemb'));
//         $('#periode').val($(this).data('periode'));
//     })
// }

// 


function delMyMessege(idPesan) {
    // alert('terhapus');
    $.ajax({
        type: "post",
        url: "Models/del_pesan.php",
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
    $('#btn_reply_to_dospem').click(function(e) {
        e.preventDefault();
        let formDataDospem = new FormData($("#formReplyToDospem")[0]);
        $.ajax({
            type: "post",
            url: "Models/reply_chat_dospem.php",
            data: formDataDospem,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function() {
                $('#btn_reply_to_dospem').prop('disabled', true);
                $('#btn_reply_to_dospem').html(
                    `<div class="fa fa-spin fa-spinner"></div> Please Wait...`
                );
            },
            complete: function() {
                $('#btn_reply_to_dospem').prop('disabled', false);
                $('#btn_reply_to_dospem').html(
                    `<i class="fa fa-reply"></i>
                            Kirim Pesan`);
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
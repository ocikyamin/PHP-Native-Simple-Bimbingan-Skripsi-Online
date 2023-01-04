<?php
if (isset($_SESSION['MHS_SES'])) {

    if (isset($_GET['key'])) {
        $fileID = intval($_GET['key']);
        $file = mysqli_real_escape_string($con, $_GET['file']);
        $doc = "../apl/file_skripsi/" . $file . "";

        if (file_exists($doc)) {
            unlink($doc);
            mysqli_query($con, "DELETE FROM tb_fileskripsi WHERE id_file=$fileID ");
            echo "<script>
	alert('File dihapus !');
	window.location='?pages=doc';
	</script>";
        } else {
            mysqli_query($con, "DELETE FROM tb_fileskripsi WHERE id_file=$fileID ");
            echo "<script>
	alert('File dihapus !');
	window.location='?pages=doc';
	</script>";
        }
    }
} else {

    echo "<script>alert('Harap Login ..');window.location='../';</script>";
}


?>
<div class="d-sm-flex align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Dokumen</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="./">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Dokumen</li>
    </ol>
</div>
<div class="alert alert-light bg-gradient-light" style="color: black;">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
    <ol>
        <li>File yang di Upload adalah file Skripsi yang akan di konsultasikan bersama dosen pembimbing</li>
        <li>File Upload Max 2 MB</li>
        <li>Upload File Menjadi 1 File 1 BAB</li>
        <li>Tipe File : doc, docx,ppt, pptx, pdf</li>
    </ol>
</div>

<div class="row mb-4">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-gradient-primary text-white">
                <h6 class="font-weight-bold"><i class="fa fa-upload"></i> Upload File</h6>
            </div>
            <div class="card-body">

                <form id="formUploadFilesMhs" method="POST" enctype="multipart/form-data">
                    <?php
                    $judul = mysqli_fetch_assoc($cekJudul);
                    ?>
                    <input type="hidden" name="id_mhs" value="<?= $userID ?>">
                    <input type="hidden" name="nim" value="<?= $user['nim'] ?>">
                    <input type="hidden" name="judul" value="<?= $judul['pengajuan_id'] ?>">
                    <div class="form-group">
                        <label>Document</label>
                        <select name="nama_file" id="nama_file" class="form-control form-control-sm">
                            <option value="">- Plih Nama Document -</option>
                            <?php
                            $list_doc = mysqli_query($con, "SELECT * FROM tm_doc ORDER BY id ASC");
                            foreach ($list_doc as $fd) {
                                echo "<option value='$fd[file_name]'>$fd[file_name]</option>";
                            }
                            ?>
                            <option value="lainya">Lainya </option>
                        </select>

                    </div>
                    <div class="form-group">
                        <input type="text" id="nama_file_lain" name="nama_file_lain"
                            class="d-none form-control form-control-sm" placeholder="Contoh : BAB I,Abstrak">
                    </div>
                    <script>
                    $(function() {
                        $("#nama_file").change(function() {
                            let name_file = $('#nama_file').val();

                            if (name_file.length == 0) {
                                $('#input-area').addClass('d-none');
                            } else {
                                $('#input-area').removeClass('d-none');
                            }

                            if (name_file == 'lainya') {
                                $('#nama_file_lain').removeClass('d-none');
                            } else {
                                $('#nama_file_lain').addClass('d-none');
                            }


                        });
                    })
                    </script>
                    <div id="input-area" class="d-none">
                        <div class="form-group">
                            <label>Url Google Docs</label>
                            <input type="text" name="link_doc" class="form-control form-control-sm"
                                placeholder="Url Google Docs">
                        </div>
                        <div class="form-group">
                            <label>Upload File</label>
                            <div class="custom-file">
                                <input name="file" type="file" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" id="btnMhsUploadDoc"
                                class="btn btn-primary bg-gradient-primary text-white btn-sm btn-icon-split mt-2">
                                <span class="icon text-white-50">
                                    <i class="fas fa-upload"></i>
                                </span>
                                <span class="text">Upload File</span>
                            </button>
                            <a href="javascript:history.back()"
                                class="btn btn-warning bg-gradient-warning text-white btn-sm btn-icon-split mt-2">
                                <span class="icon text-white-50">
                                    <i class="fa fa-chevron-left"></i>
                                </span>
                                <span class="text">Back</span>
                            </a>

                        </div>
                    </div>
                </form>






            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-gradient-success text-white">
                <h6 class="font-weight-bold"><i class="fa fa-file-alt"></i> Daftar Dokumen</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="row mb-4">

                        <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
                            <?php
                            // daftar dokumen yg di upload
                            $list_file = mysqli_query($con, "SELECT * FROM tb_fileskripsi WHERE id_mhs=$userID ORDER BY id_file ASC ");
                            foreach ($list_file as $df) : ?>
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
                                        <?= $df['file'] ?></a>
                                    <span class="mailbox-attachment-size clearfix mt-1">
                                        <span><?= $df['ukuran_file'] ?> KB</span>
                                        <a href="../apl/file_skripsi/<?= $df['file'] ?>" target="_blank"
                                            class="btn btn-default btn-sm float-right"><i
                                                class="fas fa-cloud-download-alt"></i></a>
                                        <a onclick="return confirm('Yakin menghapus file ?')"
                                            href="?pages=doc&key=<?= $df['id_file'] ?>&file=<?= $df['file'] ?>"
                                            class="btn btn-default btn-sm float-right"><i class="fa fa-trash"></i>
                                        </a>
                                    </span>
                                </div>
                            </li>

                            <?php endforeach; ?>


                        </ul>

                    </div>


                </div>
            </div>
        </div>
    </div>

</div>

<script>
$(function() {
    // consult_area()
    $('#btnMhsUploadDoc').click(function(e) {
        e.preventDefault();
        let formData = new FormData($("#formUploadFilesMhs")[0]);
        $.ajax({
            type: "post",
            url: "Models/upload_doc.php",
            data: formData,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function() {
                $('#btnMhsUploadDoc').prop('disabled', true);
                $('#btnMhsUploadDoc').html(
                    `<div class="fa fa-spin fa-spinner"></div> Please Wait...`
                );
            },
            complete: function() {
                $('#btnMhsUploadDoc').prop('disabled', false);
                $('#btnMhsUploadDoc').html(
                    ` <span class="icon text-white-50">
                                <i class="fas fa-upload"></i>
                            </span>
                            <span class="text">Upload File</span>`);
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
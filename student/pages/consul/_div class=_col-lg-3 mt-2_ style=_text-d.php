<div class="col-lg-3 mt-2" style="text-decoration: none;">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <span style="font-size: 10px;"><i class="fas fa-paperclip"></i>
                <?= $df['nama_file'] ?></span>
        </div>
        <div class="card-body">

            <a href="../apl/file_skripsi/<?= $df['file'] ?>" target="_blank">
                <center>
                    <?php
                    if ($df['tipe_file'] == 'doc') {
                        echo "<i class='fas fa-file-word fa-4x'></i> ";
                    } elseif ($df['tipe_file'] == 'docx') {
                        echo "<i class='fas fa-file-word fa-4x'></i> ";
                    } elseif ($df['tipe_file'] == 'xls') {
                        echo "<i class='fas fa-file-excel fa-4x text-success'></i> ";
                    } elseif ($df['tipe_file'] == 'xlsx') {
                        echo "<i class='fas fa-file-excel fa-4x text-success'></i> ";
                    } elseif ($df['tipe_file'] == 'ppt') {
                        echo "<i class='fas fa-file-powerpoint fa-4x'></i> ";
                    } elseif ($df['tipe_file'] == 'pptx') {
                        echo "<i class='fas fa-file-powerpoint fa-4x'></i> ";
                    } elseif ($df['tipe_file'] == 'pdf') {
                        echo "<i class='fas fa-file-pdf fa-4x text-danger'></i> ";
                    } elseif ($df['tipe_file'] == 'rar') {
                        echo "<i class='fas fa-file-archive fa-4x'></i>";
                    } elseif ($df['tipe_file'] == 'zip') {
                        echo "<i class='fas fa-file-zip fa-4x'></i> ";
                    }
                    ?>
                    <!-- <i class="fa fa-file-alt fa-4x"></i> -->
                    <br>
                    <span style="font-size: 9px;text-transform: uppercase;"><?= $df['tipe_file'] ?>
                        - <?= $df['ukuran_file'] ?> KB</span>
                </center>
            </a>


        </div>
        <p>
            <center>
                <a href="?pages=doc&key=<?= $df['id_file'] ?>&file=<?= $df['file'] ?>" class="btn btn-danger bg-gradient-danger btn-sm"><i class="fa fa-trash"></i>
                    Delete</a>
            </center>
        </p>
    </div>
</div>
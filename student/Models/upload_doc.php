<?php
include '../../config/databases.php';
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {


    $allowed_ext = array('doc', 'docx', 'ppt', 'pptx', 'pdf');
    $file_name   = $_FILES['file']['name'];
    @$file_ext   = strtolower(end(explode('.', $file_name)));
    $file_size   = $_FILES['file']['size'];
    $file_tmp    = $_FILES['file']['tmp_name'];
    $mhs         = intval($_POST['id_mhs']);
    $judul         = intval($_POST['judul']);
    $kodefile    = $_POST['nim'] . '-' . time();
    // $nama_file   = ;

    if ($_POST['nama_file_lain'] == '') {
        $namadoc = $_POST['nama_file'];
    } else {
        $namadoc = $_POST['nama_file_lain'];
    }

    $tgl         = date("Y-m-d H:i:s");
    $dok = $kodefile . '.' . $file_ext;
    $link_doc = $_POST['link_doc'];

    if ($file_name == "") {
        //    tanpa file 
        $in = mysqli_query($con, "INSERT INTO tb_fileskripsi (id_mhs,pengajuan_id,nama_file,tgl_upload,tipe_file,ukuran_file,file,doc) VALUES('$mhs','$judul','$namadoc','$tgl','doc', '0', 'nofile','$link_doc')");
        if ($in) {
            $msg = ['sukses' => 'Dokumen Berhasil disimpan tanpa lampiran'];
        } else {
            $msg = ['error' => 'Gagal Mengunggah File'];
        }
    } else {


        if (in_array($file_ext, $allowed_ext) === true) {
            if ($file_size < 3044070) {
                $lokasi = '../../apl/file_skripsi/' . $kodefile . '.' . $file_ext;
                move_uploaded_file($file_tmp, $lokasi);
                $in = mysqli_query($con, "INSERT INTO tb_fileskripsi (id_mhs,pengajuan_id,nama_file,tgl_upload,tipe_file,ukuran_file,file,doc) VALUES('$mhs','$judul','$namadoc','$tgl','$file_ext', '$file_size', '$dok','$link_doc')");
                if ($in) {
                    $msg = ['sukses' => 'File Berhasil di Unggah.'];
                } else {
                    $msg = ['error' => 'Gagal Mengunggah File'];
                }
            } else {
                $msg = ['error' => 'Besar ukuran file (file size) maksimal 2 Mb!'];
            }
        } else {
            $msg = ['error' => 'Ekstensi file tidak di izinkan!'];
        }
    }



    echo json_encode($msg);
} else {
    echo "404 Bad Request";
}
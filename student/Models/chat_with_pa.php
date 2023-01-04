<?php
include '../../config/databases.php';
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    //request is ajax
    $array  = array(
        'jpg', 'jpeg', 'png', 'doc', 'docx', 'ppt', 'pptx', 'pdf', 'zip', 'rar', 'xls', 'xlsx',
    );
    $pesan_id = $_POST['pesan_id'];
    $kode = $_POST['kode'];
    $userId = $_POST['user_id'];
    $to_user = $_POST['user_id_to'];
    $pesan = htmlspecialchars($_POST['pesan']);

    $filenama = 'MHS' . '_' . time();
    $file_name    = $_FILES['file']['name'];
    @$file_ext     = strtolower(end(explode('.', $file_name)));
    $file_size    = $_FILES['file']['size'];
    $file_tmp     = $_FILES['file']['tmp_name'];
    $dok = $filenama . '.' . $file_ext;

    if ($pesan == "") {
        $msg = ['error' => 'Pesan wajib diisi'];
    } else {

        // Jika pesan tanpa file 
        if ($file_name == "") {
            $query = mysqli_query($con, "INSERT INTO `tb_forum`(`kode`,`user_id`,`user_id_to`, `user_type`, `pesan`,`reply_to`,`document`) VALUES ('$kode','$userId','$to_user','mhs','$pesan','$pesan_id','nofile')");
            if ($query) {
                mysqli_query($con, "UPDATE tb_forum SET pesan_status='Y' WHERE id=$pesan_id ");
                $msg = ['sukses' => 'Pesan Terkirim'];
            } else {
                $msg = ['error' => 'Pesan Gagal Terkirim'];
            }
        } else {
            // pesab by file 
            // jika pesan melampirkan file
            if (in_array($file_ext, $array) === true) {
                if ($file_size < 2000000) {
                    $lokasi = '../../files/' . $filenama . '.' . $file_ext;
                    move_uploaded_file($file_tmp, $lokasi);
                    $query = mysqli_query($con, "INSERT INTO `tb_forum`(`kode`,`user_id` ,`user_id_to`, `user_type`, `pesan`,`reply_to`,`document`) VALUES ('$kode','$userId','$to_user','mhs','$pesan','$pesan_id','$dok')");
                    if ($query) {
                        mysqli_query($con, "UPDATE tb_forum SET pesan_status='Y' WHERE id=$pesan_id ");
                        $msg = ['sukses' => 'Pesan Terkirim dengan file'];
                    } else {
                        $msg = ['error' => 'Pesan Gagal Terkirim'];
                    }
                } else {
                    $msg = ['error' => 'Ukuran File terlalu besar, Maksimal 2 MB'];
                }
            } else {
                $msg = ['error' => 'Ekstensi file tidak di izinkan!'];
            }
        }
    }




    echo json_encode($msg);
} else {
    echo "404 Bad Request";
}
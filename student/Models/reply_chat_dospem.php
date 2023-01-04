<?php
include '../../config/databases.php';
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    //request is ajax
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
    if ($pesan == "") {
        $msg = ['error' => 'Gagal Mengirim Pesan, Harap Tuliskan Pesan Anda'];
    } else {

        if ($file_name == "") {
            // jika pesan tanpa file
            $is_send = mysqli_query($con, "INSERT INTO tb_pesan (pengajuan_id,pengirim_id,user_pengirim,penerima_id,user_penerima,topik,subyek,isi_pesan,pembing_id,jenis_pemb,wkt,reply_to,tahun_bimbingan) VALUES ('$judul','$pengirim','mhs','$penerima','dsn','$topik','$subyek','$pesan','$pembing','$jenis_pemb','$wkt','$id','$periode')  ");
            // $reply = mysqli_query($con,"INSERT INTO reply (id_pesan,user_id,user_tipe,tipe_pesan)  ");
            if ($is_send) {
                mysqli_query($con, "UPDATE tb_pesan SET status_pesan='Y' WHERE id_pesan=$id ");
                $msg = ['sukses' => 'Pesan Terkirim'];
            } else {
                $msg = ['error' => 'Pesan Gagal Terkirim, periksa kembali isi pesan anda'];
            }
        } else {

            // jika pesan melampirkan file
            if (in_array($file_ext, $array) === true) {
                if ($file_size < 2000000) {
                    $lokasi = '../../files/' . $filenama . '.' . $file_ext;
                    move_uploaded_file($file_tmp, $lokasi);
                    $is_send = mysqli_query($con, "INSERT INTO tb_pesan (pengajuan_id,pengirim_id,user_pengirim,penerima_id,user_penerima,topik,subyek,isi_pesan,document,pembing_id,jenis_pemb,wkt,reply_to,tahun_bimbingan) VALUES ('$judul','$pengirim','mhs','$penerima','dsn','$topik','$subyek','$pesan','$dok','$pembing','$jenis_pemb','$wkt','$id','$periode')  ");
                    if ($is_send) {
                        mysqli_query($con, "UPDATE tb_pesan SET status_pesan='Y' WHERE id_pesan=$id ");

                        $msg = ['sukses' => 'Pesan Terkirim dengan lampiran'];
                    } else {
                        $msg = ['error' => 'Pesan Gagar Terkirim, Periksa kembali isi pesan anda.'];
                    }
                } else {
                    $msg = ['error' => 'Ukuran File terlalu besar, Maksimal 2 MB'];
                    echo '<div class="alert alert-danger bg-gradient-danger text-white" id="alert">ERROR: </div>';
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
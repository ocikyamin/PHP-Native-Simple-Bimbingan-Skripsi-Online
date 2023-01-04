<?php
include '../../config/databases.php';
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    //request is ajax
    $array  = array(
        'jpg', 'jpeg', 'png', 'doc', 'docx', 'ppt', 'pptx', 'pdf', 'zip', 'rar', 'xls', 'xlsx',
    );

    $periode         = intval($_POST['periode']);
    $judul         = intval($_POST['judul']);
    $subyek        = htmlspecialchars($_POST['subyek']);
    $topik         = 'DSN-TOPIK' . '-' . time();
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
    if ($subyek == "" || $pesan == "") {
        $msg = ['error' => 'Subyek / Topik / Pesan Wajib Diisi.'];
    } else {

        if ($file_name == "") {
            // jika pesan tanpa file
            $is_send = mysqli_query($con, "INSERT INTO tb_pesan (pengajuan_id,pengirim_id,user_pengirim,penerima_id,user_penerima,topik,subyek,isi_pesan,pembing_id,jenis_pemb,wkt,tahun_bimbingan) VALUES ('$judul','$pengirim','dsn','$penerima','mhs','$topik','$subyek','$pesan','$pembing','$jenis_pemb','$wkt','$periode')  ");
            if ($is_send) {
                $msg = ['sukses' => 'Pesan Terkirim'];
            } else {
                $msg = ['error' => 'Pesan Gagal Terkirim'];
            }
        } else {

            // jika pesan melampirkan file
            if (in_array($file_ext, $array) === true) {
                if ($file_size < 2000000) {
                    $lokasi = '../../files/' . $filenama . '.' . $file_ext;
                    move_uploaded_file($file_tmp, $lokasi);
                    $is_send = mysqli_query($con, "INSERT INTO tb_pesan (pengajuan_id,pengirim_id,user_pengirim,penerima_id,user_penerima,topik,subyek,isi_pesan,document,pembing_id,jenis_pemb,wkt,tahun_bimbingan) VALUES ('$judul','$pengirim','dsn','$penerima','mhs','$topik','$subyek','$pesan','$dok','$pembing','$jenis_pemb','$wkt','$periode')  ");
                    if ($is_send) {
                        $msg = ['sukses' => 'Pesan Terkirim Dengan Lampiran'];
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
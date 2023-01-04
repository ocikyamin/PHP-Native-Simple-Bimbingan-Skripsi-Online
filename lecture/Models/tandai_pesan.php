<?php
include '../../config/databases.php';
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    //request is ajax

    $pesanId = intval($_POST['idPesan']);
    $del = mysqli_query($con, "UPDATE `tb_forum` SET `pesan_status`='Y' WHERE id=$pesanId ");
    if ($del) {
        $msg = ['sukses' => 'Pesan Ditandai Telah Dibaca'];
    } else {
        $msg = ['error' => 'Pesan Gagal Ditandai'];
    }



    echo json_encode($msg);
} else {
    echo "404 Bad Request";
}
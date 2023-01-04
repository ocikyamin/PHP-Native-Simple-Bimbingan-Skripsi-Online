<?php
include '../../config/databases.php';
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    //request is ajax

    $pesanId = intval($_POST['idPesan']);
    $del = mysqli_query($con, "DELETE FROM `tb_forum` WHERE id=$pesanId ");
    if ($del) {
        $msg = ['sukses' => 'Pesan Telah Dihapus'];
    } else {
        $msg = ['error' => 'Pesan Gagal Dihapus'];
    }



    echo json_encode($msg);
} else {
    echo "404 Bad Request";
}
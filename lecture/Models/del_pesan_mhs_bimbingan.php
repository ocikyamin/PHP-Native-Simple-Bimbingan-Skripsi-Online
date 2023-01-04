<?php
include '../../config/databases.php';
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    //request is ajax
    $array  = array(
        'jpg', 'jpeg', 'png', 'doc', 'docx', 'ppt', 'pptx', 'pdf', 'zip', 'rar', 'xls', 'xlsx',
    );
    $pesanId = intval($_POST['idPesan']);
    $del = mysqli_query($con, "DELETE FROM `tb_pesan` WHERE id_pesan=$pesanId ");
    if ($del) {
        $msg = ['sukses' => 'Pesan Telah Dihapus'];
    } else {
        $msg = ['error' => 'Pesan Gagal Dihapus'];
    }



    echo json_encode($msg);
} else {
    echo "404 Bad Request";
}
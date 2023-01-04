<?php
include '../../config/databases.php';
$pembingID = intval(base64_decode($_GET['print']));
$d = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM pembing
	JOIN tm_periode ON pembing.periode=tm_periode.periode_id
	JOIN tb_mhs ON pembing.id_mhs=tb_mhs.id_mhs
	JOIN tb_dsn ON pembing.dosen=tb_dsn.id_dsn
	JOIN pengajuan ON pembing.pengajuan_id=pengajuan.pengajuan_id
	JOIN tm_prodi ON tb_mhs.prodi_id=tm_prodi.prodi_id
	JOIN tm_fakultas ON tm_prodi.fakultas_id=tm_fakultas.fakultas_id

 WHERE pembing.pembing_id=$pembingID "));

?>

<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Kartu Bimbingan</title>
    <style>
    body {
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        font-size: 12px;
    }

    .tabel {
        border-collapse: collapse;
        font-size: 11px;

    }
    </style>
</head>

<body>

    <table width="100%" style="text-align: center;font-size: 17px;">
        <tr>
            <td>
                <img src="../../logo.png" width="60">
            </td>
            <td>
                <h4 align="center"><br>
                    <!-- SEKOLAH TINGGI TRKNIK MALANG <br>  -->
                    <?= strtoupper($d['fakultas']) ?>
                    <p align="center" style="font-size: 9px;">Alamat : Jl. Soekarno Hatta No.94, Mojolangu, Kec.
                        Lowokwaru,Kota Malang, Jawa Timur 65142</p>
                </h4>

            </td>
        </tr>
    </table>
    <hr style="border:1px double">
    <table width="100%">
        <tr>
            <td>
                <div align="center">KARTU BUKTI KONSULTASI BIMBINGAN SKRIPSI/TUGAS AKHIR</div>
            </td>
        </tr>
        <tr>
            <td>
                <p align="center"><?= strtoupper($d['fakultas']) ?></p>
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="11%">NAMA</td>
            <td width="1%">:</td>
            <td width="88%"><?php echo $d['nama'] ?></td>
        </tr>
        <tr>
            <td>NIM</td>
            <td>:</td>
            <td><?php echo $d['nim'] ?> </td>
        </tr>
        <tr>
            <td>JURUSAN</td>
            <td>:</td>
            <td><?php echo $d['prodi'] ?></td>
        </tr>
        <tr>
            <td>DOSEN PEMBIMBING </td>
            <td>:</td>
            <td><?php echo $d['nama_dosen']; ?> - Pembimbing <?php echo $d['jenis']; ?> </td>
        </tr>
    </table>
    <!-- <table width="100%">
  <tr>
    <td> -->
    <br>

    <!-- </td>
<td> -->

    <!-- <table width="100%" border="1" class="tabel" cellpadding="3">
 

    </table> -->
    <!-- </td>
  </tr>
</table> -->
    <table width="100%" border="1" class="tabel">
        <tr>
            <td>
                <table width="100%" border="1" class="tabel" cellpadding="3">
                    <tr>
                        <td rowspan="2">No</td>
                        <td rowspan="2">Hari/Tanggal</td>
                        <td>Hal yang dikonsultasikan </td>
                    </tr>
                    <tr>
                        <td align="center"><b>Pembimbing <?php echo $d['jenis']; ?> </b></td>
                        <td>Tanda Tangan </td>
                    </tr>
                    <!-- pembimbing 1 -->
                    <?php
          $no = 1;
          $satu = mysqli_query($con, "SELECT * FROM tb_pesan WHERE pembing_id=$pembingID 
          ORDER BY topik ASC  ");
          while ($chat = mysqli_fetch_array($satu)) { ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($chat['wkt'])); ?></td>
                        <td><b>#<?php echo $chat['subyek']; ?> </b> <br>
                            <?php echo html_entity_decode($chat['isi_pesan']); ?>
                        </td>
                        <td></td>
                    </tr>
                    <?php } ?>
                </table>
            </td>
        </tr>
    </table>
    <table width="100%">

        <tr>
            <td align="right" colspan="6" rowspan="" headers="">
                <p>Malang, <?php echo date(" d F Y") ?> <br>
                    <!-- Dekan FTIK </p> <br> <br>
            <p><u><b>Dr.H.Nunu Burnahunddin,Lc,M.Ag</b></u> <br><b>NIP. 197305102000121002</b></p> -->
            </td>
        </tr>
    </table>




</body>

</html>
<script>
window.print();
</script>
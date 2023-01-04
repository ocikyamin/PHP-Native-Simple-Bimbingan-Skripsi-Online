  <div class="d-sm-flex align-items-center justify-content-between">
<h1 class="h3 mb-0 text-gray-800">Revisi Judul</h1>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="./">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Revisi Judul</li>
</ol>
</div>

    <!-- Informasi Revisi Judul -->
    <div class="card mt-2">
<!--     <div class="card-header py-2 bg-gradient-warning text-white d-flex flex-row align-items-center justify-content-between">
    <h6 class="m-0 font-weight-bold"><i class="fa fa-info"></i> Informasi Revisi Judul </h6>
    </div> -->
           <div class="card-header bg-gradient-primary text-white py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-white"><i class="fa fa-file-alt"></i> Informasi Revisi Judul</h6>
          </div>
    <div class="card-body">
        <table class="table table-striped table-sm mid">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>MAHASISWA</th>
                    <th>JUDUL</th>
                    <th>STATUS</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $i=1;
            $cekJudulRevisi = mysqli_query($con,"SELECT 
            tb_mhs.id_mhs,
            tb_mhs.nim,
            tb_mhs.nama,
            pengajuan.pengajuan_id,
            pengajuan.revisi_judul,
            pengajuan.judul,
            pengajuan.stt_revisi,
            pengajuan.pengajuan_id
            FROM pengajuan
            JOIN tb_mhs ON pengajuan.id_mhs=tb_mhs.id_mhs
            WHERE pengajuan.stt_revisi !='NULL' ");
            if (mysqli_num_rows($cekJudulRevisi) < 1) {
            echo "<center><p>Belum ada informasi ...</p></center>";
            }
            foreach ($cekJudulRevisi as $nRev):?>
                <tr>
                    <td><?= $i++ ?>.</td>
                    <td><?= $nRev['nama'] ?> </td>
                    <td>
<span style="font-size: 12px;"><b><?= $nRev['judul'] ?></b></span> 

 </td>
                    <td>
                        <?php 
                        if ($nRev['stt_revisi']=='new') {
                            echo 'Belum diperiksa ..';
                        }elseif ($nRev['stt_revisi']=='Y') {
                            echo '<span class="badge badge-success">DISETUJUI</span>';
                        }elseif ($nRev['stt_revisi']=='N') {
                            echo '<span class="badge badge-danger">DITOLAK</span>';
                        }


                         ?>
                        <!-- <?= $nRev['stt_revisi'] ?>  --></td>
                    <td>
                        <a href="?pages=detail_judul_revisi&details=<?= $nRev['pengajuan_id'] ?>" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Detail</a>
                            <a href="../apl/report/revisi_judul_print.php?print=<?= $nRev['pengajuan_id'] ?>" target="_blank" class="btn btn-light btn-sm"><i class="fa fa-print"></i> Print</a>
                    </td>
                </tr>
                   <?php endforeach; ?>
            </tbody>
        </table>

    </div>
    </div>

    <!-- end Revisi judul -->
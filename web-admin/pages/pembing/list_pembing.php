 <div class="d-sm-flex align-items-center justify-content-between">
<h1 class="h3 mb-0 text-gray-800">Status Pemibimbing</h1>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="./">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Status Pemibimbing</li>
</ol>
</div>
    <div class="row">
          <div class="col-lg-12 mb-4">
          <!-- Simple Tables -->
          <div class="card">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Daftar Permohonan Kesediaan Membimbing Skripsi/TA</h6>
          </div>
          <div class="table-responsive">
          <table class="table table-sm align-items-center table-flush">
          <thead class="thead-light">
          <tr>
          <th>NO</th>
          <th>TGL KIRIM</th>
          <th>NIP/NIDN</th>
          <th>NAMA</th>
          <th>JUDUL</th>
          <th>STATUS</th>
          <th>ACTION</th>
          </tr>
          </thead>
          <tbody>
     <?php 
     $i=1;
     $pembing = mysqli_query($con,"SELECT
     tb_dsn.nip,
     tb_dsn.nama_dosen,
     tb_dsn.foto,
     pembing.pembing_id,
     pembing.create_at,
     pembing.kesediaan,
     pembing.jenis,
     pengajuan.pengajuan_id,
     pengajuan.judul
     FROM pembing 
     JOIN tb_dsn ON pembing.dosen=tb_dsn.id_dsn
     JOIN pengajuan ON pembing.pengajuan_id=pengajuan.pengajuan_id
      JOIN tm_periode ON pembing.periode=tm_periode.periode_id
      WHERE tm_periode.stt_periode='on'

     ORDER BY pembing.pembing_id ASC
     ");
foreach ($pembing as $dp):?>
          <tr>
          <td><a href="#"><?= $i++ ?></a></td>
          <td><?= date('d-m-Y',strtotime($dp['create_at'])) ?></td>
          <td><?= $dp['nip'] ?></td>
          <td><?= $dp['nama_dosen'] ?></td>             
          <td><?= $dp['judul'] ?></td>
          <td>
               <?php 
               if ($dp['kesediaan']=='new') {
                    echo "<span class='badge badge-warning bg-gradient-warning text-white'>Belum ada tanggapan</span>";
               }elseif ($dp['kesediaan']=='Y') {
                    echo "<span class='badge badge-success bg-gradient-success text-white'>BERSEDIA</span>";
               }elseif ($dp['kesediaan']=='N') {
                    echo "<span class='badge badge-danger bg-gradient-danger text-white'>TIDAK BERSEDIA</span>";
               }

                ?>
          </td>
          <td>
            <a href="?pages=fix_judul&set_pembing=<?= $dp['pengajuan_id'] ?>" class="btn btn-primary bg-gradient-primary text-white btn-sm"><i class="fa fa-search"></i></a>
          </td>
          
          </tr>
          <?php endforeach; ?>
          </tbody>
          </table>
          </div>
          </div>
          </div>
          </div>
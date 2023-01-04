<?php 
  // manampilakan data daftar judul
  $ta = mysqli_query($con,"SELECT * FROM pengajuan WHERE id_mhs=$userID ORDER BY pengajuan_id ASC ");
if (isset($_SESSION['MHS_SES'])) {
// cek sebelum hapus data
if (isset($_GET['cancel'])) {
$id =intval($_GET['cancel']);
$is_del=mysqli_query($con,"DELETE FROM pengajuan WHERE pengajuan_id={$id} ");
if ($is_del) {
  echo "
<script>
alert('Judul dibatalkan');
window.location ='?pages=list_judul';   
</script>";
}else{
  echo "
<script>
alert('Oppss ! Judul Gagal dibatalkan !');
window.location ='?pages=list_judul';   
</script>";
}
}
}
// jika belum ada judul arahkan ke form pengajuan
if (mysqli_num_rows($ta)< 1) {
  echo "
<script>
window.location ='?pages=add_judul';   
</script>";	
}
?>
<div class="d-sm-flex align-items-center justify-content-between">
<h1 class="h3 mb-0 text-gray-800">Daftar Judul</h1>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="./">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Daftar Judul</li>
</ol>
</div>
<div class="row mb-4">
		<div class="col-lg-12">
		<div class="card">
		<div class="card-header bg-gradient-primary text-white">
				<h6 class="mt-3 font-weight-bold"><i class="fa fa-list"></i> Daftar Judul</h6>
				<a href="?pages=add_judul" class="btn btn-default text-white btn-sm btn-icon-split mt-2">
				<span class="icon text-white-50">
				<i class="fas fa-plus"></i>
				</span>
				<span class="text">Tambah Judul</span>
				</a>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-sm align-items-center table-flush">
					<thead class="thead-light">
						<tr>
							<th>#</th>
							<th>No</th>
							<th>Judul</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$i=1;
					foreach ($ta as $dta):?>
						<tr>
							<td><a href="?pages=list_judul&cancel=<?= $dta['pengajuan_id'] ?>" onclick="return confirm('Apakah yakin ?')" class="btn btn-sm btn-danger bg-gradient-danger"><i class="fa fa-times"></i> Batal</a></td>
							<td><?= $i++ ?></td>
							<td><?= $dta['judul'] ?></td>
							<td>
								<?php if ($dta['rekomendasi_pa']=='Y') {
								echo '<span class="badge badge-success">Rekomendasi PA</span>';
								}elseif ($dta['rekomendasi_pa']=='new') {
								echo '<span class="badge badge-warning">Belum ada tanggapan PA</span>';
								}elseif ($dta['rekomendasi_pa']=='N') {
								echo '<span class="badge badge-danger">Ditolak PA</span>';
								} ?>

								<?php if ($dta['disetujui_kajur']=='Y') {
								echo '<span class="badge badge-success">Disetujui Prodi</span>';
								}elseif ($dta['disetujui_kajur']=='new') {
								echo '<span class="badge badge-warning">Belum ada tanggapan Prodi</span>';
								}elseif ($dta['disetujui_kajur']=='N') {
								echo '<span class="badge badge-danger">Ditolak Prodi</span>';
								} ?>
								
							</td>
						</tr>
					<?php endforeach;?>
					</tbody>
				</table>
			</div>
		</div>
		</div>
		</div>
		</div>
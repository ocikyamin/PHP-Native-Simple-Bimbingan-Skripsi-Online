  <?php 
if (isset($_SESSION['ADMIN_SESS'])) {
// Aktifkan akun
if (isset($_GET['active'])) {
$id =intval($_GET['active']);
$stt = mysqli_escape_string($con,$_GET['account']);
if ($stt=='actived') {
      $is_actived=mysqli_query($con,"UPDATE tb_mhs SET status_akun='Y' WHERE id_mhs={$id} ");
      if ($is_actived) {
      echo "
      <script>
      alert('Akun diaktifkan !')
      window.location ='?pages=list_account';   
      </script>";
      }else{
      echo "
      <script>
      alert('Oppss ! Gagal diaktifkan !')
      window.location ='?pages=list_account';   
      </script>";
      }
}else{
  $is_blocked=mysqli_query($con,"UPDATE tb_mhs SET status_akun='N' WHERE id_mhs={$id} ");
      if ($is_blocked) {
      echo "
      <script>
      alert('Akun diblokir.. !')
      window.location ='?pages=list_account';   
      </script>";
      }else{
      echo "
      <script>
      alert('Oppss ! Gagal diblokir !')
      window.location ='?pages=list_account';   
      </script>";
      }
}

}
}


?>

<div class="d-sm-flex align-items-center justify-content-between">
<h1 class="h3 mb-0 text-gray-800">User Baru</h1>
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="./">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">User Baru</li>
</ol>
</div>

      <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Daftar Akun Baru</h6>
                </div>
                <div class="table-responsive">
                  <table class="table table-sm align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>TANGGAL</th>
                        <th>NIM</th>
                        <th>NAMA</th>
                        <th>PRODI</th>
                        <th>TH MASUK</th>
                        <th>ACTION</th>
                      </tr>
                    </thead>
                    <tbody>
                    	<?php 
                    	$i=1;
                    	$new_user = mysqli_query($con,"SELECT tb_mhs.id_mhs,tb_mhs.nim,tb_mhs.nama,tb_mhs.tahun_angkatan,tb_mhs.create_at,tm_prodi.prodi FROM tb_mhs JOIN tm_prodi ON tb_mhs.prodi_id=tm_prodi.prodi_id WHERE tb_mhs.status_akun='new' ORDER BY tb_mhs.id_mhs ASC ");
                    	foreach ($new_user as $dna):?>
                      <tr>
                        <td><a href="#"><?= $i++ ?></a></td>
                        <td><?= date('d-m-Y H:i:s',strtotime($dna['create_at'])) ?></td>
                        <td><?= $dna['nim'] ?></td>
                        <td><?= $dna['nama'] ?></td>
                        <td><?= $dna['prodi'] ?></td>
                        <td><?= $dna['tahun_angkatan'] ?></td>
                        <td>
                        	<a href="?pages=list_account&active=<?= $dna['id_mhs'] ?>&account=block" class="btn btn-sm btn-danger bg-gradient-danger text-white" onclick="return confirm('Apakah Yakin ?')"><i class="fa fa-times"></i> Blokir</a>
                        	<a href="?pages=list_account&active=<?= $dna['id_mhs'] ?>&account=actived" onclick="return confirm('Apakah Yakin ?')" class="btn btn-sm btn-primary bg-gradient-primary text-white"><i class="fa fa-check"></i> Aktifkan</a>

                        </td>
                      </tr>
                  <?php endforeach; ?>
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  </div>
  
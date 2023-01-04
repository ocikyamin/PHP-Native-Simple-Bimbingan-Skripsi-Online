<?php 
if (isset($_SESSION['ADMIN_SESS'])) {
if (isset($_GET['remv'])) {
$id =intval($_GET['remv']);
mysqli_query($con,"DELETE FROM tb_info WHERE info_id=$id ");
echo "<script>
alert('Terhapus ..');
window.location='?pages=settings';
</script>";
}
}

?>

  <div class="d-sm-flex align-items-center justify-content-between">
  <h1 class="h3 mb-0 text-gray-800">Setting</h1>
  <ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="./">Home</a></li>
  <li class="breadcrumb-item active" aria-current="page">Setting</li>
  </ol>
  </div>

  <div class="row">
  	<div class="col-lg-8">
  		<div class="card">
<div class="card-header bg-gradient-primary text-white">
<h6 class="mt-3 font-weight-bold"><i class="fa fa-list"></i> Daftar Persyaratan</h6>
<a href="#" data-toggle="modal"
data-target="#modalAdd" id="#modalAdd" class="btn btn-default text-white btn-sm btn-icon-split mt-2">
<span class="icon text-white-50">
<i class="fas fa-plus"></i>
</span>
<span class="text">Tambah Syarat</span>
</a>
</div>
  			<div class="card-body">
  				<div class="table-responsive">
  					<table class="table table-sm table-striped">
  						<thead>
  							<tr>
  								<th>NO</th>
  								<th>Persyaratan</th>
  								<th>Keterangan</th>
                  <th></th>
  							</tr>
  						</thead>
  						<tbody>
  							<?php 
                $i=1;
                $set = mysqli_query($con,"SELECT * FROM tb_info ORDER BY info_id ASC ");
                foreach ($set as $ds) :?>
  							<tr>
  								<td> <?= $i++ ?>. </td>
  								<td><?= $ds['judul'] ?></td>
                  <td><?= $ds['isi'] ?></td>
                  <td>
                    <a href="?pages=settings&remv=<?= $ds['info_id'] ?>" onclick="return confirm ('Apakah Yakin ?')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                  </td>
  							</tr>
              <?php endforeach; ?>
  						</tbody>
  					</table>
  				</div>
  			</div>
  		</div>
  	</div>
  </div>

                <!-- Modal Tambah -->
                <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog"
                aria-labelledby="modalAdd" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="modalAdd"><i class="fa fa-plus"></i> Tambah Syarat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form method="POST">
                <div class="modal-body">
                <div class="form-group">
                <label>Judul</label>
                <input type="text" name="judul" class="form-control" placeholder="Ex : Judul" required>
                </div>
                 <div class="form-group">
                <label>Isi/Keterangan</label>
                <textarea  name="ket" class="form-control" placeholder="Keterangan" required></textarea>
                </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                <button name="submit" type="submit" class="btn btn-primary bg-gradient-primary"><i class="fa fa-check"></i> Save</button>
                </div>
                </form>
                <!-- SCRIPT SIMPAN DATA FAKULTAS -->
                <?php 
                if (isset($_POST['submit'])) {
                $judul  = htmlspecialchars($_POST['judul']);
                $ket  = htmlspecialchars($_POST['ket']);
                // Cek jika inputan kosong
                if ($judul=="") {
                    echo "
                    <script>
                    alert ('Opss ! Inputan Tidak Boleh Kosong !');
                    window.location ='?pages=settings';   
                    </script>";
                }else{
                  mysqli_query($con,"INSERT INTO tb_info (judul,isi) VALUES ('$judul','$ket') ");
                    echo "
                    <script>
                    alert('Data Telah Ditambahkan !');
                    window.location ='?pages=settings';   
                    </script>";
                 

                }
              }

                ?>
                <!-- END SCRIPT SIMPAN DATA FAKULTAS -->
                </div>
                </div>
                </div>
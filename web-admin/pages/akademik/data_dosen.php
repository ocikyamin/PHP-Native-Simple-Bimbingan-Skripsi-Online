<?php 
if (isset($_SESSION['ADMIN_SESS'])) {
// cek sebelum hapus data
if (isset($_GET['id'])) {
$dosenID = intval($_GET['id']);
$del = mysqli_fetch_assoc(mysqli_query($con,"SELECT id_dsn,foto FROM tb_dsn WHERE id_dsn=$dosenID "));
$doc ="../apl/img/dosen/".$del['foto']."";

if (file_exists($doc)) {
if (!$del=='user.png') {
  unlink($doc);
}
mysqli_query($con,"DELETE FROM tb_dsn WHERE id_dsn=$del[id_dsn] ");
echo "<script>
alert('Data Dosen Telah dihapus !');
window.location='?pages=dosen';
</script>";
}else{
mysqli_query($con,"DELETE FROM tb_dsn WHERE id_dsn=$del[id_dsn] ");
echo "<script>
alert('Data Dosen Telah dihapus !');
window.location='?pages=dosen';
</script>"; 
}

}
}

?>
  <div class="d-sm-flex align-items-center justify-content-between">
  <h1 class="h3 mb-0 text-gray-800">Dosen</h1>
  <ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="./">Home</a></li>
  <li class="breadcrumb-item">Akademik</li>
  <li class="breadcrumb-item active" aria-current="page">Dosen</li>
  </ol>
  </div>

<div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header bg-gradient-primary text-white">
                  <h6 class="mt-3 font-weight-bold"><i class="fa fa-graduation-cap"></i> Daftar Dosen</h6>
                  <a href="#" data-toggle="modal"
                    data-target="#modalAdd" id="#modalAdd" class="btn btn-outline-light text-white btn-sm btn-icon-split mt-2">
                    <span class="icon text-white-50">
                      <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">New Dosen</span>
                  </a>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-hover table-sm align-items-center table-flush mid">
                    <thead class="table-flush">
                      <tr style="text-transform: uppercase;">
                        <th>NO</th>
                        <th>NIP/NIDN</th>
                        <th>NAMA</th>
                        <th>JABATAN</th>
                        <th>IMG</th>
                        <th>ACTION</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $no=1;
                      $sql = mysqli_query($con,"SELECT * FROM tb_dsn ORDER BY nip ASC");
                      foreach ($sql as $d) {?>
                      <tr>
                        <td><?=$no++?></td>
                        <td><b><?=$d['nip'] ?></b></td>
                        <td><?=$d['nama_dosen'] ?></td>
                        <td><?=$d['jabatan'] ?></td>
                        <td><img src="../apl/img/dosen/<?=$d['foto'] ?>" class="img-thumbnail" style="width: 50px;height: 50px;border-radius: 100%;"></td>
                          <td>
                          <a href="#" id="select" onclick="confirm_modal_edit()" data-id="<?= $d['id_dsn'] ?>" data-nip="<?= $d['nip'] ?>" data-nama="<?= $d['nama_dosen'] ?>" data-jabatan="<?= $d['jabatan'] ?>" data-foto="<?= $d['foto'] ?>" class="btn btn-primary bg-gradient-primary btn-sm">
                          <i class="fas fa-edit"></i>
                          </a>

                          <a href="?pages=dosen&id=<?= $d['id_dsn'] ?>" onclick="return confirm ('Apakah Yakin ?')" class="btn btn-danger bg-gradient-danger btn-sm"><i class="fa fa-trash"></i></a>
                             
                          </td>
                      </tr>
                    <?php } ?>
          
                     
                    </tbody>
                  </table> 

                <!-- Modal Tambah -->
                <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog"
                aria-labelledby="modalAdd" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="modalAdd"><i class="fa fa-plus"></i> New Dosen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                <div class="form-group">
                <label for="nip">NIP/NIDN</label>
                <input type="number" id="nip" name="nip" class="form-control" placeholder="Nomor Induk Pegawai" required>
                </div>
                <div class="form-group">
                <label for="nama">Nama Dosen</label>
                <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Lengkap & Gelar" required>
                </div>

                <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <input type="text" id="jabatan" name="jabatan" class="form-control" placeholder="Ex : Lektor">
                </div>

                <div class="form-group">
                <label for="foto">Foto</label>
                <input type="file" id="foto" name="file" class="form-control">
                </div>

                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                <button name="submit" type="submit" class="btn btn-primary bg-gradient-primary"><i class="fa fa-check"></i> Save</button>
                </div>
                </form>
                  <!-- SCRIPT SIMPAN DATA DOSEN -->
                  <?php 
                  if (isset($_POST['submit'])) {
                  $array    = array('jpg','jpeg','png');
                  $nip      = htmlspecialchars($_POST['nip']);
                  $nama     = htmlspecialchars($_POST['nama']);
                  $jabatan  = htmlspecialchars($_POST['jabatan']);
                  $password = sha1($nip);
                  // Post file
                  $filenama = $nip.'_'.time();
                  $file_name    = $_FILES['file']['name'];
                  @$file_ext     = strtolower(end(explode('.', $file_name)));
                  $file_size    = $_FILES['file']['size'];
                  $file_tmp     = $_FILES['file']['tmp_name'];
                  $img = $filenama.'.'.$file_ext;

                  if ($nip=="" || $nama=="") {
                  echo "
                  <script> alert ('Opss ! Inputan Tidak Boleh Kosong !');
                  window.location ='?pages=dosen';   
                  </script>";
                  }else{

                  $cekNip = mysqli_num_rows(mysqli_query($con,"SELECT nip FROM tb_dsn WHERE nip=$nip "));
                  // cek NIP jika sudah ada ..
                  if ($cekNip < 1) {
                  if ($file_name=="") {
                  mysqli_query($con,"INSERT INTO tb_dsn (nip,nama_dosen,jabatan,password) VALUES ('$nip','$nama','$jabatan','$password') ");
                  echo "
                  <script> alert ('Sukses ! Data berhasil ditambahkan .. ');
                  window.location ='?pages=dosen';   
                  </script>";
                  }else{
                  // jika pesan melampirkan file
                  if(in_array($file_ext, $array) === true){
                  if($file_size < 2000000){
                  $lokasi = '../apl/img/dosen/'.$filenama.'.'.$file_ext;
                  move_uploaded_file($file_tmp, $lokasi);
                  $is_insert= mysqli_query($con,"INSERT INTO tb_dsn (nip,nama_dosen,jabatan,password,foto) VALUES ('$nip','$nama','$jabatan','$password','$img')");
                  if ($is_insert) {
                  echo "
                  <script> alert ('Sukses ! Data berhasil ditambahkan .. ');
                  window.location ='?pages=dosen';   
                  </script>";
                  }else{
                  echo '<div class="alert alert-danger bg-gradient-danger text-white" id="alert">PESAN TIDAK TERKIRIM: Periksa kembali isi pesan anda ..</div>';
                  }

                  }else{
                  echo '<div class="alert alert-danger bg-gradient-danger text-white" id="alert">ERROR: Ukuran File terlalu besar, Maksimal 2 MB</div>';
                  }
                  }else{
                  echo '<div class="alert alert-danger bg-gradient-danger text-white" id="alert">ERROR: Ekstensi file tidak di izinkan!</div>';
                  }

                  }

                  }else{
                  // NIP sudah terdaftar..
                  echo "
                  <script>
                  alert ('Opss ! NIP/NIDN Sudah terdaftar ..');
                  window.location ='?pages=dosen';   
                  </script>";
                  }

                  }

                  }

                  ?>
                  <!-- END SCRIPT SIMPAN DATA DOSEN -->
                </div>
                </div>
                </div>

                          <!-- Modal Edit -->
                <div class="modal fade" id="modal_update" tabindex="-1" role="dialog"
                aria-labelledby="modalAdd" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="modalAdd"><i class="fa fa-plus"></i> Edit Dosen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                  <input type="hidden" name="id" id="id1">
                   <input type="hidden" name="nip" id="nipnya">
                <div class="modal-body">
                <div class="form-group">
                <label for="nip">NIP/NIDN</label>
                <input type="text" id="nip1" class="form-control">
                </div>
                <div class="form-group">
                <label for="nama">Nama Dosen</label>
                <input type="text" id="nama1" name="nama" class="form-control" placeholder="Nama Lengkap & Gelar" required>
                </div>

                <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <input type="text" id="jabatan1" name="jabatan" class="form-control" placeholder="Ex : Lektor">
                </div>

                <div class="form-group">
                <label for="foto">Foto</label>
                <input type="hidden" name="foto" id="foto1">
                <input type="file" name="file" class="form-control">
                </div>

                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                <button name="update" type="submit" class="btn btn-primary bg-gradient-primary"><i class="fa fa-check"></i> Save</button>
                </div>
                </form>
                  <!-- SCRIPT EDIT DATA DOSEN -->
                  <?php 
                  if (isset($_POST['update'])) {
                  $array    = array('jpg','jpeg','png');
                   $id      = htmlspecialchars($_POST['id']);
                  $nip      = htmlspecialchars($_POST['nip']);
                  $nama     = htmlspecialchars($_POST['nama']);
                  $jabatan  = htmlspecialchars($_POST['jabatan']);
                  $foto  = $_POST['foto']; 
                  // Post file
                  $filenama = $nip.'_'.time();
                  $file_name    = $_FILES['file']['name'];
                  @$file_ext     = strtolower(end(explode('.', $file_name)));
                  $file_size    = $_FILES['file']['size'];
                  $file_tmp     = $_FILES['file']['tmp_name'];
                  $img = $filenama.'.'.$file_ext;

                  if ($file_name=="") {
                  mysqli_query($con,"UPDATE tb_dsn SET nama_dosen='$nama',jabatan='$jabatan' WHERE id_dsn=$id ");
                  echo "
                  <script> alert ('Sukses ! Data berhasil diperbarui .. ');
                  window.location ='?pages=dosen';   
                  </script>";
                  }else{
                  // jika pesan melampirkan file
                  if(in_array($file_ext, $array) === true){
                  if($file_size < 2000000){
                  $lokasi = '../apl/img/dosen/'.$filenama.'.'.$file_ext;
                  move_uploaded_file($file_tmp, $lokasi);
                  $is_update= mysqli_query($con,"UPDATE tb_dsn SET nama_dosen='$nama',jabatan='$jabatan',foto='$img' WHERE id_dsn=$id ");
                  if ($is_update) {
                  if ($foto !=="user.png") {
                  $doc ="../apl/img/dosen/".$foto."";
                  unlink($doc);                    
                  }
                  echo "
                  <script> alert ('Sukses ! Data berhasil diperbarui .. ');
                  window.location ='?pages=dosen';   
                  </script>";
                  }else{
                  echo '<div class="alert alert-danger bg-gradient-danger text-white" id="alert">PESAN TIDAK TERKIRIM: Periksa kembali isi pesan anda ..</div>';
                  }

                  }else{
                  echo '<div class="alert alert-danger bg-gradient-danger text-white" id="alert">ERROR: Ukuran File terlalu besar, Maksimal 2 MB</div>';
                  }
                  }else{
                  echo '<div class="alert alert-danger bg-gradient-danger text-white" id="alert">ERROR: Ekstensi file tidak di izinkan!</div>';
                  }

                  }


                  }

                  ?>
                  <!-- END SCRIPT EDIT DATA DOSEN -->
                </div>
                </div>
                </div>


             

                </div>
              </div>
            </div>
            </div>

<script type="text/javascript">
// Popup modal edit
function confirm_modal_edit(){
$(document).on('click','#select', function() {
$('#modal_update').modal('show', {backdrop: 'static'});
var id      = $(this).data('id');
var nip = $(this).data('nip');
var nama = $(this).data('nama');
var jabatan = $(this).data('jabatan');
var foto = $(this).data('foto');
$('#id1').val(id);
$('#nip1').val(nip);
$('#nipnya').val(nip);
$('#nama1').val(nama);
$('#jabatan1').val(jabatan);
$('#foto1').val(foto);
})
}
</script> 
  <div class="d-sm-flex align-items-center justify-content-between">
  <h1 class="h3 mb-0 text-gray-800">Fakultas</h1>
  <ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="./">Home</a></li>
  <li class="breadcrumb-item">Akademik</li>
  <li class="breadcrumb-item active" aria-current="page">Fakultas</li>
  </ol>
  </div>

<?php 
if (isset($_SESSION['ADMIN_SESS'])) {
// cek sebelum hapus data
if (isset($_GET['id'])) {
$id =intval($_GET['id']);
$is_del=mysqli_query($con,"DELETE FROM tm_fakultas WHERE fakultas_id={$id} ");

if ($is_del) {
echo "
<script>
alert('Data Fakultas Telah dihapus !');
window.location ='?pages=fakultas';   
</script>";
}else{
echo "
<script>
alert('Oppss ! Data Fakultas Gagal dihapus !')
window.location ='?pages=fakultas';   
</script>";
}



}
}


?>
<div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header bg-gradient-primary text-white">
                  <h6 class="mt-3 font-weight-bold"><i class="fa fa-graduation-cap"></i> Daftar Fakultas</h6>
                  <a href="#" data-toggle="modal"
                    data-target="#modalAdd" id="#modalAdd" class="btn btn-default text-white btn-sm btn-icon-split mt-2">
                    <span class="icon text-white-50">
                      <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">New Fakultas</span>
                  </a>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-hover table-sm align-items-center table-flush">
                    <thead class="table-flush">
                      <tr style="text-transform: uppercase;">
                        <th>No</th>
                        <th>Nama Fakultas</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $no=1;
                      $sql = mysqli_query($con,"SELECT * FROM tm_fakultas ORDER BY fakultas_id  ASC");
                      foreach ($sql as $d) {?>
                      <tr>
                        <td><?=$no++?></td>
                        <td><b><?=$d['fakultas'] ?></b></td>
                          <td>
                          <button id="select" onclick="confirm_modal_edit()" data-id="<?= $d['fakultas_id'] ?>" data-fakultas="<?= $d['fakultas'] ?>"
                            class="btn btn-primary bg-gradient-primary btn-sm">
                          <i class="fas fa-edit"></i>
                          </button>
                          <a href="?pages=fakultas&id=<?= $d['fakultas_id'] ?>" onclick="return confirm ('Apakah Yakin ?')" class="btn btn-danger bg-gradient-danger btn-sm"><i class="fa fa-trash"></i></a>
                             
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
                <h5 class="modal-title" id="modalAdd"><i class="fa fa-plus"></i> New Fakultas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form method="POST">
                <div class="modal-body">
                <div class="form-group">
                <label for="">Nama Fakultas</label>
                <input type="text" name="fakultas" class="form-control" placeholder="Ex : MIPA" required>
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
                $fakName  = mysqli_real_escape_string($con,$_POST['fakultas']);
                // Cek jika inputan kosong
                if ($fakName=="") {
                    echo "
                    <script>
                    alert ('Opss ! Inputan Tidak Boleh Kosong !');
                    window.location ='?pages=fakultas';   
                    </script>";
                }else{
                $cekRowId = mysqli_num_rows(mysqli_query($con,"SELECT fakultas FROM tm_fakultas WHERE fakultas='{$fakName}'"));
                // jika periode belum ada, tambahkan periode baru
                  if ($cekRowId < 1) {
                  mysqli_query($con,"INSERT INTO tm_fakultas (fakultas) VALUES ('$fakName') ");
                    echo "
                    <script>
                    alert('Fakultas Telah Ditambahkan !');
                    window.location ='?pages=fakultas';   
                    </script>";
                  }else{
                    // tampilakn pesan jika periode yag sama sudah ada
                    echo "
                    <script>
                    alert('Ops ! Data Fakultas sudah ada !');
                    window.location ='?pages=fakultas';   
                    </script>";
                  }

                }
              }

                ?>
                <!-- END SCRIPT SIMPAN DATA FAKULTAS -->
                </div>
                </div>
                </div>


               <!-- Modal edit -->
          <div class="modal fade" id="modal_update" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title"><i class="fa fa-edit"></i> Edit Fakultas</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form method="POST">
                <div class="modal-body">
                  <input name="id" type="hidden" id="id">
                  <div class="form-group">
                  <label for="">Tahun Akademik</label>
                  <input name="fakultas" type="text" id="fakultas" class="form-control">
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-danger" data-dismiss="modal"><i class="fa fa-times"></i>Cancel</button>
                  <button type="submit" name="update" class="btn btn-info bg-gradient-info"><i class="fa fa-edit"></i>Update</button>
                </div>
                </form>
                  <!-- SCRIPT EDIT DATA PERIODE -->
                  <?php 
                  if (isset($_POST['update'])) {
                  $id  = mysqli_real_escape_string($con,$_POST['id']);
                  $fakultas  = mysqli_real_escape_string($con,$_POST['fakultas']);
                  if ($tp=="") {
                  echo "
                  <script>
                  alert('Ops ! Inputan Tidak Boleh Kosong !'); 
                  window.location ='?pages=fakultas';  
                  </script>";
                  }else{
                  $cekRowId = mysqli_num_rows(mysqli_query($con,"SELECT fakultas FROM tm_fakultas WHERE fakultas='{$fakultas}' "));
                  if ($cekRowId < 1) {
                  mysqli_query($con,"UPDATE tm_fakultas SET fakultas='{$fakultas}' WHERE fakultas_id={$id} ");
                  echo "
                  <script>
                  alert('Yes ! Fakultas Telah Diperbarui !'); 
                  window.location ='?pages=fakultas';  
                  </script>";

                  }else{
                  echo "
                  <script>
                  alert('Ops ! Data Fakultas sudah ada !');  
                  window.location ='?pages=fakultas'; 
                  </script>";
                  }

                  }
                  }

                  ?>

                  <!-- END SCRIPT EDIT DATA PERIODE -->
              </div>
            </div>
          </div>

                </div>
              </div>
            </div>
            </div>
<!-- Javascript untuk popup modal Delete-->
<script type="text/javascript">
  // Konfirmasi Hapus Data
function confirm_modal(delete_url){
$('#modal_delete').modal('show', {backdrop: 'static'});
document.getElementById('delete_link').setAttribute('href' , delete_url);
}

// Popup modal edit
function confirm_modal_edit(){
$(document).on('click','#select', function() {
$('#modal_update').modal('show', {backdrop: 'static'});
var id      = $(this).data('id');
var fakultas = $(this).data('fakultas');
$('#id').val(id);
$('#fakultas').val(fakultas);
})
}
</script> 


          
            
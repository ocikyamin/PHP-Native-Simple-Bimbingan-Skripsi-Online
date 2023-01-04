  <div class="d-sm-flex align-items-center justify-content-between">
  <h1 class="h3 mb-0 text-gray-800">Prodi</h1>
  <ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="./">Home</a></li>
  <li class="breadcrumb-item">Akademik</li>
  <li class="breadcrumb-item active" aria-current="page">Prodi</li>
  </ol>
  </div>

<?php 
if (isset($_SESSION['ADMIN_SESS'])) {
// cek sebelum hapus data
if (isset($_GET['id'])) {
$id =intval($_GET['id']);
$is_del=mysqli_query($con,"DELETE FROM tm_prodi WHERE prodi_id={$id} ");
if ($is_del) {
echo "
<script>
alert('Data Prodi Telah dihapus !');
window.location ='?pages=prodi';   
</script>";
}else{
echo "
<script>
alert('Oppss ! Data Prodi Gagal dihapus !')
window.location ='?pages=prodi';   
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
                  <h6 class="mt-3 font-weight-bold"><i class="fa fa-graduation-cap"></i> Daftar Prodi</h6>
                  <a href="#" data-toggle="modal"
                    data-target="#modalAdd" id="#modalAdd" class="btn btn-default text-white btn-sm btn-icon-split mt-2">
                    <span class="icon text-white-50">
                      <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">New Prodi</span>
                  </a>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-hover table-sm align-items-center table-flush">
                    <thead class="table-flush">
                      <tr style="text-transform: uppercase;">
                        <th>No</th>
                        <th>Fakultas</th>
                        <th>Nama Prodi</th>
                        <th>Konsentrasi</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $no=1;
                      $sql = mysqli_query($con,"SELECT * FROM tm_prodi
                       JOIN tm_fakultas ON tm_prodi.fakultas_id=tm_fakultas.fakultas_id
                      ORDER BY prodi_id  ASC");
                      foreach ($sql as $d) {?>
                      <tr>
                        <td><?=$no++?></td>
                        <td><b><?=$d['fakultas'] ?></b></td>
                        <td><b><?=$d['prodi'] ?></b></td>
                        <td><?=$d['konsen'] ?></td>
                          <td>
                          <a href="#" data-toggle="modal" data-target="#modalEdit<?= $d['prodi_id'] ?>" class="btn btn-primary bg-gradient-primary btn-sm">
                          <i class="fas fa-edit"></i>
                          </a>
                          <a href="?pages=prodi&id=<?= $d['prodi_id'] ?>" onclick="return confirm ('Apakah Yakin ?')" class="btn btn-danger bg-gradient-danger btn-sm"><i class="fa fa-trash"></i></a>

                          <div class="modal fade" id="modalEdit<?= $d['prodi_id'] ?>" tabindex="-1" role="dialog"
                aria-labelledby="modalEdit" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="modalEdit"><i class="fa fa-edit"></i> Edit Prodi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form method="POST">
                  <input type="hidden" name="id" value="<?= $d['prodi_id'] ?>">
                <div class="modal-body">
                    <div class="form-group">
                    <label for="fakultas">Fakultas</label>
                    <select name="fakultas" id="fakultas" class="form-control">
                    <option value="">Pilih Fakultas</option>
                    <?php 
                    $fakultas = mysqli_query($con,"SELECT * FROM tm_fakultas ORDER BY fakultas_id ASC ");
                    foreach ($fakultas as $f) {
                    if ($f['fakultas_id']==$d['fakultas_id']) {
                    $selected = 'selected';
                    }else{
                    $selected = '';
                    }
                    echo "<option value='$f[fakultas_id]' $selected>$f[fakultas]</option>";
                    }
                    ?>
                    </select>
                    </div>
                    <div class="form-group">
                    <label for="prodi">Nama Prodi</label>
                    <input type="text" id="prodi" name="prodi" class="form-control" value="<?= $d['prodi'] ?>"  required>
                    </div>
                    <div class="form-group">
                    <label for="konsen">Konsentrasi</label>
                    <input type="text" id="konsen" name="konsen" class="form-control" value="<?= $d['konsen'] ?>"  required>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                <button name="update" type="submit" class="btn btn-primary bg-gradient-primary"><i class="fa fa-check"></i> Save</button>
                </div>
                </form>
                <!-- SCRIPT SIMPAN DATA FAKULTAS -->
                <?php 
                if (isset($_POST['update'])) {
                  $id = intval($_POST['id']);
                $fakID = intval($_POST['fakultas']);
                $prodi  = htmlspecialchars($_POST['prodi']);
                $konsen  = htmlspecialchars($_POST['konsen']);
                echo "<pre>";
                print_r ($_POST);
                echo "</pre>";

                    // Cek jika inputan kosong
                if ($prodi=="" || $konsen=="") {
                    echo "
                    <script>
                    alert ('Opss ! Inputan Tidak Boleh Kosong !');
                    window.location ='?pages=prodi';   
                    </script>";
                }else{
                $cekRowId = mysqli_num_rows(mysqli_query($con,"SELECT prodi FROM tm_prodi WHERE prodi='{$prodi}' AND konsen='$konsen' "));
                // jika periode belum ada, tambahkan periode baru
                  if ($cekRowId < 1) {
                  mysqli_query($con,"UPDATE tm_prodi SET fakultas_id='$fakID',prodi='$prodi',konsen='$konsen' WHERE prodi_id=$id ");
                    echo "
                    <script>
                    alert('Prodi Telah Diperbarui ..');
                    window.location ='?pages=prodi';   
                    </script>";
                  }else{
                    // tampilakn pesan jika periode yag sama sudah ada
                    echo "
                    <script>
                    alert('Ops ! Data Prodi sudah ada !');
                    window.location ='?pages=prodi';   
                    </script>";
                  }

                }
            
              }

                ?>
                <!-- END SCRIPT SIMPAN DATA FAKULTAS -->
                </div>
                </div>
                </div>


                             
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
                <h5 class="modal-title" id="modalAdd"><i class="fa fa-plus"></i> New Prodi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form method="POST">
                <div class="modal-body">
                  <div class="form-group">
                <label for="fakultas">Fakultas</label>
                  <select name="fakultas" id="fakultas" class="form-control">
                    <option value="">Pilih Fakultas</option>
                    <?php 
                    $fakultas = mysqli_query($con,"SELECT * FROM tm_fakultas ORDER BY fakultas_id ASC ");
                    foreach ($fakultas as $f) {
                        echo "<option value='$f[fakultas_id]'>$f[fakultas]</option>";
                    }

                     ?>
                  </select>
                </div>
                <div class="form-group">
                <label for="prodi">Nama Prodi</label>
                <input type="text" id="prodi" name="prodi" class="form-control" placeholder="Ex : Teknik Elektro" required>
                </div>

                 <div class="form-group">
                    <label for="konsen">Konsentrasi</label>
                    <input type="text" id="konsen" name="konsen" class="form-control" placeholder="Ex : Teknik Informatika"  required>
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
                $fakID = intval($_POST['fakultas']);
                $prodi  = htmlspecialchars($_POST['prodi']);
                $konsen  = htmlspecialchars($_POST['konsen']);
                // Cek jika inputan kosong
                if ($prodi=="" || $konsen=="") {
                    echo "
                    <script>
                    alert ('Opss ! Inputan Tidak Boleh Kosong !');
                    window.location ='?pages=prodi';   
                    </script>";
                }else{
                $cekRowId = mysqli_num_rows(mysqli_query($con,"SELECT prodi FROM tm_prodi WHERE prodi='{$prodi}' AND konsen='{$konsen}' "));
                // jika periode belum ada, tambahkan periode baru
                  if ($cekRowId < 1) {
                  mysqli_query($con,"INSERT INTO tm_prodi (fakultas_id,prodi,konsen) VALUES ('$fakID','$prodi','$konsen') ");
                    echo "
                    <script>
                    alert('Prodi Telah Ditambahkan !');
                    window.location ='?pages=prodi';   
                    </script>";
                  }else{
                    // tampilakn pesan jika periode yag sama sudah ada
                    echo "
                    <script>
                    alert('Ops ! Data Prodi sudah ada !');
                    window.location ='?pages=prodi';   
                    </script>";
                  }

                }
              }

                ?>
                <!-- END SCRIPT SIMPAN DATA FAKULTAS -->
                </div>
                </div>
                </div>
                
                </div>
                 </div>
                  </div>
                   </div>


              

          
            
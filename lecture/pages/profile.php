<div class="d-sm-flex align-items-center justify-content-between">
<h1 class="h3 mb-0 text-gray-800">Profile</h1>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="./">Profile</a></li>
  <li class="breadcrumb-item">Profile</li>
</ol>
</div>
    <!-- SCRIPT EDIT DATA DOSEN -->
                  <?php 
                  if (isset($_POST['update'])) {
                  $array    = array('jpg','jpeg','png');
                   $id      = intval($_POST['id']);
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
                  window.location ='?pages=profile';   
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
                  window.location ='?pages=profile';   
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
<div class="row">
  <div class="col-lg-4">
    <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Update Profile</h6>
                </div>
                <div class="card-body">
                  <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $user['id_dsn'] ?>">
                    <input type="hidden" name="nip" value="<?= $user['nip'] ?>">
                    <input type="hidden" name="foto" value="<?= $user['foto'] ?>">
                    <div class="form-group">
                      <label for="nip">NIP/NIDN</label>
                      <input type="text" class="form-control" id="nip" value="<?= $user['nip'] ?>" disabled>
                    </div>
                      <div class="form-group">
                      <label for="nama">Nama Lengkap & Gelar</label>
                      <input type="text" name="nama" class="form-control" id="nama" value="<?= $user['nama_dosen'] ?>">
                      </div>
                      <div class="form-group">
                      <label for="jabatan">Jabatan</label>
                      <input type="text" name="jabatan" class="form-control" id="jabatan" value="<?= $user['jabatan'] ?>">
                      </div>
                         
                      
                    <div class="form-group">
                      <p>
                        <center>
                          <img src="../apl/img/dosen/<?= $user['foto'] ?>" class="img-thumbnail" style="width: 120px; height:120px;border-radius: 100%">
                        </center>
                      </p>
                      <div class="custom-file">
                        <input type="file" name="file" class="custom-file-input" id="customFile">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                      </div>
                    </div>
                 
                    <button name="update" type="submit" class="btn btn-primary btn-block bg-gradient-primary text-white"> <i class="fa fa-check"></i> Update Profile</button>
                  </form>

                </div>
              </div>
            </div>
</div>

  
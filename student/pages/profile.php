<div class="d-sm-flex align-items-center justify-content-between">
<h1 class="h3 mb-0 text-gray-800">Profile</h1>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="./">Profile</a></li>
  <li class="breadcrumb-item">Profile</li>
</ol>
</div>
<!-- SCRIPT EDIT DATA MAHASIWA -->
                  <?php 
                  if (isset($_POST['update'])) {
                  
                          $array    = array('jpg','jpeg','png');
                  $id    = intval($_POST['id']);
                  $nim   = htmlspecialchars($_POST['nim']);
                  $nama  = htmlspecialchars($_POST['nama']);
                  $tmp_lahir  = htmlspecialchars($_POST['tmp_lahir']);
                  $tgl_lahir  = htmlspecialchars($_POST['tgl_lahir']);
                  $tahun = htmlspecialchars($_POST['tahun']);
                  $prodi  = $_POST['prodi'];
                  $foto  = $_POST['foto']; 
                  // Post file
                  $filenama = $nim.'_'.time();
                  $file_name    = $_FILES['file']['name'];
                  @$file_ext     = strtolower(end(explode('.', $file_name)));
                  $file_size    = $_FILES['file']['size'];
                  $file_tmp     = $_FILES['file']['tmp_name'];
                  $gambar = $filenama.'.'.$file_ext;

                  if ($file_name=="") {
                  mysqli_query($con,"UPDATE tb_mhs SET nama='$nama',tmp_lahir='$tmp_lahir',tg_lahir='$tgl_lahir', tahun_angkatan='$tahun',prodi_id='$prodi' WHERE id_mhs=$id ");
                  echo "
                  <script> alert ('Sukses ! Data berhasil diperbarui .. ');
                  window.location ='?pages=profile';   
                  </script>";
                  }else{
                  // jika pesan melampirkan file
                  if(in_array($file_ext, $array) === true){
                  if($file_size < 2000000){
                  $lokasi = '../apl/img/'.$filenama.'.'.$file_ext;
                  move_uploaded_file($file_tmp, $lokasi);
                  $is_update= mysqli_query($con,"UPDATE tb_mhs SET nama='$nama',tmp_lahir='$tmp_lahir',tg_lahir='$tgl_lahir',fotomhs='$gambar',tahun_angkatan='$tahun',prodi_id='$prodi' WHERE id_mhs=$id ");
                  if ($is_update) {
                      if ($foto !=="user.png") {
                      $doc ="../apl/img/".$foto."";
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
                  <!-- END SCRIPT EDIT DATA MAHASIWA -->
<div class="row">
  <div class="col-lg-4">
    <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Update Profile</h6>
                </div>
                <div class="card-body">
                  <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $user['id_mhs'] ?>">
                    <input type="hidden" name="nim" value="<?= $user['nim'] ?>">
                    <input type="hidden" name="foto" value="<?= $user['fotomhs'] ?>">
                    <div class="form-group">
                      <label for="nim">NIM (Nomor Induk Mahasiswa)</label>
                      <input type="text" class="form-control" id="nim" value="<?= $user['nim'] ?>" disabled>
                    </div>
                      <div class="form-group">
                      <label for="nama">Nama Lengkap</label>
                      <input type="text" name="nama" class="form-control" id="nama" value="<?= $user['nama'] ?>">
                      </div>
                       <div class="form-group">
                      <label for="tmp">Tempat Lahir</label>
                      <input type="text" name="tmp_lahir" class="form-control" id="tmp" value="<?= $user['tmp_lahir'] ?>">
                      </div>
                          <div class="form-group">
                      <label for="tgl_lahir">Tanggal Lahir</label>
                      <input type="date" name="tgl_lahir" class="form-control" id="tgl_lahir" value="<?= date('Y-m-d',strtotime($user['tg_lahir'])) ?>">
                      </div>
                      <div class="form-group">
                      <label for="tahun">Tahun Masuk</label>
                      <input type="number" name="tahun" class="form-control" id="tahun" value="<?= $user['tahun_angkatan'] ?>">
                      </div>

                         <div class="form-group">
                    <label for="prodi">Prodi</label>
                    <select name="prodi" id="prodi" class="form-control">
                    <?php 
                    $prodi = mysqli_query($con,"SELECT * FROM tm_prodi ORDER BY prodi_id ASC ");
                    foreach ($prodi as $f) {
                    if ($f['prodi_id']==$user['prodi_id']) {
                    $selected = 'selected';
                    }else{
                    $selected = '';
                    }
                    echo "<option value='$f[prodi_id]' $selected>$f[prodi]</option>";
                    }
                    ?>
                    </select>
                    </div>
                         
                      
                    <div class="form-group">
                      <p>
                        <center>
                          <img src="../apl/img/<?= $user['fotomhs'] ?>" class="img-thumbnail" style="width: 120px; height:120px;border-radius: 100%">
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

  
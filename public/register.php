 <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <ol>
          <li><a href="./">Home</a></li>
          <li>Register</li>
        </ol>
        <h2>Buat Akun Mahasiswa</h2>

      </div>
    </section><!-- End Breadcrumbs -->

    <section class="inner-page">
      <div class="container">
        <div class="row">
          <div class="col-lg-2"></div>
          <div class="col-lg-8">
              <div class="card">
              <div class="card-header">
              <h5>Persyaratan</h5>
              </div>
              <div class="card-body">
              <div class="alert alert-info">
                <?php 
                foreach ($result as $d):?>
                  <b><?= $d['judul'] ?></b> - <?= $d['isi'] ?> <br>
                <?php endforeach; ?>


              </div> 
              </div>
              </div>
              <div class="card mt-3">
              <div class="card-body">
<?php 
if (isset($_POST['daftar'])) {
$nama       = htmlspecialchars($_POST['nm_mhs']);
$nim        = htmlspecialchars($_POST['nim']);
$password   = htmlspecialchars($_POST['password']);
$secondpass = htmlspecialchars($_POST['secondpass']);
$tahun      = htmlspecialchars($_POST['tahun']);
$ok         = htmlspecialchars($_POST['ok']);
$prodi         = htmlspecialchars($_POST['prodi']);
$tgl = date('Y-m-d H:i:s');

// membuat SESSION masing2 inputan
$_SESSION['nama']       = $nama;
$_SESSION['nim']        = $nim; 
$_SESSION['password']   = $password;
$_SESSION['secondpass'] = $secondpass;
$_SESSION['tahun'] = $tahun;
$_SESSION['prodi'] = $prodi;

// cek jika inputan kosong
if ($nama=="" || $nim=="" || $password=="" || $secondpass=="" || $tahun=="" || $ok=="") {
echo '<div class="alert alert-danger" id="alert">
Inputan Tidak Boleh Kossong / Anda harus setuju dengan persayaratan ...
</div>';
}else{
// cek jika password tidak sama
if ($password == $secondpass) {
$newPassFix = sha1($secondpass);
$cekRowId = mysqli_num_rows(mysqli_query($con,"SELECT `nim`,`password` FROM `tb_mhs` WHERE `nim`='{$nim}' OR `password`='{$newPassFix}'  "));
if ($cekRowId < 1) {
// buat akun baru
$insert= mysqli_query($con,"INSERT INTO tb_mhs (nim,nama,password,tahun_angkatan,prodi_id,create_at) VALUES ('$nim','$nama','$newPassFix','$tahun','$prodi','$tgl') ");
unset($_SESSION['nis']);
if ($insert) {
// unset($_SESSION['nama']);
// unset($_SESSION['nim']);
// unset($_SESSION['password']);
// unset($_SESSION['secondpass']);
// unset($_SESSION['tahun']);
// unset($_SESSION['prodi']);
  session_destroy();

// echo '<div class="alert alert-success" id="alert">

// </div>';
  echo "  <script>
  alert('Akun Berhasil didaftarkan .. Silahkan menunggu data anda akan diperiksa oleh admin sistem ..');
  window.location='start/';
  </script>";
}





}else{

echo '<div class="alert alert-danger" id="alert">
NIM / Password Sudah terdaftar ...
</div>';
}

}else{
echo '<div class="alert alert-danger" id="alert">
Konfirmasi Password Tidak sama ...
</div>';
}




}
}


?>

            <form action="" method="post">
              <div  role="form" class="php-email-form">
              <div class="row">
                <div class="form-group col-md-6">
                  <input type="text" name="nm_mhs" class="form-control mt-2" placeholder="Nama Lengkap Anda .." value="<?php if (!empty($_SESSION['nama'])) { echo $_SESSION['nama'];}?>" required>
                </div>
                <div class="form-group col-md-6">
                   <input type="number" name="nim" class="form-control mt-2" placeholder="Nomor Induk Mahasiswa.." value="<?php if (!empty($_SESSION['nim'])) { echo $_SESSION['nim'];}?>" required>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 form-group">
                  <input type="text" name="password" class="form-control mt-2" placeholder="Password Baru .." value="<?php if (!empty($_SESSION['password'])) { echo $_SESSION['password'];}?>" required>
                </div>
                <div class="col-md-6 form-group">
                  <input type="text" name="secondpass" class="form-control mt-2" placeholder="Confirmasi Password.." value="<?php if (!empty($_SESSION['secondpass'])) { echo $_SESSION['secondpass'];}?>" required>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 form-group">
                         <?php
                      $now=date('Y');
                      echo "<select name='tahun' class='form-control mt-2' required>
                      <option value=''>Tahun Masuk</option>
                      ";
                      for ($a=2013;$a<=$now;$a++)
                      {
                      if (!empty($_SESSION['tahun'])) {
                      if ($_SESSION['tahun']==$a) {
                      $selected ="selected";
                      }else{
                      $selected="";
                      }
                      }
                      echo "<option value='$a' $selected>$a</option>";
                      }
                      echo "</select>";
                      ?>
                </div>
                <div class="col-md-6 form-group">
                  <select name="prodi" class="form-control mt-2">
                    <option value="">Pilih Prodi</option>
                      <?php 
                      $prodi = mysqli_query($con,"SELECT prodi_id,prodi,konsen FROM tm_prodi ORDER BY prodi_id ASC ");
                      foreach ($prodi as $p) {
                      if (!empty($_SESSION['prodi'])) {
                      if ($_SESSION['prodi']==$p['prodi_id']) {
                      $selected ="selected";
                      }else{
                      $selected="";
                      }
                      }
                      echo "<option value='$p[prodi_id]' $selected>$p[prodi] - $p[konsen]</option>";
                      }

                      ?>
                  </select>
                </div>
                  <div class="col-md-12 form-group mt-3">
                    <label for="ok"> 
                      <input type="checkbox" name="ok" id="ok"> Saya Setuju dan Telah memenuhi Persayaratan
                    </label>
                   
                </div>
                <div class="col-md-12 form-group mt-3 mb-5">
                  <button name="daftar" type="submit" class="btn btn-success"><i class="bx bx-check"></i> Daftar</button>
                   <a href="./start/"> Sudah Punya Akun</a>
                   
                </div>
              </div>

            </div>
            </form>
          </div>
        </div>


            
          </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->

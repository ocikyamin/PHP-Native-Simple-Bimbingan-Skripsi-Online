<div class="d-sm-flex align-items-center justify-content-between">
    <h1 class="h3 mb-0 text-gray-800">Password</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="./">Home</a></li>
        <li class="breadcrumb-item">Password</li>
    </ol>
</div>
<?php
// poses ubah data user
if (isset($_POST['update'])) {
  $pass = sha1($_POST['pass']);
  // JIKA TIDAK MERUBAH PASSWORD
  if (!empty($_POST['pass'])) {
    // JIKA MERUBAH PASSWORD
    mysqli_query($con, "UPDATE tb_dsn SET password='$pass' WHERE id_dsn='$userID' ");
    echo " <script>
                alert('Data berhasil diubah');
                window.location='./';
               </script>";
  }
}


?>
<div class="row">
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Change Password</h6>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <!-- <input type="hidden" name="id" value="<?= $user['id_dsn'] ?>"> -->

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" onclick="EnableDisableTextBox(this)" class="custom-control-input"
                                id="chkPassport">
                            <label class="custom-control-label" for="chkPassport">Ganti Password ?</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <input name="pass" type="password" class="form-control" id="txtPassportNumber"
                            disabled="disabled" placeholder="New Password..">
                    </div>


                    <button name="update" type="submit"
                        class="btn btn-warning btn-block bg-gradient-warning text-white"> <i class="fa fa-key"></i> Save
                        & Change</button>
                </form>

            </div>
        </div>
    </div>
</div>
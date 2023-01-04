  <div class="d-sm-flex align-items-center justify-content-between">
      <h1 class="h3 mb-0 text-gray-800">Periode</h1>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="./">Home</a></li>
          <li class="breadcrumb-item">Akademik</li>
          <li class="breadcrumb-item active" aria-current="page">Periode</li>
      </ol>
  </div>

  <?php
  if (isset($_SESSION['ADMIN_SESS'])) {
    // cek sebelum hapus data
    if (isset($_GET['id'])) {
      $id = intval($_GET['id']);
      $is_del = mysqli_query($con, "DELETE FROM tm_periode WHERE periode_id={$id} ");
      echo "<pre>";
      print_r($is_del);
      echo "</pre>";
      if ($is_del) {
        echo "
<script>
alert('Data Periode Telah dihapus !')
window.location ='?pages=periode';);   
</script>";
      } else {
        echo "
<script>
alert('Oppss ! Data Periode Gagal dihapus !')
window.location ='?pages=periode');   
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
                  <h6 class="mt-3 font-weight-bold"><i class="fa fa-graduation-cap"></i> Periode Akademik</h6>
                  <a href="#" data-toggle="modal" data-target="#modalAdd" id="#modalAdd"
                      class="btn btn-default text-white btn-sm btn-icon-split mt-2">
                      <span class="icon text-white-50">
                          <i class="fas fa-plus"></i>
                      </span>
                      <span class="text">New Periode</span>
                  </a>
              </div>
              <div class="table-responsive">
                  <table class="table table-striped table-hover table-sm align-items-center table-flush">
                      <thead class="table-flush">
                          <tr style="text-transform: uppercase;">
                              <th>No</th>
                              <th>Tahun Akademik</th>
                              <th>Status</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php
              $no = 1;
              $sql = mysqli_query($con, "SELECT * FROM tm_periode ORDER BY periode_id  ASC");
              foreach ($sql as $d) { ?>
                          <tr>
                              <td><?= $no++ ?></td>
                              <td><b><?= $d['th_periode'] ?></b></td>
                              <td>
                                  <div class="form-group">
                                      <div class="custom-control custom-switch">
                                          <input name="stt" data-iddata="<?= $d['periode_id'] ?>"
                                              data-sttdata="<?= $d['stt_periode'] ?>" type="checkbox"
                                              onClick="confirm_set_stt('?pages=periode&periode_target=<?= $d['periode_id']; ?>');"
                                              class="custom-control-input stt" id="<?= $d['periode_id'] ?>"
                                              <?php if ($d['stt_periode'] == 'on') {
                                                                                                                                                                                                                                                                                              echo "checked";
                                                                                                                                                                                                                                                                                            } ?>>
                                          <label class="custom-control-label" for="<?= $d['periode_id'] ?>">
                                              <?php
                          if ($d['stt_periode'] == 'on') {
                            echo "<span class='badge badge-success bg-gradient-success'><i class='fa fa-check'></i> Aktif</span>";
                          } else {
                            echo "<span class='badge badge-danger bg-gradient-danger'><i class='fa fa-times'></i> Nonaktif</span>";
                          }
                          ?>
                                          </label>
                                      </div>
                                  </div>
                              </td>
                              <td>
                                  <button id="select" onclick="confirm_modal_edit()" data-id="<?= $d['periode_id'] ?>"
                                      data-periode="<?= $d['th_periode'] ?>"
                                      class="btn btn-primary bg-gradient-primary btn-sm">
                                      <i class="fas fa-edit"></i>
                                  </button>
                                  <?php
                    if ($d['stt_periode'] !== 'on') {
                    ?>
                                  <a href="#" onClick="confirm_modal('?pages=periode&id=<?= $d['periode_id']; ?>');"
                                      class="btn btn-danger btn-sm">
                                      <i class="fas fa-trash"></i>
                                  </a>
                                  <?php
                    }

                    ?>
                              </td>
                          </tr>
                          <?php } ?>


                      </tbody>
                  </table>

                  <!-- Modal Tambah -->
                  <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalAdd"
                      aria-hidden="true">
                      <div class="modal-dialog modal-dialog-scrollable" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="modalAdd"><i class="fa fa-plus"></i> New Periode</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                              <form method="POST">
                                  <div class="modal-body">
                                      <div class="form-group">
                                          <label for="">Tahun Akademik</label>
                                          <input type="text" name="tp" class="form-control" placeholder="2021/2022"
                                              required>
                                      </div>
                                  </div>
                                  <div class="modal-footer">
                                      <button type="button" class="btn btn-outline-danger" data-dismiss="modal"><i
                                              class="fa fa-times"></i> Close</button>
                                      <button name="submit" type="submit" class="btn btn-primary bg-gradient-primary"><i
                                              class="fa fa-check"></i> Save</button>
                                  </div>
                              </form>
                              <!-- SCRIPT SIMPAN DATA PERIODE -->
                              <?php
                if (isset($_POST['submit'])) {
                  $tp  = $_POST['tp'];
                  // Cek jika inputan kosong
                  if ($tp == "") {
                    echo "
                    <script>
                    alert ('Opss ! Inputan Tidak Boleh Kosong !');
                    window.location ='?pages=periode';   
                    </script>";
                  } else {
                    $cekRowId = mysqli_num_rows(mysqli_query($con, "SELECT th_periode FROM tm_periode WHERE th_periode='{$tp}'"));
                    // jika periode belum ada, tambahkan periode baru
                    if ($cekRowId < 1) {
                      mysqli_query($con, "INSERT INTO `tm_periode`(`th_periode`) VALUES ('$tp') ");
                      echo "
                    <script>
                    alert('Periode Telah Ditambahkan !');
                    window.location ='?pages=periode';   
                    </script>";
                    } else {
                      // tampilakn pesan jika periode yag sama sudah ada
                      echo "
                    <script>
                    alert('Ops ! Data Periode sudah ada !');
                    window.location ='?pages=periode';   
                    </script>";
                    }
                  }
                }

                ?>
                              <!-- END SCRIPT SIMPAN DATA PERIODE -->
                          </div>
                      </div>
                  </div>

                  <!-- Modal Hapus -->
                  <div class="modal fade" id="modal_delete" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i> Anda yakin akan
                                      menghapus data ? </h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                              <div class="modal-body">
                                  <p>
                                      Tindakan ini akan menghapus data secara permanent, anda tidak dapat megembalikan
                                      data jika sudah terhapus, Klik <b>Hapus</b> untuk Menghapus data, klik
                                      <b>Cancel</b> untuk Batal
                                  </p>
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-outline-primary"
                                      data-dismiss="modal">Cancel</button>
                                  <a href="#" id="delete_link" class="btn btn-danger">Hapus</a>
                              </div>
                          </div>
                      </div>
                  </div>

                  <!-- Modal Set Status -->
                  <div class="modal fade" id="modal_set_stt" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title">
                                      <span id="ikon"></span>
                                      <b id="aktif"></b> Status Periode ?
                                  </h5>
                              </div>
                              <div class="modal-body">
                                  <p id="pesan"></p>
                                  <form method="POST">
                                      <input type="hidden" name="id" id="idset">
                                      <input type="hidden" name="stt" id="sttdata">
                                      <center>
                                          <button type="button" class="btn btn-outline-primary"
                                              data-dismiss="modal">Cancel</button>
                                          <span id="tombol"></span>
                                      </center>
                                  </form>
                                  <?php
                  if (isset($_POST['set_stt'])) {

                    $id = mysqli_real_escape_string($con, $_POST['id']);
                    $stt = mysqli_real_escape_string($con, $_POST['stt']);
                    if ($stt == "on") {
                      // nonaktifkan

                      $stt_off = mysqli_query($con, "UPDATE tm_periode SET stt_periode='0' WHERE periode_id={$id} ");
                      echo "
                      <script>
                      window.location ='?pages=periode'; 
                      </script>";
                    } else {
                      // aktifkan
                      // cek jika  ada yg aktif
                      $sql_stt = mysqli_query($con, "SELECT stt_periode FROM tm_periode WHERE stt_periode='on' ");
                      if (mysqli_num_rows($sql_stt) > 0) {
                        // non aktifkan status yg ada
                        $old_stt = mysqli_query($con, "UPDATE tm_periode SET stt_periode=0 ");
                        // aktifkan yg baru  
                        $new_stt = mysqli_query($con, "UPDATE tm_periode SET stt_periode='on' WHERE periode_id={$id} ");
                        echo "
                      <script>
                      window.location ='?pages=periode'; 
                      </script>";
                      } else {
                        // aktifkan yg baru  
                        $new_stt = mysqli_query($con, "UPDATE tm_periode SET stt_periode='on' WHERE periode_id={$id} ");

                        echo "
                      <script>
                      window.location ='?pages=periode';  
                      </script>";
                      }
                    }
                  }

                  ?>
                              </div>

                          </div>
                      </div>
                  </div>

                  <!-- Modal Hapus -->
                  <div class="modal fade" id="modal_update" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title"><i class="fa fa-edit"></i> Edit Periode</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                              <form method="POST">
                                  <div class="modal-body">
                                      <input name="id" type="hidden" id="idnya">
                                      <div class="form-group">
                                          <label for="">Tahun Akademik</label>
                                          <input name="periode" type="text" id="periodenya" class="form-control">
                                      </div>
                                  </div>
                                  <div class="modal-footer">
                                      <button type="button" class="btn btn-outline-danger" data-dismiss="modal"><i
                                              class="fa fa-times"></i>Cancel</button>
                                      <button type="submit" name="update" class="btn btn-info bg-gradient-info"><i
                                              class="fa fa-edit"></i>Update</button>
                                  </div>
                              </form>
                              <!-- SCRIPT EDIT DATA PERIODE -->
                              <?php
                if (isset($_POST['update'])) {
                  $id  = mysqli_real_escape_string($con, $_POST['id']);
                  $tp  = mysqli_real_escape_string($con, $_POST['periode']);
                  if ($tp == "") {
                    echo "
                  <script>
                  alert('Ops ! Inputan Tidak Boleh Kosong !'); 
                  window.location ='?pages=periode';  
                  </script>";
                  } else {
                    $cekRowId = mysqli_num_rows(mysqli_query($con, "SELECT th_periode FROM tm_periode WHERE th_periode='{$tp}' "));
                    if ($cekRowId < 1) {
                      mysqli_query($con, "UPDATE tm_periode SET th_periode='{$tp}' WHERE periode_id={$id} ");
                      echo "
                  <script>
                  alert('Yes ! Periode Telah Diperbarui !'); 
                  window.location ='?pages=periode';  
                  </script>";
                    } else {
                      echo "
                  <script>
                  alert('Ops ! Data Periode sudah ada !');  
                  window.location ='?pages=periode'; 
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
function confirm_modal(delete_url) {
    $('#modal_delete').modal('show', {
        backdrop: 'static'
    });
    document.getElementById('delete_link').setAttribute('href', delete_url);
}
// Konfirmasi status periode
function confirm_set_stt() {
    $(document).on('click', '.stt', function() {
        $('#modal_set_stt').modal('show', {
            backdrop: 'static'
        });
        var iddata = $(this).data('iddata');
        var sttdata = $(this).data('sttdata');
        $('#idset').val(iddata);
        $('#sttdata').val(sttdata);

        if (sttdata == "on") {
            $('#aktif').html("Nonaktifkan");
            $('#ikon').html(`<i class="fa fa-times"></i>`);
        } else {
            $('#aktif').html("Aktifkan");
            $('#pesan').html(`<div class="alert alert-warning bg-gradient-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                    <h6><i class="fas fa-exclamation-triangle"></i><b> Warning!</b></h6>
                    Jika anda Aktikan Periode ini, Periode yang lain akan di Nonaktifkan
                  </div>`);
            $('#ikon').html(`<i class="fa fa-check"></i>`);
        }

        if (sttdata == "on") {
            $('#btn_set').html("Nonaktifkan");
            $('#tombol').html(`
<button type="submit" name="set_stt" class="btn btn-danger bg-gradient-danger">Nonaktifkan</button>
 `);
        } else {
            // $('#btn_set').html("Aktifkan");

            $('#tombol').html(`
<button type="submit" name="set_stt" class="btn btn-success bg-gradient-success">Aktikan</button>
 `);
        }
    })
}

// Popup modal edit
function confirm_modal_edit() {
    $(document).on('click', '#select', function() {
        $('#modal_update').modal('show', {
            backdrop: 'static'
        });
        var id = $(this).data('id');
        var periode = $(this).data('periode');
        $('#idnya').val(id);
        $('#periodenya').val(periode);
    })
}
  </script>
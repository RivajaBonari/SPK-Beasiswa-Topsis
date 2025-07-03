<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SPK Beasiswa</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/logo1.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
  <style>
    .brand-logo {
      padding: 20px;
      border-bottom: 1px solid #e0e0e0;
      background-color: #ffffff;
    }

    .brand-logo .logo-img img {
      height: 30px;
      width: auto;
      object-fit: contain;
      transform: scale(1.5);
      /* Perbesar tampilannya */
      transform-origin: left center;
      /* Supaya pembesaran dari kiri */
    }
  </style>
</head>

<body>
  <!-- untuk autentikasi supaya wajib login untuk mengakses web nya -->
  <?php
  session_start();
  if (!isset($_SESSION['login'])) {
    header("location:../html/authentication-login.php");
    exit;
  }
  ?>
  <!-- untuk autentikasi supaya wajib login untuk mengakses web nya -->

  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">

    <!-- Sidebar Start -->
    <?php
    include('sidebar.php');
    ?>
    <!--  Sidebar End -->

    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <?php
      include('header.php');
      ?>
      <!--  Header End -->
      <div class="body-wrapper-inner">
        <div class="container-fluid">
          <!-- Wrapper agar tombol tambah dan sort sejajar -->
          <div class="d-flex justify-content-between align-items-center mb-3">


          </div>


          <?php
          include('../backend/config.php');
          $sql_kriteria = "SELECT * FROM kriteria";
          $kriteria_result = $conn->query($sql_kriteria);

          while ($kriteria = $kriteria_result->fetch_assoc()) {
            $id_kriteria = $kriteria['id_kriteria'];
            $nama_kriteria = $kriteria['nama_kriteria'];

            $sql_sub = "SELECT * FROM sub_kriteria WHERE id_kriteria = $id_kriteria ORDER BY nilai_kecocokan DESC";
            $sub_result = $conn->query($sql_sub);
          ?>

            <!-- Header untuk masing-masing sub-kriteria -->
            <h5 class="mt-1 mb-2 px-3 py-2 text-black" style="background-color: #4ED7F1; border-radius: 6px;">
              Sub Kriteria untuk: <?= $nama_kriteria ?> (ID: <?= $id_kriteria ?>)
            </h5>

            <table class="table text-nowrap mb-0 align-middle">
              <thead class="text-dark fs-4">
                <tr>
                  <th>
                    <h6 class="fs-4 fw-semibold mb-0">Nama Sub Kriteria</h6>
                  </th>
                  <th>
                    <h6 class="fs-4 fw-semibold mb-0">Nilai Min</h6>
                  </th>
                  <th>
                    <h6 class="fs-4 fw-semibold mb-0">Nilai Max</h6>
                  </th>
                  <th>
                    <h6 class="fs-4 fw-semibold mb-0">Nilai Kecocokan</h6>
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php if ($sub_result->num_rows > 0) {
                  while ($sub = $sub_result->fetch_assoc()) { ?>
                    <tr>
                      <td>
                        <p class="mb-0 fw-normal"><?= $sub['nama_sub_kriteria'] ?></p>
                      </td>
                      <td>
                        <p class="mb-0 fw-normal"><?= $sub['nilai_min'] ?></p>
                      </td>
                      <td>
                        <p class="mb-0 fw-normal"><?= $sub['nilai_max'] ?></p>
                      </td>
                      <td>
                        <p class="mb-0 fw-normal"><?= $sub['nilai_kecocokan'] ?></p>
                      </td>
                      <td>
                        <div class="dropdown dropstart">
                          <a href="javascript:void(0)" class="text-muted" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots fs-5"></i>
                          </a>
                          <ul class="dropdown-menu">
                            <li>
                              <a class="dropdown-item d-flex align-items-center gap-3 btn-edit"
                                href="javascript:void(0)"
                                data-id="<?= $sub['id_sub_kriteria'] ?>">
                                <i class="fs-4 ti ti-edit"></i>Edit
                              </a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                  <?php }
                } else { ?>
                  <tr>
                    <td colspan="4">
                      <p class="mb-0 text-muted">Belum ada data sub kriteria.</p>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          <?php } ?>

          <!-- Modal Edit Sub Kriteria -->
          <div class="modal fade" id="editModalSubKriteria" tabindex="-1" aria-labelledby="editModalSubKriteriaLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
              <form action="../aksi/editSubKriteria.php" method="POST" id="formEditSub">
                <div class="modal-content">
                  <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="editModalSubKriteriaLabel">Edit Sub Kriteria</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                  </div>
                  <div class="modal-body">
                    <input type="hidden" name="id_sub_kriteria" id="edit_id_sub_kriteria">
                    <div class="row g-3">
                      <!-- Nama Sub Kriteria -->
                      <div class="col-md-6">
                        <label for="edit_nama_sub_kriteria" class="form-label">Nama Sub Kriteria</label>
                        <input type="text" class="form-control" id="edit_nama_sub_kriteria" name="nama_sub_kriteria" required>
                      </div>

                      <!-- Nilai Min -->
                      <div class="col-md-6">
                        <label for="edit_nilai_min" class="form-label">Nilai Min</label>
                        <input type="number" class="form-control" id="edit_nilai_min" name="nilai_min" required>
                      </div>

                      <!-- Nilai Max -->
                      <div class="col-md-6">
                        <label for="edit_nilai_max" class="form-label">Nilai Max</label>
                        <input type="number" class="form-control" id="edit_nilai_max" name="nilai_max" required>
                      </div>

                      <!-- Nilai Kecocokan -->
                      <div class="col-md-6">
                        <label for="edit_nilai_kecocokan" class="form-label">Nilai Kecocokan</label>
                        <input type="number" step="0.01" class="form-control" id="edit_nilai_kecocokan" name="nilai_kecocokan" required>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  </div>
                </div>
              </form>
            </div>
          </div>


          <?php
          include('footer.php');
          ?>
        </div>
      </div>
    </div>
  </div>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.btn-edit').on('click', function() {
        const id = $(this).data('id');

        $.ajax({
          url: '../aksi/get_sub_kriteria.php',
          method: 'POST',
          data: {
            id_sub_kriteria: id
          },
          dataType: 'json',
          success: function(data) {
            $('#edit_id_sub_kriteria').val(data.id_sub_kriteria);
            $('#edit_nama_sub_kriteria').val(data.nama_sub_kriteria);
            $('#edit_nilai_min').val(data.nilai_min);
            $('#edit_nilai_max').val(data.nilai_max);
            $('#edit_nilai_kecocokan').val(data.nilai_kecocokan);

            $('#editModalSubKriteria').modal('show');
          },
          error: function() {
            alert('Gagal mengambil data sub kriteria!');
          }
        });
      });
    });
  </script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="../assets/js/dashboard.js"></script>
  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>
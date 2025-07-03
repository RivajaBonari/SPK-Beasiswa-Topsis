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
            <!-- Tombol Tambah Data -->
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
              <i class="ti ti-pencil-plus"></i>
              <span>Tambah Data</span>
            </a>

            <!-- Tombol Sort -->
            <div class="dropdown">
              <a href="javascript:void(0)" class="btn btn-outline-secondary" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="ti ti-sort-descending"></i> Urutkan
              </a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item d-flex align-items-center gap-2" href="?sort=asc">
                    <i class="ti ti-arrow-up"></i> NPM Naik
                  </a>
                </li>
                <li>
                  <a class="dropdown-item d-flex align-items-center gap-2" href="?sort=desc">
                    <i class="ti ti-arrow-down"></i> NPM Turun
                  </a>
                </li>
              </ul>
            </div>

          </div>


          <!--  Row 1 -->
          <?php
          include("../backend/config.php");

          $perPage = 5;
          $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
          $start = ($page - 1) * $perPage;

          $sort = isset($_GET['sort']) && in_array(strtolower($_GET['sort']), ['asc', 'desc']) ? $_GET['sort'] : 'asc';

          $totalQuery = $conn->query("SELECT COUNT(*) AS total FROM mahasiswa");
          $totalData = $totalQuery->fetch_assoc()['total'];
          $totalPages = ceil($totalData / $perPage);

          $sql = "SELECT * FROM mahasiswa ORDER BY npm $sort LIMIT $start, $perPage";
          $exe = $conn->query($sql);
          ?>

          <table class="table text-nowrap mb-0 align-middle">
            <thead class="text-dark fs-4">
              <tr>
                <th>
                  <h6 class="fs-4 fw-semibold mb-0">Nama Mahasiswa</h6>
                </th>
                <th>
                  <h6 class="fs-4 fw-semibold mb-0">Jenis Kelamin</h6>
                </th>
                <th>
                  <h6 class="fs-4 fw-semibold mb-0">Telepon</h6>
                </th>
                <th>
                  <h6 class="fs-4 fw-semibold mb-0">Alamat</h6>
                </th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php while ($data = $exe->fetch_assoc()) { ?>
                <tr>
                  <td>
                    <div class="d-flex align-items-center">
                      <img src="../assets/images/profile/user-2.jpg" class="rounded-circle" width="40" height="40">
                      <div class="ms-3">
                        <h6 class="fs-4 fw-semibold mb-0"><?= $data['nama_mahasiswa']; ?></h6>
                        <span class="fw-normal"><?= $data['npm']; ?></span>
                      </div>
                    </div>
                  </td>
                  <td>
                    <p class="mb-0 fw-normal"><?= $data['gender'] ?></p>
                  </td>
                  <td>
                    <p class="mb-0 fw-normal"><?= $data['telepon'] ?></p>
                  </td>
                  <td>
                    <p class="mb-0 fw-normal"><?= $data['alamat'] ?></p>
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
                            data-bs-toggle="modal"
                            data-bs-target="#editModal"
                            data-npm="<?= $data['npm']; ?>"
                            data-nama="<?= $data['nama_mahasiswa']; ?>"
                            data-gender="<?= $data['gender']; ?>"
                            data-telepon="<?= $data['telepon']; ?>"
                            data-alamat="<?= $data['alamat']; ?>">
                            <i class="fs-4 ti ti-edit"></i>Edit
                          </a>
                        </li>
                        <li>
                          <a class="dropdown-item d-flex align-items-center gap-3" href="../aksi/deleteMhs.php?npm=<?= $data['npm']; ?>"
                            onclick="return confirm('Yakin dihapus?')">
                            <i class="fs-4 ti ti-trash"></i>Hapus
                          </a>
                        </li>
                      </ul>
                    </div>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>

          <!-- Navigasi Pagination -->
          <?php if ($totalPages > 1): ?>
            <nav class="mt-3">
              <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                  <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                  </li>
                <?php endfor; ?>
              </ul>
            </nav>
          <?php endif; ?>


          <!-- Modal Tambah Data Mahasiswa -->
          <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered">
              <form action="../aksi/tambahMhs.php" method="POST">
                <div class="modal-content">
                  <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="tambahModalLabel">Tambah Data Mahasiswa</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                  </div>
                  <div class="modal-body">
                    <div class="row g-3">
                      <div class="col-md-6">
                        <label for="npm" class="form-label">NPM</label>
                        <input type="text" class="form-control" id="npm" name="npm" required>
                      </div>
                      <div class="col-md-6">
                        <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
                        <input type="text" class="form-control" id="nama_mahasiswa" name="nama_mahasiswa" required>
                      </div>
                      <div class="col-md-6">
                        <label for="gender" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="gender" name="gender" required>
                          <option value="">-- Pilih --</option>
                          <option value="Laki-laki">Laki-laki</option>
                          <option value="Perempuan">Perempuan</option>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon" required>
                      </div>
                      <div class="col-12">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="2" required></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  </div>
                </div>
              </form>
            </div>
          </div>

          <!-- Modal Edit Data Mahasiswa -->
          <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
              <form action="../aksi/editMhs.php" method="POST">
                <div class="modal-content">
                  <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="editModalLabel">Edit Data Mahasiswa</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                  </div>
                  <div class="modal-body">
                    <div class="row g-3">
                      <div class="col-md-6">
                        <label for="edit_npm" class="form-label">NPM</label>
                        <input type="text" class="form-control" id="edit_npm" name="npm" readonly>
                      </div>
                      <div class="col-md-6">
                        <label for="edit_nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
                        <input type="text" class="form-control" id="edit_nama_mahasiswa" name="nama_mahasiswa" required>
                      </div>
                      <div class="col-md-6">
                        <label for="edit_gender" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="edit_gender" name="gender" required>
                          <option value="">-- Pilih --</option>
                          <option value="Laki-laki">Laki-laki</option>
                          <option value="Perempuan">Perempuan</option>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <label for="edit_telepon" class="form-label">Telepon</label>
                        <input type="text" class="form-control" id="edit_telepon" name="telepon" required>
                      </div>
                      <div class="col-12">
                        <label for="edit_alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="edit_alamat" name="alamat" rows="2" required></textarea>
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
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="../assets/js/dashboard.js"></script>
  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>
<script>
  $(document).ready(function() {
    $('.btn-edit').click(function() {
      const npm = $(this).data('npm');
      const nama = $(this).data('nama');
      const gender = $(this).data('gender');
      const telepon = $(this).data('telepon');
      const alamat = $(this).data('alamat');

      $('#edit_npm').val(npm);
      $('#edit_nama_mahasiswa').val(nama);
      $('#edit_gender').val(gender);
      $('#edit_telepon').val(telepon);
      $('#edit_alamat').val(alamat);
    });
  });
</script>


</html>
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
            padding-left: 43px;
            border-bottom: 1px solid #e0e0e0;
            background-color: #ffffff;
        }

        .brand-logo .logo-img img {
            height: 30px;
            width: auto;
            object-fit: contain;
            transform: scale(1.5);
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

    <!-- Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        <!-- Sidebar Start -->
        <?php
        include('sidebar.php');
        ?>
        <!-- Sidebar End -->

        <!-- Main Wrapper -->
        <div class="body-wrapper">
            <!-- Header Start -->
            <?php
            include('header.php');
            ?>
            <!-- Header End -->

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

                    <!-- Modal Tambah Pendaftaran -->
                    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <form action="../aksi/tambahPendaftaran.php" method="POST">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="tambahModalLabel">Tambah Data Penilaian</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <!-- Dropdown NPM -->
                                            <div class="col-md-6">
                                                <label for="npm" class="form-label">NPM</label>
                                                <select class="form-select" id="npm" name="npm" required>
                                                    <option value="" disabled selected>Pilih NPM</option>
                                                    <?php
                                                    // Ambil data npm dan nama_mahasiswa dari tabel mahasiswa
                                                    include("../backend/config.php");
                                                    $sql = "SELECT npm, nama_mahasiswa FROM mahasiswa";
                                                    $result = $conn->query($sql);

                                                    // Tampilkan opsi dropdown untuk setiap mahasiswa
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<option value='" . $row['npm'] . "'>" . $row['npm'] . " - " . $row['nama_mahasiswa'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <!-- Input IPK -->
                                            <div class="col-md-6">
                                                <label for="nilai_akademik" class="form-label">Nilai Akademik (IPK)</label>
                                                <input type="number" step="0.01" class="form-control" id="nilai_akademik" name="nilai_akademik" required>
                                            </div>
                                            <!-- Input Penghasilan Orang Tua -->
                                            <div class="col-md-6">
                                                <label for="penghasilan_ortu" class="form-label">Penghasilan Orang Tua</label>
                                                <input type="number" class="form-control" id="penghasilan_ortu" name="penghasilan_ortu" required>
                                            </div>
                                            <!-- Input Tanggungan -->
                                            <div class="col-md-6">
                                                <label for="jumlah_tanggungan" class="form-label">Jumlah Tanggungan</label>
                                                <input type="number" class="form-control" id="jumlah_tanggungan" name="jumlah_tanggungan" required>
                                            </div>
                                            <!-- Input Organisasi -->
                                            <div class="col-md-6">
                                                <label for="prestasi" class="form-label">Prestasi (Jumlah Sertifikat/Organisasi)</label>
                                                <input type="number" class="form-control" id="prestasi" name="prestasi" required>
                                            </div>
                                            <!-- Input Status -->
                                            <div class="col-md-6">
                                                <label for="status" class="form-label">Status</label>
                                                <select class="form-select" id="status" name="status" required>
                                                    <option value="">-- Pilih Status --</option>
                                                    <option value="Aktif">Aktif</option>
                                                    <option value="Tidak Aktif">Tidak Aktif</option>
                                                </select>
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

                    <!-- Modal Edit Data Pendaftaran -->
                    <div class="modal fade" id="editModalPendaftaran" tabindex="-1" aria-labelledby="editModalPendaftaranLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <form action="../aksi/editPendaftaran.php" method="POST">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning text-white">
                                        <h5 class="modal-title" id="editModalPendaftaranLabel">Edit Data Pendaftaran</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <!-- NPM (Dropdown) -->
                                            <div class="col-md-6">
                                                <label for="edit_npm" class="form-label">NPM</label>
                                                <select class="form-select" id="edit_npm" name="npm" required>
                                                    <option value="">-- Pilih NPM --</option>
                                                    <?php
                                                    // Koneksi database dan ambil data mahasiswa
                                                    include("../backend/config.php");
                                                    $result = $conn->query("SELECT npm, nama_mahasiswa FROM mahasiswa");
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<option value='{$row['npm']}'>{$row['npm']} - {$row['nama_mahasiswa']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <!-- IPK -->
                                            <div class="col-md-6">
                                                <label for="edit_ipk" class="form-label">IPK</label>
                                                <input type="number" step="0.01" class="form-control" id="edit_ipk" name="ipk" required>
                                            </div>

                                            <!-- Penghasilan Orang Tua -->
                                            <div class="col-md-6">
                                                <label for="edit_penghasilan_ortu" class="form-label">Penghasilan Orang Tua</label>
                                                <input type="number" class="form-control" id="edit_penghasilan_ortu" name="penghasilan_ortu" required>
                                            </div>

                                            <!-- Tanggungan -->
                                            <div class="col-md-6">
                                                <label for="edit_tanggungan" class="form-label">Tanggungan</label>
                                                <input type="number" class="form-control" id="edit_tanggungan" name="tanggungan" required>
                                            </div>

                                            <!-- Organisasi -->
                                            <div class="col-md-6">
                                                <label for="edit_organisasi" class="form-label">Organisasi</label>
                                                <input type="text" class="form-control" id="edit_organisasi" name="organisasi" required>
                                            </div>

                                            <!-- Status -->
                                            <div class="col-md-6">
                                                <label for="edit_status" class="form-label">Status</label>
                                                <select class="form-select" id="edit_status" name="status" required>
                                                    <option value="">-- Pilih Status --</option>
                                                    <option value="Aktif">Aktif</option>
                                                    <option value="Tidak Aktif">Tidak Aktif</option>
                                                </select>
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


                    <!-- Row 1 -->
                    <?php
                    include("../backend/config.php");

                    $perPage = 5;
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $start = ($page - 1) * $perPage;

                    $sort = isset($_GET['sort']) && in_array(strtolower($_GET['sort']), ['asc', 'desc']) ? $_GET['sort'] : 'asc';

                    $totalQuery = $conn->query("SELECT COUNT(*) AS total FROM pendaftaran");
                    $totalData = $totalQuery->fetch_assoc()['total'];
                    $totalPages = ceil($totalData / $perPage);

                    $sql = "SELECT * FROM pendaftaran ORDER BY id_pendaftaran $sort LIMIT $start, $perPage";
                    $exe = $conn->query($sql);
                    ?>

                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th>
                                    <h6 class="fs-4 fw-semibold mb-0">ID Alternatif</h6>
                                </th>
                                <th>
                                    <h6 class="fs-4 fw-semibold mb-0">NPM</h6>
                                </th>
                                <th>
                                    <h6 class="fs-4 fw-semibold mb-0">IPK</h6>
                                </th>
                                <th>
                                    <h6 class="fs-4 fw-semibold mb-0">Penghasilan Orang Tua</h6>
                                </th>
                                <th>
                                    <h6 class="fs-4 fw-semibold mb-0">Tanggungan</h6>
                                </th>
                                <th>
                                    <h6 class="fs-4 fw-semibold mb-0">Organisasi</h6>
                                </th>
                                <th>
                                    <h6 class="fs-4 fw-semibold mb-0">Status</h6>
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($data = $exe->fetch_assoc()) { ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="fw-normal"><?= $data['id_pendaftaran']; ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0 fw-normal"><?= $data['npm']; ?></p>
                                    </td>
                                    <td>
                                        <p class="mb-0 fw-normal"><?= $data['nilai_akademik']; ?></p>
                                    </td>
                                    <td>
                                        <p class="mb-0 fw-normal"><?= $data['penghasilan_ortu']; ?></p>
                                    </td>
                                    <td>
                                        <p class="mb-0 fw-normal"><?= $data['jumlah_tanggungan']; ?></p>
                                    </td>
                                    <td>
                                        <p class="mb-0 fw-normal"><?= $data['prestasi']; ?></p>
                                    </td>
                                    <td>
                                        <p class="mb-0 fw-normal"><?= $data['status']; ?></p>
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
                                                        data-bs-target="#editModalPendaftaran"
                                                        data-id_pendaftaran="<?= $data['id_pendaftaran']; ?>"
                                                        data-npm="<?= $data['npm']; ?>"
                                                        data-ipk="<?= $data['ipk']; ?>"
                                                        data-penghasilan_ortu="<?= $data['penghasilan_ortu']; ?>"
                                                        data-tanggungan="<?= $data['tanggungan']; ?>"
                                                        data-organisasi="<?= $data['organisasi']; ?>"
                                                        data-status="<?= $data['status']; ?>">
                                                        <i class="fs-4 ti ti-edit"></i>Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center gap-3"
                                                        href="../aksi/deletePendaftaran.php?id=<?= $data['id_pendaftaran']; ?>"
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

                </div>
            </div>

            <!-- Footer Start -->
            <?php
            include('footer.php');
            ?>
            <!-- Footer End -->
        </div>
        <!-- Main Wrapper End -->
    </div>
    <!-- Body Wrapper End -->

    <!-- JS Files -->
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
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.btn-edit');
        editButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                // Ambil data dari atribut
                const id = this.getAttribute('data-id_pendaftaran');
                const npm = this.getAttribute('data-npm');
                const nilai_akademik = this.getAttribute('data-nilai_akademik');
                const penghasilan = this.getAttribute('data-penghasilan_ortu');
                const tanggungan = this.getAttribute('data-jumlah_tanggungan');
                const prestasi = this.getAttribute('data-prestasi');
                const status = this.getAttribute('data-status');

                // Set nilai ke dalam modal
                document.getElementById('edit_npm').value = npm;
                document.getElementById('edit_nilai_akademik').value = nilai_akademik;
                document.getElementById('edit_penghasilan_ortu').value = penghasilan;
                document.getElementById('edit_jumlah_tanggungan').value = tanggungan;
                document.getElementById('edit_prestasi').value = organisasi;
                document.getElementById('edit_status').value = prestasi;

                // Tambahkan field hidden untuk ID pendaftaran
                if (!document.getElementById('edit_id_pendaftaran')) {
                    const hiddenId = document.createElement('input');
                    hiddenId.type = 'hidden';
                    hiddenId.name = 'id_pendaftaran';
                    hiddenId.id = 'edit_id_pendaftaran';
                    hiddenId.value = id;
                    document.querySelector('#editModalPendaftaran form').appendChild(hiddenId);
                } else {
                    document.getElementById('edit_id_pendaftaran').value = id;
                }
            });
        });
    });
</script>

</html>
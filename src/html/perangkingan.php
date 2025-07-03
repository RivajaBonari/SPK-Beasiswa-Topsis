<?php
include("../backend/config.php");
session_start();
if (!isset($_SESSION['login'])) {
  header("location:../html/authentication-login.php");
  exit;
}

// Pagination
$perPage = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $perPage;

// Sorting
$sort = isset($_GET['sort']) && in_array(strtolower($_GET['sort']), ['asc', 'desc']) ? $_GET['sort'] : 'desc';

// Total data
$totalQuery = $conn->query("SELECT COUNT(*) AS total FROM perangkingan");
$totalData = $totalQuery->fetch_assoc()['total'];
$totalPages = ceil($totalData / $perPage);

// Query JOIN pendaftaran
$sql = "SELECT p.id AS id_perangkingan, p.id_pendaftaran, p.nilai_akhir, p.ranking,
               d.nilai_akademik, d.penghasilan_ortu, d.jumlah_tanggungan, d.prestasi
        FROM perangkingan p
        JOIN pendaftaran d ON p.id_pendaftaran = d.id_pendaftaran
        ORDER BY p.nilai_akhir $sort
        LIMIT $start, $perPage";


$exe = $conn->query($sql);
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>SPK Beasiswa</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/logo1.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
</head>

<body>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical">
    <?php include('sidebar.php'); ?>
    <div class="body-wrapper">
      <?php include('header.php'); ?>
      <div class="body-wrapper-inner">
        <div class="container-fluid">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <form action="../backend/proses_perangkingan.php" method="POST">
              <button type="submit" class="btn btn-primary">
                <i class="ti ti-loader"></i> Proses Data
              </button>
            </form>

            <div class="dropdown">
              <a href="javascript:void(0)" class="btn btn-outline-secondary" data-bs-toggle="dropdown">
                <i class="ti ti-sort-descending"></i> Urutkan
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="?sort=asc"><i class="ti ti-arrow-up"></i> Nilai Akhir Naik</a></li>
                <li><a class="dropdown-item" href="?sort=desc"><i class="ti ti-arrow-down"></i> Nilai Akhir Turun</a></li>
              </ul>
            </div>
          </div>

          <table class="table text-nowrap mb-0 align-middle">
            <thead>
              <tr>
                <th>ID Alternatif</th>
                <th>IPK</th>
                <th>Penghasilan Ortu</th>
                <th>Tanggungan</th>
                <th>Organisasi</th>
                <th>Nilai Akhir</th>
                <th>Ranking</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($data = $exe->fetch_assoc()) : ?>
                <tr>
                  <td><?= $data['id_pendaftaran']; ?></td>
                  <td><?= number_format($data['nilai_akademik'], 2); ?></td>
                  <td><?= number_format($data['penghasilan_ortu'], 2); ?></td>
                  <td><?= number_format($data['jumlah_tanggungan'], 2); ?></td>
                  <td><?= $data['prestasi']; ?></td>
                  <td><strong><?= number_format($data['nilai_akhir'], 4); ?></strong></td>
                  <td><span class="badge bg-success"><?= $data['ranking'] ?? '-'; ?></span></td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>

          <!-- Pagination -->
          <?php if ($totalPages > 1): ?>
            <nav class="mt-3">
              <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                  <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?= $i; ?>&sort=<?= $sort; ?>"><?= $i; ?></a>
                  </li>
                <?php endfor; ?>
              </ul>
            </nav>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- JS Files -->
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/app.min.js"></script>
</body>

</html>
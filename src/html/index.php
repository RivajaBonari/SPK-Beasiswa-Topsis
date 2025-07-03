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
      transform-origin: left center;
    }
  </style>
</head>

<body>
  <?php
  session_start();
  if (!isset($_SESSION['login'])) {
    header("location:../html/authentication-login.php");
    exit;
  }

  include('../backend/config.php');

  // Query gender
  $sql = "SELECT 
            CASE 
              WHEN LOWER(gender) = 'laki-laki' THEN 'Laki-laki'
              WHEN LOWER(gender) = 'perempuan' THEN 'Perempuan'
              ELSE 'Lainnya'
            END as gender_group, 
            COUNT(*) as total 
          FROM mahasiswa 
          GROUP BY gender_group";

  $result = mysqli_query($conn, $sql);

  $dataGender = [
    "Laki-laki" => 0,
    "Perempuan" => 0
  ];

  while ($row = mysqli_fetch_assoc($result)) {
    $gender = $row['gender_group'];
    $total = (int)$row['total'];
    $dataGender[$gender] = $total;
  }

  // Query jumlah mahasiswa (untuk $data['count'])
  $queryCount = mysqli_query($conn, "SELECT COUNT(*) AS count FROM mahasiswa");
  $data = mysqli_fetch_assoc($queryCount);

  // Query data perangkingan
  $rankingQuery = mysqli_query($conn, "SELECT id_pendaftaran, nilai_akhir FROM perangkingan ORDER BY nilai_akhir DESC");
  ?>

  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6"
    data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">

    <?php include('sidebar.php'); ?>

    <div class="body-wrapper">
      <?php include('header.php'); ?>

      <div class="body-wrapper-inner">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-8 d-flex align-items-stretch">
              <div class="card w-100">
                <div class="card-body">
                  <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                    <div class="mb-3 mb-sm-0">
                      <h5 class="card-title fw-semibold">Dashboard Perangkingan 🏆</h5>
                    </div>
                  </div>
                  <div id="perangkingan"></div>
                </div>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card overflow-hidden shadow-sm">
                    <div class="card-body p-4">
                      <h5 class="card-title mb-4 fw-semibold text-center">Dashboard Mahasiswa</h5>
                      <div class="row align-items-center">
                        <div class="col-md-7">
                          <h4 class="fw-semibold mb-4 fs-4">Total Mahasiswa: <?= $data['count'] ?></h4>
                          <div class="d-flex flex-column gap-2">
                            <div class="d-flex align-items-center">
                              <span class="round-8 rounded-circle me-2 d-inline-block" style="background-color: #2962FF; width: 10px; height: 10px;"></span>
                              <span class="fs-2 me-auto">Laki-laki</span>
                            </div>
                            <div class="d-flex align-items-center">
                              <span class="round-8 rounded-circle me-2 d-inline-block" style="background-color: #F50057; width: 10px; height: 10px;"></span>
                              <span class="fs-2 me-auto">Perempuan</span>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-5">
                          <div class="d-flex justify-content-center">
                            <div id="breakup1"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- <div class="col-lg-12">
                  <div class="card">
                    <div class="card-body">
                      <div class="row align-items-start">
                        <div class="col-8">
                          <h5 class="card-title mb-9 fw-semibold"> Monthly Earnings </h5>
                          <h4 class="fw-semibold mb-3">$6,820</h4>
                          <div class="d-flex align-items-center pb-1">
                            <span class="me-2 rounded-circle bg-light-danger round-20 d-flex align-items-center justify-content-center">
                              <i class="ti ti-arrow-down-right text-danger"></i>
                            </span>
                            <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                            <p class="fs-3 mb-0">last year</p>
                          </div>
                        </div>
                        <div class="col-4">
                          <div class="d-flex justify-content-end">
                            <div class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                              <i class="ti ti-currency-dollar fs-6"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div id="earning"></div>
                    </div>
                  </div>
                </div> -->
              </div>
            </div>
          </div>

          <?php include('footer.php'); ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Script Chart Mahasiswa -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      var options = {
        chart: {
          type: 'donut',
          height: 250
        },
        labels: ['Laki-laki', 'Perempuan'],
        series: [
          <?= $dataGender['Laki-laki']; ?>,
          <?= $dataGender['Perempuan']; ?>
        ],
        colors: ['#2962FF', '#F50057'],
        legend: {
          position: 'bottom'
        },
        dataLabels: {
          enabled: true
        }
      };

      var chart = new ApexCharts(document.querySelector("#breakup1"), options);
      chart.render();
    });
  </script>

  <!-- Script Chart Perangkingan -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Ambil data dari PHP untuk chart perangkingan
      var dataLabels = [
        <?php
        mysqli_data_seek($rankingQuery, 0);
        while ($row = mysqli_fetch_assoc($rankingQuery)) {
          echo "'" . $row['id_pendaftaran'] . "',";
        }
        ?>
      ];

      var dataValues = [
        <?php
        mysqli_data_seek($rankingQuery, 0);
        while ($row = mysqli_fetch_assoc($rankingQuery)) {
          echo $row['nilai_akhir'] . ",";
        }
        ?>
      ];

      // Inisialisasi Chart
      var options = {
        chart: {
          type: 'bar',
          height: 350
        },
        series: [{
          name: 'Nilai Akhir',
          data: dataValues,
        }],
        xaxis: {
          categories: dataLabels,
          title: {
            text: 'Alternatif berdasarkan id_alternatif',
            style: {
              fontSize: '14px',
              fontWeight: 'bold'
            }
          }
        },
        yaxis: {
          title: {
            text: 'Nilai Akhir',
            style: {
              fontSize: '14px',
              fontWeight: 'bold'
            }
          }
        },
        title: {
          text: 'Grafik Perangkingan Mahasiswa',
          align: 'center'
        }
      };

      var chart = new ApexCharts(document.querySelector("#perangkingan"), options);
      chart.render();
    });
  </script>


  <!-- Scripts -->
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="../assets/js/dashboard.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>
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
        }
        p {
            text-indent: 50px;
            text-align: justify;
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
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title fw-semibold mb-4 text-center">Perancangan Website Sistem Pendukung Keputusan Beasiswa di Universitas XYZ
                                menggunakan Metode SAW (Simple Additive Weighting)</h2>
                            <div class="card mb-0">
                                <div class="card-body p-4">
                                    <h5 class="card-title fw-semibold mb-1">Latar Belakang</h5>
                                    <p> Di setiap pendidikan khususnya pada Perguruan Tinggi banyak sekali beasiswa yang ditawarkan kepada mahasiswa.
                                        Ada beasiswa yang berasal dari pemerintah maupun dari pihak swasta. Untuk mendapatkan beasiswa tersebut maka
                                        harus sesuai dengan aturan yang telah ditetapkan. Kriteria yang ditetapkan antara lain indeks prestasi kumulatif,
                                        penghasilan orang tua, jumlah saudara kandung, jumlah organisasi yang di ikuti dan lain-lain. Tidak semua mahasiswa
                                        yang mengajukan permohonan untuk menerima beasiswa dapat dikabulkan, karena jumlah mahasiswa yang mengajukan permohonan
                                        sangat banyak. Oleh karena itu, perlu dibangun suatu <mark>Sistem Pendukung Keputusan</mark> yang dapat membantu memberikan
                                        rekomendasi penerima beasiswa.</p>
                                    <h5 class="card-title fw-semibold mb-1">Tujuan</h5>
                                    <p> Tujuan pembuatan sistem ini adalah untuk seleksi penerima beasiswa dengan tepat dan akurat serta untuk mengatahui
                                        kelayakan mahasiswa penerima bantuan beasiswa.</p>
                                    <h5 class="card-title fw-semibold mb-1">Analisis masalah dan solusi</h5>
                                    <h6>Masalah</h6>
                                    <li>Panitia beasiswa kesulitan dalam menentukan siapa penerima beasiswa</li>
                                    <li>Beasiswa yang ditawarkan terlalu banyak</li>
                                    <li>Banyaknya mahasiswa yang mengajukan beasiswa</li>
                                    <br>
                                    <h6>Solusi</h6>
                                    <li>Dibangun suatu <mark>Sistem Pendukung Keputusan</mark> yang dapata membantu memberikan rekomendasi penerima beasiswa</li>
                                </div>
                            </div>
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

</html>
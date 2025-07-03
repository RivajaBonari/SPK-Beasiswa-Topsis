<?php
// Include file koneksi
include '../backend/config.php';

// Query untuk mengambil data dari tabel perangkingan
$exe = mysqli_query($conn, "SELECT id_pendaftaran, nilai_akhir FROM perangkingan ORDER BY nilai_akhir DESC");
?>

<!-- HTML -->
<div class="card mt-4">
    <div class="card-body">
        <h4 class="card-title mb-4 text-center">Hasil Perangkingan</h4>
        
        <!-- Chart untuk perangkingan -->
        <div id="rankingChart" class="mt-4"></div>

        <!-- Tabel untuk hasil perangkingan -->
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Pendaftaran</th>
                    <th>Nilai Akhir</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Menampilkan data tabel hasil perangkingan
                $no = 1;
                $exe->data_seek(0); // Reset pointer ke awal
                while ($data = $exe->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . $data['id_pendaftaran'] . "</td>";
                    echo "<td>" . $data['nilai_akhir'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Load Library JS (Pastikan ini dimuat SEBELUM script ApexCharts dipanggil) -->
<script src="../assets/libs/jquery/dist/jquery.min.js"></script>
<script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>

<!-- Script untuk membuat Chart -->
<script>
    $(document).ready(function () {
        // Ambil data dari PHP
        var dataLabels = [
            <?php
            $exe->data_seek(0); // Reset pointer ke awal
            while ($data = $exe->fetch_assoc()) {
                echo "'" . $data['id_pendaftaran'] . "',";
            }
            ?>
        ];

        var dataValues = [
            <?php
            $exe->data_seek(0); // Reset pointer lagi
            while ($data = $exe->fetch_assoc()) {
                echo $data['nilai_akhir'] . ",";
            }
            ?>
        ];

        // Debug: Cek isi data (boleh dihapus nanti)
        console.log(dataLabels);
        console.log(dataValues);

        // Inisialisasi Chart
        var options = {
            chart: {
                type: 'bar',
                height: 350
            },
            series: [{
                name: 'Nilai Akhir',
                data: dataValues
            }],
            xaxis: {
                categories: dataLabels
            },
            title: {
                text: 'Grafik Perangkingan Mahasiswa',
                align: 'center'
            }
        };

        var chart = new ApexCharts(document.querySelector("#rankingChart"), options);
        chart.render();
    });
</script>

<?php
include("../backend/config.php");

// Fungsi konversi ke nilai kecocokan dari sub_kriteria
function getNilaiKecocokan($conn, $id_kriteria, $nilai_input) {
    $query = $conn->query("SELECT nilai_kecocokan 
        FROM sub_kriteria 
        WHERE id_kriteria = $id_kriteria 
        AND $nilai_input BETWEEN nilai_min AND nilai_max 
        LIMIT 1");

    if ($row = $query->fetch_assoc()) {
        return $row['nilai_kecocokan'];
    }
    return 0;
}

// Ambil data pendaftar yang aktif
$pendaftaran = [];
$alternatifQuery = $conn->query("SELECT * FROM pendaftaran WHERE status = 'Aktif'");
while ($row = $alternatifQuery->fetch_assoc()) {
    $id = $row['id_pendaftaran'];
    $pendaftaran[$id] = [
        'id_pendaftaran' => $id,
        'npm' => $row['npm'],
        'nilai_akademik' => getNilaiKecocokan($conn, 1, $row['nilai_akademik']),
        'penghasilan_ortu' => getNilaiKecocokan($conn, 2, $row['penghasilan_ortu']),
        'jumlah_tanggungan' => getNilaiKecocokan($conn, 3, $row['jumlah_tanggungan']),
        'prestasi' => getNilaiKecocokan($conn, 4, $row['prestasi']),
    ];
}

// Ambil data kriteria
$kriteria = [];
$kriteriaQuery = $conn->query("SELECT * FROM kriteria");
while ($row = $kriteriaQuery->fetch_assoc()) {
    $kriteria[] = $row;
}

// Hitung nilai pembagi (akar kuadrat) tiap kriteria
$pembagi = [];
foreach ($kriteria as $k) {
    $field = $k['nama_field'];
    $jumlahKuadrat = 0;
    foreach ($pendaftaran as $p) {
        $jumlahKuadrat += pow($p[$field], 2);
    }
    $pembagi[$field] = sqrt($jumlahKuadrat);
}

// Normalisasi
$normalisasi = [];
foreach ($pendaftaran as $id => $data) {
    foreach ($kriteria as $k) {
        $field = $k['nama_field'];
        $nilai = $pembagi[$field] > 0 ? $data[$field] / $pembagi[$field] : 0;

        // Jika cost, nilai dibalik
        if ($k['sifat'] === 'cost') {
            $nilai = 1 - $nilai;
        }

        $normalisasi[$id][$field] = $nilai;
    }
}

// Hitung nilai preferensi (nilai akhir)
$preferensi = [];
foreach ($normalisasi as $id => $data) {
    $total = 0;
    foreach ($kriteria as $k) {
        $field = $k['nama_field'];
        $bobot = $k['bobot'] / 100;
        $total += $data[$field] * $bobot;
    }
    $preferensi[$id] = $total;
}

// Kosongkan tabel perangkingan
$conn->query("TRUNCATE TABLE perangkingan");

// Simpan ke tabel perangkingan
foreach ($preferensi as $id => $nilai_akhir) {
    $conn->query("INSERT INTO perangkingan (id_pendaftaran, nilai_akhir) 
                  VALUES ('$id', '$nilai_akhir')");
}

// Update ranking berdasarkan nilai_akhir
$conn->query("SET @rank = 0");
$conn->query("
    UPDATE perangkingan p
    JOIN (
        SELECT id, @rank := @rank + 1 AS urutan
        FROM (
            SELECT id, id_pendaftaran, nilai_akhir
            FROM perangkingan
            ORDER BY nilai_akhir DESC
        ) AS sorted
    ) urut ON p.id = urut.id
    SET p.ranking = urut.urutan
");

// Redirect kembali ke halaman hasil
header("Location: ../html/perangkingan.php");
exit;
?>

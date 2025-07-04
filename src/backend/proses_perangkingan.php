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
    
// LANGKAH 1: Normalisasi menggunakan rumus TOPSIS    
$pembagi = [];    
foreach ($kriteria as $k) {    
    $field = $k['nama_field'];    
    $jumlahKuadrat = 0;    
    foreach ($pendaftaran as $p) {    
        $jumlahKuadrat += pow($p[$field], 2);    
    }    
    $pembagi[$field] = sqrt($jumlahKuadrat);    
}    
    
// Normalisasi dengan pembagian    
$normalisasi = [];    
foreach ($pendaftaran as $id => $data) {    
    foreach ($kriteria as $k) {    
        $field = $k['nama_field'];    
        $nilai = $pembagi[$field] > 0 ? $data[$field] / $pembagi[$field] : 0;    
        $normalisasi[$id][$field] = $nilai;    
    }    
}    
    
// LANGKAH 2: Hitung matriks ternormalisasi terbobot    
$ternormalisasiTerbobot = [];    
foreach ($normalisasi as $id => $data) {    
    foreach ($kriteria as $k) {    
        $field = $k['nama_field'];    
        $bobot = $k['bobot'];  // PERBAIKAN: Hapus pembagian 100 jika bobot sudah dalam desimal  
        $ternormalisasiTerbobot[$id][$field] = $data[$field] * $bobot;    
    }    
}    
    
// LANGKAH 3: Tentukan solusi ideal positif (A+) dan negatif (A-)    
$idealPositif = [];    
$idealNegatif = [];    
    
foreach ($kriteria as $k) {    
    $field = $k['nama_field'];    
    $values = array_column($ternormalisasiTerbobot, $field);    
        
    if ($k['sifat'] === 'benefit') {    
        $idealPositif[$field] = max($values);    
        $idealNegatif[$field] = min($values);    
    } else { // cost    
        $idealPositif[$field] = min($values);    
        $idealNegatif[$field] = max($values);    
    }    
}    
    
// LANGKAH 4: Hitung jarak Euclidean ke solusi ideal    
$jarakPositif = [];    
$jarakNegatif = [];    
    
foreach ($ternormalisasiTerbobot as $id => $data) {    
    $sumPositif = 0;    
    $sumNegatif = 0;    
        
    foreach ($kriteria as $k) {    
        $field = $k['nama_field'];    
        $sumPositif += pow($data[$field] - $idealPositif[$field], 2);    
        $sumNegatif += pow($data[$field] - $idealNegatif[$field], 2);    
    }    
        
    $jarakPositif[$id] = sqrt($sumPositif);    
    $jarakNegatif[$id] = sqrt($sumNegatif);    
}    
    
// LANGKAH 5: Hitung coefficient closeness (Ci)    
$preferensi = [];    
foreach ($pendaftaran as $id => $data) {    
    // PERBAIKAN: Tambahkan pengecekan untuk menghindari pembagian dengan nol  
    $totalJarak = $jarakPositif[$id] + $jarakNegatif[$id];  
    if ($totalJarak > 0) {  
        $ci = $jarakNegatif[$id] / $totalJarak;  
    } else {  
        $ci = 0; // atau nilai default lainnya  
    }  
    $preferensi[$id] = $ci;    
}    
    
// Kosongkan tabel perangkingan    
$conn->query("TRUNCATE TABLE perangkingan");    
    
// Simpan ke tabel perangkingan dengan prepared statement untuk keamanan  
foreach ($preferensi as $id => $nilai_akhir) {    
    $stmt = $conn->prepare("INSERT INTO perangkingan (id_pendaftaran, nilai_akhir) VALUES (?, ?)");  
    $stmt->bind_param("id", $id, $nilai_akhir);  
    $stmt->execute();  
}    
    
// Update ranking berdasarkan nilai_akhir (descending karena nilai Ci yang lebih tinggi lebih baik)    
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
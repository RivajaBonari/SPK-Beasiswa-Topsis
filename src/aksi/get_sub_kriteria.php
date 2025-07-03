<?php
include('../backend/config.php');

if (isset($_POST['id_sub_kriteria'])) {
  $id = intval($_POST['id_sub_kriteria']);
  $query = $conn->query("SELECT * FROM sub_kriteria WHERE id_sub_kriteria = $id");

  if ($query->num_rows > 0) {
    echo json_encode($query->fetch_assoc());
  } else {
    echo json_encode([]);
  }
}
?>

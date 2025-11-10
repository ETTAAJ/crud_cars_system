<?php
include 'db.php';
$id = $_GET['id'];
$car = $conn->query("SELECT images FROM cars WHERE id = $id")->fetch_assoc();
if ($car) {
    $images = json_decode($car['images'], true);
    foreach ($images as $img) {
        @unlink('uploads/' . $img);
    }
}
$conn->query("DELETE FROM cars WHERE id = $id");
header("Location: index.php");
?>
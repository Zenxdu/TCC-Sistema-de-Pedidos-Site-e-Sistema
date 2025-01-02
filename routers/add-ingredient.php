<?php
include '../includes/connect.php';

$name = $_POST['name'];
$price = $_POST['price'];

// Processar a imagem
$image_name = $_FILES['image']['name'];
$image_tmp = $_FILES['image']['tmp_name'];
$image_path = "../images/$image_name";

if (move_uploaded_file($image_tmp, $image_path)) {
    $sql = "INSERT INTO ingredients (name, price, image_path) VALUES ('$name', $price, 'images/$image_name')";
    $con->query($sql);
}

header("location: ../admin-custom.php");
?>

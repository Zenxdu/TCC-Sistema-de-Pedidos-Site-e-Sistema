<?php
include '../includes/connect.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM items WHERE id = $id";
    $con->query($sql);
}

header("location: ../admin-page.php");
?>
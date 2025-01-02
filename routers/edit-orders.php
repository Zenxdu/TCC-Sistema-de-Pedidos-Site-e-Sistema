<?php
include '../includes/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['id'];
    $status = $_POST['status'];

    $sql = "UPDATE orders SET status = '$status' WHERE id = $order_id";
    if ($con->query($sql) === TRUE) {
        header("location: ../all-orders.php");
    } else {
        echo "Erro ao atualizar o pedido: " . $con->error;
    }
}
?>
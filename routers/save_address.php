<?php
include 'includes/connect.php';
session_start();

if ($_SESSION['customer_sid'] == session_id()) {
    $user_id = $_SESSION['user_id'];
    $rua = $_POST['rua'];
    $bairro = $_POST['bairro'];
    $numero = $_POST['numero'];
    $complemento = $_POST['complemento'];

    $sql = "INSERT INTO enderecodeentrega (user_id, rua, bairro, numero, complemento) VALUES ('$user_id', '$rua', '$bairro', '$numero', '$complemento')";
    if (mysqli_query($con, $sql)) {
        echo 'success';
    } else {
        echo "Erro: " . mysqli_error($con);
    }
} else {
    echo "Sessão inválida.";
}
?>
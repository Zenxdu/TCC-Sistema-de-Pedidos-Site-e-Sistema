<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$servername = "localhost";
$server_user = "root";
$server_pass = "";
$dbname = "food";

// Inicializa valores padrão para as variáveis de sessão, caso não estejam definidas
if (!isset($_SESSION['name'])) {
    $_SESSION['name'] = 'Guest';  // Valor padrão
}
if (!isset($_SESSION['role'])) {
    $_SESSION['role'] = 'Guest';  // Valor padrão
}

$name = $_SESSION['name'];
$role = $_SESSION['role'];

$con = new mysqli($servername, $server_user, $server_pass, $dbname);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>

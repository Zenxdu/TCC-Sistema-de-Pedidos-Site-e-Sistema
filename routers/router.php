<?php
include '../includes/connect.php';
session_start(); // Mover a inicialização da sessão para o início

$success = false;

$username = $_POST['username'];
$password = $_POST['password'];

$result = mysqli_query($con, "SELECT * FROM users WHERE username='$username' AND password='$password' AND role='Administrador' AND not deleted;");
while ($row = mysqli_fetch_array($result)) {
    $success = true;
    $user_id = $row['id'];
    $name = $row['name'];
    $role = $row['role'];
}

if ($success == true) {
    $_SESSION['admin_sid'] = session_id();
    $_SESSION['user_id'] = $user_id;
    $_SESSION['role'] = $role;
    $_SESSION['name'] = $name;

    header("location: ../admin-page.php");
} else {
    $result = mysqli_query($con, "SELECT * FROM users WHERE username='$username' AND password='$password' AND role='Cliente' AND not deleted;");
    while ($row = mysqli_fetch_array($result)) {
        $success = true;
        $user_id = $row['id'];
        $name = $row['name'];
        $role = $row['role'];
    }
    if ($success == true) {
        $_SESSION['customer_sid'] = session_id();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['role'] = $role;
        $_SESSION['name'] = $name;
        header("location: ../index.php");
    } else {
        $_SESSION['login_error'] = "Usuário ou senha incorretos"; // Definir a mensagem de erro na sessão
        header("location: ../login.php");
    }
}
?>

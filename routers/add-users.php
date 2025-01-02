<?php
include '../includes/connect.php';

$username = $_POST['username'];
$password = $_POST['password'];
$name = $_POST['name'];
$email = $_POST['email'];
$contact = $_POST['contact'];
$address = $_POST['address'];
$role = $_POST['role'];
$deleted = $_POST['deleted'];

// Verificar se o username ou email já existem
$sql_check = "SELECT * FROM users WHERE username='$username' OR email='$email'";
$result_check = mysqli_query($con, $sql_check);

if (mysqli_num_rows($result_check) > 0) {
    // Redireciona para a página de usuários com uma mensagem de erro
    echo "<script>alert('Nome de usuário ou email já existem. Por favor, escolha outros.'); window.location.href='../users.php';</script>";
} else {
    $sql = "INSERT INTO users (username, password, name, email, contact, address, role, deleted) VALUES ('$username', '$password', '$name', '$email', $contact, '$address', '$role', $deleted)";
    if($con->query($sql) === TRUE){
        echo "<script>alert('Usuário adicionado com sucesso!'); window.location.href='../users.php';</script>";
    } else {
        echo "<script>alert('Erro ao adicionar usuário. Tente novamente.'); window.location.href='../users.php';</script>";
    }
}
$con->close();
?>

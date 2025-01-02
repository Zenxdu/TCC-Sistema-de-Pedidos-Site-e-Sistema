<?php
include '../includes/connect.php';

$username = $_POST['username'];
$password = $_POST['password'];
$name = $_POST['name'];
$email = $_POST['email'];
$contact = $_POST['phone'];

// Verificar se o username ou email já existem
$sql_check = "SELECT * FROM users WHERE username='$username' OR email='$email'";
$result_check = mysqli_query($con, $sql_check);

if (mysqli_num_rows($result_check) > 0) {
    // Redireciona para a página de registro com uma mensagem de erro
    header("location: ../register.php?error=existente");
} else {
    // Inserir usuário no banco de dados
    $sql_insert = "INSERT INTO users (username, password, name, email, contact) VALUES ('$username', '$password', '$name', '$email', '$contact')";
    if ($con->query($sql_insert) === TRUE) {
        // Redireciona para a página de login com sucesso
        header("location: ../login.php?success=true");
    } else {
        // Redireciona com mensagem de erro genérico
        header("location: ../register.php?error=failed");
    }
}
?>

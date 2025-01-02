<?php
// Verifica se o método de solicitação é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se o nome de usuário foi recebido por meio de uma solicitação POST
    if (isset($_POST['username'])) {
        // Conecte-se ao banco de dados (substitua 'host', 'username', 'password' e 'dbname' pelos valores do seu banco de dados)
        $conn = new mysqli('host', 'username', 'password', 'dbname');

        // Verifique se houve algum erro de conexão com o banco de dados
        if ($conn->connect_error) {
            die("Erro de conexão: " . $conn->connect_error);
        }

        // Prepare uma declaração SQL para verificar se o nome de usuário já existe no banco de dados
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $_POST['username']);
        $stmt->execute();

        // Obtenha o resultado da consulta
        $result = $stmt->get_result();

        // Verifique se o nome de usuário já existe no banco de dados
        if ($result->num_rows > 0) {
            echo "existente"; // Se o nome de usuário existir, retorne 'existente'
        } else {
            echo "nao_existente"; // Se o nome de usuário não existir, retorne 'nao_existente'
        }

        // Feche a declaração preparada e a conexão com o banco de dados
        $stmt->close();
        $conn->close();
    }
}
?>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('connect.php');

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Use prepared statements para evitar SQL injection
    $stmt = $con->prepare("SELECT * FROM enderecodeentrega WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row1 = $result->fetch_assoc()) {
            $rua = $row1['rua'];
            $bairro = $row1['bairro'];
            $numero = $row1['numero'];
            $complemento = $row1['complemento'];
        }

        $stmt->close();
    } else {
        
    }
} else {
    echo "User ID is not set in session.";
}
?>

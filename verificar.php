<?php
include '../includes/connect.php';

$username = $_POST['username'];
$email = $_POST['email'];

$sql = "SELECT * FROM users WHERE username='$username' OR email='$email'";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
    echo 'existente';
} else {
    echo 'disponivel';
}
?>

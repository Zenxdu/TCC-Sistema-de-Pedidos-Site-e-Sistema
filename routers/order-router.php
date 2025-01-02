<?php
include '../includes/connect.php';
include '../includes/wallet.php';
$total = 0;
$rua = htmlspecialchars($_POST['rua']);
$bairro = htmlspecialchars($_POST['bairro']);
$numero = htmlspecialchars($_POST['numero']);
$complemento = htmlspecialchars($_POST['complemento']);
$description = htmlspecialchars($_POST['description']);
$payment_type = $_POST['payment_type'];
$total = $_POST['total'];

$user_id = $_SESSION['user_id']; 
	
$sql = "INSERT INTO orders (customer_id, payment_type, address, total, description) VALUES ($user_id, '$payment_type', '$rua, $bairro, $numero', $total, '$description')";
	if ($con->query($sql) === TRUE){
		$order_id =  $con->insert_id;
		foreach ($_POST as $key => $value)
		{
			if(is_numeric($key)){
			$result = mysqli_query($con, "SELECT * FROM items WHERE id = $key");
			while($row = mysqli_fetch_array($result))
			{
				$price = $row['price'];
			}
				$price = $value*$price;
			$sql = "INSERT INTO order_details (order_id, item_id, quantity, price) VALUES ($order_id, $key, $value, $price)";
			$con->query($sql) === TRUE;		
			}
		}
			header("location: ../orders.php");
	}

?>
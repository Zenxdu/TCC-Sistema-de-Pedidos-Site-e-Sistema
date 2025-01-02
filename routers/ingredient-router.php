<?php
include '../includes/connect.php';

foreach ($_POST as $key => $value) {
    if (preg_match("/[0-9]+_name/", $key)) {
        if ($value != '') {
            $key = strtok($key, '_');
            $value = htmlspecialchars($value);
            $sql = "UPDATE ingredients SET name = '$value' WHERE id = $key;";
            $con->query($sql);
        }
    }
    if (preg_match("/[0-9]+_price/", $key)) {
        $key = strtok($key, '_');
        $sql = "UPDATE ingredients SET price = $value WHERE id = $key;";
        $con->query($sql);
    }
    if (preg_match("/[0-9]+_hide/", $key)) {
        $key = strtok($key, '_');
        if ($_POST[$key.'_hide'] == 1) {
            $sql = "UPDATE ingredients SET deleted = 0 WHERE id = $key;";
        } else {
            $sql = "UPDATE ingredients SET deleted = 1 WHERE id = $key;";
        }
        $con->query($sql);
    }
}

// Processar as imagens
foreach ($_FILES as $key => $file) {
    if (preg_match("/[0-9]+_image/", $key)) {
        $key = strtok($key, '_');
        $image_name = $file['name'];
        $image_tmp = $file['tmp_name'];
        $image_path = "../images/$image_name";
        if (move_uploaded_file($image_tmp, $image_path)) {
            $sql = "UPDATE ingredients SET image_path = 'images/$image_name' WHERE id = $key;";
            $con->query($sql);
        }
    }
}

header("location: ../admin-custom.php");
?>

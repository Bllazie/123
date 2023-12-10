<?php

$servername = "localhost";
$database = "jewelry";
$username = "root";
$password = "";

$conn = mysqli_connect($servername, $username, $password, $database);

$sql = "SELECT earrings.id, earrings.img_path, earrings.name, earrings.description, material.material_name, earrings.cost 
        FROM earrings 
        INNER JOIN material ON earrings.material = material.id 
        WHERE 1=1";


if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}


$result = $conn->query($sql);

?>


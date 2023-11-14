<?php

$servername = "localhost";
$database = "jewelry";
$username = "root";
$password = "";

$conn = mysqli_connect($servername, $username, $password, $database);

$sql = "SELECT * FROM earrings INNER JOIN material on earrings.material = material.id where 1=1";

if (isset($_GET['costFrom']) && $_GET['costFrom'] != '') {
    $costFrom = $_GET['costFrom'];
    $sql .= ' AND earrings.cost >= '.mysqli_real_escape_string($conn, $costFrom);
}
if (isset($_GET['costTo']) && $_GET['costTo'] != '') {
    $costTo = $_GET['costTo'];
    $sql .= ' AND earrings.cost <= '.mysqli_real_escape_string($conn, $costTo);
}
if (isset($_GET['material']) && $_GET['material'] != ''){
    $material = $_GET['material'];
    $sql .= ' AND material.id = '.mysqli_real_escape_string($conn, $material);
}
if (isset($_GET['description']) && $_GET['description'] != ''){
    $description = $_GET['description'];
    $sql .= ' AND earrings.description LIKE "%'.mysqli_real_escape_string($conn, $description).'%"';
}
if (isset($_GET['name']) && $_GET['name'] != ''){
    $name = $_GET['name'];
    $sql .= ' AND earrings.name LIKE "%'.mysqli_real_escape_string($conn, $name).'%"';
}

$fullList = $conn->query($sql);
foreach($fullList as $row){
    echo '<tr>
                <th><img src="inc/'.$row['img_path'].'" style="height: 200px; width: 250px;"></th>
                <td>'.$row['name'].'</td>
                <td>'.$row['material_name'].'</td>
                <td>'.$row['description'].'</td> 
                <td>'.$row['cost'].'</td>
            </tr>';
}
?>
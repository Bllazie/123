<?php

$servername = "localhost";
$database = "jewelry";
$username = "root";
$password = "";

$conn = mysqli_connect($servername, $username, $password, $database);

$sql = "SELECT * FROM earrings INNER JOIN material on earrings.material = material.id where 1=1";

$params = [];
$paramTypes = '';

if (isset($_GET['costFrom']) && $_GET['costFrom'] != '') {
    $costFrom = $_GET['costFrom'];
    $sql .= ' AND earrings.cost >= ?';
    $params[] = $costFrom;
    $paramTypes .= 'd';
}
if (isset($_GET['costTo']) && $_GET['costTo'] != '') {
    $costTo = $_GET['costTo'];
    $sql .= ' AND earrings.cost <= ?';
    $params[] = $costTo;
    $paramTypes .= 'd';
}
if (isset($_GET['material']) && $_GET['material'] != ''){
    $material = $_GET['material'];
    $sql .= ' AND material.id = ?';
    $params[] = $material;
    $paramTypes .= 'i';
}
if (isset($_GET['description']) && $_GET['description'] != ''){
    $description = $_GET['description'];
    $sql .= ' AND earrings.description LIKE ?';
    $params[] = "%$description%";
    $paramTypes .= 's';
}
if (isset($_GET['name']) && $_GET['name'] != ''){
    $name = $_GET['name'];
    $sql .= ' AND earrings.name LIKE ?';
    $params[] = "%$name%";
    $paramTypes .= 's';
}

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($paramTypes, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo '<tr>
                <th><img src="inc/'.$row['img_path'].'" style="height: 200px; width: 250px;"></th>
                <td>'.$row['name'].'</td>
                <td>'.$row['material_name'].'</td>
                <td>'.$row['description'].'</td> 
                <td>'.$row['cost'].'</td>
            </tr>';
}

$stmt->close();
$conn->close();

?

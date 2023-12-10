<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Соколов</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles_error.css">
    <?php require('sokolov.php'); ?>
</head>
<body>

<?php
require_once 'TableModule.php';

$tableModule = new TableModule($conn);

$img_path = $_POST['img_path'];
$name = $_POST['name'];
$description = $_POST['description'];
$material = $_POST['material'];
$cost = $_POST['cost'];

$res = $tableModule->addData($img_path, $name, $description, $material, $cost);

if ($res["success"]) {
    echo "Данные успешно добавлены в базу данных.";
    echo '<br><a href="index.php">На главную</a>';
} else {
    echo '<div class="error-container">';
    echo '<h4>Ошибка при добавлении данных:</h4>';
    foreach ($res["errors"] as $error) {
        echo '<p class="error-message">' . $error . '</p>';
    }
    echo '<a class="back-to-home" href="index.php">На главную</a>';
    echo '</div>';
}
?>

</body>
</html>

<?php
include 'header.php';

// Функция для генерации CSV файла и сохранения его на сервере
function saveDataToCSV($path, $conn)
{
    $tableName = 'earrings'; // Имя вашей таблицы
    $fileType = 'csv';
    $fileName = $tableName . '_' . date('YmdHis') . '.' . $fileType;
    $filePath = $_SERVER['DOCUMENT_ROOT'] . $path . $fileName; // Исправленный путь

    try {
        // Выборка данных из таблицы
        $stmt = $conn->query("SELECT * FROM $tableName");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Открытие потока для записи в CSV файл
        $stream = fopen($filePath, 'w');

        // Запись заголовков в CSV файл
        fputcsv($stream, array_keys($result[0]));

        // Запись данных в CSV файл
        foreach ($result as $row) {
            fputcsv($stream, $row);
        }

        // Закрытие потока
        fclose($stream);

        echo 'Файл с данными сохранен на диск по адресу: ' . $path . $fileName;
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}

// Обработка формы
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["export"])) {
    $path_to_save = $_POST["path_to_save"];
    saveDataToCSV($path_to_save, $pdo);
}
?>

<!-- Форма -->
<div class="save">
    <form method="post" action="export.php" enctype="multipart/form-data">
        <p>Путь сохранения csv относительно внешнего скрипта</p>
        <input type="text" class="form-control" id="path_to_save" name="path_to_save" placeholder="/LR5/upload/export.csv" required="">
        <button type="submit" class="btn btn-primary" name="export">Сохранить</button>
    </form>
</div>

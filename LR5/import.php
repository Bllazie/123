<?php
include 'header.php';

// Функция для обработки и импорта данных из загруженного пользователем файла
function importCSVFile($uploadedFile, $conn)
{
    $tableName = 'earrings'; // Имя вашей таблицы
    $importedTableName = $tableName . '_imported'; // Имя таблицы для импортированных данных

    try {
        // Создание таблицы для импортированных данных, если её еще нет
        $conn->exec("CREATE TABLE IF NOT EXISTS $importedTableName LIKE $tableName");

        // Открытие загруженного файла для чтения
        $handle = fopen($uploadedFile, 'r');

        // Получение заголовков CSV файла
        $headers = fgetcsv($handle);

        // Создание временной таблицы для импорта
        $conn->exec("CREATE TEMPORARY TABLE IF NOT EXISTS temp_import_table LIKE $importedTableName");

        // Генерация запроса для вставки данных
        $insertQuery = "INSERT INTO temp_import_table (" . implode(',', $headers) . ") VALUES (:" . implode(',:', $headers) . ")";

        // Подготовка запроса
        $stmt = $conn->prepare($insertQuery);

        // Чтение данных из CSV и вставка их во временную таблицу
        while (($data = fgetcsv($handle)) !== false) {
            $row = array_combine($headers, $data);
            $stmt->execute($row);
        }

        // Закрытие файла
        fclose($handle);

        // Вставка данных из временной таблицы в таблицу для импортированных данных
        $conn->exec("INSERT INTO $importedTableName SELECT * FROM temp_import_table");

        // Вывод сообщения о завершении импорта
        $rowCount = $conn->query("SELECT COUNT(*) FROM $importedTableName")->fetchColumn();
        echo "Файл с данными загружен и обработан. 
        Создана таблица $importedTableName и добавлено $rowCount записей.";
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}

// Обработка формы
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["import"])) {
    if ($_FILES['import_file']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['import_file']['tmp_name'];
        importCSVFile($tmpName, $pdo);
    } else {
        die('Ошибка загрузки файла.');
    }
}
?>

<!-- Форма импорта -->
<div class="save">
    <form method="post" action="import.php" enctype="multipart/form-data">
        <p>Выберите файл CSV для загрузки:</p>
        <input type="file" name="import_file" id="input_import_file" required="">
        <button type="submit" class="btn btn-primary" name="import">Импорт</button>
    </form>
</div>

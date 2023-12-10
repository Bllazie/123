<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавление данных</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles_form.css">
</head>
<body>
    <h2>Добавление данных в базу данных</h2>

    <form action="add_data.php" method="post">
        <label for="img_path">Изображение (ссылка на картинку):</label>
        <input type="text" name="img_path" required><br>

        <label for="name">Наименование:</label>
        <input type="text" name="name" required><br>

        <label for="description">Описание:</label>
        <textarea name="description" required></textarea><br>

        <label for="material">Материал:</label>
        <input type="text" name="material" required><br>

        <label for="cost">Стоимость:</label>
        <input type="text" name="cost" required><br>

        <input type="submit" value="Добавить">
    </form>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Соколов-драгоценности</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles_index.css">
    <?php require('sokolov.php'); ?>
</head>
<body>

<div class="container text-center mt-3">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Изображение</th>
            <th scope="col">Наименование</th>
            <th scope="col">Описание</th>
            <th scope="col">Материал</th>
            <th scope="col">Стоимость</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($result as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['id'], ENT_QUOTES, 'UTF-8') ?></td>
                <td>
                    <?php
                    $imgPath = $item['img_path'];

                    // Проверяем, является ли img_path URL-ссылкой
                    if (filter_var($imgPath, FILTER_VALIDATE_URL)) {
                        echo "<img src=\"$imgPath\" style=\"max-width: 150px;\">";
                    } else {
                        echo "<img src=\"inc/" . basename($imgPath) . "\" style=\"max-width: 150px;\">";
                    }
                    ?>
                </td>
                <td><?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($item['description'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($item['material_name'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($item['cost'], ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <a class="btn btn-primary" type="button" href="/LR6/add_form.php">Добавить</a>
</div>

</body>
</html>

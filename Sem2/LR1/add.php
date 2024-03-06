<?php
require_once "header.php";
require_once "TableModule.php";

$earringsModule = new TableModule('earrings');


if (isset($_GET['id'])) {
    $id = intval($_GET['id']);


    $earringsInv = $earringsModule->getById($id);

    if ($earringsInv) {

        $name = htmlspecialchars($earringsInv['name']);
        $description = htmlspecialchars($earringsInv['description']);
        $cost = intval($earringsInv['cost']);
        $img_path = $earringsInv['img_path'];
        $id_materials = intval($earringsInv['material']);

        $action = "edit";
    } else {

        echo "Ошибка: Украшение не найдено.";
        exit;
    }
} else {
    $name = "";
    $description = "";
    $cost = "";
    $img_path = "";
    $id_materials = "";

    $action = "add";
}


$materialModule = new TableModule("material");
$materials = $materialModule->getAll();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];


    if (empty($_POST['set_earrings_name'])) {
        $errors[] = "Название драгоценностей обязательно для заполнения.";
    } elseif (strlen($_POST['set_earrings_name']) > 60) {
        $errors[] = "Название драгоценностей не должно превышать 60 символов.";
    }


    if (!is_numeric($_POST['set_earrings_cost'])) {
        $errors[] = "Введите корректную стоимость.";
    }

    if (empty($errors)) {

        $data = [
            'name' => htmlspecialchars($_POST['set_earrings_name']),
            'description' => htmlspecialchars($_POST['set_earrings_recipe']),
            'cost' => intval($_POST['set_earrings_cost']),
            'material' => intval($_POST['set_earrings_store']),
        ];

        if (isset($_POST['id'])) {
            $data['id'] = intval($_POST['id']);
        }


        if (isset($_FILES['set_earrings_img']) && $_FILES['set_earrings_img']['error'] === UPLOAD_ERR_OK) {
            $img_name = uniqid('img_') . '_' . $_FILES['set_earrings_img']['name'];
            $img_path = 'img/' . $img_name;
            move_uploaded_file($_FILES['set_earrings_img']['tmp_name'], $img_path);
            $data['img_path'] = $img_name;
        }


        $errors = $earringsModule->insert($data);

        if (empty($errors)) {

            header('Location: earrings_list.php');
            exit();
        }
    } else {

        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    }
}
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="earrings_list.php">Драгоценности</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= ($action == "edit") ? "Редактирование украшения $name" : "Добавление украшения" ?></li>
    </ol>
</nav>

<h1><?= ($action == "edit") ? "Редактирование драгоценности $id" : "Добавление украшения" ?></h1>

<form class="row row-cols-lg-auto g-3 align-items-center" name="add_earrings" method="post" action="add.php" enctype="multipart/form-data">
    <input type="hidden" name="action" value="<?= $action ?>">
    <?php if ($action == "edit") : ?>
        <input type="hidden" name="id" value="<?= $id ?>">
    <?php endif; ?>
    <div class="col-4">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Название украшения" name="set_earrings_name" maxlength="60" title="Название украшения" value="<?= $name ?>">
        </div>
    </div>

    <div class="col-4">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Описание" name="set_earrings_recipe" maxlength="60" title="Описание" value="<?= $description ?>">
        </div>
    </div>

    <div class="col-4">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Стоимость" name="set_earrings_cost" maxlength="60" title="Стоимость" value="<?= $cost ?>">
        </div>
    </div>

    <div class="col-4">
        <div class="input-group">
            <input type="hidden" name="MAX_FILE_SIZE" value="3000000">
            <input type="file" class="form-control" name="set_earrings_img" title="Фото">
        </div>
    </div>

    <div class="col-4">
        <div class="input-group">
            <select class="form-select" aria-label="Материал" name="set_earrings_store" title="Материал">
                <option value="" selected disabled>Выберите материал</option>
                <?php foreach ($materials as $store) : ?>
                    <option value="<?= $store['id'] ?>" <?= ($store['id'] == $id_materials) ? "selected" : "" ?>><?= $store['material_name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="col-4">
        <button class="btn btn-primary" type="submit"><?= ($action == "edit") ? "Сохранить" : "Добавить" ?></button>
    </div>
</form>

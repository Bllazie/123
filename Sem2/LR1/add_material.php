<?php
require_once "head.php";
require_once "header.php";
require_once 'TableModule.php';

$materialModule = new TableModule("material");
$errors = [];

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $materialData = $materialModule->getById($id);

    if ($materialData) {
        $materialName = htmlspecialchars($materialData['material_name']);
        $action = "edit";
    } else {
        echo "Ошибка: Материал не найден.";
        exit;
    }
} else {
    $materialName = "";
    $action = "add";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $materialName = htmlspecialchars($_POST['material_name']);

    if (empty($materialName)) {
        $errors[] = "Название материала обязательно для заполнения.";
    }

    if (empty($errors)) {
        $data = array(
            "material_name" => $materialName
        );

        if ($action === "edit") {
            $data['id'] = intval($_POST['id']);
        }

        $errors = $materialModule->insert($data);

        if (empty($errors)) {
            header('Location: material_list.php');
            exit();
        }
    }
}
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="material_list.php">Список материалов</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= ($action == "edit") ? "Редактирование материала $materialName" : "Добавить/Изменить материал" ?></li>
    </ol>
</nav>
<h1><?= ($action == "edit") ? "Редактирование материала $materialName" : "Добавить/Изменить материал" ?></h1>

<?php if (!empty($errors)) : ?>
    <div class="alert alert-danger" role="alert">
        <?php foreach ($errors as $error) : ?>
            <?= $error ?><br>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="post" action="<?= ($action === "edit") ? "edit_material.php" : "add_material.php" ?>">
    <?php if ($action === "edit") : ?>
        <input type="hidden" name="id" value="<?= intval($id) ?>">
    <?php endif; ?>
    <div class="mb-3">
        <label for="material_name" class="form-label">Материал</label>
        <input type="text" class="form-control" id="material_name" name="material_name" required value="<?= ($action == 'edit') ? htmlspecialchars($materialName) : '' ?>">
    </div>
    <button type="submit" class="btn btn-primary"><?= ($action == "edit") ? "Сохранить" : "Добавить" ?></button>
</form>

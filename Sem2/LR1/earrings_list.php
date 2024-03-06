<?php
require_once 'header.php';
require_once 'TableModule.php';


$earringsModule = new TableModule("earrings");
$materialModule = new TableModule("material");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);


    $deleted = $earringsModule->delete($id);

}

$material_id  = isset($_GET['material_id']) ? $_GET['material_id'] : null;

$earringsInv = ($material_id !== null) ? $earringsModule->getAllByFilter("material = ?", [$material_id]) : $earringsModule->getAll();

?>


<body>

<div class="container">
    <h1>Список драгоценностей</h1>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">Изображение</th>
            <th scope="col">Наименование</th>
            <th scope="col">Материал</th>
            <th scope="col">Описание</th>
            <th scope="col">Стоимость</th>
            <th colspan="2">Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($earringsInv as $earringsInv) : ?>
            <tr>
                <th scope="row"><?php echo intval($earringsInv['id']); ?></th>
                <th scope="row"><img src="img/<?=$earringsInv['img_path']?>" style="max-width: 150px;" alt=""></th>
                <td><?php echo htmlspecialchars($earringsInv['name']); ?></td>
                <td><?php
                    $materialData = $materialModule->getById($earringsInv['material']);


                    if (is_array($materialData)) {
                        $substance_name = $materialData['id'];
                    } else {
                        $substance_name = '';
                    }

                    echo htmlspecialchars($substance_name);
                    ?></td>
                <td><?php echo htmlspecialchars($earringsInv['description']); ?></td>
                <td><?php echo intval($earringsInv['cost']); ?></td>
                <td>
                    <a href="add.php?id=<?php echo intval($earringsInv['id']); ?>" class="btn btn-primary">Изменить</a>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="delete_id" value="<?php echo intval($earringsInv['id']); ?>">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Удалить это?');">Удалить</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <a class="btn btn-primary" type="button" href="add.php">Добавить</a>
</div>

</body>

</html>

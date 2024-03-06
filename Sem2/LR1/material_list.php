<?php
require_once 'header.php';
require_once 'TableModule.php';


$materialModule = new TableModule("material");
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];


    $deleted = $materialModule->delete($id);
}

$materials = $materialModule->getAll();

?>

<body>

<div class="container">
    <h1>Список материалов</h1>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Название</th>
            <th scope="col">Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($materials as $material) : ?>
            <tr>
                <th scope="row"><?php echo intval($material['id']); ?></th>

                <td><a href="earrings_list.php?material_id=<?php echo intval($material['id']); ?>"><?php echo htmlspecialchars($material['material_name']); ?></a></td>

                <!--<td><a href="earrings_list.php?materials_id=<?php /*echo intval($material['id']); */?>"><?php /*echo htmlspecialchars($material['material_name']); */?></a></td>
                -->

                <td>
                    <a href="add_material.php" class="btn btn-primary">Изменить</a>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="delete_id" value="<?php echo intval($material['id']); ?>">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Вы хотите удалить запись?');">Удалить</button>
                    </form>

                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <a class="btn btn-primary" type="button" href="add_material.php">Добавить</a>
</div>

</body>

</html>

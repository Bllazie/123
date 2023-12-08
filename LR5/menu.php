
<?php if(isset($_SESSION['email'])) {
    // Пользователь авторизован
}
 ?>
<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger"><?php echo $_SESSION['error_message']; ?></div>
    <?php unset($_SESSION['error_message']);
endif; ?>

<?php include 'header.php'?>

<div class="main">
    <div class="container text-center">
        <form action="menu.php" method="get">
            <label class="filtr">Фильтрация результата поиска</label>
            <div class="mb">
                <label>По цене:</label>
                <input type="number" name="costFrom" placeholder="Цена от" value='' class="form-control">
                <input type="number" name="costTo" placeholder="Цена до" value='' class="form-control mt-3">
            </div>
            <div class="mb">
                <label>Фильтрация по материалу:</label>
                <select name="material" class="form-control">
                    <option value="" selected>Выберите материал</option>
                    <option value="1">Комбинированное золото 585 пробы</option>
                    <option value="2">Красное золото 585 пробы</option>
                    <option value="3">Белое золото 585 пробы</option>
                </select>
            </div>
            <div class="mb">
                <label>Фильтрация по описанию:</label>
                <textarea class="form-control" placeholder="Введите описание товара" name="description"></textarea>
            </div>
            <div class="mb">
                <label>Фильтрация по наименованию:</label>
                <input type="text" name="name" placeholder="Введите наименование товара" value='' class="form-control">
            </div>
            <input type="submit" value="Применить фильтр" class="btn btn-primary">
            <input type="submit" name="clearFilter" value="Очистить фильтр" class="btn btn-danger">
        </form>
    </div>
    <div class="container text-center mt-3">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Изображение</th>
                <th scope="col">Наименование</th>
                <th scope="col">Материал</th>
                <th scope="col">Описание</th>
                <th scope="col">Стоимость</th>
            </tr>
            </thead>
            <tbody>
            <?php
            include("logic.php");
            ?>


            </tbody>
        </table>
    </div>
</div>
</body>
</html>
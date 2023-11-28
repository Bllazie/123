
<?php include 'header.php'?>

<?php
// Функция для предзаполнения полей формы из $_POST с фильтрацией
function prefill($field) {
    return isset($_POST[$field]) ? htmlspecialchars($_POST[$field]) : '';
}
 if(isset($_SESSION['email'])){
    header("Location: jewerly.php");
exit();}
    ?>
<div class="main py-5">
    <div class="container py-5">
        <div class="row">
            <p class="py-2"><a href="jewerly.php">Домашняя страница</a> &gt; Создание аккаунта </p>
        </div>
        <!-- Форма -->
        <div class="col-md-5 mx-auto">
            <form action="signup_process.php" method="POST">
                <input type="hidden" name="action" value="signup">
                <?php
                if (isset($_SESSION['error_message'])) {
                    echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
                    unset($_SESSION['error_message']);
                }
                ?>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="example@example.com" value="<?php echo (isset($_SESSION['form_data']['email']) ? htmlspecialchars($_SESSION['form_data']['email']) : ''); ?>">
                </div>
                <div class="form-group">
                    <label for="full_name">ФИО</label>
                    <input type="text" name="full_name" id="full_name" class="form-control" placeholder="Иванов Иван Иванович" value="<?php echo (isset($_SESSION['form_data']['full_name']) ? htmlspecialchars($_SESSION['form_data']['full_name']) : ''); ?>">
                </div>
                <div class="form-group">
                    <label for="date">Дата рождения</label>
                    <input type="date" name="date" id="date" class="form-control" value="<?php echo (isset($_SESSION['form_data']['date']) ? htmlspecialchars($_SESSION['form_data']['date']) : ''); ?>">
                </div>
                <div class="form-group">
                    <label for="gender">Пол</label>
                    <select name="gender" id="gender" class="form-control">
                        <option value="" selected="">Пол</option>
                        <option value="man"<?php if (isset($_SESSION['form_data']['gender']) && $_SESSION['form_data']['gender'] == 'man') { echo ' selected'; } ?>>Мужчина</option>
                        <option value="woman"<?php if (isset($_SESSION['form_data']['gender']) && $_SESSION['form_data']['gender'] == 'woman') { echo ' selected'; } ?>>Женщина</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="address">Адрес</label>
                    <input type="text" name="address" id="address" class="form-control" placeholder="г.xxx,ул.xxx,д.xxx" value="<?php echo (isset($_SESSION['form_data']['address']) ? htmlspecialchars($_SESSION['form_data']['address']) : ''); ?>">
                </div>
                <div class="form-group">
                    <label for="blood">Группа Крови</label>
                    <select name="blood" id="blood" class="form-control">
                        <option value="" selected="">Группа Крови</option>
                        <option value="0 (I)"<?php if (isset($_SESSION['form_data']['blood']) && $_SESSION['form_data']['blood'] == '0 (I)') { echo ' selected'; } ?>>0 (I)</option>
                        <option value="A (II)"<?php if (isset($_SESSION['form_data']['blood']) && $_SESSION['form_data']['blood'] == 'A (II)') { echo ' selected'; }?>>A (II)</option>
                        <option value="B (III)"<?php if (isset($_SESSION['form_data']['blood']) && $_SESSION['form_data']['blood'] == 'B (III)') { echo ' selected'; }?>>B (III)</option>
                        <option value="AB (IV)"<?php if (isset($_SESSION['form_data']['blood']) && $_SESSION['form_data']['blood'] == 'AB (IV)') { echo ' selected'; }?>>AB (IV)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="rhesus">Резус фактор</label>
                    <select name="rhesus" id="rhesus" class="form-control">
                        <option value="" selected="">Резус фактор</option>
                        <option value="Положительный (+)"<?php if (isset($_SESSION['form_data']['rhesus']) && $_SESSION['form_data']['rhesus'] == 'Положительный (+)') { echo ' selected'; } ?>>Положительный (+)</option>
                        <option value="Отрицательный (-)"<?php if (isset($_SESSION['form_data']['rhesus']) && $_SESSION['form_data']['rhesus'] == 'Отрицательный (-)') { echo ' selected'; }?>>Отрицательный (-)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="interes">Интересы</label>
                    <input type="text" name="interes" id="interes" class="form-control" placeholder="Мне интересно/нравится....." value="<?php echo (isset($_SESSION['form_data']['interes']) ? htmlspecialchars($_SESSION['form_data']['interes']) : ''); ?>">

                    <label for="url">Ссылка на vk.com</label>
                    <input type="text" name="url" id="url" class="form-control" placeholder="https://vk.com/example" value="<?php echo (isset($_SESSION['form_data']['url']) ? htmlspecialchars($_SESSION['form_data']['url']) : ''); ?>">
                </div>
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Совершенно секретно">
                    <label for="password_confirm">Подтвердите пароль</label>
                    <input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="Совершенно секретно">
                </div>
                <div class="col-md-12 text-center ">
                    <button type="submit" class="btn btn-block btn-primary tx-tfm register-btn">
                        Зарегистрироваться
                    </button>
                </div>
                <div class="form-group">
                    <p class="text-center">Уже есть аккаунт? <a href="login.php">Войти в аккаунт</a></p>
                </div>
            </form>
        </div>
    </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
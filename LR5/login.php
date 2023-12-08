
<body>
<?php include 'header.php'?>
<?php if(isset($_SESSION['email'])){
header("Location login.php");
exit();}
?>
<div class="main py-5">
    <div class="container">
        <div class="row">
            <p class="py-2"> <a href="jewerly.php">Домашняя страница</a> &gt; Вход в аккаунт </p>
        </div>
        <!-- Form -->
        <div class="col-md-5 mx-auto">

            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger"><?php echo $_SESSION['error_message']; ?></div>
                <?php unset($_SESSION['error_message']);
            endif; ?>

            <form action="login_process.php" method="POST">
                <input type="hidden" name="action" value="signin">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="example@example.com" value="<?php echo (isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''); ?>">
                </div>
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="**********">
                </div>
                <div class="col-md-12 text-center ">
                    <button type="submit" class=" btn btn-block mybtn btn-primary tx-tfm login-btn">Войти</button>
                </div>
                <div class="form-group">
                    <p class="text-center">Ещё нет аккаунта? <a href="signup.php">Зарегистрируйтесь</a></p>
                </div>
            </form>
        </div>
    </div>
</div>
</header>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
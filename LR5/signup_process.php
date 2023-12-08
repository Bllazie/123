<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'db_connection.php';  // Подключение к базе данных

    function validateEmail($email) {
        // Проверка наличия символа @
        if (strpos($email, '@') === false) {
            return false;
        }

        return true;
    }

    // Получение данных из формы
    $email = $_POST["email"];
    $full_name = $_POST["full_name"];
    $date = $_POST["date"];
    $gender = $_POST["gender"];
    $address = $_POST["address"];
    $blood = $_POST["blood"];
    $rhesus = $_POST["rhesus"];
    $interes = $_POST["interes"];
    $url = $_POST["url"];
    $password = $_POST["password"];
    $password_confirm = $_POST["password_confirm"];

    // Проверка требований к паролю
    $uppercase = preg_match('/[A-Z]/', $password);  // содержит большие латинские буквы
    $lowercase = preg_match('/[a-z]/', $password);  // содержит маленькие латинские буквы
    $special_chars = preg_match('/[^a-zA-Z0-9]/', $password);  // содержит спецсимволы (знаки препинания, арифметические действия и тп)
    $no_russian_chars = preg_match('/[а-яА-Я]/u', $password);  // не содержит русские буквы

    // Проверка валидности email
    if (!validateEmail($email)) {
        $_SESSION['error_message'] = "Email некорректный!";
    }

    // Проверка длины и требований к паролю
    if (strlen($password) < 6 || !$uppercase || !$lowercase || !$special_chars || $no_russian_chars) {
        $_SESSION['error_message'] = "Требования к паролю не соблюдены!
        Требования к паролю: длиннее 6 символов, обязательно содержит большие латинские буквы, маленькие латинские буквы, спецсимволы (знаки препинания, арифметические действия и тп). 
Русские буквы запрещены.
";
    }

    if ($password == $password_confirm) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    } else {
        $_SESSION['error_message'] = "Пароли не совпадают!";
    }


    if (isset($_SESSION['error_message'])) {
        $_SESSION['form_data'] = $_POST;
        header("Location: signup.php"); // Перенаправление обратно на форму регистрации с ошибками в сеансе
        exit();
    }

    // Используем подготовленные запросы для обеспечения безопасности
    $check_email_sql = "SELECT * FROM users WHERE email = :email";
    $check_email_stmt = $pdo->prepare($check_email_sql);
    $check_email_stmt->bindParam(':email', $email);
    $check_email_stmt->execute();

    if ($check_email_stmt->rowCount() > 0) {
        header("Location signup_process.php");
        $_SESSION['error_message'] ="Пользователь с такой почтой уже существует.";
    } else
    {
        // Вставка нового пользователя в базу данных с использованием подготовленного запроса
        $insert_sql = "INSERT INTO users (email,full_name,date,gender,adress,password,interes,url,rhesus,blood) VALUES (:email, :full_name, :date, :gender, :address, :hashed_password,:interes,:url,:rhesus,:blood)";
        $insert_stmt = $pdo->prepare($insert_sql);
        $insert_stmt->bindParam(':email', $email);
        $insert_stmt->bindParam(':full_name', $full_name);
        $insert_stmt->bindParam(':date', $date);
        $insert_stmt->bindParam(':gender', $gender);
        $insert_stmt->bindParam(':address', $address);
        $insert_stmt->bindParam(':interes', $interes);
        $insert_stmt->bindParam(':url', $url);
        $insert_stmt->bindParam(':rhesus', $rhesus);
        $insert_stmt->bindParam(':blood', $blood);
        $insert_stmt->bindParam(':hashed_password', $hashed_password);

        if ($insert_stmt->execute()) {
            header("Location: login.php");
        } else {
            echo 'Ошибка регистрации: ' . $insert_stmt->errorInfo()[2];
        }
    }

    $pdo = null;
}
?>
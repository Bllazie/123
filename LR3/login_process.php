<?php

// Проверяем, есть ли уже сессионные переменные для счетчика попыток и времени
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

if (!isset($_SESSION['last_login_attempt_time'])) {
    $_SESSION['last_login_attempt_time'] = time();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'db_connection.php';
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Проверяем, не прошло ли уже часа с последней неудачной попытки
        $lastAttemptTime = $_SESSION['last_login_attempt_time'];
        if (time() - $lastAttemptTime >= 3600) {
            // Если прошло больше часа, сбрасываем счетчик попыток
            $_SESSION['login_attempts'] = 0;
        }

        // Проверяем, не превысили ли пользователь три неудачных попытки
        if ($_SESSION['login_attempts'] < 3) {
            // Продолжаем обработку попытки входа

            // Запрос к базе данных для получения хешированного пароля и проверки существования пользователя
            $stmt = $pdo->prepare("SELECT password FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $hashedPassword = $row['password'];

                // Проверка введенного пароля с хешированным паролем
                if (password_verify($password, $hashedPassword)) {
                    // Пароль верен, пользователь аутентифицирован
                    $_SESSION['email'] = $email; // Save the email in session for prefilling
                    $_SESSION['login_attempts'] = 0; // Сбрасываем счетчик попыток
                    header("Location: jewerly.php"); // Перенаправление на страницу после успешной аутентификации
                } else {
                    // Неверный пароль
                    $_SESSION['login_attempts']++;
                    $_SESSION['error_message'] = "Неверные учетные данные. Пожалуйста, попробуйте снова.";
                    header("Location: login.php");
                    exit();
                }
            } else {
                // Пользователь не найден
                $_SESSION['login_attempts']++;
                $_SESSION['error_message'] = "Пользователь не найден. Пожалуйста, проверьте имя пользователя.";
                header("Location: login.php");
                exit();
            }


            // Обновляем время последней попытки
            $_SESSION['last_login_attempt_time'] = time();
        } else {
            // Пользователь превысил лимит попыток, блокируем вход на 1 час
            echo "Превышен лимит попыток. Попробуйте снова через 1 час.";
        }
    } else {
        // Если не переданы данные из формы, выполните соответствующие действия
        echo "Данные формы не переданы.";
    }

    // Закрытие соединения с базой данных
    $pdo = null;
}

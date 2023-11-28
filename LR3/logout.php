<?php
// Начать сессию (если еще не начата)
session_start();

// Уничтожить все данные сессии
session_unset();
session_destroy();

// Перенаправление на страницу входа или другую страницу по вашему выбору
header("Location: login.php");
exit();

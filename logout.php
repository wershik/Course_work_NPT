<?php
    //Запускаем сессию
    session_start();

    unset($_SESSION["login"]);
    unset($_SESSION["password"]);
    unset($_SESSION["role"]);

    // Возвращаем пользователя на ту страницу, на которой он нажал на кнопку выход.
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: index.php");

    session_destroy();
?>

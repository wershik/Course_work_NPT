<?
    // Указываем кодировку
    header('Content-Type: text/html; charset=utf-8');

    include_once 'globalsettings.php';

    




    // Подключение к базе данных через MySQLi
    $mysqli = @new mysqli($MySQL_hostname, $MySQL_username, $MySQL_password, $MySQL_databasename);

    // Проверяем, успешность соединения.
    if ($mysqli->connect_errno) {
        die("<p><strong>Ошибка подключения к БД</strong></p><p><strong>Код ошибки: </strong> ". $mysqli->connect_errno ." </p><p><strong>Описание ошибки:</strong> ".$mysqli->connect_error."</p>");
    }
    //else echo "good";

    // Устанавливаем кодировку подключения
    $mysqli->set_charset('utf8');

    //Для удобства, добавим здесь переменную, которая будет содержать адрес (URL) нашего сайта
    $address_site = "http://d92970ys.beget.tech";
?>

<?php
//Запускаем сессию
session_start();

//Добавляем файл подключения к БД
require_once("connToDB.php");


//Объявляем ячейку для добавления ошибок, которые могут возникнуть при обработке формы.
$_SESSION["error_messages"] = '';

//Объявляем ячейку для добавления успешных сообщений
$_SESSION["success_messages"] = '';




/*
Проверяем была ли отправлена форма, то есть была ли нажата кнопка Войти. Если да, то идём дальше, если нет, то выведем пользователю сообщение об ошибке, о том что он зашёл на эту страницу напрямую.
*/
if(isset($_POST["btn_submit_auth"]) && !empty($_POST["btn_submit_auth"])){

  //Проверяем полученную капчу
  if(isset($_POST["captcha"])){

    //Обрезаем пробелы с начала и с конца строки
    $captcha = trim($_POST["captcha"]);

    if(!empty($captcha)){

      //Сравниваем полученное значение с значением из сессии.
      if(($_SESSION["rand"] != $captcha) && ($_SESSION["rand"] != "")){

        // Если капча не верна, то возвращаем пользователя на страницу авторизации, и там выведем ему сообщение об ошибке что он ввёл неправильную капчу.

        $error_message = "<p class='mesage_error'><strong>Ошибка!</strong> Вы ввели неправильную капчу </p>";

        // Сохраняем в сессию сообщение об ошибке.
        $_SESSION["error_messages"] = $error_message;

        //Возвращаем пользователя на страницу авторизации
        header("HTTP/1.1 301 Moved Permanently");
        header('Location: form_auth.php');

        //Останавливаем скрипт
        exit();
      }

    }else{

      $error_message = "<p class='mesage_error'><strong>Ошибка!</strong> Поле для ввода капчи не должна быть пустой. </p>";

      // Сохраняем в сессию сообщение об ошибке.
      $_SESSION["error_messages"] = $error_message;

      //Возвращаем пользователя на страницу авторизации
      header("HTTP/1.1 301 Moved Permanently");
      header("Location: ".$address_site."/form_auth.php");

      //Останавливаем скрипт
      exit();

    }

    //Обрезаем пробелы с начала и с конца строки
    $login = trim($_POST["login"]);
    if(isset($_POST["login"])){

      if(!empty($login)){
        $login = htmlspecialchars($login, ENT_QUOTES);

      }else{
        // Сохраняем в сессию сообщение об ошибке.
        $_SESSION["error_messages"] .= "<p class='mesage_error' >Поле для ввода login не должно быть пустым.</p>";

        //Возвращаем пользователя на страницу регистрации
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ".$address_site."/form_auth.php");

        //Останавливаем скрипт
        exit();
      }


    }else{
      // Сохраняем в сессию сообщение об ошибке.
      $_SESSION["error_messages"] .= "<p class='mesage_error' >Отсутствует поле для ввода Login</p>";

      //Возвращаем пользователя на страницу авторизации
      header("HTTP/1.1 301 Moved Permanently");
      header("Location: ".$address_site."/form_auth.php");

      //Останавливаем скрипт
      exit();
    }


    if(isset($_POST["password"])){

      //Обрезаем пробелы с начала и с конца строки
      $password = trim($_POST["password"]);

      if(!empty($password)){
        $password = htmlspecialchars($password, ENT_QUOTES);

        //Шифруем пароль
        $password = md5($password."top_secret");
      }else{
        // Сохраняем в сессию сообщение об ошибке.
        $_SESSION["error_messages"] .= "<p class='mesage_error' >Укажите Ваш пароль</p>";

        //Возвращаем пользователя на страницу регистрации
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ".$address_site."/form_auth.php");

        //Останавливаем скрипт
        exit();
      }

    }else{
      // Сохраняем в сессию сообщение об ошибке.
      $_SESSION["error_messages"] .= "<p class='mesage_error' >Отсутствует поле для ввода пароля</p>";

      //Возвращаем пользователя на страницу регистрации
      header("HTTP/1.1 301 Moved Permanently");
      header("Location: ".$address_site."/form_auth.php");

      //Останавливаем скрипт
      exit();
    }

    //echo "good";

    //Запрос в БД на выборке пользователя.
    $result_query_select = $mysqli->query("SELECT * FROM $MySQL_table_Users WHERE Login = '$login' AND Pass = '$password'");
    //echo "SELECT * FROM $MySQL_table_Users WHERE Login = '$login' AND Pass = '$password'";
    if(!$result_query_select){
      // Сохраняем в сессию сообщение об ошибке.
      $_SESSION["error_messages"] .= "<p class='mesage_error' >Ошибка запроса на выборке пользователя из БД</p>";

      //Возвращаем пользователя на страницу регистрации
      header("HTTP/1.1 301 Moved Permanently");
      header("Location: ".$address_site."/form_auth.php");

      //Останавливаем скрипт
      exit();
    }else{

      //Проверяем, если в базе нет пользователя с такими данными, то выводим сообщение об ошибке
      if($result_query_select->num_rows == 1){
        $row = $result_query_select->fetch_assoc();
        if($row['Status'] == 1){
          // Если введенные данные совпадают с данными из базы, то сохраняем логин и пароль в массив сессий.
          $_SESSION['login'] = $login;
          $_SESSION['password'] = $password;


          $_SESSION['role'] = $row['Role'];


          //Возвращаем пользователя на главную страницу
          header("HTTP/1.1 301 Moved Permanently");
          header("Location: ".$address_site."/index.php");

          exit();
        }
        elseif($row['Status'] == 0) {
          $_SESSION["error_messages"] .= "<p class='mesage_error' >Вы забанены!!!</p>";

          //Возвращаем пользователя на страницу авторизации
          header("HTTP/1.1 301 Moved Permanently");
          header("Location: ".$address_site."/form_auth.php");

          //Останавливаем скрипт
          exit();
        }
      }else{

        // Сохраняем в сессию сообщение об ошибке.
        $_SESSION["error_messages"] .= "<p class='mesage_error' >Неправильный логин и/или пароль</p>";

        //Возвращаем пользователя на страницу авторизации
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ".$address_site."/form_auth.php");

        //Останавливаем скрипт
        exit();
      }
    }



  }else{
    //Если капча не передана
    exit("<p><strong>Ошибка!</strong> Отсутствует проверочный код, то есть код капчи. Вы можете перейти на <a href=".$address_site."> главную страницу </a>.</p>");
  }

}else{
  exit("<p><strong>Ошибка!</strong> Вы зашли на эту страницу напрямую, поэтому нет данных для обработки. Вы можете перейти на <a href=".$address_site."> главную страницу </a>.</p>");
}

?>

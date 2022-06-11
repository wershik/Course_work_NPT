<?php
//Запускаем сессию
session_start();

//Добавляем файл подключения к БД
require_once("connToDB.php");



//Объявляем ячейку для добавления ошибок, которые могут возникнуть при обработке формы.
$_SESSION["error_messages"] = '';

//Объявляем ячейку для добавления успешных сообщений
$_SESSION["success_messages"] = '';



if(isset($_POST["btn_submit_adm_1"]) && !empty($_POST["btn_submit_adm_1"])){

  if(isset($_POST["id_h_text"])){
    $id_h_text = $_POST["id_h_text"];

    $result = mysqli_query($mysqli, "SELECT Id, Role, Status FROM $MySQL_table_Users WHERE Id = '$id_h_text'");
    // echo "SELECT Id, Role, Status FROM $MySQL_table_Users WHERE Id = '$id_h_text'";
    $row = mysqli_fetch_array($result);

    if($row['Role'] != 111){
      if($row['Status'] == 1){

        $sql = "UPDATE Users SET Status = 0 WHERE id = '".$row['Id']."'";
        if($result = mysqli_query($mysqli, $sql)){
          $_SESSION["success_messages"] = "Успешно";
          header("HTTP/1.1 301 Moved Permanently");
          header("Location: ".$address_site."/adm.php");
          exit();
          // echo "UPDATE Users SET Status = 0 WHERE id = '".$row['Id']."'";
        } else{
          $_SESSION["error_messages"] = "Ошибка: " . mysqli_error($conn);
        }

      }
      elseif($row['Status'] == 0) {
        $sql = "UPDATE Users SET Status = 1 WHERE id = '".$row['Id']."'";
        if($result = mysqli_query($mysqli, $sql)){
          $_SESSION["success_messages"] = "Успешно";
          header("HTTP/1.1 301 Moved Permanently");
          header("Location: ".$address_site."/adm.php");
          exit();
          // echo "UPDATE Users SET Status = 0 WHERE id = '".$row['Id']."'";
        } else{
          $_SESSION["error_messages"] = "Ошибка: " . mysqli_error($conn);
        }
      }
    }
    else {
      $_SESSION["error_messages"] = "Нет доступа";
      header("HTTP/1.1 301 Moved Permanently");
      header("Location: ".$address_site."/adm.php");
      exit();
    }
  }
  else{

  }
}
elseif ((isset($_POST["btn_submit_adm_2"]) && !empty($_POST["btn_submit_adm_2"]))) {
  if(isset($_POST["id_h_text"])){
    $id_h_text = $_POST["id_h_text"];

    $result = mysqli_query($mysqli, "SELECT Id, Role, Status FROM $MySQL_table_Users WHERE Id = '$id_h_text'");
    // echo "SELECT Id, Role, Status FROM $MySQL_table_Users WHERE Id = '$id_h_text'";
    $row = mysqli_fetch_array($result);

    if($row['Role'] == 1){


      $sql = "UPDATE Users SET Role = 11 WHERE id = '".$row['Id']."'";
      if($result = mysqli_query($mysqli, $sql)){
        $_SESSION["success_messages"] = "Успешно";
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ".$address_site."/adm.php");
        exit();

      } else{
        $_SESSION["error_messages"] = "Ошибка: " . mysqli_error($conn);
      }

    }
    elseif ($row['Role'] == 11) {
      $sql = "UPDATE Users SET Role = 111 WHERE id = '".$row['Id']."'";
      if($result = mysqli_query($mysqli, $sql)){
        $_SESSION["success_messages"] = "Успешно";
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ".$address_site."/adm.php");
        exit();

      } else{
        $_SESSION["error_messages"] = "Ошибка: " . mysqli_error($conn);
      }
    }
    elseif ($row['Role'] == 111)
    {
      $_SESSION["error_messages"] = "Уже макстимальный доступ";
      header("HTTP/1.1 301 Moved Permanently");
      header("Location: ".$address_site."/adm.php");
      exit();
    }
    else {
      $_SESSION["error_messages"] = "Нет доступа";
      header("HTTP/1.1 301 Moved Permanently");
      header("Location: ".$address_site."/adm.php");
      exit();
    }
  }
  else{

  }
}
elseif ((isset($_POST["btn_submit_adm_3"]) && !empty($_POST["btn_submit_adm_3"]))) {
  if(isset($_POST["id_h_text"])){
    $id_h_text = $_POST["id_h_text"];

    $result = mysqli_query($mysqli, "SELECT Id, Role, Status FROM $MySQL_table_Users WHERE Id = '$id_h_text'");
    // echo "SELECT Id, Role, Status FROM $MySQL_table_Users WHERE Id = '$id_h_text'";
    $row = mysqli_fetch_array($result);

    if($row['Role'] == 1){


      $_SESSION["error_messages"] = "Уже минимальный доступ";
      header("HTTP/1.1 301 Moved Permanently");
      header("Location: ".$address_site."/adm.php");
      exit();

    }
    elseif ($row['Role'] == 11) {
      $sql = "UPDATE Users SET Role = 1 WHERE id = '".$row['Id']."'";
      if($result = mysqli_query($mysqli, $sql)){
        $_SESSION["success_messages"] = "Успешно";
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ".$address_site."/adm.php");
        exit();

      } else{
        $_SESSION["error_messages"] = "Ошибка: " . mysqli_error($conn);
      }
    }
    elseif ($row['Role'] == 111)
    {
      $_SESSION["error_messages"] = "Обратитесь к системному администратору";
      header("HTTP/1.1 301 Moved Permanently");
      header("Location: ".$address_site."/adm.php");
      exit();
    }
    else {
      $_SESSION["error_messages"] = "Нет доступа";
      header("HTTP/1.1 301 Moved Permanently");
      header("Location: ".$address_site."/adm.php");
      exit();
    }
  }
  else{

  }
}
else{
  exit("<p><strong>Ошибка!</strong> Вы зашли на эту страницу напрямую, поэтому нет данных для обработки. Вы можете перейти на <a href=".$address_site."> главную страницу </a>.</p>");
}

?>

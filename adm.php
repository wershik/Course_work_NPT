<?php
//Подключение шапки
require_once("header.php");
require_once("connToDB.php");

?>

<div id="content">

  <h2>Админ панель</h2>
  <div class="block_for_messages">
      <?php

          if(isset($_SESSION["error_messages"]) && !empty($_SESSION["error_messages"])){
              echo $_SESSION["error_messages"];

              //Уничтожаем чтобы не появилось заново при обновлении страницы
              unset($_SESSION["error_messages"]);
          }

          if(isset($_SESSION["success_messages"]) && !empty($_SESSION["success_messages"])){
              echo $_SESSION["success_messages"];

              //Уничтожаем чтобы не появилось заново при обновлении страницы
              unset($_SESSION["success_messages"]);
          }
      ?>
  </div>

  <table>
    <thead>
      <tr>
        <td>id</td>
        <td>login</td>
        <td>имя</td>
        <td>email</td>
        <td>роль</td>
        <td>статус</td>
      </tr>
    </thead>
    <?php
    $result = mysqli_query($mysqli, "SELECT id, login, name, email, role, status FROM Users");
    $i = 0;
    while($row = mysqli_fetch_array($result)){
      $flag = true;
      //$flag2 = true;
      ?>
      <tr>
        <form action="ban_user.php" method="POST" name="form_adm_<? echo $i; ?>">
          <input type="hidden" name="id_h_text" value="<? echo $row['id']; ?>">
          <td><?php echo $row['id']; ?></td>
          <td><?php echo $row['login']; ?></td>
          <td><?php echo $row['name']; ?></td>
          <td><?php echo $row['email']; ?></td>
          <td><?php
          if($row['role'] == 1) echo "Пользователь";
          elseif ($row['role'] == 11) echo "Менеджер";
          elseif ($row['role'] == 111) echo "Администратор";
          else echo "Не определён";
          ?></td>
          <td><?php
          if($row['status'] == 1) echo "Активный";
          else {echo "Забанен"; $flag = false;}
          ?></td>
          <td>
            <input type="<? if($row['role'] == 111) echo "hidden"; else echo "submit"; ?>" name="btn_submit_adm_1" value="<? if($flag) echo "Забанить"; else echo "Разбанить"; ?>">
          </td>
          <td>
            <input type="<? if($row['role'] == 111) echo "hidden"; else echo "submit"; ?>" name="btn_submit_adm_2" value="Повысить">
          </td>
          <td>
            <input type="<? if($row['role'] == 1 || $row['role'] == 111) echo "hidden"; else echo "submit"; ?>" name="btn_submit_adm_3" value="Понизить">
          </td>
        </form>
      </tr>
    <?php $i++;} ?>
  </table>





</div>

<?php
//Подключение подвала
require_once("footer.php");
?>

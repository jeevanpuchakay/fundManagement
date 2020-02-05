<?php
session_start();
require 'config.php';
if(isset($_POST['but_submit'])){
    $uname = ($_POST['username']);
    $password = ($_POST['password']);
    if ($uname != "" && $password != ""){
      $query = $con->prepare('select admin_id, password from admin where admin.admin_id = ? and admin.password = ?');
      $query->execute(array($uname,$password));
      $row = $query->fetch(PDO::FETCH_BOTH);
      if($query->rowCount()>0) {
          $_SESSION['username'] = $uname;
          header('location: admin.html');
      } 
      else {
          $message = "Username/Password is wrong";
          echo '<script> alert ("Wrong user id or password"); window.history.back();</script>';
      }
    }
}
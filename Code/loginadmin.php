<?php
session_start();
$dsn = "mysql:host=localhost;port=3307;dbname=fund";
$con = new PDO($dsn,"root","");
$sql= $con->prepare("SELECT * FROM users ");
$sql->execute();

if(isset($_POST['but_submit'])){
    $uname = ($_POST['username']);
    $password = ($_POST['password']);
    if ($uname != "" && $password != ""){
      $query = $con->prepare('select admin_id, password,name from admin where admin.admin_id = ? and admin.password = ?');
      $query->execute(array($uname,$password));
      $row = $query->fetch(PDO::FETCH_ASSOC);
      if($query->rowCount()>0) {
		  
          $_SESSION['admin'] = $row["name"];
          header('location: direct.php');
      } 
      else {
          $message = "Username/Password is wrong";
          echo '<script> alert ("Wrong user id or password"); window.history.back();</script>';
      }
    }
}
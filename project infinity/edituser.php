<?php
session_start();
require 'config.php';
//$uname = ($_SESSION['username']);
//$pd = ($_SESSION['pass']);
$uname ='cse180001026';
$pd='12345';

$query = $con->prepare('select email_id, name,password, contact, office from user where user.user_id = ? and user.password = ?');
$query->execute(array($uname,$pd));
$row = $query->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['but_submit'])){
    $a = $_POST['mail_id'];
    $b = $_POST['username'];
    $d = $_POST['office'];
    $e=$_POST['contact'];
    $g= $_POST['pass'];

$sql1 = 'update user set 
       email_id =:a , 
       name = :b, 
       office = :d, 
       contact = :e, 
       password = :g
  where user_id=:h and password= :i';
$statement = $con->prepare($sql1);
$statement->execute(array(":a"=>$a,":b"=>$b,":g"=>$g,":e"=>$e,":d"=>$d,":h"=>$uname,":i"=>$pd));
$result = $statement->fetch(PDO::FETCH_ASSOC);

$query = $con->prepare('select email_id, name,password, contact, office from user where user.user_id = ? and user.password = ?');
$query->execute(array($uname,$pd));
$row = $query->fetch(PDO::FETCH_ASSOC);
}
?>
<html>
    <head>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="new_user.css">
    <body>
    <div class="container-fluid c0">
        <div class="jumbotron f1">
          <img class="img-responsive img" src="logo1.png" alt="">
        </div>
      <div>
      <div class="container">
        <div class="row">
          <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
              <div class="card-body">
                <h5 class="card-title text-center g3">Edit User Details</h5>
                <form action="" method = "post" class="form-signin">
                <div class="form-label-group">
                    <?php
                    echo '<input  name="mail_id" value="'.$row['email_id'].'" class="form-control" placeholder="Name" Required>';
                    ?>
                    <label for="inputEmail">Email Id</label>
                  </div>
                  <div class="form-label-group">
                    <?php
                    echo '<input type= "text" name="username" value="'.$row['name'].'" class="form-control" placeholder="Name" Required>';
                    ?>
                    <label for="username">Name</label>
                  </div>
                  <div class="form-label-group">
                    <?php
                    echo '<input name="office" value="'.$row['office'].'" class="form-control" placeholder="Office" Required>';
                    ?>
                    <label for="inputOffice">Office Address</label>
                  </div>
                  <div class="form-label-group">
                  <?php
                    echo '<input name="contact" value="'.$row['contact'].'" class="form-control" placeholder="Name" Required>';
                    ?>
                    <label for="inputContact">Contact Number</label>
                  </div>
                  <div class="form-label-group">
                  <?php
                    echo '<input name="pass" value="'.$row['password'].'" class="form-control" placeholder="Name" Required>';
                    ?>
                    <label for="inputPassword">Password</label>
                  </div>
                  <button class="btn btn-lg btn-primary btn-block text-uppercase"  id="lgin"  name ='but_submit' type="submit">Save Changes</button>
             </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <!--button type="button" class="close" data-dismiss="modal">&times;</button-->
                <h6 class="modal-title" >Succesfull!!</h6>
              </div>
              <div class="modal-body">
                <p>New User Added.</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
     
    </body>
</html>
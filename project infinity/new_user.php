<?php
session_start();
require 'config.php';
$show_modal=false;
if(isset($_POST['but_submit'])){
$a = $_POST['user_id'];
$b = $_POST['username'];
$c =$_POST['email'];
$d = $_POST['office'];
$e=$_POST['contact'];
$f = $_POST['fund'];
$g= $_POST['pass'];
$h= date("Y-m-d");

$sql="INSERT INTO `user`(`user_id`, `email_id`, `name`, `password`, `contact`, `office`, `add_date`, `left_balance`) VALUES (:a,:c,:b,:g,:e,:d,:h,:f)"; 
$result=$con->prepare($sql);
$row=$result->execute(array(":a"=>$a,":c"=>$c,":b"=>$b,":g"=>$g,":e"=>$e,":d"=>$d,":h"=>$h,":f"=>$f));
 if($row) 
 {  $show_modal=true;
 }
 else
 {
  echo '<script> alert ("Error Adding New User!!"); window.history.back();</script>'; 
 }

}
//session_destroy();
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
                <h5 class="card-title text-center g3">Create New User</h5>
                <form action="" method = "post" class="form-signin">
                  <div class="form-label-group">
                    <input name="user_id" class="form-control" placeholder="User Id" required autofocus>
                    <label for="username">User Id</label>
                  </div>
                  <div class="form-label-group">
                    <input name="username" class="form-control" placeholder="Name" required autofocus>
                    <label for="username">Name</label>
                  </div>
                  <div class="form-label-group">
                    <input name="email" class="form-control" placeholder="Email address" required autofocus>
                    <label for="inputEmail">Email Id</label>
                  </div>
                  <div class="form-label-group">
                    <input  name="office"  class="form-control" placeholder="Office Address" required>
                    <label for="inputOffice">Office Address</label>
                  </div>
                  <div class="form-label-group">
                    <input name="contact"  class="form-control" placeholder="Contact Number" required>
                    <label for="inputPassword">Contact Number</label>
                  </div>
                  <div class="form-label-group">
                    <input name="fund" class="form-control" placeholder="Initial Funding" required>
                    <label for="inputFunding">Initial Funding</label>
                  </div>
                  <div class="form-label-group">
                    <input type="password" name="pass" class="form-control" placeholder="Password" required>
                    <label for="inputPassword">Password</label>
                  </div>
                  <button class="btn btn-lg btn-primary btn-block text-uppercase"  id="lgin"  name ='but_submit' type="submit">Submit</button>
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
      <?php if($show_modal):?>
          <script> $('#myModal').modal('show');</script>
      <?php endif;?>
    </body>
</html>
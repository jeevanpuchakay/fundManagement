<?php
session_start();
require 'config.php';
$show_table=false;
$show_modal=false;
$u_id="";
$u="F";
if(isset($_POST['but_search'])){
    $u_id = $_POST['user_id'];
    $_SESSION['user_id']=$u_id;
    $u=$u_id;
    $sql = $con->prepare('select user_id,email_id,name, contact, office, add_date, left_balance from user where user_id = ?');
    $sql->execute(array($u_id));
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    if($sql->rowCount()==1){
     $show_table=true;
    }
    else {echo '<script> alert ("Invalid User Id!!"); window.history.back();</script>';}
}

if(isset($_POST['but_del'])){
    $u=$_SESSION['user_id'];
    $query = $con->prepare('Delete from user where user_id = ?');
    $query1 = $con->prepare('Delete from work where user_id = ?');
    $query2= $con->prepare('Delete from balance where user_id = ?');
    $query->execute(array($u));
    $query2->execute(array($u));
    $query1->execute(array($u));
    $row = $query->fetch(PDO::FETCH_ASSOC);
    if($query->rowCount()==1){
     $show_modal=true;
    }
    else {
          echo '<script> alert ("Unable To Delete!!");</script>';}
    }
?>
<html>
    <head>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="del_user.css">
    <body>
    <div class="container-fluid c0">
        <div class="jumbotron f1">
          <img class="img-responsive img" src="logo1.png" alt="">
        </div>
    </div>
      <div class="container">
        <div class="row">
          <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
              <div class="card-body">
                <h5 class="card-title text-center g3">Delete A User</h5>
                <form action="" method = "post" class="form-signin">
                  <div class="form-label-group">
                    <input name="user_id" class="form-control" placeholder="" required autofocus>
                  </div>
                    <button class="btn btn-lg btn-primary btn-block text-uppercase" id="lgin" name ='but_search' type="submit">Search</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container d1">
          <div class="row">
            <div class = "jumbotron bg-light cc1 col-md-12" id = "displaytable" >
                <div class = "data f0 row">
                    <?php
                        echo '<table width = "50%" border = "0" cellpadding = "4" cellspacing = "10">';                       
                        echo '<tr><th><h6>User Id </th><th>:    '.$row["user_id"].'</th></h6></th> </tr>';
                        echo '<tr><th><h6>Name </th><th>:    '.$row["name"].'</th></h6></th></tr>';
                        echo '<tr><th><h6>Email Id </th><th>:    '.$row["email_id"].'</th></h6></th> </tr>';
                        echo '<tr><th><h6>Contact </th><th>:    '.$row["contact"].'</th></h6></th></tr>';
                        echo '<tr><th><h6>Office </th><th> :    '.$row["office"].'</th></h6></th></tr>';
                        echo '<tr><th><h6>Joined On </th><th>:    '.$row["add_date"].'</th></h6></th></tr>';
                        echo '<tr><th><h6>Balance Left</th><th>:    Rs.  '.$row["left_balance"].'/-</th></h6></th></tr>';
                        echo '</table>';  
                    ?>
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
                <p>User Deleted.</p>
              </div>
              <div class="modal-footer">
                  <form action="post">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button></form>
              </div>
            </div>
          </div>
        </div>
      <form action="" method="post">
      <div class="container">
        <div class = "row ff1">
         <div class = "col-md-12" style="text-align: right">
          <button class="btn btn-danger" name ="but_del" id="del">delete</button>
         </div>
      </div>
      </div>
      </form>
      <?php
    if($show_table){
    ?>
      <script>
          var x = document.getElementById("displaytable");
          var y = document.getElementById("del");
          x.style.display="block";
           y.style.display="block";
      </script>    
      <?php
        }
      ?>
    <?php if($show_modal):?>
          <script> $('#myModal').modal('show');</script>
      <?php endif;?>
    </body>
</html>
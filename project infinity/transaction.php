<?php
    session_start();
    require 'PHPMailerAutoload.php';
    require 'config.php';
    $bool = false;
    $var = "";
    $user_id = "";
    $name = "";
    $email_id = "";
    $contact = "";
    $office = "";
    $add_date = "";
    $left_balance = "";
    $tr_type = "";
    $email="";
    $nameUser="";
    if(isset($_POST['search_by_userID'])){
        $var = $_POST['search_by_userID'];
        $query = $con->prepare('select * from user where user_id = ?');
        $query->execute(array($var));
        $row = $query->fetch(PDO::FETCH_ASSOC);
        if($query->rowCount()>0){
            $user_id = $row['user_id'];
            $name= $row['name'];
            $email_id = $row['email_id'];
            $contact = $row['contact'];
            $office = $row['office'];
            $add_date = $row['add_date'];
            $left_balance = $row['left_balance'];
            $_SESSION['new_var'] = $user_id;
            $_SESSION['email'] = $email_id;
            $_SESSION['name'] = $name;
        }
        else{
            echo '<script> alert ("User does not EXIST"); window.history.back();</script>';
        }
    }
    if(isset($_POST['search_by_emailID'])){
        $var1 = $_POST['search_by_emailID'];
        $query = $con->prepare('select *from user where email_id = ?');
        $query->execute(array($var1));
        $row = $query->fetch(PDO::FETCH_ASSOC);
        if($query->rowCount()>0){
            $var = $row['user_id'];
            $user_id = $row['user_id'];
            $name= $row['name'];
            $email_id = $row['email_id'];
            $contact = $row['contact'];
            $office = $row['office'];
            $add_date = $row['add_date'];
            $left_balance = $row['left_balance'];
            $_SESSION['new_var'] = $user_id;
            $_SESSION['email'] = $email_id;
            $_SESSION['name'] = $name;
        }
        else{
            echo '<script> alert ("user does not EXIST"); window.history.back();</script>';
        }
    }

    $email="";
    $nameUser="";
    $user_id = "";
    $user_id= $_SESSION['new_var'];
    $email= $_SESSION['email'];
    $nameUser=$_SESSION['name'];
    if(isset($_POST['tr-btn'])){
        
        $tr_type = "";
        $tr_type = $_POST['tr_type'];
        $amount = $_POST['amount'];
        if($tr_type == "Credit"){
            $data = ['user_id' => $user_id, 'amount' => $amount];
            $sql = $con->prepare('update user set left_balance = left_balance + :amount where user_id=:user_id');
            $sql->execute($data);
            $sql = $con->prepare('select max(trans_id) as m from transactions');
            $sql->execute();
            $id = $sql->fetch(PDO::FETCH_ASSOC);
            $id1 = 0;
            $id1 = $id['m'];
            $data = ['trans_id' => $id1+1, 'credit' => "Credit", 'amount' => $amount];
            $sql = $con->prepare('insert into transactions(trans_id, type, amount, date) values (:trans_id,:credit,:amount,NOW())');
            $sql->execute($data);
            $data = ['trans_id' => $id1+1, 'user_id' => $user_id];
            $sql = $con->prepare('insert into balance values(:user_id,:trans_id)');
            $sql->execute($data);
            $_SESSION['new_var'] = "";
            $bool = true; 
            $type="Credited";

        }
        else{
            $data = ['user_id' => $user_id, 'amount' => $amount];
            $sql = $con->prepare('update user set left_balance = left_balance - :amount where user_id=:user_id');
            $sql->execute($data);
            
            $sql = $con->prepare('select max(trans_id) as m from transactions');
            $sql->execute();
            $id = $sql->fetch(PDO::FETCH_ASSOC);
            $id1 = 0;
            $id1 = $id['m'];
            $data = ['trans_id' => $id1+1, 'credit' => "Debit", 'amount' => $amount];
            $sql = $con->prepare('insert into transactions(trans_id, type, amount, date) values (:trans_id,:credit,:amount,NOW())');
            $sql->execute($data);
            $data = ['trans_id' => $id1+1, 'user_id' => $user_id];
            $sql = $con->prepare('insert into balance values(:user_id,:trans_id)');
            $sql->execute($data);
            $_SESSION['new_var'] = "";
            $bool = true;
            $type="Debited";

        }

        
        if($bool){

            $query = $con->prepare('select left_balance from user where user_id = ?');
            $query->execute(array($user_id));
            $row = $query->fetch(PDO::FETCH_ASSOC);
            $left=$row['left_balance'];
            $mail = new PHPMailer;
            //$mail->SMTPDebug = 3;                               // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'gkrjeevan37@gmail.com';                 // SMTP username
            $mail->Password = 'dummypassword123';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to
            $userEmail="cse180001022@iiti.ac.in";
            $mail->setFrom('gkrjeevan37@gmail.com', 'Mailer');
            
            $mail->addAddress($email,$nameUser);     // Add a recipient
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            $mail->isHTML(true);   
            //echo $amount;                               // Set email format to HTML

            $Content="Your account has been ".$type." with Rs. ".$amount.". The Left Balance is Rs. ".$left;
            $mail->Subject = 'Transaction alert';
            $mail->Body   = $Content;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            
            if(!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo 'Message has been sent';
            }


            }
    }
?>

<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="transaction.css">
        <link href='//fonts.googleapis.com/css?family=RobotoDraft:regular,bold,italic,thin,light,bolditalic,black,medium&lang=en' rel='stylesheet'> 
    </head>
    <body>
        <div class="container-fluid c0">
            <div class="jumbotron f1">
            <img class="img-responsive img" src="logo1.png" alt="">
            </div>
        <div>
        <div class = "container main">
            <div class = "mt-2 container prime1 border border-secondary" style = "padding-top : 0.5%; padding-bottom : 0.5%; border-radius: 8px">
                <div style = "text-align:left;color: #3B5998">
                    <h4>→Transaction Management</h4>
                </div>
            </div>    
            <div class="mt-2 container prime border border-secondary">
                <div class ="container searchBox">
                    <div class = "row">
                        <div class="col-md-auto searchText">
                            <i class = "text-secondary searchText1" style = "font-family :-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">Search by User ID</i> 
                        </div>
                        <form action = "transaction.php" method="post">
                        <div class="col-md-auto  func0">
                            <input type="text" class="search-hover" name="search_by_userID" placeholder="search here...">
                        </div></form>
                        <div class="col searchText createuser">
                            <a href="" class = "text-danger searchText1" style = "font-family :-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">Create New User</a>
                        </div>
                    </div>
                    <div class = "row">
                        <div class="col-md-auto searchText">
                            <i class = "text-secondary searchText1" style = "font-family :-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">Search by Email ID</i> 
                        </div>
                        <form action = "transaction.php" method="post">
                        <div class="col-md-auto">
                            <input type="text" class="search-hover" name="search_by_emailID" placeholder="search here...">
                        </div></form> 
                    </div>    
                </div>
            </div>
            <div class = "mt-2 container prime1 border border-secondary">
                <div class="row">
                    <div class="col" style="text-align:right">
                        <h5> USER-ID : </h5>
                    </div>
                    <div class="col" style="text-align:left">
                        <h5><?php echo $user_id ?> </h5>
                    </div>
                    <div class="col" style="text-align:right">
                        <h5> EMAIL-ID : </h5>
                    </div>
                    <div class="col" style="text-align:left">
                        <h5> <?php echo $email_id ?> </h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col" style="text-align:right">
                        <h5> NAME : </h5>
                    </div>
                    <div class="col" style="text-align:left">
                        <h5> <?php echo $name ?> </h5>
                    </div>
                    <div class="col" style="text-align:right">
                        <h5> CONTACT : </h5>
                    </div>
                    <div class="col" style="text-align:left">
                        <h5> <?php echo $contact ?> </h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col" style="text-align:right">
                        <h5> OFFICE : </h5>
                    </div>
                    <div class="col" style="text-align:left">
                        <h5> <?php echo $office ?> </h5>
                    </div>
                    <div class="col" style="text-align:right">
                        <h5> REG. Date : </h5>
                    </div>
                    <div class="col" style="text-align:left">
                        <h5> <?php echo $add_date ?> </h5>
                    </div>
                </div>
            </div>
            <div class = "mt-2 container prime2 border border-secondary">
            <form action = 'transaction.php' method = 'post'>
                <div class = 'row'>    
                    <div class='col-md-2' style = "text-align:left">
                        <p style = "font-size : 20px">Available Balance</p>
                    </div>
                    <div class = "col-md-1.5 text-success"style = "text-align:left">
                        <p style = 'font-size:20px'><?php echo 'Rs. '.$left_balance.'/-' ?></p> 
                    </div>
                    <div class='col-md-2' style ='text-align:right'>
                        <p style="font-size: 20px">Update Balance : </p>
                    </div>
                    <div class = 'col-md-3'>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Rs.</span>
                            </div>
                            <input type="text" class="form-control" name = "amount"placeholder="Amount" aria-label="Username" aria-describedby="basic-addon1" required>
                        </div>
                    </div>
                    <div class= 'col-md-2' style= 'padding-top:0.0%; padding-left:2%'>
                        <select class="form-control" name="tr_type">
                            <option>Credit</option>
                            <option>Debit</option>
                        </select>
                    </div>
                    
                    <div class = 'col-md-1'>
                        <button name = "tr-btn" class="btn btn-primary " type ="submit" onclick = "myFunction">Update</button>
                    </div>
                </div></form>
            </div>
        </div>
    </body>
</html>
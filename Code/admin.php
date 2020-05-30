<?php
session_start();
//require 'config.php'; // use config file for connection
$dsn = "mysql:host=localhost;port=3307;dbname=fund";
$con = new PDO($dsn,"root","");
$sql = $con->prepare("SELECT * FROM user;");
$sql->execute();
$xyz = '';
if(isset($_POST['btn_search'])){
  $uid = ($_POST['viewuser']);
  if (!is_null($uid)){
    $query = $con->prepare('select *from user where user_id = ?');
    $query->execute(array($uid));
    $xyz = $query->fetch(PDO::FETCH_ASSOC);
    if($query->rowCount()>0) {
      $user_id =$xyz["user_id"];
        header('location: viewuser.php?userid='.$user_id.'');
    } 
    
  }
}
$search = $con->prepare("SELECT password from user where user_id=?;");
$t=time();
$ti = $t - 86400;
$time = date("Y-m-d",$ti);
$query = $con->prepare("SELECT type,amount,purpose,name,u.user_id,password, date FROM transactions t inner join balance b on b.trans_id = t.trans_id inner join user u on u.user_id=b.user_id WHERE t.date>=? order by t.trans_id asc;"); 
$query->execute(array($time));
 
?>

<html lang="en">

<head>
  <meta charset="utf-8">
  <title>IIT Indore Fund Management system</title>
  <link rel="shortcut icon" href="../assets/favicon.jpeg">
  <script src="https://kit.fontawesome.com/c4b975f7fd.js" crossorigin="anonymous"></script>
<style>
.grid-container {
  display: grid;
  background-color: #1a242f;
  height:90px;
  
}
.id {
  display: grid;
  background-color: #fff;
  height:90px;
  float:right;
  margin-right:20px;
  margin-top :10px;
  width:250px;
  border-style:outset;
  border-size:3px;
  border-radius:17px;
}
.pic{
	grid-coloumn:1;
	width:60px;
}
.pic h1{
	margin-top:10px;
	padding-left:10px;
}

.det{
	grid-column:2;
}

.det h1{
	margin-top:12px;
	margin-bottom:0px;
	margin-left:0px;
	font-size:20px;
	font-family: 'Viaoda Libre', cursive;

}

.det p{
	margin-top:0px;
	font-family: 'Viaoda Libre', cursive;
	font-size:22px;
}

.grid-item {
  background-color: #1a242f;
}

.item1{
	  grid-column: 1;
	  
}

.item1 p{
	padding-top : 20px;
	padding-bottom : 0px;
	padding-left : 4px;
}
.item2{
	grid-column:2;
	text-align:center;
}
.item2 h1{
	font-size:30px;
	 font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	 padding-top :25px;
	 color:#f3f5f9;
}
.item3{
	grid-column:3;
}
.item3 h1{
	font-size:26px;
	 font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	 padding-top :25px;
	 padding-left :175px;
	 color:#f3f5f9;
}
.item3 p{
	font-size:20px;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	padding-left:175px;
	color:#f3f5f9;
}

*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  list-style: none;
  text-decoration: none;
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
}


.wrapper{
  display: flex;
  position: relative;
}

.wrapper .sidebar{
  width: 200px;
  height: 100%;
  background: #1a242f;
  padding: 30px 0px;
  position: fixed;
}

.wrapper .sidebar h2{
  color: #fff;
  text-transform: uppercase;
  text-align: center;
  margin-bottom: 20px;
}

.wrapper .sidebar ul li{
  padding: 15px;
  border-bottom: 1px solid #bfc6d5;
  border-bottom: 1px solid rgba(0,0,0,0.05);
  border-top: 1px solid rgba(255,255,255,0.05);
}    
.view{
	color:#bfc6d5;
	display:block;
	cursor:pointer;
}
.view .fas{
	width:25px;
}
.view:hover{
	color:#fff;
}
	
.wrapper .sidebar ul li a{
  color: #bfc6d5;
  display: block;
}

.wrapper .sidebar ul li a .fas{
  width: 25px;
}

.wrapper .sidebar ul li:hover{
  background-color: #bebec0;
}
    
.wrapper .sidebar ul li:hover a{
  color: #fff;
}
 

.button1{
	margin-top:10px;
	margin-left:250px;
	display: inline-block;
    padding: 15px 30px;
    color: #2196f3;
    text-transform: uppercase;
    letter-spacing: 4px;
    text-decoration: none;
    font-size: 24px;
    overflow: hidden;
    transition: 0.2s;

}
.button2{
	margin-top:10px;
	margin-left:30px;
    display: inline-block;
    padding: 15px 30px;
    color: #2196f3;
    text-transform: uppercase;
    letter-spacing: 4px;
    text-decoration: none;
    font-size: 24px;
    overflow: hidden;
    transition: 0.2s;
}
.button1:hover{
  color: #255784;
  background: #2196f3;
  box-shadow: 0 0 10px #2196f3, 0 0 40px #2196f3, 0 0 80px #2196f3;
  transition-delay: 0.1s;
}
.button2:hover{
  color: #255784;
  background: #2196f3;
  box-shadow: 0 0 10px #2196f3, 0 0 40px #2196f3, 0 0 80px #2196f3;
  transition-delay: 0.1s;
}
* {
  box-sizing: border-box;
}

body {
  font: 16px Arial;  
}

.autocomplete {
	position:absolute;
	margin-top:-57px;
	margin-left:900px;
	background-color: #f1f3f4;
	height: 50px;
	border-radius: 8px;
	width:500px;
	display:none;
}
.btn{
	width:40px;
	height:40px;
	border-radius:40px;
	background-color: #f1f3f4;
	float:right;
	padding:0;
	color: #4d4b4b;
	transition: 0.1s;
	cursor: pointer;
	margin-top:5px;
	margin-right:5px;
}
.btn:hover{
	background-color:#cccccc;
}
   
.btn i{
	padding-left:3px;
	padding-top:5px;
}

.search::selection {
  color: #2ecc71;
}	
#myInput{
	width:340px;
	height:40px;
	border:none;
	padding-top:10px;
	outline:none;
	float:left;
	background: none;
	font-size:15px;
	border: none;
	color: black;
	margin-left:10px;
}


.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}

.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4; 
}

/*when hovering an item:*/
.autocomplete-items div:hover {
  background-color: #e9e9e9; 
}

/*when navigating through the items using the arrow keys:*/
.autocomplete-active {
  background-color: DodgerBlue !important; 
  color: #ffffff; 
}
.announcements{
	display:grid;
	grid-template-columns:auto;
	font-size : 18px;
	margin-top: 110px;
	margin-left:1270px;
	height:460px;
	width:400px;
	background-color:#376ba6;
	color:white;
	box-shadow: 0 14px 20px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
}
.picture{
	height:140px;
	padding-left:140px;
	background-color:#376ba6;
}
.ball{
	margin-top:10px;
	height:120px;
	width:120px;
	border-radius:60px;
	background-color:white;
	color:grey;
	padding-top:23px;
	padding-left:37px;
}
.head{
	height:20px;
	font-family:Arial;
	text-align:center;
	background-color:#376ba6;
	color:white;
}
.head h{
	font-size:24px;
}

.trans{
	background-color:#376ba6;
  height:300px;
  overflow:hidden;
}
.trans li{
	margin-left:50px;
	margin-top:10px;
	margin-bottom:10px;
}
.trans li a{
	color:white;
}
.trans li a:hover{
	color:red;
}
.trans li a:focus{
	color:skyblue;
}
.line{
	margin-left: 10px;
	margin-right: 10px;
	border:2.5px solid white;
}
</style>
</head>
<body>
<div class="grid-container">
  <div class="grid-item item1"><p><img src="../assets/logo.png" /></p></div>
  <div class="grid-item item2"><h1><i class="fas fa-users-crown"></i>FUND MANAGEMENT SYSTEM</h1></div>
  <div class="grid-item item3"><h1>CSE DEPARTMENT</h1><p>ADMIN PAGE</p></div>  
</div>
<div class="wrapper">
    <div class="sidebar">
        <h2>BROWSE</h2>
        <ul>
            <li><a href="admin.php"><i class="fas fa-home"></i>Home</a></li>
            <li><a href="new_user.php"><i class="fas fa-user-plus"></i>Create User</a></li>
            <!--<li><a href="edituser.php"><i class="fas fa-user-edit"></i>Edit User</a></li-->
			      <li><a href="del_user.php"><i class="fas fa-address-book"></i>Delete User</a></li>
            <li><a href="access.php?request=user"><i class="far fa-file-alt"></i> Access User Records</a></li>
            <li><a href="transaction.php"><i class="fas fa-file-invoice-dollar"></i>Make a Transaction</a></li>
            <li><a href="access.php?request=transaction"><i class="fas fa-file-invoice-dollar"></i>Transactions log</a></li>
        </ul> 
      </div>
    </div>
	</div>
<div class = "id">
<div class ="pic"><h1><i class="fas fa-id-card fa-2x"></i></h1></div>
<div class ="det"><h1>Logged In As </h1><p><?php echo $_SESSION["admin"]?></p></div>
</div>
<a class="button1" href="ad.php">Upload file</a>
<a class="button2" href="ad.php">View file</a>
  <form autocomplete="off" method="post" action="admin.php" >
  <div class="autocomplete" id="search1">
    <input id="myInput" type="text" name="viewuser" placeholder="Search User">
      <button type="submit" class="btn" name = "btn_search"><i class="fa fa-search fa-lg"></i></button>
	  </div>
</form>
<script>
  document.getElementById("search1").style.display = "block";

</script>
<div class ="announcements">
<div class="picture">
<div class ="ball">
<i class="fas fa-rupee-sign fa-5x"></i>
</div>
</div>
<div class="head">
<h>Recent transactions</h>
</div>
<div class ="trans">
<hr class ="line">
<?php
echo '<marquee behavior="scroll" direction="up" scrollamount="2" height=200px onmouseover="this.stop();"onmouseout ="this.start();"><ol>';
  while($row = $query->fetch(PDO::FETCH_ASSOC)){
	  $user_id = $row["user_id"];
	  $password = $row["password"];
    echo '<li><a href="redirect.php?subject='.$user_id.'& web='.$password .'" >'.strtoupper($row["name"]).'s account has been '.$row["type"].'ed for Rs.'.$row["amount"].'<br>on '.$row["date"].' for the  purpose:'.strtoupper($row["purpose"]).'</a></li><hr style="border-top: 0.1px dashed white ;border-bottom: 0.1px dashed white ">';	
  }
echo '</ol></marquee>'
?>
</div>
</div>
</body>
</html>

<script>
function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

/*An array containing all the country names in the world:*/
var users = [];
<?php
  while($row = $sql->fetch(PDO::FETCH_ASSOC)){
	  $acc = '<a href="default.asp" target="_blank">visit page</a>';
    echo'users.push("'.$row["user_id"].'");';
  }
	
?>
/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
autocomplete(document.getElementById("myInput"), users);
</script>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // collect value of input field
  $name = $_REQUEST["viewuser"];
  if (empty($name)) {
    echo 'Name is empty';
  } else {
	  $SESSION["username"] = $name;
	  $search->execute(array($name));
	  while($row = $search->fetch(PDO::FETCH_ASSOC)){
		  $_SESSION["pass"]= $row["password"];
	  }
	  
    echo '<meta http-equiv="refresh" content="0;URL=user.php">';
  }
}
?>



<?php
//require 'config.php'; // use config file for connection
$dsn = "mysql:host=localhost;port=3308;dbname=fund";
$con = new PDO($dsn,"root","");
$sql= $con->prepare("SELECT * FROM users ");
$sql->execute();
 
?>
<html>
<head>
<style>
#iit{
	background-color:blue;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	width:100%;
	height:200px;
	border-radius: 50px;
}
#iit h1{
	padding-top:70px;
	padding:100px;
	
}
#acs {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  margin:300px 35px 35px 175px;
  width: 75%;
}
#acs tr{
	border : 1px solid #ddd;
	border-radius:25px;

}
#acs td, #acs th {
  border: 2px solid #ddd;
  padding: 8px;
}
#acs td{
	text-align:left;
}

#acs tr:nth-child(even){background-color: #f2f2f2;}

#acs tr:hover {background-color: #ddd;}

#acs th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: green;
  color: white;
}
</style>
</head>
<div id="iit">
<h1>iit indore</h1>
</div>
<table id="acs"> 
<tr>
<th>user_id</th>
<th>name</th>
<th>email_id</th>
<th>bal</th>
<th>office</th>
<th>address</th>
</tr> 

<?php
  while($row = $sql->fetch(PDO::FETCH_ASSOC)){
    echo'<tr>
    <td>'.$row["user_id"].'</td>
    <td>'.$row["name"].'</td>
    <td>'.$row["email_id"].'</td>
    <td>'.$row["bal"].'</td>
    <td>'.$row["office"].'</td>
    <td>'.$row["address"].'</td> 
    </tr>';
  }
?>
</table>
</body>
</html>
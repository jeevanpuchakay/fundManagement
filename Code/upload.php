<?php
session_start();
// https://www.codexworld.com/upload-multiple-images-store-in-database-php-mysql/
// Remember to make change in php.ini file(search file_uploads)
//Make a dialogue box for succesfull update
//unable to upload file of size >10MB
// 3rd april
require 'config.php';
$uID = ($_SESSION['username']);
$allowed=array('pdf','txt','png'); //File types
$target_dir="../uploads/".$uID."/"; //Target Directory for a specific user
if(isset($_POST["submit"])){
$statusMsg ='Hello';
$fileNames = array_filter($_FILES['fileToUpload']['name']);
if(!empty($fileNames)){
	foreach ($_FILES['fileToUpload']['name'] as $key => $val) {
		// file upload path
		$fileName=basename($_FILES['fileToUpload']['name'][$key]); //see this
		$targetFilePath=$target_dir.$fileName;
		$size= $_FILES["fileToUpload"]["size"][$key];
		// Check whether file type is valid 
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION)); 
        if(in_array($fileType, $allowed)){
        	// Upload file to Server
        	if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$key],$targetFilePath)){
        		$statusMsg="File Uploaded Succesfully";
        	}
        	else{
        		//$errorUpload.=$_FILES["fileToUpload"]["name"][$key].' | ';
        		$statusMsg="Error in Upload";
        	}
        }
        else {
        	//$errorUpload.=$_FILES["fileToUpload"]["name"][$key].' | ';
        	$statusMsg="Wrong File Format For ".$_FILES["fileToUpload"]["name"][$key];
        }

	}
	
}
else {
		$statusMsg="Please Select a File to Upload";
	}
	echo $statusMsg;
}


if(isset($_POST["view"])){
$target_dir="uploads/".$uID."/";
if ($handle = opendir($target_dir)) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            echo "<a href='download.php?file=".$entry."'>".$entry."</a></br>";
    	    }
    	}
    	closedir($handle);
	}
}
// Fisrt Try (For Uploading a single File)
/*$target_file=$target_dir.basename($_FILES["fileToUpload"]["name"]); //File Name
$allowed=array('pdf','txt','png'); //File types
$uploadOK=1;
$fileType=strtolower((pathinfo($target_file,PATHINFO_EXTENSION))); //Getting the file Extension  and converting to lower alphabets

if(isset($_POST["submit"])){
	if(!in_array($fileType,$allowed)){echo "Wrong File Type"; $uploadOK=0;} // Checking is the file type is correct or not	
	}
if(file_exists($target_file)){echo "Sorry! File Already Exists. " ;  // To Check If the file Already  Exists
								$uploadOK=0;}
if($_FILES["fileToUpload"]["size"]>1000000){echo "Sorry! File Size too Large. " ;  // To Check If the file size >1000 KB
								$uploadOK=0;}
if($uploadOK==0){echo "Sorry Your File Was not Uploaded. ";}

else{ if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)){
					echo "The File ".basename($_FILES["fileToUpload"]["name"])." has been Uploaded. ";}
	
else {echo "Error in Uploadin File.";}
}
*/
?>
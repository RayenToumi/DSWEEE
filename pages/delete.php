<?php
if(isset($_GET["email"])){

    $email=$_GET["email"];

 $servername = "localhost";
		$dbname = "projet web";
		$username = "toumi";
		$password = "Toumi123"; 

// Connection
$connection = new mysqli($servername, $username, $password, $dbname);
$sql="DELETE FROM `users` WHERE email='$email'";
$res=$connection->query($sql);
}
header("location:admin.php");
exit;


?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<title>RokianStats II</title>
<link rel="shortcut icon" href="/RMLogo.ico" >
</head>
<body>
<?php
session_start();
$userName = $_POST["username"];
$passWord = $_POST["password"];
$submitted = $_POST["submitted"];
if($submitted=="true"){
$_SESSION["username"] = $userName;
$_SESSION["password"] = $passWord;
}
else{
$passWord= $_SESSION["password"];
}
$con=mysqli_connect("localhost","example","example","example");
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
else{
$sql="SELECT * FROM members WHERE password='$passWord'";
$passOrNo=mysqli_query($con,$sql);
while($row = mysqli_fetch_array($passOrNo)) {
if($row['password']==$_SESSION["password"] and $row['username']==$_SESSION["username"])
{
$ok = true;
}
}
}
?>
<h2><?php
if($ok==true){
echo("Welcome, " . $_SESSION["username"]);}
else{
echo("You do not have access to this page");
}
?></h2>
<hr>
<a href="Process.php">Back</a><br/><br/>
<?php 
if($ok==true){
$con=mysqli_connect("localhost","example","example","example");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
else{
$sql="SELECT * FROM rokians";
$result=mysqli_query($con,$sql);
echo("<b>CURRENT DATABASE ENTRIES:</b><br/>");
echo("Username | PP<br/>");
echo("-------------------------------------------<br/>");
$count = 0;
while($row = mysqli_fetch_array($result)) {
$count = $count+1;
  echo "PlayerNAME=" . $row['username'] . ":" . $row['pp'] . "NAMEEND";
  echo "<br>";
}
echo('<br/><b>' . $count . ' total entries</b><br/>');
}
}
else{
echo("You cannot view this page without the proper password.");
}
 ?>
</body>
</html>
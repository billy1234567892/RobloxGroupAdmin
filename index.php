<html>
<head>
<title>RokianStats II</title>
<link rel="shortcut icon" href="/RMLogo.ico" >
</head>
<body>
Redirecting
<?php
session_start();
$userName = $_SESSION["username"];
$passWord = $_SESSION["password"];
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
if($ok==true){
Header('Location: Process.php');
}
else{
Header('Location: Google.php');
}
?>
</body>
</html>
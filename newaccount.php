<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<title>RokianStats II</title>
<link rel="shortcut icon" href="/RMLogo.ico" >
</head>
<body>
<?php
$code = $_POST['code'];
$user = $_POST['username'];
$pass = $_POST['password'];
?>
<h2><?php
if ($code=="3459345"){
echo("Welcome, " . $user);
}
else{
echo("Wrong Signup Code");
}
?></h2>
<hr>
<a id='a' href="Google.php">Back</a><br/><br/>
<?php 
if($code=="3459345" and strlen($user)>2 and strlen($pass)>6){
$con=mysqli_connect("localhost","example","example","example");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
else{
$sql="SELECT * FROM members WHERE username = '$user'";
$res = mysqli_query($con,$sql);
$row = mysqli_fetch_array($res);
if($row['username'] == $user){
echo("That username is already in use.");
}
else{
$sql="INSERT INTO members (username,password) VALUES ('$user','$pass')";
mysqli_query($con,$sql);
echo("Your account has been created.");
}
}
}
else{
echo("You have entered an incorrect signup code <b>or</b> your username/password is too short.");
}
 ?>
</body>
</html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<title>RokianStats II</title>
<link rel="shortcut icon" href="/RMLogo.ico" >
<script type="text/javascript">
    function updateTextInput(val) {
      document.getElementById('textInput').value=val+" PP"; 
    }
</script>
</head>
<img src="RM1.png" alt="" id="blurpic" style="width:100%;max-width:400px">
<body>
<?php
session_start();
$userName = $_POST["username"];
$userName2 = $_POST["username2"];
$securitylvl2 = $_POST["securitylvl"];
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
if($row['password']==$_SESSION["password"] and strtolower($row['username'])==strtolower($_SESSION["username"]))
{
$ok = true;
$securitylvl = $row['security_lvl'];
}
}
}
?>
<br/><br/><br/>
<h2><?php
if($ok==true){
echo("Accounts");}
else{
echo("You do not have access to this page");
}
?>
</h2>
<?php echo("<img id='char' src='http://www.roblox.com/Thumbs/Avatar.ashx?x=100&y=100&format=png&username=" . $_SESSION["username"] . "'></img>"); ?>
<hr>
<?php 
if ($ok==true and $securitylvl>2 and $securitylvl>$securitylvl2 and $_SESSION["username"] != $userName2){
echo("<br/><br/>");
$sql="SELECT * FROM members WHERE username = '$userName2'";
$result = mysqli_query($con,$sql);
$userAcc = mysqli_fetch_array($result);
if($userAcc){
if($userAcc['security_lvl'] < $securitylvl){
$sql="UPDATE members SET security_lvl='$securitylvl2' WHERE username='$userName2' AND '$securitylvl2'<5";
$result=mysqli_query($con,$sql);
if(mysqli_error($con)==""){
Header('Location: Users.php');
}
else{
echo("Error changing security level");
}}
else{
echo("<br/><div id='header'><br/><a href='Users.php'class='logbutton'>Refresh</a> | <a href='Log.php'class='logbutton'>Log</a> | <a href='Users.php'class='logbutton'>Back</a> | <a id='logout' href='Google.php'class='logbutton'>Logout</a><p></p></div>");
echo("Your security level is too low.");
}
}
else{
echo("<br/><div id='header'><br/><a href='Users.php'class='logbutton'>Refresh</a> | <a href='Log.php'class='logbutton'>Log</a> | <a href='Users.php'class='logbutton'>Back</a> | <a id='logout' href='Google.php'class='logbutton'>Logout</a><p></p></div>");
echo("Account does not exist.");
}
}
elseif($ok==true){
echo("<br/><div id='header'><br/><a href='Users.php'class='logbutton'>Refresh</a> | <a href='Log.php'class='logbutton'>Log</a> | <a href='Users.php'class='logbutton'>Back</a> | <a id='logout' href='Google.php'class='logbutton'>Logout</a><p></p></div>");
echo("<br/>Your security level is too low.");
}
else{
$_SESSION["password"]="";
echo("<a href='Google.php'>Back</a><br/><br/>Wrong password.<br/><br/>Remember to use exact capitalization<br/>for both username and password.");
}
?>

</body>
</html>
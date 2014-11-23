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
<body id='blur'>
<img src="RM1.png" alt="" id="blurpic" style="width:100%;max-width:400px">
<?php
session_start();
$userName = $_POST["username"];
$passWord = $_POST["password"];
$submitted = $_POST["submitted"];
if($submitted=="true"){
$_SESSION["username"] = $userName;
$_SESSION["password"] = $passWord;
mail("example@example.com","RokianStats","Someone attempted to sign in with username '" . $userName . "' on " . date('n\/j\/Y \a\t g:i a T'));
}
else{
$passWord= $_SESSION["password"];
}
$con=mysqli_connect("localhost","example","example","example2");
$con2=mysqli_connect("localhost","example","example","example");
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
$securitylvl = 1;
}
}
}
?>
<br/><br/><br/>
<h2><?php
if($ok==true){
echo("DATABASE BACKUP STATUS");}
else{
echo("You do not have access to this page");
}
?>
</h2>
<?php echo("<a href='http://www.roblox.com/User.aspx?username=" . $_SESSION['username'] . "'><img id='char' src='http://www.roblox.com/Thumbs/Avatar.ashx?x=100&y=100&format=png&username=" . $_SESSION['username'] . "'></img></a>"); ?>
<hr>
<?php
if ($ok==true){
echo("Comparison of main database to backup database");
echo("<br/><div id='header'><br/>
<a href='match.php' class='logbutton'>Refresh</a> | <a href='Process.php' class='logbutton'>Back</a> | <a id='logout' href='Google.php' class='logbutton'>Logout</a>");
echo("<br/><p></p></div>");
    if ($ok==true and $securitylvl>1) {
echo("<b>ADD/EDIT ENTRY:</b>");
echo("<br/><small>Remember, your actions will be logged.</small><br/>");
echo("<form action='Submit.php' method='post'><input type='text' name='username' placeholder='Full Username'/><br/>");

if ($ok==true and $securitylvl==2) {
echo("<input type='range' name='pp' min='-5' max='5' value='0' onmousemove='updateTextInput(this.value);'><input type='text' style='width: 40px;' id='textInput' value='0 PP' readonly='true'><br/><br/>");
}
if ($ok==true and $securitylvl==3) {
echo("<input type='number' name='pp' placeholder='Amount of RCs to add'><br/>");
}

echo("<input type='submit' /></form>");
}
$sql="SELECT * FROM rokians ORDER BY username";
$result=mysqli_query($con,$sql);
$result2=mysqli_query($con2,$sql);
$count = 0;
$match = 1;
while($row = mysqli_fetch_array($result)) {
$count = $count+1;
$row2 = mysqli_fetch_array($result2);
if($row2['pp']!=$row['pp']){
$match=0;
}
}
if($match==1){
echo('<br/><b>Backup is up-to-date.</b><br/>');
}
else{
echo('<br/><b style="color:#aa0000;font-size:20px">Backup is not up-to-date.</b><br/>');
}

}
else{
$_SESSION["password"]="";
echo("<a href='Google.php'>Back</a><br/><br/>Wrong password.<br/><br/>Remember to use exact capitalization<br/>for both username and password.");
}
?>

</body>
</html>
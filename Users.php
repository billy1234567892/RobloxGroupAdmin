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
$deleteName = $_POST["delete"];
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
<h2>
<?php
if($ok==true){
echo("Accounts");}
else{
echo("You do not have access to this page");
}
?>
</h2>
<?php echo("<a href='http://www.roblox.com/User.aspx?username=" . $_SESSION['username'] . "'><img id='char' src='http://www.roblox.com/Thumbs/Avatar.ashx?x=100&y=100&format=png&username=" . $_SESSION["username"] . "'></img></a>"); ?>
<hr>
<?php 
if ($ok==true and $securitylvl>1){
echo("<br/><div id='header'><br/>
<a href='Users.php'class='logbutton'>Refresh</a> | <a href='Log.php'class='logbutton'>Log</a> | <a href='Process.php'class='logbutton'>Back</a> | <a id='logout' href='Google.php'class='logbutton'>Logout</a>");
echo("<br/><p></p></div>");
if($deleteName != "" and $securitylvl>3){
if($deleteName != $_SESSION["username"]){
$sql="SELECT * FROM members WHERE username = '$deleteName'";
$result = mysqli_query($con,$sql);
$deleteAcc = mysqli_fetch_array($result);
if($deleteAcc['security_lvl']>=$securitylvl){
echo("Your security level is too low to delete this account.<br><br>");
}
else{
$sql="DELETE FROM members WHERE username = '$deleteName'";
mysqli_query($con,$sql);
mail("example@example.com","RokianStats",$_SESSION["username"] . " deleted the database account named " . $deleteName . " on " . date('n\/j\/Y \a\t g:i a T'));
echo("Account deleted and deletion logged.<br><br>");
}
}
else{
echo("You can't delete your own account.<br><br>");
}
}
elseif($deleteName != ""){
echo("Your security level is too low to delete an account.<br><br>");
}
$sql="SELECT * FROM members";
$result=mysqli_query($con,$sql);
echo("<b>CURRENT DATABASE ACCOUNTS:</b><br/>");
$count = 0;
echo("<table style='width:300px'>
<tr>
  <th>Security LVL</th>
  <th>Username</th>");
if($securitylvl>3){
  echo("<th>Delete</th>");
}
echo("</tr>");
while($row = mysqli_fetch_array($result)) {
$count = $count+1;
echo("<tr><td>" . $row['security_lvl'] . "</td>" . "<td>" . "<a id='a' title='Database Account Username' href='http://www.roblox.com/User.aspx?username=" . $row['username'] . "'>" . $row['username'] . "</a></td>");
if($securitylvl>3){
echo("<td><form action='Users.php' method='post'><input type='hidden' name='delete' value='". $row['username'] ."'/><input type='submit' value='Delete'/></form></td>");
}
echo("</tr>");
}
echo("</table>");
echo('<br/><b>' . $count . ' total accounts</b><br/>');
if($ok==true and $securitylvl>2){
echo("<br/>Change security level:<br/><form action='EditUsers.php' method='post'>
<input required type='text' name='username2' placeholder='Account Username'/><br/>
<input required type='text' name='securitylvl' placeholder='Security LVL'/><br/>
<input type='submit'/>
</form>
Signup code is 3459345
");}
}
elseif($ok==true){
echo("<br/><br/>
<div id='header'><br/>
<a href='Users.php'class='logbutton'>Refresh</a> | <a href='Log.php'class='logbutton'>Log</a> | <a href='Process.php'class='logbutton'>Back</a> | <a id='logout' href='Google.php'class='logbutton'>Logout</a><p></p></div>");
echo("<br/>Your security level is too low.");
}
else{
$_SESSION["password"]="";
echo("<a id='a' href='Google.php'>Back</a><br/><br/>Wrong password maybe?<br/><br/>Remember to use exact capitalization<br/>for both username and password.");
}
?>
</body>
</html>
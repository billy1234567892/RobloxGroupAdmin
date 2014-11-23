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
echo("Welcome, " . $_SESSION["username"]);}
else{
echo("You do not have access to this page");
}
?>
</h2>
<?php echo("<a href='http://www.roblox.com/User.aspx?username=" . $_SESSION['username'] . "'><img id='char' src='http://www.roblox.com/Thumbs/Avatar.ashx?x=100&y=100&format=png&username=" . $_SESSION['username'] . "'></img></a>"); ?>
<hr>
<?php 
if ($ok==true){
echo("<a id='a' title='Rules for HRs' href='http://www.roblox.com/Forum/ShowPost.aspx?PostID=136487281'><b>[RM] RC Distribution Guidelines</a>");
echo(" - 
<a id='a' title='Backup Database' href='match.php'>Check Backup Status</a></b>
<br/><br/>
<div id='header'><br/>
<a href='Process.php' class='logbutton'>Refresh</a> | <a href='Log.php' class='logbutton'>Log</a> | <a href='Users.php' class='logbutton'>Accounts</a> | <a id='logout' href='Google.php' class='logbutton'>Logout</a>");
echo("<br/><p></p></div>");
    if ($ok==true and $securitylvl>1) {
echo("<b>ADD/EDIT ENTRY:</b>");
echo("<br/><small>Remember, your actions will be logged.</small><br/>");
echo("<form action='Submit.php' method='post'><input required type='text' name='username' placeholder='Full Username'/><br/>");
 
if ($ok==true and $securitylvl==2) {
echo("<input type='range' name='pp' min='-5' max='5' value='0' onmousemove='updateTextInput(this.value);'><input type='text' style='width: 40px;' id='textInput' value='0 PP' readonly='true'><br/><br/>");
}
if ($ok==true and $securitylvl>2) {
echo("<input type='number' name='pp' placeholder='Amount of RCs to add' required><br/>");
}
 
echo("<input title='Add/Remove RCs' type='submit' /></form>");
echo("
<form action='Process.php' method='POST'>
<input type='text' required name='getrank' placeholder='Username'><input type='submit' value='Check Rank' />
</form>");


function getrank($username){
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://www.roblox.com/User.aspx?UserName=".$username);
curl_setopt($ch, CURLOPT_HEADER, TRUE);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$a = curl_exec($ch);
$l=false;
if(preg_match('#Location: (.*)#', $a, $r))
$l = trim($r[1]);
if ($l){
$l = intval(substr($l, 14));
}

curl_setopt($ch, CURLOPT_URL, "http://www.roblox.com/Game/LuaWebService/HandleSocialRequest.ashx?method=GetGroupRole&playerid=". $l ."&groupid=953997");
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$rank1 = curl_exec($ch);
curl_close($ch);
return $rank1;
}

if($_POST['getrank']){
echo($_POST['getrank']. ": " .getrank($_POST['getrank'])."<br><br>");
}
}
$sql="SELECT * FROM rokians ORDER BY username";
$result=mysqli_query($con,$sql);
echo("<b>CURRENT DATABASE ENTRIES:</b><br/><small>Alphabetical Order</small><br/>");
$count = 0;
echo("<table style='width:500px'>
<tr>
  <th>RC</th>
  <th>Username</th>
  <th>Last Change Date/Time (EST)</th>
  <th>Last Changer</th>");
if($securitylvl>2){
  echo("<th>Delete</th>");
}
echo("</tr>");






while($row = mysqli_fetch_array($result)) {
$count = $count+1;
echo("<tr><td>" . $row['pp'] . "</td>" . "<td>" . "<a id='a' title='Person with the RCs' href='http://www.roblox.com/User.aspx?username=" . $row['username'] . "'>" . $row['username'] . "</a>" . "</td>" . "<td>" . $row['mostrecentchangetime'] . "</td>" . "<td>" . "<a id='a' title='Last Changer' href='http://www.roblox.com/User.aspx?username=" . $row['mostrecentchanger'] . "'>" . $row['mostrecentchanger'] . "</a>" . "</td>");
if($securitylvl>2){
echo("<td><form action='Submit.php' method='post'><input type='hidden' name='delete' value='".$row['username']."'/><input type='submit' value='Delete'/></form></td>");
}
echo("</tr>");

}
echo("</table>");
echo('<br/><b>' . $count . ' total entries</b><br/>');
 
 
}
else{
$_SESSION["password"]="";
echo("<a id='a' href='Google.php'>Back</a><br/><br/>Wrong password maybe?<br/><br/>Remember to use exact capitalization<br/>for both username and password.");
}
?>
 
</body>
</html>
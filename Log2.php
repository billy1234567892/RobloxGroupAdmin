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
$filter = $_POST["filter"];
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
echo("Log");}
else{
echo("You do not have access to this page");
}
?>
</h2>
<?php echo("<a href='http://www.roblox.com/User.aspx?username=" . $_SESSION['username'] . "'><img id='char' src='http://www.roblox.com/Thumbs/Avatar.ashx?x=100&y=100&format=png&username=" . $_SESSION["username"] . "'></img></a>"); ?>
<hr>
<?php
if ($ok==true and $securitylvl>1){
echo("<a id='a' href='Process2.php'><b>View Database Backup</b></a>");
echo("<br/><div id='header'><br/>
<a href='Log.php' class='logbutton'>Refresh</a> | <a href='Process.php' class='logbutton'>Back</a> | <a href='Users.php' class='logbutton'>Accounts</a> | <a id='logout' href='Google.php' class='logbutton'>Logout</a>");
echo("<br/><p></p></div><br/>");
$sql="SELECT * FROM log ORDER BY id DESC";
$result=mysqli_query($con,$sql);
echo("<form action='Log.php' method='post'>
<input type='text' name='filter' placeholder='Username'></input>
<input value='Filter' type='submit'></input>
</form><b>CURRENT LOG ENTRIES:</b><br/><small>Newest to Oldest</small><br/>");
$count = 0;
echo("<table style='width:500px'>
<tr>
  <th>RC</th>
  <th>Username</th>
  <th>Change Date/Time (EST)</th>
  <th>Changer</th>
  <th>Rank</th>
</tr>");


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

while($row = mysqli_fetch_array($result)) {
if($filter){
if(strtolower($filter)==strtolower($row['username'])){
$count = $count+1;
  echo("<tr><td>" . $row['pp'] . "</td>" . "<td>" . "<a id='a' href='http://www.roblox.com/User.aspx?username=" . $row['username'] . "'>" . $row['username'] . "</a>" . "</td>" . "<td>" . $row['changetime'] . "</td>" . "<td>" . "<a id='a' href='http://www.roblox.com/User.aspx?username=" . $row['changer'] . "'>" . $row['changer'] . "</a>" . "</td><td>" . getrank($row['username']) . "</td></tr>");
}}
else{
$count = $count+1;
  echo("<tr><td>" . $row['pp'] . "</td>" . "<td>" . "<a id='a' href='http://www.roblox.com/User.aspx?username=" . $row['username'] . "'>" . $row['username'] . "</a>" . "</td>" . "<td>" . $row['changetime'] . "</td>" . "<td>" . "<a id='a' href='http://www.roblox.com/User.aspx?username=" . $row['changer'] . "'>" . $row['changer'] . "</a>" . "</td><td>" . getrank($row['username']) . "</td></tr>");
}
}
echo("</table>");
echo('<br/><b>' . $count . ' total entries</b><br/>');


}
elseif($ok==true){
echo("<br/><br/><a href='Log.php'>Refresh</a> | <a href='Process.php'>Back</a> | <a href='Users.php'>Accounts</a> | <a id='logout' href='Google.php'>Logout</a><br/><br/>Your security level is too low.");
}
else{
$_SESSION["password"]="";
echo("<a id='a' href='Google.php'>Back</a><br/><br/>Wrong password maybe?<br/><br/>Remember to use exact capitalization<br/>for both username and password.");
}
?>

</body>
</html>	
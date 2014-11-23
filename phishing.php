<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<title>RokianStats II</title>
<link rel="shortcut icon" href="/RMLogo.ico" >
<h2>Why this is not a phishing site</h2>
<hr><br/>
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
}
else{
$passWord= $_SESSION["password"];
}
echo("<a href='Google.php' class='logbutton'>Back</a>
<p style='margin-left:400px; margin-right:400px'>Some people may think that this is a phishing site because of the simple fact that you need an account with a password 
to use it. This is just a quick note informing you that 
RM does NOT encourage you to use your Roblox password, or any other important 
password, on this website. The password you use should be unique, do not use it for any 
accounts anywhere else. There is no reason another HR will need the password you use for this website.</p>");
?>
</body>
</html>
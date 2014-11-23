<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<title>RokianStats II</title>
<link rel="shortcut icon" href="/RMLogo.ico" >
</head>
<body>
<?php
session_start();
$_SESSION["username"] = "";
$_SESSION["password"] = "";
?>
<img src='Name.png' style='width:300px;height:75' alt='Rokianstats II'></img>
<hr>
<small>A more secure version of RokianStats in hopes of a more powerful version of the Rokian Military.</small><br/><br/>
<a href="http://www.roblox.com/Groups/group.aspx?gid=953997"><img src="RM1.png" alt="RM Logo" id="passpic" style="width:100%;max-width:240px"></a>
<p>Login:</p>
<form action="Process.php" method="post">
<input type="hidden" name="submitted" value="true"/>
<input required type="text" name="username" placeholder="Username" autofocus/><br/><br/>

<input required type="password" name="password" placeholder="Password"/><br/><br/>

<input type="submit"class='logbutton'value='Log in'/>
</form>
Or <a id='a' href='Signup.php'>sign up</a><br/><br/>
<a id='a' href='phishing.php'>Why this is not a phishing site</a>
<p></p><hr>
</body>
</html>
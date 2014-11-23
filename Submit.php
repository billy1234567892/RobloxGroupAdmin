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
$pp = $_POST["pp"];
$del = $_POST["delete"];
$NAME = $_SESSION["username"];
$con=mysqli_connect("localhost","example","example","example");
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
else{
$sql="SELECT * FROM rokians WHERE username='$userName'";
$check=mysqli_query($con,$sql);
while($row = mysqli_fetch_array($check)){
if(strtolower($row['username'])==strtolower($userName)){
$alreadyexists=true;
}
else{



$alreadyexists=false;
}
}
if(($alreadyexists==false) and (strlen($userName)>2) and ($userName != NULL)){



$sql="INSERT INTO rokians (pp,username,mostrecentchanger) VALUES ('$pp','$userName','$NAME')";
mysqli_query($con,$sql);
if(mysqli_error($con)==""){
$doneOrNo = "Done.";
$sql="SELECT * FROM rokians WHERE LOWER(username)=LOWER('$userName')";
$new=mysqli_query($con,$sql);
$row=mysqli_fetch_array($new);
$pp = $row["pp"];
$sql="INSERT INTO log (pp,username,changer) VALUES ('$pp','$userName','$NAME')";
mail('example@example.com','RokianStats',$NAME . ' added user ' . $userName . ' and gave the user ' . $pp . ' RCs');
mysqli_query($con,$sql);
}

}
elseif(($alreadyexists==true) and ($del==NULL)){



$sql="UPDATE rokians SET pp=pp+'$pp',mostrecentchanger='$NAME' WHERE LOWER(username)=LOWER('$userName')";
mysqli_query($con,$sql);
if(mysqli_error($con)==""){
$doneOrNo = "Done.";
$sql="SELECT * FROM rokians WHERE LOWER(username)=LOWER('$userName')";
$new=mysqli_query($con,$sql);
$row=mysqli_fetch_array($new);
$pp = $row["pp"];
$sql="INSERT INTO log (pp,username,changer) VALUES ('$pp','$userName','$NAME')";
mail('example@example.com','RokianStats',$NAME . ' changed ' . $userName . "'s RCs to " . $pp);
mysqli_query($con,$sql);
}
else{
$doneOrNo = "Error";
}
}
elseif($del){

$sql="INSERT INTO log (pp,username,changer) VALUES (0,'$del','$NAME')";
mail('example@example.com','RokianStats',$NAME . ' deleted user ' . $del);
mysqli_query($con,$sql);

$sql= "DELETE FROM rokians WHERE LOWER(username)=LOWER('$del')";
mysqli_query($con,$sql);
$doneOrNo = "Done.";
}
?>
<h2><?php echo($doneOrNo) ?></h2>
<hr>
<a id='a' href='Process.php'>Back</a>
<br/><br/>
<?php
if($doneOrNo!="Done."){
echo("<h2>Error</h2>There was an error submitting your information to the database.<br/><br/><img src='error.png'>");
}
else{
echo("Data Submitted<br/><br/>");
Header('Location: Process.php');
}

}




 ?>

</body>
</html>
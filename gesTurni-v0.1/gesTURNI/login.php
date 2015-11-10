<?php
require('connectDB.php');
require('functions.php');
?>


<html>
<head>
<title>Login TURNI</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body id="body-color"> 


<div id='loginDIV'>
<fieldset id='fieldLOGIN' style='width:250px'><legend>LOGIN</legend>
<form id='loginFORM' method='POST'>
USERNAME&nbsp&nbsp<input id='username' name='userNAME' type='text' size='25'><br><br>
PASSWORD&nbsp&nbsp<input id='password' name='userPASS' type='text' size='25'><br><br>
<input id='inviaDATI' name='inviaDATI' type='submit' value='LOGIN'> 
</form>
</fieldset>
</div>
</html>

<?php
if(isset($_POST['inviaDATI'])){
	$user=mysql_real_escape_string($_POST['userNAME']);
	$pass=mysql_real_escape_string($_POST['userPASS']);
	
	$sql="SELECT user FROM profili WHERE user='$user' AND password='$pass'";
	$query=mysql_query($sql) or die(mysql_error());
	$si=mysql_num_rows($query);
	if($si==1){
		session_start();
		$_SESSION['username']=$user;
		$_SESSION['logged']=1;
		header('Location:home.php');
		
	}
	else alert_pop("Login non riuscita");
	
	
}
?>
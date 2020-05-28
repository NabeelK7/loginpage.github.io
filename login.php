<?php
session_start();//start
ob_start();

include('php/config.php');
include('php/function.php');
?>

<html>
<head>
<title>Login</title>
<link rel='stylesheet' type='text/css' href='style.css'/>
</head>
<body>
<?php
 if(isset($_POST['submit']))   //handle the form
 {
	 $username=protect($_POST['username']);  // echo"$username";
	 $password=protect($_POST['password']);  // echo"$password";
	 if(!$username || !$password)
	 {
		 echo "<center>You need to fill a <b>Username</b> and a <b>Password</b>!!</center>";
	 }
	 else
	 {
		 
		 $res=mysqli_query($con,"SELECT * FROM `users` WHERE `username`= '".$username."' ")or die(mysqli_error($con));
		 $num=mysqli_num_rows($res);
		
		 if($num == 0)
		 {
			 echo"<center>The <b>Username</b> you supplied does not exist!!</center>";
		 }
		 else
		 {
			 $res=mysqli_query($con,"SELECT * FROM `users` WHERE `username` = '".$username."' AND `password` = '".$password."' ")or die(mysqli_error($con));
			 $num=mysqli_num_rows($res);
			 
			 if($num == 0)
			 {
				 echo"<center>The <b>Password</b> you supplied does not match the one for that username!!</center>";
			 }
			 else
			 {
				 $row=mysqli_fetch_assoc($res);
				 
				 if($row['active'] !=1) //CURRENT active in rows i.e 0 or 1
				 {
					 echo"<center>You have not yet <b>Activated</b> your account!!</center>";
				 }
				 else
				 {
					 $_SESSION['uid']= $row['id'];
					 
					 echo"<center>You have successfully logged in!!</center>";
					 
					 $time=date('U')+50;
					 mysqli_query($con,"UPDATE `users` SET `online`= '".$time."' WHERE `id`= '".$_SESSION['uid']."' ");
					 
					 header('useronline.php');
				 }
			 }
		 }
	 }
 }
 ?>
			 
<form action='login.php' method='post'>
<div id='border'>
<table cellpadding='2' cellspacing='0' border='0'>
<tr>
<td>Username</td>
<td><input type='text' name='username' /></td>
</tr>
<tr>
<td>Password</td>
<td><input type='password' name='password' /></td>
</tr>
<tr>
<td colspan='2' align='center'>
<input type='submit' name='submit' value='Login'>
</td>
</tr>
<tr>
<td colspan='2' align='center'>
<a href='register.php'>Register </a>|<a href='forgot.php'>Forgot Password</a>
</td>
</tr>
</div>
</form>
</body>
</html>

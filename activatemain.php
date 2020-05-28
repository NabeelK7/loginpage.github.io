<?php
session_start();
include("php/config.php");
include("php/function.php");
?>
<html>
<head>
<title>Activate</title>
<link type="text/css" rel="stylesheet" href="style.css"/>
</head> 
<body>
<?php
	$code=$_POST['code'];
	if(!$code)
	{
	echo"<center>Unfortunately there was an error!!</center>";
	}
	else
	{
		$que=mysqli_query($con,"SELECT * FROM `users` WHERE `active`='0' ")or die(mysqli_error($con));
		
		while($row=mysqli_fetch_assoc($que))
		{
			if($code == md5($row['username']).$row['rtime'])
			{
				$res=mysqli_query($con,"UPDATE `users` SET `active` = '1' WHERE `active` ='".$row['id']."' ")or die(mysqli_error($con));
				echo"<center><b>Account</b> activated successfully!!</center>";
			}
		}
	}
	header('useronline.php');
?>

<form method="post" action="activatemain.php">
<div id='border'>
<table border='0' cellpadding='2' cellspacing='0'>
<tr><td>Enter Code</td>
<td><input type='text' name='code'></td></tr>
<tr><td colspan='2' align='center'><input type='submit' name='active' value='Activate'></td></tr>
</div>
</form>
</body>
</html>

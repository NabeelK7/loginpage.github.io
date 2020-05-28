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
//echo"<h3>Processing...........</h3>";

	$code=protect($_GET['code']);
	if($code)
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
			header('useronline.php');
	}
	else
	{
		echo"<center>Unfortunately there was an error!!</center>";
		header('activatemain.php');
	}
?>
</body>
</html>
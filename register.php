<?php
session_start();

include("php/config.php");
include("php/function.php");
?>

<html>
<head>
<title>Register</title>
<link type="text/css" rel="stylesheet" href="style.css"/> 
</head>
<body>
<?php
if(isset($_POST['register']))
{
	$username= protect($_POST['username']);  // echo $username;
	$password= protect($_POST['password']);  // echo $password;
	$pswdcnf= protect($_POST['passwordcnf']);  // echo $pswdcnf;
	$email= protect($_POST['email']);  // echo $email;
	
	if(!$username || !$password || !$pswdcnf || !$email)
	{
		echo "<center>You need to fill the <b>Details</b></center>";
	}
	else
	{
		if(strlen($username)>30 || strlen($username)<3)
			{
				echo"<center><b>Username</b> should be between 3 to 30 characters long!!</center>";
			}
			else
			{
				$que=mysqli_query($con,"SELECT * FROM `users` WHERE `username`= '".$username."'")or die(mysqli_error($con));
				$num=mysqli_num_rows($que);
				
				if($num==1)
				{
					echo"<center><b>Name</b> already exists!!</center>";
				}
				else
				{
					if(strlen($password)<5)
					{
						echo"<center><b>Password</b> must be at least 5 character long!!</center>";
					}
					else
					{
						if($password!= $pswdcnf)
						{
							echo"<center><b>Password</b> you enter does not match the confirmation password</center>";
						}
						else
						{
							//check email
							$emailcheck="/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i";
							if(!preg_match($emailcheck,$email))
							{
								echo"<center>The <b>E-mail</b> is not valid, Must be example@gmail.com!</center>";
							}
							else
							{
								$que=mysqli_query($con,"SELECT * FROM `users` WHERE `email`= '".$email."' ")or die(mysqli_error($con));	
								$num=mysqli_num_rows($que);
								if($num==1)
								{
									echo"<center>Given <b>E-mail</b> is already taken</center>";
								}
								else
								{
									$registertime=date('U');
									
									//code for activation
									$code=md5($username).$registertime;
									//echo $code;
									
									//insert details in db
									$que=mysqli_query($con,"INSERT INTO `users`(`username`,`password`,`email`,`rtime`)VALUES('".$username."','".$password."','".$email."','".$registertime."') ")or die(mysqli_error($con));
									
									//send email
									mail($email, 'registration confirmation', "Thank you for registering to us ".$username.",\n\nHere is your activation link. If the link doesn't work copy and paste it into your browser address bar.\n\n http://www.yourwebsitehere.co.uk/activate.php?code=".$code, 'From: khannabeel995@gmail.com');
									
									echo"<center>You have successfully registered, Check your E-mail inbox for activation!!</center>";
								}
							}
						}
					}
				}
			}
		}
	}	
					
?>

<form action="register.php" method="post">
<div id="border">
<table border="0" cellpadding="2" cellspacing="0">
<tr>
<td>Username</td>
<td><input type="text" name="username"></td>
</tr>
<tr>
<td>Password</td>
<td><input type="password" name="password" size="16"></td>
</tr>
<tr>
<td>Confirm Password</td>
<td><input type="password" name="passwordcnf" size="16"></td>
</tr>
<tr>
<td>Email</td>
<td><input type="text" name="email" size="25"></td>
</tr>
<tr>
<td colspan='2' align="center">
<input type="submit" name="register" value="Register"></td>
</tr>
<tr>
<td colspan='2' align="center">
<a href="login.php">Login</a>|<a href="forgot.php">Forgot Password</a>
</td>
</tr>
</table>
</div>
</form>
</body>
</html>
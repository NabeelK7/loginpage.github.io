<?php

session_start();

include('php/config.php');
include('php/function.php');
?>

<html>
<head>
<title>Forgot Password</title>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<?php

if(isset($_POST['send']))//Check to see if the forms submitted
{

$email = protect($_POST['email']);

if(!$email)//check if the email box was not filled in
{
echo "<center>You need to fill in your <b>E-mail</b> address!</center>";
}
else
{
$checkemail = "/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i";

if(!preg_match($checkemail, $email))
{
echo "<center><b>E-mail</b> is not valid, must be name@server.tld!</center>";
}
else
{
$res = mysqli_query($con,"SELECT * FROM `users` WHERE `email` = '".$email."'")or die(mysqli_error($con));
$num = mysqli_num_rows($res);

if($num == 0)
{
echo "<center>The <b>E-mail</b> you supplied does not exist in our database!</center>";
}
else
{
$row = mysqli_fetch_assoc($res);
mail($email, 'Forgotten Password', "Here is your password: ".$row['password']."\n\nPlease try not too lose it again!", 'From: khannabeel995@gmail.com');

echo "<center>An email has been sent too your email address containing your password!</center>";
}
}
}
}

?>

<div id="border">
<form action="forgot.php" method="post">
<table cellpadding="2" cellspacing="0" border="0">
<tr>
<td>Email</td>
<td><input type="text" name="email" /></td>
</tr>
<tr>
<td colspan="2" align="center"><input type="submit" name='send' value="Send" /></td>
</tr>
<tr>
<td colspan="2" align="center"><a href="login.php">Login</a></a>|<a href="register.php">Register</a></td>
</tr>
</table>
</form>
</div>
</body>
</html>
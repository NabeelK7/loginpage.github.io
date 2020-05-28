<?php

//allow sessions to be passed so we can see if the user is logged in

session_start();

//connect to the database so we can check, edit, or insert data to our users table

include('php/config.php');

//include out functions file giving us access to the protect() function made earlier

include('php/function.php');

?>

<html>

<head>

<title>Logout</title>

<link rel="stylesheet" type="text/css" href="style.css" />

</head>

<body>
<?php
//update to set this users online field to the current time

mysqli_query($con,"UPDATE `users` SET `online` = '".date('U')."' WHERE `id` = '".$_SESSION['uid']."'")or die(mysqli_error($con));

//destroy all sessions canceling the login session

session_destroy();

//display success message

echo "<center>You have successfully logged out!!</center>";


?>

</body>

</html>
<?php
//this is basically the entry point to the app using MVC architecture. 
//Our initial "landing page". Usually, you might have a system that does less BUT I figured it would be easiest 
//to work with this way.
session_start();

//Loads user controller logic
require_once 'controller/user_controller.php';

// Defines web API key for OpenWeather
$apiKey  = '1cc91f40e8a5f8c15ccf9fb11cbcc931';

//IF the user is logged in, redirect to the user page.
if (isset($_SESSION['user_id'])) { 
	header("Location: Controller/user_controller.php?action=home");
	exit();

}
?>

<!DOCTYPE html>
<html> 
<head>
	<title>Weather App</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<div class="container">
	<h2>This is a generic greeting</h2>
	<p>Please login or register to continue:</p>
	<br>
	<form method="post" action="controller/user_controller.php?action=login">
        <input type="hidden" name="action" value="login">
        <h3>Enter User Information</h3>
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <input type="submit" value="Login">
    </form>
	<br>
	<a href="view/register.php"><button>Register</button></a>
</div>
</body>
</html>
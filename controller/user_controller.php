<?php
// controller/user_controller.php
// This is the controller for the user (it is the mid-layer between the UI and our data)


//I setup a bunch of error stuff bellow. I couldn't figure out WHY my data wasn't being pulled properly.

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
//^^^^^^^^^^ All this error stuff can prolly go ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

require_once __DIR__ . '/../model/database.php';
require_once __DIR__ . '/../model/user.php';

$action = $_REQUEST['action'] ?? '';

switch ($action) {
    case 'login': //Our login function. It's simple and straightforward and the password hash stuff WORKS.
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user = loginUser($email, $password);
        if ($user) {
            $_SESSION['user'] = $user;
            header('Location: user_controller.php?action=home');
        } else {
            echo "<p class='error'>Invalid credentials. <a href='../index.php'>Try again</a></p>";
        }
        break;

    case 'register': //Our register new user function. This was what was crashing out BUT it should work fine now.
        $data = [
		//All this is stand-in SQL. We can change as needed.
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'preferred_city' => $_POST['preferred_city']
        ];
        error_log("Attempting to register user: " . json_encode($data));
        if (registerUser($data['first_name'], $data['last_name'], $data['email'], $data['password'], $data['preferred_city'])) {
            header('Location: ../index.php');
        } else {
            echo "<p class='error'>Registration failed. Email may already exist. <a href='../view/register.php'>Try again</a></p>";
        }
        break;

    case 'home': // Send the user to "home", which is where registered users are sent.
        if (!isset($_SESSION['user'])) {
            header('Location: ../index.php');
            exit();
        }
        header('Location: ../view/home.php');
        break;

    case 'logout': // logs out users.
        session_destroy();
        header('Location: ../index.php');
        break;
}
//BASIC user update method. We can style this out a little more if need-be
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'edit_profile') {
    $updated = updateUser(
	//All this is stand-in SQL. We can change as needed.
        $_POST['first_name'],
        $_POST['last_name'],
        $_SESSION['user']['email'],
        $_POST['preferred_city'],
        $_POST['password']
    );

    if ($updated) {
	//All this is stand-in SQL. We can change as needed.
        $_SESSION['user']['first_name'] = $_POST['first_name'];
        $_SESSION['user']['last_name'] = $_POST['last_name'];
        $_SESSION['user']['preferred_city'] = $_POST['preferred_city'];
        header('Location: ../index.php?action=home');
    } else {
        echo "Error updating profile.";
    }
}
?>

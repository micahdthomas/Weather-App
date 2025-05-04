<?php
// controller/user_controller.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../model/database.php';
require_once __DIR__ . '/../model/user.php';

$action = $_REQUEST['action'] ?? '';

switch ($action) {
    case 'login':
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user = loginUser($email, $password);
        if ($user) {
            $_SESSION['user'] = $user;
            header('Location: ../view/home.php');
            exit();
        } else {
            echo "<p class='error'>Invalid credentials. <a href='../index.php'>Try again</a></p>";
        }
        break;

    case 'register':
        $data = [
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'preferred_city' => $_POST['preferred_city']
        ];
        if (registerUser($data['first_name'], $data['last_name'], $data['email'], $data['password'], $data['preferred_city'])) {
            header('Location: ../index.php');
            exit();
        } else {
            echo "<p class='error'>Registration failed. <a href='../view/register.php'>Try again</a></p>";
        }
        break;
	
	case 'update':
        if (!isset($_SESSION['user'])) {
            header('Location: ../index.php');
            exit();
        }

        $email = $_SESSION['user']['email']; // prevent email changes
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $preferredCity = $_POST['preferred_city'];
        $newPassword = $_POST['password'];

        // Handle conditional password change
        if (!empty($newPassword)) {
            $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        } else {
            // Get the current password hash from DB
            $existingUser = getUserByEmail($email);
            $passwordHash = $existingUser['password'];
        }

        $updated = updateUser($email, $firstName, $lastName, $passwordHash, $preferredCity);

        if ($updated) {
            // Update session with new values
            $_SESSION['user']['first_name'] = $firstName;
            $_SESSION['user']['last_name'] = $lastName;
            $_SESSION['user']['preferred_city'] = $preferredCity;
            header('Location: ../view/home.php');
            exit();
        } else {
            echo "<p class='error'>Update failed. <a href='../view/edit_user.php'>Try again</a></p>";
        }
        break;
	
	
    case 'home':
        if (!isset($_SESSION['user'])) {
            header('Location: ../index.php');
            exit();
        }
        header('Location: ../view/home.php');
        exit();
        break;

    case 'logout':
        session_destroy();
        header('Location: ../index.php');
        exit();
        break;
}

?>

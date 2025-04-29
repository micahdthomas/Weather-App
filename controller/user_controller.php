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

// Profile editing stays unchanged
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'edit_profile') {
    $updated = updateUser(
        $_POST['first_name'],
        $_POST['last_name'],
        $_SESSION['user']['email'],
        $_POST['preferred_city'],
        $_POST['password']
    );

    if ($updated) {
        $_SESSION['user']['first_name'] = $_POST['first_name'];
        $_SESSION['user']['last_name'] = $_POST['last_name'];
        $_SESSION['user']['preferred_city'] = $_POST['preferred_city'];
        header('Location: ../view/home.php');
        exit();
    } else {
        echo "Error updating profile.";
    }
}
?>

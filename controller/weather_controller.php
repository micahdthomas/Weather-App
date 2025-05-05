<?php
// controller/weather_controller.php
session_start();
require_once __DIR__ . '/../model/weather.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // Save weather
    if ($action === 'save_weather') {
        $email = $_SESSION['user']['email'];
        saveWeather(
            $email,
            $_POST['city'],
            $_POST['temperature'],
            $_POST['description'],
            $_POST['icon_url']
        );
        header('Location: ../view/home.php');
        exit();
    }

    // Delete weather
    if ($action === 'delete_weather' && isset($_POST['id'])) {
        $email = $_SESSION['user']['email'];
        $id = intval($_POST['id']); // sanitize
        deleteSavedWeather($id, $email);
        header('Location: ../view/home.php'); // or history.php if used there
        exit();
    }
}
?>
<?php
// controller/weather_controller.php
session_start();
require_once __DIR__ . '/../model/weather.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'save_weather') {
    $email = $_SESSION['user']['email'];
    saveWeather($email, $_POST['city'], $_POST['temperature'], $_POST['description'], $_POST['icon_url']);
    header('Location: /weather_app/index.php?action=home'); // Possible incorrect redirect. Double check.
    exit();
}
?>

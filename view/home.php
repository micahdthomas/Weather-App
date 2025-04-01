<?php
// view/home.php - Our user landing page.

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit();
}

require_once '../model/weather.php';

$user = $_SESSION['user'];

$rawWeather = getWeather($user['preferred_city']);

if (is_array($rawWeather)) {
    $weather = $rawWeather;
} else {
    $errorMsg = $rawWeather; // e.g. "API call failed" or "Invalid response: ..."
    $weather = [
        'city' => $user['preferred_city'],
        'temperature' => '--',
        'description' => "Weather unavailable: $errorMsg",
        'icon_url' => 'https://via.placeholder.com/50?text=?'
    ];
}

$savedWeather = getSavedWeather($user['email']);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../styles.css">
    <title>User Home</title>
</head>
<body>
<div class="container">
    <h2>Welcome, <?= htmlspecialchars($user['first_name']) ?>!</h2>
    <div class="weather-card">
        <h3><?= htmlspecialchars($weather['city']) ?></h3>
        <p><?= htmlspecialchars($weather['temperature']) ?>°C - <?= htmlspecialchars($weather['description']) ?></p>
        <img src="<?= htmlspecialchars($weather['icon_url']) ?>" alt="Weather Icon"><br><br>
        <form method="post" action="/weather_app/controller/weather_controller.php">
            <input type="hidden" name="action" value="save_weather">
            <input type="hidden" name="city" value="<?= htmlspecialchars($weather['city']) ?>">
            <input type="hidden" name="temperature" value="<?= htmlspecialchars($weather['temperature']) ?>">
            <input type="hidden" name="description" value="<?= htmlspecialchars($weather['description']) ?>">
            <input type="hidden" name="icon_url" value="<?= htmlspecialchars($weather['icon_url']) ?>">
            <button type="submit">Save this weather</button>
        </form>
    </div>

    <h3>Saved Weather</h3>
    <?php foreach ($savedWeather as $entry): ?>
        <div class="weather-card">
            <p><?= htmlspecialchars($entry['city']) ?> - <?= htmlspecialchars($entry['temperature']) ?>°C</p>
            <p><?= htmlspecialchars($entry['description']) ?></p>
            <p><?= htmlspecialchars($entry['date_saved']) ?></p>
            <img src="<?= htmlspecialchars($entry['icon_url']) ?>" alt="icon">
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>

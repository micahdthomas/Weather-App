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
    $errorMsg = $rawWeather; //failure notices
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
    <meta charset="UTF-8">
    <title>Home - Weather Dashboard</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>

<!-- Top Search Bar -->
<div class="top-bar">
    <form class="search-form" action="../controller/weather_controller.php" method="get">
        <input type="text" name="city" placeholder="Enter city name" required>
        <button type="submit">Search</button>
    </form>
</div>

<!-- Three Column Flex Layout -->
<div class="three-column-layout">
    
    <!-- Left Column (Empty) -->
    <div class="left-column">
        <!-- Intentionally left empty -->
    </div>

    <!-- Center Column (Time, Date, Current Weather) -->
    <div class="center-column">
        <div class="datetime">
            <?php echo date("g:i A"); ?>
        </div>
        <div class="date-display">
            <?php echo date("l, F j, Y"); ?>
        </div>

        <?php if ($rawWeather): ?>
            <div class="weather-card current-weather">
                <h2><?php echo htmlspecialchars($rawWeather['city']); ?></h2>
                <p><?php echo htmlspecialchars($rawWeather['description']); ?></p>
                <p>Temp: <?php echo htmlspecialchars($rawWeather['temperature']); ?>°C</p>
                <img src="http://openweathermap.org/img/wn/<?php echo htmlspecialchars($rawWeather['icon']); ?>@2x.png" alt="Weather Icon">
            </div>
        <?php else: ?>
            <p>No current weather data available.</p>
        <?php endif; ?>
    </div>

    <!-- Right Column (Saved Weather List) -->
    <div class="sidebar">
        <h3>Recent Saved Weather</h3>

        <?php if ($savedWeather): ?>
            <?php 
            $count = 0;
            foreach ($savedWeather as $entry): 
                if ($count >= 3) break;
            ?>
                <div class="weather-card">
                    <h4><?php echo htmlspecialchars($entry['city']); ?></h4>
                    <p><?php echo htmlspecialchars($entry['description']); ?></p>
                    <p>Temperature: <?php echo htmlspecialchars($entry['temperature']); ?>°C</p>
                    <p>Date Saved: <?php echo htmlspecialchars($entry['date_saved']); ?></p>
                </div>
            <?php 
                $count++;
            endforeach;
            ?>
        <?php else: ?>
            <p>No saved weather entries.</p>
        <?php endif; ?>

        <div class="view-history-link">
            <a href="history.php">View More</a>
        </div>
    </div>

</div>

</body>
</html>

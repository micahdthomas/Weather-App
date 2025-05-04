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
$searchResult = null;
if (isset($_GET['city']) && !empty($_GET['city'])) {
    $searchCity = htmlspecialchars($_GET['city']);
    $searchData = getWeather($searchCity);

    if (is_array($searchData)) {
        $searchResult = $searchData;
    } else {
        $searchResult = [
            'error' => "No data found for '$searchCity'."
        ];
    }
}
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
    <form class="search-form" action="home.php" method="get">
        <input type="text" name="city" placeholder="Enter city name" required>
        <button type="submit">Search</button>
    </form>
    <div style="display: inline-block; margin-left: 35px;">
        <a href="edit.php" style="text-decoration: none; font-weight: bold;">Edit Profile</a>
    </div>
</div>

<!-- Three Column Flex Layout -->
<div class="three-column-layout">
    <!-- Left Column (Search Results) -->
	<div class="left-column">
		<?php if ($searchResult && !isset($searchResult['error'])): ?>
			<div class="weather-card">
				<h2><?= htmlspecialchars($searchResult['city']) ?></h2>
				<p><?= htmlspecialchars($searchResult['description']) ?></p>
				<p>Temp: <?= htmlspecialchars($searchResult['temperature']) ?>°F</p>
				<img src="<?= htmlspecialchars($searchResult['icon_url']) ?>" alt="Weather Icon">

				<form method="post" action="/weather_app/controller/weather_controller.php">
					<input type="hidden" name="action" value="save_weather">
					<input type="hidden" name="city" value="<?= htmlspecialchars($searchResult['city']) ?>">
					<input type="hidden" name="temperature" value="<?= htmlspecialchars($searchResult['temperature']) ?>">
					<input type="hidden" name="description" value="<?= htmlspecialchars($searchResult['description']) ?>">
					<input type="hidden" name="icon_url" value="<?= htmlspecialchars($searchResult['icon_url']) ?>">
					<button type="submit">Save this weather</button>
				</form>

				<!-- Clear button: redirects back to home.php without query -->
				<form method="get" action="home.php" style="margin-top:10px;">
					<button type="submit">Clear</button>
				</form>
			</div>
		<?php elseif (isset($searchResult['error'])): ?>
			<p><?= htmlspecialchars($searchResult['error']) ?></p>
			<form method="get" action="home.php" style="margin-top:10px;">
				<button type="submit">Clear</button>
			</form>
		<?php endif; ?>
	</div>

    <!-- Center Column (Time, Date, Current Weather) -->
    <div class="center-column">
	


        <?php if ($rawWeather): ?>
            <div class="weather-card">
			        <div class="date-time-wrapper">
						<div class="datetime">
							<?php echo date("g:i A"); ?>
						</div>
						<div class="date-display">
							<?php echo date("l, F j, Y"); ?>
						</div>
					</div>
                <h2><?php echo htmlspecialchars($rawWeather['city']); ?></h2>
                <p><?php echo htmlspecialchars($rawWeather['description']); ?></p>
                <p>Temp: <?php echo htmlspecialchars($rawWeather['temperature']); ?>°F</p>
                <img src="<?= htmlspecialchars($rawWeather['icon_url']) ?>" alt="Weather Icon">
				<form method="post" action="/weather_app/controller/weather_controller.php">
					<input type="hidden" name="action" value="save_weather">
					<input type="hidden" name="city" value="<?= htmlspecialchars($rawWeather['city']) ?>">
					<input type="hidden" name="temperature" value="<?= htmlspecialchars($rawWeather['temperature']) ?>">
					<input type="hidden" name="description" value="<?= htmlspecialchars($rawWeather['description']) ?>">
					<input type="hidden" name="icon_url" value="<?= htmlspecialchars($rawWeather['icon_url']) ?>">
					<button type="submit">Save this weather</button>
				</form>
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
                    <p>Temperature: <?php echo htmlspecialchars($entry['temperature']); ?>°F</p>
                    <p>Date Saved: <?php echo htmlspecialchars($entry['date_saved']); ?></p>
					<img src="<?= htmlspecialchars($entry['icon_url']) ?>" alt="Weather Icon">
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

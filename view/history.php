<?php
// view/history.php - User's saved weather history page

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit();
}

require_once '../model/weather.php';

$user = $_SESSION['user'];
$savedWeather = getSavedWeather($user['email']);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../styles.css">
    <title>Saved Weather History</title>
</head>
<body>
<div class="container">
    <h2><?= htmlspecialchars($user['first_name']) ?>'s Saved Weather</h2>
    <a href="home.php" class="back-link">← Back to Home</a>

    <?php if (!empty($savedWeather)) : ?>
        <?php foreach ($savedWeather as $entry) : ?>
            <div class="weather-card">
                <h3><?= htmlspecialchars($entry['city']) ?></h3>
                <p><?= htmlspecialchars($entry['temperature']) ?>°F - <?= htmlspecialchars($entry['description']) ?></p>
                <p>Saved on: <?= date('F j, Y', strtotime($entry['date_saved'])) ?></p>
                <img src="<?= htmlspecialchars($entry['icon_url']) ?>" alt="Weather Icon">
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>No saved weather entries yet.</p>
    <?php endif; ?>
</div>
</body>
</html>

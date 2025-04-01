<?php
// -------------------------------------------------------
// 1. CONFIGURATION
// -------------------------------------------------------

// Replace with your valid OpenWeatherMap API key
$apiKey  = '1cc91f40e8a5f8c15ccf9fb11cbcc931';
$apiUrl  = 'http://api.openweathermap.org/data/2.5/weather';

$weatherData = null;

// -------------------------------------------------------
// 2. HANDLE FORM SUBMISSION (NO DATABASE)
// -------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $city    = htmlspecialchars($_POST['city']);
    $state   = htmlspecialchars($_POST['state']);
    $country = htmlspecialchars($_POST['country']);

    $query = urlencode("$city,$state,$country");
    
    // Use metric units => Celsius
    $url = "$apiUrl?q=$query&appid=$apiKey&units=metric";

    $jsonResponse = @file_get_contents($url);

    if ($jsonResponse === false) {
        echo "<p style='color:red;'>Failed to fetch weather data. Check API key, network, or allow_url_fopen.</p>";
    } else {
        $weatherData = json_decode($jsonResponse, true);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Weather Viewer</title>
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
    <div class="container">
        <h1>Weather Viewer (No Database)</h1>

        <form method="POST">
            <input type="text" name="city" placeholder="City" required />
            <input type="text" name="state" placeholder="State (Optional)" />
            <input type="text" name="country" placeholder="Country" required />
            <button type="submit">Search</button>
        </form>

        <?php if (!empty($weatherData) && isset($weatherData['cod'])): ?>
            <?php if ($weatherData['cod'] == 200): ?>
                <?php
                    // MAIN WEATHER DATA
                    $temp        = $weatherData['main']['temp'];
                    $feelsLike   = $weatherData['main']['feels_like'];
                    $tempMin     = $weatherData['main']['temp_min'];
                    $tempMax     = $weatherData['main']['temp_max'];
                    $humidity    = $weatherData['main']['humidity'];

                    // WEATHER DESCRIPTION
                    $description = $weatherData['weather'][0]['description'];
                    $icon        = 'http://openweathermap.org/img/wn/' . $weatherData['weather'][0]['icon'] . '.png';

                    // WIND
                    $windSpeed   = $weatherData['wind']['speed']; // m/s if metric
                    $windDeg     = $weatherData['wind']['deg'] ?? null;

                    // SUNRISE & SUNSET
                    $sunrise     = isset($weatherData['sys']['sunrise']) ? date('H:i', $weatherData['sys']['sunrise']) : '--';
                    $sunset      = isset($weatherData['sys']['sunset'])  ? date('H:i', $weatherData['sys']['sunset'])  : '--';

                    // CITY & COUNTRY
                    $cityName    = $weatherData['name'];
                    $countryCode = $weatherData['sys']['country'] ?? $country;
                ?>
                <div class="weather-card">
                    <h2><?php echo "$cityName, $countryCode"; ?></h2>
                    <img src="<?php echo $icon; ?>" alt="Weather Icon" />
                    <p><strong>Conditions:</strong> <?php echo ucfirst($description); ?></p>
                    <p><strong>Temp:</strong> <?php echo $temp; ?> °C</p>
                    <p><strong>Feels Like:</strong> <?php echo $feelsLike; ?> °C</p>
                    <p><strong>Low /</strong> <?php echo $tempMin; ?> °C 
                       <strong>High:</strong> <?php echo $tempMax; ?> °C
                    </p>
                    <p><strong>Humidity:</strong> <?php echo $humidity; ?> %</p>
                    <p><strong>Wind Speed:</strong> <?php echo $windSpeed; ?> m/s
                        <?php if ($windDeg !== null): ?>
                            (Direction: <?php echo $windDeg; ?>°)
                        <?php endif; ?>
                    </p>
                    <p><strong>Sunrise:</strong> <?php echo $sunrise; ?> 
                       <strong>Sunset:</strong> <?php echo $sunset; ?>
                    </p>
                </div>
            <?php else: ?>
                <p class="error">
                    Error fetching weather. Code: <?php echo $weatherData['cod']; ?>.<br />
                    <?php if (isset($weatherData['message'])): ?>
                        Message: <?php echo $weatherData['message']; ?>
                    <?php endif; ?>
                </p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
// model/weather.php - This basically manipulates our weather data and pulls from our API.
//All our weather-ralted SQL calls can be found here. 

/*             The older model gave weather details like the code bellow. Might need to grab all this the same way.


                    $temp        = $weatherData['main']['temp'];
                    $feelsLike   = $weatherData['main']['feels_like'];
                    $tempMin     = $weatherData['main']['temp_min'];
                    $tempMax     = $weatherData['main']['temp_max'];
                    $humidity    = $weatherData['main']['humidity'];
					
				The way we pulled from the user and bridged it all together was:
				
				    $city    = htmlspecialchars($_POST['city']);
					$state   = htmlspecialchars($_POST['state']);
					$country = htmlspecialchars($_POST['country']);

					$query = urlencode("$city,$state,$country");
*/
require_once 'database.php';
//
function getWeather($city) {
    $apiKey = '1cc91f40e8a5f8c15ccf9fb11cbcc931'; //my individually generated key from openweather.
    $apiUrl = 'http://api.openweathermap.org/data/2.5/weather'; //where we connect to the site
    
    // Construct URL using the provided city and currently grabs celsius - we should def change to f.
    $url = $apiUrl . '?q=' . urlencode($city) . '&appid=' . $apiKey . '&units=imperial';
    //failsafe in case call fails
    $response = @file_get_contents($url);
    if (!$response) {
        return "API call failed";
    }
    
    $data = json_decode($response, true);
    // Check for a successful response (OpenWeatherMap returns a 'cod' key, whatever that means)
    if (!is_array($data) || (($data['cod'] ?? 0) != 200)) {
        $errorMessage = $data['message'] ?? 'Unknown error';
        return "Invalid response: $errorMessage";
    }
    
    return [
        'city' => $data['name'] ?? $city,
        'temperature' => $data['main']['temp'] ?? '--',
        'description' => $data['weather'][0]['description'] ?? 'N/A',
        'icon_url' => isset($data['weather'][0]['icon'])
            ? 'http://openweathermap.org/img/wn/' . $data['weather'][0]['icon'] . '.png'
            : 'https://via.placeholder.com/50?text=?'
    ];
}
//retrieve saved weather function
function getSavedWeather($email) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM saved_weather WHERE email = ? ORDER BY date_saved DESC");
    $stmt->execute([$email]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
//Save weather function
function saveWeather($email, $city, $temperature, $description, $icon_url) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO saved_weather (email, city, temperature, description, icon_url, date_saved) VALUES (?, ?, ?, ?, ?, NOW())");
    return $stmt->execute([$email, $city, $temperature, $description, $icon_url]);//Likely cause of the issue. Double check.
}
//Delete weather function
function deleteSavedWeather($id, $email) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM saved_weather WHERE id = ? AND email = ?");
    return $stmt->execute([$id, $email]);
}
?>

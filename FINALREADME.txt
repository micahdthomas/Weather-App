A lightweight weather tracking application built with PHP, MySQL, and 
HTML/CSS using a custom MVC architecture. Users can register, log in, 
edit their profile, and save current weather conditions for U.S. cities.

Requirements:

-XAMPP (includes Apache + MySQL)
-PHP 7.4 or higher (included in XAMPP)
-A modern web browser

Download and install XAMPP from apachefriends.org.

Start: Apache server and MySQL server
(from the XAMPP Control Panel)

Move or copy your project folder (e.g., weather_app/) into:
C:\xampp\htdocs\

So the full path is:
C:\xampp\htdocs\weather_app\

Go to http://localhost/phpmyadmin and click Import.
Upload the provided database.sql file to import database.

Default XAMPP MySQL user is root with no password.

TO RUN THE APPLICATION:
In your browser, visit http://localhost/weather_app/

Start by registering and then log in. You can view and save
weather data from there.

INDEX OF FILES:

/weather_app/
│
├── index.php                   # Landing/Login page
├── database.sql                # SQL schema (for setup/import)
├── styles.css                  # Global CSS for all views
│
├── controller/
│   ├── user_controller.php     # Handles login, register, update, logout
│   └── weather_controller.php  # Handles saving weather data
│
├── model/
│   ├── database.php            # PDO connection to MySQL
│   ├── user.php                # User logic (register, login, update)
│   └── weather.php             # Weather logic (get/save weather)
│
├── view/
│   ├── register.php            # User registration form
│   ├── edit.php                # Edit user profile info
│   ├── home.php                # Profile dashboard with current + saved weather and search
│   ├── history.php             # View saved weather history
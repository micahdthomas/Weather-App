CREATE DATABASE weather_app;
USE weather_app;

-- Users Table
CREATE TABLE users (
    email VARCHAR(100) PRIMARY KEY,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    password VARCHAR(255),
    preferred_city VARCHAR(100)
);

-- Saved Weather Table
CREATE TABLE saved_weather (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100),
    city VARCHAR(100),
    temperature VARCHAR(10),
    description VARCHAR(255),
    icon_url VARCHAR(255),
    date_saved DATETIME,
    FOREIGN KEY (email) REFERENCES users(email) ON DELETE CASCADE
);


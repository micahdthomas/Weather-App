<?php
// model/user.php - This basically manipulates data and connects to our user database. 
//SQL has been properly updated and should be fully functional now. 
//All our user-ralted SQL calls can be found here. 

require_once __DIR__ . '/database.php';

function registerUser($first_name, $last_name, $email, $password, $preferred_city) {
    global $pdo;
    
    $hashed = password_hash($password, PASSWORD_DEFAULT);//Successful password hashing (security!)
    $sql = "INSERT INTO users (first_name, last_name, email, password, preferred_city) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql); 
    
    return $stmt->execute([$first_name, $last_name, $email, $hashed, $preferred_city]);
}
//Update user function -- MKII - hoping this works!
function updateUser($email, $first_name, $last_name, $password_hash, $preferred_city) {
    global $pdo;

    if (!empty($password_hash)) {
        $stmt = $pdo->prepare("UPDATE users SET first_name = ?, last_name = ?, password = ?, preferred_city = ? WHERE email = ?");
        return $stmt->execute([$first_name, $last_name, $password_hash, $preferred_city, $email]);
    } else {
        $stmt = $pdo->prepare("UPDATE users SET first_name = ?, last_name = ?, preferred_city = ? WHERE email = ?");
        return $stmt->execute([$first_name, $last_name, $preferred_city, $email]);
    }
}
//Login function
function loginUser($email, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }
    return false;
}

//Get user by email function -- used in editing
function getUserByEmail($email) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

?>

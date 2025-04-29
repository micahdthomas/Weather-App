<?php
// model/user.php - This basically manipulates data and connects to our user database. 
//ALL SQL is stand-in for the purpose of testing funcitonality. 
//All our user-ralted SQL calls can be found here. 

require_once __DIR__ . '/database.php';

function registerUser($first_name, $last_name, $email, $password, $preferred_city) {
    global $pdo;
    
    $hashed = password_hash($password, PASSWORD_DEFAULT);//Successful password hashing (security!)
    $sql = "INSERT INTO users (first_name, last_name, email, password, preferred_city) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql); 
    
    return $stmt->execute([$first_name, $last_name, $email, $hashed, $preferred_city]);
}

function updateUser($first_name, $last_name, $email, $preferred_city, $new_password) {
    global $pdo;

    if (!empty($new_password)) {
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET first_name = ?, last_name = ?, preferred_city = ?, password = ? WHERE email = ?");
        return $stmt->execute([$first_name, $last_name, $preferred_city, $hashed, $email]);
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
?>

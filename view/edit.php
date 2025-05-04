<?php
session_start();
require_once '../model/user.php'; // Assuming you have this model

// If the user is not logged in, redirect
if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit();
}

// Optionally pull latest user data from database
$user = getUserByEmail($_SESSION['user']['email']); // function you'll need to write if not done already
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" type="text/css" href="../styles.css">
</head>
<body>
    <div class="container">
		<div class="top-bar" style="text-align: right; margin-bottom: 10px;">
			<a href="home.php">← Back to Home</a>
		</div>
        <h2>Edit Your Information</h2>

        <?php if (isset($_GET['error'])): ?>
            <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>

        <form action="../controller/user_controller.php" method="post">
            <label for="first_name">First Name:</label><br>
            <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required><br><br>

            <label for="last_name">Last Name:</label><br>
            <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required><br><br>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required readonly><br><br>

            <label for="password">New Password (leave blank to keep current):</label><br>
            <input type="password" id="password" name="password"><br><br>

            <label for="preferred_city">Preferred City (city, state abbreviation, country):</label><br>
            <input type="text" id="preferred_city" name="preferred_city" value="<?= htmlspecialchars($user['preferred_city']) ?>" required><br><br>

            <input type="hidden" name="action" value="update">

            <input type="submit" value="Update">
        </form>
    </div>
</body>
</html>
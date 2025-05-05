<?php
// This is the registration form stuff
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <link rel="stylesheet" type="text/css" href="../styles.css">
</head>
<body>
    <div class="container">
        <h2>Register</h2>

        <?php if (isset($_GET['error'])): ?>
            <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>

        <form action="../controller/user_controller.php" method="post">
            <label for="first_name">First Name:</label><br>
            <input type="text" id="first_name" name="first_name" required><br><br>

            <label for="last_name">Last Name:</label><br>
            <input type="text" id="last_name" name="last_name" required><br><br>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br><br>

            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>

            <label for="preferred_city">Preferred City (City, state abbreviation, USA):</label><br>
            <input type="text" id="preferred_city" name="preferred_city" placeholder="e.g. Denver, CO, USA" required>
			<input type="hidden" name="action" value="register">

			<input type="submit" value="Register">
		</form>

        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </div>
</body>
</html>
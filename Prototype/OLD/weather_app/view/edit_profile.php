<?php
// view/edit_profile.php - The HTML layout. Basically our UI stuff.

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit();
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../styles.css">
    <title>Edit Profile</title>
</head>
<body>
<div class="container">
    <h2>Edit Profile</h2>
    <form method="post" action="../controller/user_controller.php">
        <input type="hidden" name="action" value="edit_profile">
        
        <label>First Name:</label><br>
        <input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required><br><br>

        <label>Last Name:</label><br>
        <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required><br><br>

        <label>Preferred City:</label><br>
        <input type="text" name="preferred_city" value="<?= htmlspecialchars($user['preferred_city']) ?>" required><br><br>

        <label>New Password (leave blank to keep current):</label><br>
        <input type="password" name="password"><br><br>

        <button type="submit">Save Changes</button>
    </form>
</div>
</body>
</html>

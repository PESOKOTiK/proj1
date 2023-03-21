<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit;
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>

<head>
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="../css/home.css">
</head>

<body>
    <div class="container">
        <div class="welcome-container">
            <h2>Welcome, <?php echo $username ?>!</h2>
            <p>You have successfully logged in.</p>
            <form action="../index.php" method="POST">
                <button type="submit" name="logout">Logout</button>
            </form>
        </div>
    </div>
</body>

</html>
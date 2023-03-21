<head>
  <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<div class="container">
		
        <?php

        $host = "localhost";
        $dbname = "proj1";
        $username = "root";
        $password = "";
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

        // Rрегистрация
        if (isset($_POST['register'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $birthdate = $_POST['birthdate'];
            $stmt = $conn->prepare("SELECT * FROM User WHERE email=:email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                echo "<div class='error'>Email already taken.</div>";
            } else {
                $stmt = $conn->prepare("SELECT * FROM User WHERE username=:username");
                $stmt->bindParam(':username', $username);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    echo "<div class='error'>Username already taken.</div>";
                } else {
                    $stmt = $conn->prepare("INSERT INTO User (id, username, password, email, birthdate) VALUES (NULL, :username, :password, :email, :birthdate)");
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':password', $password);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':birthdate', $birthdate);
                    if ($stmt->execute()) {
                        echo "<br><div class='success'>Registration successful.</div>";
                    } else {
                        echo "<div class='error'>Registration failed.</div>";
                    }
                }
            }
        }

        // логин
        if (isset($_POST['login'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $stmt = $conn->prepare("SELECT * FROM User WHERE email=:email AND password=:password");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $username = $row['username'];
                $_SESSION['username'] = $username;
                header("Location: pages/home.php");
                exit;
            } else {
                echo "<div class='error'>Invalid email or password.</div>";
            }
        }
    ?>

<div class="container">
        <div class="login-container">
            <h2>Login</h2>
            <form method="post" action="">
                <div>
                    <label>Email:</label>
                    <input type="text" name="email" required>
                </div>
                <div>
                    <label>Password:</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" name="login">Login</button>
            </form>
        </div>
        <div class="register-container">
            <h2>Register</h2>
            <form method="post" action="">
                <div>
                    <label>Username:</label>
                    <input type="text" name="username" required>
            </div>
            <div>
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>
            <div>
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>
            <div>
                <label>Birthdate:</label>
                <input type="date" name="birthdate" required>
            </div>
            <button type="submit" name="register">Register</button>
        </form>
    </div>
</div>
<?php
    session_start();
    if (isset($_SESSION["username"])) {
        header("Location: http://localhost/osk_login/dashboard");
        exit();
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="main">

        <h2>Logowanie</h2>
        <form method="post" action="login.php">
            <label for="username">Użytkownik:</label>
            <input type="text" id="username" name="username" required><br><br>

            <label for="password">Hasło:</label>
            <input type="password" id="password" name="password" required><br><br>

            <input type="submit" value="Zaloguj">
        </form>
    </div>
</body>
</html>
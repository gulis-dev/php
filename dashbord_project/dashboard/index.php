<?php
    session_start();
    if (!isset($_SESSION["username"])) {
        header("Location: http://localhost/osk_login/");
        exit();
    }
    if (isset($_GET["action"]) && $_GET["action"] === "logout") {
        session_unset();
        session_destroy();
        header("Location: http://localhost/osk_login/");
        exit();
    }

    $mysqli = new mysqli("localhost", "admin", "admin", "osk_login");

    if ($mysqli->connect_error) {
        die("Błąd połączenia z bazą danych: " . $mysqli->connect_error);
    }

    $username = $_SESSION["username"];

    $query = "SELECT last_login FROM users WHERE username = '$username'";
    $result = $mysqli->query($query);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $lastLogin = $row["last_login"];
        $lastLogin = date("d-m-Y H:i", time());
    }

    $mysqli->close();
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Dashboard</h1>
    <hr>
    <?php
        echo "Witaj <b>" . $_SESSION["username"] . "</b><br>Ostatnie logowanie: " . $lastLogin;
    ?>
    <a href="http://localhost/osk_login/dashboard/users" style="background-color: grey;">User</a>
    <a href="?action=logout">Logout</a>
</body>
</html>

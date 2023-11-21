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

    
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="users/style.css">
</head>
<body>
    <div id="main">
        <div id="menu">
            <?php 
                $username = $_SESSION["username"];
                $query2 = "SELECT avatar FROM users WHERE username = '$username'";
                $result2 = $mysqli->query($query2);

                if ($result2->num_rows === 1) {
                    $row = $result2->fetch_assoc();
                    $avatar = $row["avatar"];
                    
                    echo " <img src=".$avatar." alt='avatar uzytkownika'><br>";
                }
            ?>
            <?php
                echo "<h2>" . $_SESSION["username"] . "</h2>";
            ?>
            <?php
                echo "</b><br>Ostatnie logowanie:<br>" . $_SESSION["last_login"];
            ?>
            <a href="http://localhost/osk_login/dashboard">Dashboard</a>
        </div>
        <div id="content">
        <h1>Dashboard</h1>
            <hr>
            
            <a href="http://localhost/osk_login/dashboard/users" style="background-color: grey;">User</a>
            <a href="?action=logout">Logout</a>
        </div>
    </div>
    
</body>
</html>

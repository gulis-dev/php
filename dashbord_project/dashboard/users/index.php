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
            <div id="user">
            <?php

                class User {
                    public $name;
                    public $last_name;

                    public function __construct($name, $last_name) {
                        $this->name = $name;
                        $this->last_name = $last_name;
                    }

                    public function get_full_name() {
                        return $this->name . ' ' . $this->last_name;
                    }
                }

                $user = new User("Oskar", "Andrukiewicz");
                echo "<h2>".$user->get_full_name()."</h2>";

                ?>

            </div>
            <h1>Adresses:</h1>
            <div id="adresses">
            <?php 
                if (!isset($_SESSION["username"])) {
                    header("Location: http://localhost/osk_login/");
                    exit();
                }


                $user = $_SESSION["username"];


                $query = "SELECT city, street, no, country FROM adresses WHERE user = ?";
                if ($stmt = $mysqli->prepare($query)) {
                    $stmt->bind_param("s", $user);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<table>";
                            echo "<tr style='background-color: #57b3ff'><td>Edytuj Usuń</td></tr>";
                            echo "<tr><td><b>City:</b> " . $row["city"] . "</td></tr>";
                            echo "<tr class='two'><td><b>Street:</b> " . $row["street"] . "</td></tr>";
                            echo "<tr><td><b>No:</b> " . $row["no"] . "</td></tr>";
                            echo "<tr class='two'><td><b>Country:</b> " . $row["country"] . "</td></tr>";
                            echo "</table>";
                        }
                    } else {
                        echo "No address records found for this user.";
                    }
                } else {
                    echo "Database error.";
                }
            ?>
            </div>
            <a class="new" href="http://localhost/osk_login/dashboard/users/new-adress">New Adress</a>
        </div>
    </div>
</body>
</html>
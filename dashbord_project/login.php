<?php
session_start();

$mysqli = new mysqli("localhost", "admin", "admin", "osk_login");

if ($mysqli->connect_error) {
    die("Błąd połączenia z bazą danych: " . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $username = $mysqli->real_escape_string($username);

    $query = "SELECT id, password FROM users WHERE username = '$username'";
    $result = $mysqli->query($query);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row["password"];

        if (md5($password) === $hashed_password) {
            $_SESSION["username"] = $username;

            $time = time();
            
            $updateDate = "UPDATE users SET last_login = $time WHERE username = '$username'";
            if ($mysqli->query($updateDate)) {
                $query2 = "SELECT last_login FROM users WHERE username = '$username'";
                $result2 = $mysqli->query($query2);

                if ($result2->num_rows === 1) {
                    $row = $result2->fetch_assoc();
                    $lastLogin = $row["last_login"];
                    $lastLogin = date("d-m-Y H:i", time());
                    $_SESSION["last_login"] = $lastLogin;
                }
                header("Location: ./dashboard");
                exit();
            } else {
                echo "Błąd podczas aktualizacji ostatniego logowania.";
            }
        } else {
            echo "Błędne hasło. Proszę spróbować ponownie.";
        }
    } else {
        echo "Błędna nazwa użytkownika. Proszę spróbować ponownie.";
    }
}

$mysqli->close();
?>

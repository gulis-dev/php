<?php
session_start();

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
    private $conn;
    public function addAddress($user, $city, $street, $no, $country) {
        $sql = "INSERT INTO adresses (user, city, street, no, country) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssss", $user, $city, $street, $no, $country);
        if ($stmt->execute()) {
            echo "Dane zostały dodane do tabeli adresses.";
        } else {
            echo "Błąd podczas dodawania danych: " . $stmt->error;
        }
    }

    public function close() {
        $this->conn->close();
    }

    public function __destruct() {
        $this->close();
    }
}

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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $city = $_POST["city"];
    $street = $_POST["street"];
    $no = $_POST["no"];
    $country = $_POST["country"];
    $user = $_SESSION["username"];

    $db_host = "localhost";
    $db_username = "admin";
    $db_password = "admin";
    $db_name = "osk_login";

    $User->addAddress($user, $city, $street, $no, $country);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Address Book</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <a href="http://localhost/osk_login/dashboard/users" class="button">Powrót</a>
    <div id="main">
        <h2>Dodaj adres</h2>
        <form method="post" action="">
            <label for="city">City:</label>
            <input type="text" id="city" name="city" required><br><br>
            <div id="dane">
                <label for="street">Street</label>
                <input type="text" id="street" name="street" required><br><br>
                <label for="no">No.</label>
                <input type="text" id="no" name="no" required><br><br>
            </div>
            <label for="country">Country:</label>
            <select id="country" name="country">
                <option value="Poland">Poland</option>
                <option value="Germany">Germany</option>
                <option value="United States">United States</option>
            </select><br><br>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>

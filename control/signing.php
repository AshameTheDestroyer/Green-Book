<?php
$signing_up = filter_input(INPUT_POST, "signing_up", FILTER_SANITIZE_STRING);
$signing_in = filter_input(INPUT_POST, "signing_in", FILTER_SANITIZE_STRING);

if ($signing_up) {
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
    $surname = filter_input(INPUT_POST, "surname", FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);

    try {
        $query = "INSERT INTO users(name, surname, email) VALUES ('$name', '$surname', '$email')";
        $connection->execute_query($query);
    } catch (mysqli_sql_exception $e) {
        echo $e->getMessage();
    }
} else if ($signing_in) {
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);

    $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $result = $connection->execute_query($query);
    var_dump($result->fetch_all()[0]);
}
?>
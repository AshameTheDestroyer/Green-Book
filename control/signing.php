<?php
$signingUp = filter_input(INPUT_POST, "signing_up", FILTER_SANITIZE_STRING);
$signingIn = filter_input(INPUT_POST, "signing_in", FILTER_SANITIZE_STRING);

if ($signingUp) {
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
    $surname = filter_input(INPUT_POST, "surname", FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

    $email = strtolower($email);
    $password = sha1($password);

    try {
        $query = "INSERT INTO users(name, surname, email, password) VALUES ('$name', '$surname', '$email', '$password')";
        $connection->execute_query($query);
    } catch (mysqli_sql_exception $e) {
        $signingError = "Duplicate Email";
        $signingErrorMessage = "Email already exists, either sign in or pick another one.";
    }
} else if ($signingIn) {
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

    $email = strtolower($email);
    $password = sha1($password);

    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password' LIMIT 1";
    $result = $connection->execute_query($query);
    $user = $result->fetch_all()[0];

    if ($user == NULL) {
        $signingError = "Login Failed";
        $signingErrorMessage = "Either email or password is incorrect.";
    }
}
?>
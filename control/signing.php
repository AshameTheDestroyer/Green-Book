<?php
$signingOut = filter_input(INPUT_POST, "signing_out", FILTER_SANITIZE_STRING);
$signingUp = filter_input(INPUT_POST, "signing_up", FILTER_SANITIZE_STRING);
$signingIn = filter_input(INPUT_POST, "signing_in", FILTER_SANITIZE_STRING);

if ($signingOut) {
    $_SESSION["is_authenticated"] = false;
    $_SESSION["user"] = null;
} elseif ($signingUp) {
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
    $surname = filter_input(INPUT_POST, "surname", FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

    $email = strtolower($email);
    $password = sha1($password);

    try {
        $query = "INSERT INTO users(name, surname, email, password) VALUES ('$name', '$surname', '$email', '$password')";
        $connection->execute_query($query);

        $query = "SELECT id, name, surname, email, is_administrator, is_owner FROM users WHERE email = '$email' AND password = '$password' LIMIT 1";
        $result = $connection->execute_query($query);
        $user_to_edit = $result->fetch_all(MYSQLI_ASSOC)[0];

        $_SESSION["is_authenticated"] = true;
        $_SESSION["user"] = $user_to_edit;
        header("location: home_page.php");
    } catch (mysqli_sql_exception $e) {
        $signingError = "Duplicate Email";
        $signingErrorMessage = "Email already exists, either sign in or pick another one.";
    }
} elseif ($signingIn) {
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

    $email = strtolower($email);
    $password = sha1($password);

    $query = "SELECT id, name, surname, email, is_administrator, is_owner FROM users WHERE email = '$email' AND password = '$password' LIMIT 1";
    $result = $connection->execute_query($query);
    $user_to_edit = $result->fetch_all(MYSQLI_ASSOC)[0];

    if ($user_to_edit == NULL) {
        $signingError = "Login Failed";
        $signingErrorMessage = "Either email or password is incorrect.";

        return;
    }

    $_SESSION["is_authenticated"] = true;
    $_SESSION["user"] = $user_to_edit;
    header("location: home_page.php");
}
?>
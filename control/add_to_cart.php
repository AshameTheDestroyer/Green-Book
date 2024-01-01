<?php
$serverName = "localhost";
$username = "root";
$password = "";
$databaseName = "book_store";
$connection = new mysqli($serverName, $username, $password, $databaseName);
if ($connection->connect_error) {
    die("Connection has failed: " . $connection->connect_error);
}

$book_id = filter_input(INPUT_POST, "book-id", FILTER_SANITIZE_STRING);
$bought_amount = filter_input(INPUT_POST, "bought-amount", FILTER_SANITIZE_STRING);
$user_id = filter_input(INPUT_POST, "user-id", FILTER_SANITIZE_STRING);

$query = "
        INSERT INTO reserved_books (book_id, user_id, quantity)
        VALUES ('$book_id', '$user_id', '$bought_amount')
    ";
$result = $connection->execute_query($query);

header("location: ..");
?>
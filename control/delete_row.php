<?php
$serverName = "localhost";
$username = "root";
$password = "";
$databaseName = "book_store";
$connection = new mysqli($serverName, $username, $password, $databaseName);
if ($connection->connect_error) {
    die("Connection has failed: " . $connection->connect_error);
}

$id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_STRING);
$table_name = filter_input(INPUT_POST, "table-name", FILTER_SANITIZE_STRING);
$requester_page = filter_input(INPUT_POST, "requester-page", FILTER_SANITIZE_STRING);

$query = "DELETE FROM $table_name WHERE id = $id";
$connection->execute_query($query);

header("location: $requester_page");
?>
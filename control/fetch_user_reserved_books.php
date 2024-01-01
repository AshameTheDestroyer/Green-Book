<?php
$reserved_books = array();
$user_id = $_SESSION["user"]["id"];

$query = "SELECT * FROM reserved_books WHERE user_id = '$user_id'";
$result = $connection->execute_query($query);
$reserved_books = $result->fetch_all(MYSQLI_ASSOC);
?>
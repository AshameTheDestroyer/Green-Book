<?php
$reserved_books = array();

$query = "SELECT * FROM reserved_books";
$result = $connection->execute_query($query);
$reserved_books = $result->fetch_all(MYSQLI_ASSOC);
?>
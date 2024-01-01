<?php
$books = array();

$query = "SELECT * FROM books";
$result = $connection->execute_query($query);
$books = $result->fetch_all(MYSQLI_ASSOC);
?>
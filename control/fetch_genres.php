<?php
$genres = array();

$query = "SELECT * FROM genres";
$result = $connection->execute_query($query);
$genres = $result->fetch_all(MYSQLI_ASSOC);
?>
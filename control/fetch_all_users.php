<?php
$users = array();

$query = "SELECT id, name, surname, email, is_administrator FROM users";
$result = $connection->execute_query($query);
$users = $result->fetch_all(MYSQLI_ASSOC);
?>
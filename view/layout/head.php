<?php
$serverName = "localhost";
$username = "root";
$password = "";
$databaseName = "book_store";
$connection = new mysqli($serverName, $username, $password, $databaseName);
if ($connection->connect_error) {
    die("Connection has failed: " . $connection->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Here where you'll find every book you'll ever dream of!" />
    <meta name="robots" content="index, follow" />

    <link rel="icon" type="image/svg+xml" href="" />
    <link rel="stylesheet" href="styles/style.css">

    <script src="utils/create_portal.js" defer></script>
    <script src="utils/fragment.js" defer></script>

    <title>Book Store</title>
</head>

<body>
    <main id="root">
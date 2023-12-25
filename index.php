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
    <meta name="description" content="" />
    <meta name="robots" content="index, follow" />

    <link rel="icon" type="image/svg+xml" href="" />
    <link rel="stylesheet" href="styles/style.css">

    <title>Book Store</title>
</head>

<body>
    <?php include_once("./view/layout/header.php") ?>

    <main id="root">
        <?php include_once("./view/pages/signing_page/signing_page.php") ?>
    </main>
    <section id="modal-container"></section>

    <?php include_once("./view/layout/footer.php") ?>
</body>

</html>
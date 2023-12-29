<?php
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    return;
}

$title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
$author = filter_input(INPUT_POST, "author", FILTER_SANITIZE_STRING);
$price = filter_input(INPUT_POST, "price", FILTER_SANITIZE_STRING);
$page_count = filter_input(INPUT_POST, "page-count", FILTER_SANITIZE_STRING);
$rating = filter_input(INPUT_POST, "rating", FILTER_SANITIZE_STRING);
$cover = $_FILES["cover"];
$pdf = $_FILES["pdf-file"];

function validate_file_size($file): bool
{
    return $file["size"] < ($max_file_size = 1048576);
}

function write_file($file, $folder_name): string
{
    $file_extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    $file_new_name = uniqid() . "." . $file_extension;
    $file_upload_path = __DIR__ . "/../uploads/" . $folder_name . "/" . $file_new_name;
    if (!move_uploaded_file($file["tmp_name"], $file_upload_path)) {
        return null;
    }

    return $file_new_name;
}

if (!$cover["error"] and !validate_file_size($cover)) {
    $publishingError = "Excessive File Size";
    $publishingErrorMessage = "Cover file size has exceeded one megabyte.";

    return;
}

if (!$cover["error"] and !($cover_url = write_file($cover, "covers"))) {
    $publishingError = "Unable to Write";
    $publishingErrorMessage = "Cover file has failed to be written.";

    return;
}

if (!$pdf["error"] and !validate_file_size($pdf)) {
    $publishingError = "Excessive File Size";
    $publishingErrorMessage = "PDF file size has exceeded one megabyte.";

    return;
}

if (!$pdf["error"] and !($pdf_url = write_file($pdf, "pdfs"))) {
    $publishingError = "Unable to Write";
    $publishingErrorMessage = "PDF file has failed to be written.";

    return;
}

$rating /= 2;

$query = "INSERT INTO books(title, author, price, page_count, rating, cover_url, url)
    VALUES ('$title', '$author', '$price', '$page_count', '$rating', '$cover_url', '$pdf_url')";
$connection->execute_query($query);

header("location: publishing_page.php");
?>
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
$pdf = $_FILES["pdf"];

$genre_inputs = array();
foreach ($genres as $genre) {
    $genre_input = filter_input(INPUT_POST, $genre["title"], FILTER_SANITIZE_STRING);
    if ($genre_input != null) {
        array_push($genre_inputs, $genre);
    }
}

function write_file($file, $folder_name): string
{
    $file_extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    $file_new_name = uniqid() . "." . $file_extension;
    $file_upload_path = str_replace("control", "", __DIR__) . "uploads/" . $folder_name . "/" . $file_new_name;
    if (!move_uploaded_file($file["tmp_name"], $file_upload_path)) {
        return null;
    }

    return $file_new_name;
}

if (!$cover["error"] and $cover["size"] > 1048576) {
    $publishingError = "Excessive File Size";
    $publishingErrorMessage = "Cover file size has exceeded one megabyte.";

    return;
}

if (!$cover["error"] and !($cover_url = write_file($cover, "covers"))) {
    $publishingError = "Unable to Write";
    $publishingErrorMessage = "Cover file has failed to be written.";

    return;
}

if (!$pdf["error"] and $pdf["size"] > 4194304) {
    $publishingError = "Excessive File Size";
    $publishingErrorMessage = "PDF file size has exceeded four megabytes";

    return;
}

if (!$pdf["error"] and !($pdf_url = write_file($pdf, "pdfs"))) {
    $publishingError = "Unable to Write";
    $publishingErrorMessage = "PDF file has failed to be written.";

    return;
}

$rating /= 2;

$query = "
    INSERT INTO books(title, author, price, page_count, rating, cover_url, url)
    VALUES ('$title', '$author', '$price', '$page_count', '$rating', '$cover_url', '$pdf_url')
";
$connection->execute_query($query);

$query = "SELECT * FROM books WHERE id = (SELECT MAX(id) FROM books) LIMIT 1";
$result = $connection->execute_query($query);
$published_book = $result->fetch_all(MYSQLI_ASSOC)[0];

foreach ($genre_inputs as $genre) {
    $book_id = $published_book["id"];
    $genre_id = $genre["id"];

    $query = "
        INSERT INTO books_to_genres(book_id, genre_id)
        VALUES ('$book_id', '$genre_id')
    ";
    $connection->execute_query($query);
}

header("location: publishing_page.php");
?>
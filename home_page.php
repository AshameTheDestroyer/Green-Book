<?php include_once("./view/layout/head.php") ?>
<?php include_once("./view/components/header/header.php") ?>
<?php include_once("./view/components/book_card/book_card.php") ?>
<?php include_once("./view/components/books_section/books_section.php") ?>
<?php include_once("./view/components/slideshow/slideshow.php") ?>
<?php include_once("./view/components/advantage/advantage.php") ?>

<?php
$rating_query = "SELECT * FROM books ORDER BY rating DESC LIMIT 10";
$top_rated_books = $connection->execute_query($rating_query)->fetch_all(MYSQLI_ASSOC);
$top_book_cards = "";
foreach ($top_rated_books as $book) {
    $top_book_cards .= book_card(
        $book['id'],
        $book['price'],
        $book['rating'],
        $book['cover_url'],
        $book['title'],
        $book['author']
    ) . " ";
}

$trending_query = "SELECT * FROM books LIMIT 10";
$trending_books = $connection->execute_query($trending_query)->fetch_all(MYSQLI_ASSOC);
$most_read_books = "";
foreach ($trending_books as $book) {
    $most_read_books .= book_card(
        $book['id'],
        $book['price'],
        $book['rating'],
        $book['cover_url'],
        $book['title'],
        $book['author']
    ) . " ";
}
?>
<link rel="stylesheet" href="./view//pages/home_page/home_page.css">
<link rel="stylesheet" href="./view/components/book_card/book_card.css">
<link rel="stylesheet" href="./view/components/slideshow/slideshow.css">
<link rel="stylesheet" href="./view/components/advantage/advantage.css">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<script src="view/components/books_section/books_section.js"></script>
<main id="home-page">
    <!-- <img src="./assets/images/bookshelf.png" alt="Books on a bookshelf."> -->
    <?php
    echo slideshow();
    echo books_section(
        "top",
        "top rated books",
        $top_book_cards
    );
    echo books_section(
        "trending",
        "most read books",
        $most_read_books
    );
    ?>
    <div class="advantages">
        <?php
        echo advantage("free and fast delivery", "Free delivery for all orders over 140$", "bx bxs-truck");
        echo advantage("24/7 customer service", "Friendly 24/7 customer support", "bx bx-headphone");
        echo advantage("money back guarantee", "We return money within 30 days", "bx bx-check-shield");
        ?>
    </div>
</main>

<?php include_once("./view/components/footer/footer.php") ?>
<?php include_once("./view/layout/foot.php") ?>
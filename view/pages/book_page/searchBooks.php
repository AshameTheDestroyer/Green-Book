<?php
    $q = strval($_GET['q']);
    $serverName = "localhost";
    $username = "root";
    $password = "";
    $databaseName = "green_book";
    $connection = new mysqli($serverName, $username, $password, $databaseName);
    if ($connection->connect_error) {
        die("Connection has failed: " . $connection->connect_error);
    }
    mysqli_select_db($connection,$databaseName);
    $stmt = $connection->prepare("SELECT * FROM books WHERE title LIKE ?");
    $searchTerm = '%' . $q . '%';
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $results = $stmt->get_result();
    $stmt->close();
    $connection->close();
?>
<?php foreach ($results as $result): ?>
    <div class="book-card" tabindex="0">
        <form action="<?= $_SERVER["PHP_SELF"] ?>" method="GET" aria-hidden>
            <input type="hidden" name="book_id" value="<?= $result["id"] ?>" />
            <button type="submit"></button>
        </form>

        <header>
            <p>
                <?= $result["price"] ?>$
            </p>
            <div class="star-displayer" title="This book has a rating of <?= $result["rating"] * 2 ?>/10.">
                <div>
                    <?php for ($i = 5; $i > 0; $i--): ?>
                        <span>
                            <?php include("./assets/icons/star.svg") ?>
                        </span>
                    <?php endfor ?>
                </div>
                <div>
                    <?php for ($i = $result["rating"]; $i > 0; $i--): ?>
                        <span data-is-half="<?= ($i == 0.5) ? "true" : "" ?>">
                            <?php include("./assets/icons/star.svg") ?>
                        </span>
                    <?php endfor ?>
                </div>
            </div>
        </header>

        <figure>
            <img src="<?= $result["cover_url"] ?>" alt="The cover of the book &quot;<?= $result["title"] ?>&quot;.">
        </figure>

        <figcaption>
            <h2>
                <?= $result["title"] ?>
            </h2>
            <p>
                By
                <a href="?author=<?= $result["author"] ?>"
                    title="Click to see other books made by <?= $result["author"] ?>.">
                    <?= $result["author"] ?>
                </a>
            </p>
        </figcaption>
    </div>
<?php endforeach ?>
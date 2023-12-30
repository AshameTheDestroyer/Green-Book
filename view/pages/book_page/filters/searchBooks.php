<?php
    //---prepare the database---
    $serverName = "localhost";
    $username = "root";
    $password = "";
    $databaseName = "green_book";
    $connection = new mysqli($serverName, $username, $password, $databaseName);
    if ($connection->connect_error) {
        die("Connection has failed: " . $connection->connect_error);
    }
    mysqli_select_db($connection,$databaseName);

    // ---define the variables---

    $search = strval($_GET['search']);
    $title = json_decode($_GET['title']);
    $author = json_decode($_GET['author']);
    $min_price = floatval($_GET['min_price']);
    $max_price = floatval($_GET['max_price']);
    $genres = json_decode($_GET['genres']);
    // $genres = array("science","educational","fiction");
    
    //---setting the query statment to apply each filter---
    $genres_query= "SELECT *
                    FROM books_to_genres
                    JOIN genres ON books_to_genres.genre_id = genres.id
                    WHERE books.id = books_to_genres.book_id AND genres.title LIKE ?";
                    
    if((!empty($search) && ($title || $author)) || !empty($min_price) || !empty($max_price) || !empty($genres))
        $sql = "SELECT * FROM books WHERE ";
    else $sql = "";

    
    if(!empty($min_price)){
        $sql .= "price >= ".$min_price;
        if(!empty($max_price))
            $sql .= " AND price <= ".$max_price;
    }
    else{
        if(!empty($max_price))
            $sql .= "price <= ".$max_price;
    }
    if(!empty($search)){
        if($title){
            $sql .= substr($sql, -1) !== " "? " AND " : "";
            $sql .= "(title LIKE ?".($author?" OR author LIKE ?)":")");
        }
        elseif($author){
            $sql .= substr($sql, -1) !== " "? " AND " : "";
            $sql .= "author LIKE ?";
        }
    }

    if(!empty($genres)){
        $sql .= substr($sql, -1) !== " "?" AND " : "";
        $sql .= count($genres) == 1 ? "EXISTS ( " .$genres_query ." )" : "EXISTS ( " .implode(" UNION ",array_fill(0,count($genres),$genres_query)) ." )";
    }

    // echo"<h1>".$sql ."</h1>";
    if(!empty($sql)){
        $stmt = $connection->prepare($sql);
        $searchTerm = '%' . $search . '%';
        if(!empty($search)){
            if($title && $author){
                $stmt->bind_param(str_pad("",count($genres)+2,"s"), $searchTerm, $searchTerm, ...$genres);
            }
            elseif($title || $author){
                $stmt->bind_param(str_pad("",count($genres)+1,"s"), $searchTerm, ...$genres);
            }
        }
        
        $stmt->execute();
        $results = $stmt->get_result();
        $stmt->close();
        $connection->close();
    }
    
?>
<?php if(!empty($results)) foreach ($results as $result): ?>
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
                            <?php include("../../../../assets/icons/star.svg"); ?>
                        </span>
                    <?php endfor ?>
                </div>
                <div>
                    <?php for ($i = $result["rating"]; $i > 0; $i--): ?>
                        <span data-is-half="<?= ($i == 0.5) ? "true" : "" ?>">
                            <?php include("../../../../assets/icons/star.svg") ?>
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
<?php include_once("./view/layout/head.php") ?>
<?php include_once("./view/components/header/header.php") ?>

<?php include_once("./control/validate_administrator.php") ?>

<?php include_once("./control/fetch_all_books.php") ?>

<link rel="stylesheet" href="./view/pages/dashboard_page/dashboard_page.css">

<main id="book-dashboard-page" class="dashboard-page">
    <main id="table-wrapper">
        <?php
        $column_count = count($books[0]);

        $cell_headings = "";
        $book_keys = array_keys($books[0]);
        foreach ($book_keys as $key) {
            $is_first_cell = ($book_keys[0] == $key);
            $is_last_cell = ($book_keys[count($book_keys) - 1] == $key);

            $data_cell = "data-heading-cell";
            $data_cell .= ($is_first_cell) ? " data-first-cell" : "";
            $data_cell .= ($is_last_cell) ? " data-last-cell" : "";

            $heading = ucwords(str_replace("_", " ", $key));
            $cell_headings .= "<span $data_cell>$heading</span>";
        }

        $cells = "";
        $is_even_row = false;
        foreach ($books as $book) {
            $book_values = array_values($book);
            foreach ($book_values as $value) {
                $is_first_cell = ($book_values[0] == $value);
                $is_last_cell = ($book_values[count($book_values) - 1] == $value);

                $data_cell = ($is_even_row) ? "data-even-cell" : "";
                $data_cell .= ($is_first_cell) ? " data-first-cell" : "";
                $data_cell .= ($is_last_cell) ? " data-last-cell" : "";

                $cells .= "<span $data_cell>$value</span>";
            }

            $is_even_row ^= true;
        }

        echo slider(
            $children = "
                    <div id=\"table\" style=\"--column-count: $column_count\">
                        <header>
                            <h1>Books</h1>
                        </header>
                        <main>
                            $cell_headings
                            $cells
                        </main>
                    </div>
                ",
        );
        ?>
    </main>
</main>

<?php include_once("./view/components/footer/footer.php") ?>
<?php include_once("./view/layout/foot.php") ?>
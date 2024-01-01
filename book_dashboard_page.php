<?php include_once("./view/layout/head.php") ?>
<?php include_once("./view/components/header/header.php") ?>

<?php include_once("./control/validate_administrator.php") ?>

<?php include_once("./control/fetch_all_books.php") ?>
<?php include_once("./view/components/slider/slider.php") ?>

<link rel="stylesheet" href="./view/pages/dashboard_page/dashboard_page.css">

<main id="book-dashboard-page" class="dashboard-page">
    <main id="table-wrapper">
        <?php
        $cell_headings = "";
        foreach (array_keys($books[0]) as $key) {
            $heading = ucwords(str_replace("_", " ", $key));
            $cell_headings .= "<th>$heading</th>";
        }
        $cell_headings .= "<th>Altering</th>";

        $rows = "";
        foreach ($books as $book) {
            $rows .= "<tr>";
            foreach (array_values($book) as $value) {
                $rows .= "<td>$value</td>";
            }

            $altering_buttons = implode(
                array_map(fn($element) => "
                    <button 
                        class=\"simple-button icon-button\"
                        data-svg-active-colour=\"$element[1]\"
                        type=\"button\"
                        title=\"$element[0] Row.\"
                    >
                        $element[2]
                    </button>
                ", [
                    ["Read", "information", file_get_contents("./assets/icons/book.svg")],
                    ["Edit", "required", file_get_contents("./assets/icons/pencil.svg")],
                    ["Delete", "error", file_get_contents("./assets/icons/cross.svg")],
                ])
            );

            $rows .= "
                    <td>$altering_buttons</td>
                </tr>
            ";
        }

        echo slider(
            $children = "
                    <table>
                        <caption><h1>Books</h1></caption>
                        <thead><tr>$cell_headings</tr></thead>
                        <tbody>$rows</tbody>
                    </table>
                ",
        );
        ?>
    </main>
</main>

<?php include_once("./view/components/footer/footer.php") ?>
<?php include_once("./view/layout/foot.php") ?>
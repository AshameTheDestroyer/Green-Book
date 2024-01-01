<link rel="stylesheet" href="./view/components/dashboard_table/dashboard_table.css">
<script src="./view/components/dashboard_table/dashboard_table.js" defer></script>

<?php include_once("./view/components/modal/modal.php") ?>
<?php include_once("./view/components/slider/slider.php") ?>

<?php
function dashboard_table(
    string $title,
    string $table_name,
    array $table,
): string {
    $edit_id = filter_input(INPUT_GET, "edit-id", FILTER_SANITIZE_STRING);
    $delete_id = filter_input(INPUT_GET, "delete-id", FILTER_SANITIZE_STRING);

    if (count($table) == 0) {
        return "
            <main class=\"dashboard-message\">
                <h1>No Data Found</h1>
                <p>Apparently the database is empty and no data can be fetched.</p>
           </main>
        ";
    }

    $cell_headings = "";
    foreach (array_keys($table[0]) as $key) {
        $heading = ucwords(str_replace("_", " ", $key));
        $cell_headings .= "<th>$heading</th>";
    }
    $cell_headings .= "<th>Altering</th>";

    $rows = "";
    foreach ($table as $field) {
        $rows .= "<tr>";
        foreach ($field as $value) {
            $data_is_nulled = ($value === null) ? "data-is-nulled" : "";
            $rows .= "<td $data_is_nulled>$value</td>";
        }

        $altering_buttons = implode(
            array_map(fn($element) => "
                <button
                    class=\"simple-button icon-button altering-button\"
                    data-svg-active-colour=\"$element[1]\"
                    type=\"button\"
                    title=\"$element[0]s row.\"
                    data-action-type=\"$element[0]\"
                    data-alter-row-id=\"{$field["id"]}\"
                >
                    <a href=\"{$_SERVER["PHP_SELF"]}?$element[0]-id={$field["id"]}\">$element[2]</a>
                </button>
            ", [
                // ["read", "warning", file_get_contents("./assets/icons/book.svg")],
                ["edit", "information", file_get_contents("./assets/icons/pencil.svg")],
                ["delete", "error", file_get_contents("./assets/icons/cross.svg")],
            ])
        );

        $rows .= "
                <td>$altering_buttons</td>
            </tr>
        ";
    }

    $slider = slider(
        $children = "
                <table>
                    <caption><h1>$title</h1></caption>
                    <thead><tr>$cell_headings</tr></thead>
                    <tbody>$rows</tbody>
                </table>
            ",
    );

    $render = "
        <main class=\"dashboard-table\">$slider</main>
    ";

    if ($delete_id != null) {
        $render .= modal(
            $id = "deletion",
            $title = "Confirm Row Deletion",
            $message = "Are you sure you wanna delete the row with the ID of $delete_id?",
            $children = "
                <form action=\"./control/delete_row.php\" method=\"POST\">
                    <input name=\"id\" type=\"hidden\" value=\"$delete_id\">
                    <input name=\"table-name\" type=\"hidden\" value=\"$table_name\">
                    <input name=\"requester-page\" type=\"hidden\" value=\"{$_SERVER["PHP_SELF"]}\">
                    
                    <button type=\"submit\">Proceed</button>
                </form>
            ",
        );
    }

    return $render;
}
?>
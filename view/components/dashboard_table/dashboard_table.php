<link rel="stylesheet" href="./view/components/dashboard_table/dashboard_table.css">

<?php include_once("./view/components/slider/slider.php") ?>

<?php
function dashboard_table(
    string $title,
    array $table,
): string {
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
        foreach (array_values($field) as $value) {
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

    $slider = slider(
        $children = "
                <table>
                    <caption><h1>$title</h1></caption>
                    <thead><tr>$cell_headings</tr></thead>
                    <tbody>$rows</tbody>
                </table>
            ",
    );

    return "<main class=\"dashboard-table\">$slider</main>";
}
?>
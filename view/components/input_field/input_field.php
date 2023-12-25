<link rel="stylesheet" href="./view/components/input_field/input_field.css">

<?php
function input_field(
    string $name,
    string $id = null,
    string $title = null,
    string $value = null,
    string $type = "text",
    bool $optional = false,
) {
    $title ??= $name;
    $id ??= $name;
    $required = (!$optional) ? "required" : "";
    $dataIsRequired = (!$optional) ? "data-is-required" : "";

    echo "
        <div id=\"{$id}-input-field\" class=\"input-field\" $dataIsRequired>
            <input id=\"{$id}-input\" type=\"$type\" placeholder=\" \" value=\"$value\" $required />
            <label for=\"{$id}-input\">$title</label>
        </div>
    ";
}
?>
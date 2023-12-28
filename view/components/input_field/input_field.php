<link rel="stylesheet" href="./view/components/input_field/input_field.css">
<script src="./view/components/input_field/input_field.js" type="module" defer></script>

<?php
function input_field(
    string $name,
    string $title = null,
    string $type = "text",
    string $value = null,
    string $pattern = null,
    string $patternMessage = null,
    string $id = null,
    bool $optional = false,
) {
    $title ??= $name;
    $id ??= $name;
    $required = (!$optional) ? "required" : "";
    $dataIsRequired = (!$optional) ? "data-is-required" : "";

    echo "
        <div id=\"{$id}-input-field\" class=\"input-field\" $dataIsRequired>
            <input id=\"{$id}-input\" name=\"$name\" type=\"$type\" placeholder=\" \" value=\"$value\" pattern=\"$pattern\" title=\"$patternMessage\" $required />
            <label for=\"{$id}-input\">$title</label>
        </div>
    ";
}
?>
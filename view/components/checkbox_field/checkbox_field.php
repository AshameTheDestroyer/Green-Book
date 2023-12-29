<link rel="stylesheet" href="./view/components/checkbox_field/checkbox_field.css">
<script src="./view/components/checkbox_field/checkbox_field.js" type="module" defer></script>

<?php
function checkbox_field(
    string $name,
    string $title = null,
    bool $checked = false,
    bool $optional = false,
    string $children = null,
    string $id = null,
): string {
    $id ??= $name;
    $title ??= $name;
    $required = (!$optional) ? "required" : "";
    $checked = ($checked) ? "checked" : "";
    $buttonEmphasizedClass = ($checked) ? "emphasized-button" : "";

    return "
        <div id=\"{$id}-checkbox-field\" class=\"checkbox-field\">
            <input id=\"{$id}-checkbox\" type=\"checkbox\" name=\"$name\" $required $checked />
            <button class=\"icon-button simple-button $buttonEmphasizedClass\" type=\"button\">
                $children
            </button>
            <label for=\"{$id}-checkbox\">$title</label>
        </div>
    ";
}
?>
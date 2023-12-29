<link rel="stylesheet" href="./view/components/input_field/input_field.css">
<script src="./view/components/input_field/input_field.js" type="module" defer></script>

<?php
function input_field(
    string $name,
    string $title = null,
    string $type = "text",
    string $value = null,
    string $pattern = null,
    string $pattern_message = null,
    string $id = null,
    bool $optional = false,
    int $minimum = null,
    int $maximum = null,
    float $step = null,
    string $accept = null,
): string {
    $title ??= $name;
    $id ??= $name;
    $required = (!$optional) ? "required" : "";
    $dataIsRequired = (!$optional) ? "data-is-required" : "";
    $dataIsFileInput = ($type == "file") ? "data-is-file-input" : "";
    $pattern = ($pattern != null) ? "pattern=\"$pattern\"" : "";

    $label = ($type != "file") ? "
            <label for=\"{$id}-input\">$title</label>
        " : "
            <button class=\"label-container-button\" type=\"button\">
                <label for=\"{$id}-input\">$title</label>
            </button>
        ";

    return "
        <div id=\"{$id}-input-field\" class=\"input-field\" $dataIsRequired $dataIsFileInput>
            <input 
                id=\"{$id}-input\" 
                name=\"$name\"
                type=\"$type\"
                placeholder=\" \"
                value=\"$value\"
                $pattern
                title=\"$pattern_message\"
                $required
                min=\"$minimum\"
                max=\"$maximum\"
                step=\"$step\"
                accept=\"$accept\"
            />
            $label
        </div>
    ";
}
?>
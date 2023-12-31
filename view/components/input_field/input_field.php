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
    int $minimum_length = null,
    int $maximum_length = null,
): string {
    $title ??= $name;
    $id ??= $name;
    $required = (!$optional) ? "required" : "";
    $dataIsRequired = (!$optional) ? "data-is-required" : "";
    $dataIsFileInput = ($type == "file") ? "data-is-file-input" : "";
    $value = ($value != null) ? "value=\"$value\"" : "";
    $pattern = ($pattern != null) ? "pattern=\"$pattern\"" : "";
    $pattern_message = ($pattern_message != null) ? "title=\"$pattern_message\"" : "";
    $minimum = ($minimum != null) ? "min=\"$minimum\"" : "";
    $maximum = ($maximum != null) ? "max=\"$maximum\"" : "";
    $step = ($step != null) ? "step=\"$step\"" : "";
    $accept = ($accept != null) ? "accept=\"$accept\"" : "";
    $minimum_length = ($minimum_length != null) ? "minlength=\"$minimum_length\"" : "";
    $maximum_length = ($maximum_length != null) ? "maxlength=\"$maximum_length\"" : "";

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
                $value
                $pattern
                $pattern_message
                $required
                $minimum
                $maximum
                $step
                $accept
                $minimum_length
                $maximum_length
            />
            $label
        </div>
    ";
}
?>
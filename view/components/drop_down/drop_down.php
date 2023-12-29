<link rel="stylesheet" href="./view/components/drop_down/drop_down.css">
<script src="./view/components/drop_down/drop_down.js" type="module" defer></script>

<?php
function drop_down(
    string $children,
    string $drop_down_children,
    string $id = null,
): string {
    return "
        <div id=\"{$id}-drop-down\" class=\"drop-down\" data-is-open=\"false\">
            <button type=\"button\">$children</button>
            <div class=\"drop-down-wrapper\">
                <div class=\"drop-down-container\">$drop_down_children</div>
            </div>
        </div>
    ";
}
?>
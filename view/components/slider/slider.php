<link rel="stylesheet" href="./view/components/slider/slider.css">

<?php
function slider(
    string $children,
    bool $isVerticalNotHorizontal = false,
    bool $isUnorderedList = false,
    string $id = "",
): string {
    $data_direction = ($isVerticalNotHorizontal) ? "vertical" : "horizontal";
    $tag = (!$isUnorderedList) ? "div" : "ul";

    return "
        <$tag id=\"$id\" class=\"slider\" data-direction=\"$data_direction\">
            $children
        </$tag>
    ";
}
?>
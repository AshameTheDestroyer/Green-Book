<link rel="stylesheet" href="view/components/books_section/books_section.css">
<?php 
function books_section(
    $section_title,
    $section_subtitle,
    $content
):string{

    return "
        <section class=\"books-section\">
            <div class=\"section-header\">
                <div class=\"section-title\">
                    <div></div>
                    <h4>{$section_title}</h4>
                </div>
                <div>
                    <a href=\"book_page.php\">View All</a>
                </div>
                <h2 class=\"section-subtitle\">{$section_subtitle}</h2>
                <div class=\"scroll-buttons-container\">
                    <button onclick=\"scrollContent('left','$section_title-section-content')\">&larr;</button>
                    <button onclick=\"scrollContent('right','$section_title-section-content')\">&rarr;</button>
                </div>
            </div>
            <div class=\"section-content\" id=\"$section_title-section-content\">
                {$content}
            </div>
        </section>
    ";
}

?>


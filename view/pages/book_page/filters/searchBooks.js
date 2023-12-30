// save the main content to restore when the search is cansled
var mainContent;
onload = ()=> {mainContent = document.getElementById("book-displayer").innerHTML;}
// define the filters elements
var search_books = document.getElementById('search-books');
var reset_search = document.getElementById('reset-search');
var submit_search = document.getElementById('submit-search');

var min_price =document.getElementById('min-price-input');
var max_price =document.getElementById('max-price-input');

var title = document.getElementById('title-checkbox');
var author = document.getElementById('author-checkbox');

var genres = document.querySelectorAll('#genres-drop-down input[type="checkbox"]');
var genre_names = [];
genres.forEach(genre => {
    if(genre.checked) genre_names.push(genre.name);
    genre.onchange = () => searchBooks(search_books.value);
});
// setting when to apply the filters
reset_search.onclick = () => {
    search_books.value = "";
    searchBooks(search_books.value);
} 
submit_search.onclick = () => searchBooks(search_books.value);
title.onchange = () => searchBooks(search_books.value);
author.onchange = () => searchBooks(search_books.value);
min_price.onchange = () => searchBooks(search_books.value);
max_price.onchange = () => searchBooks(search_books.value);
// define the filters function
function searchBooks(str) {
    // console.log(genres);
    if (str == "" && (min_price.value == 0 && max_price.value == 0)){
        document.getElementById("book-displayer").innerHTML = mainContent;
    }
    else{
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = () => {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("book-displayer").innerHTML = xmlhttp.responseText? xmlhttp.responseText:'<h3 style="color:#00e25e">No result</h3>';
            }
        };
        xmlhttp.open("GET", 
        `view/pages/book_page/filters/searchBooks.php?
        search=${str}&
        title=${JSON.stringify(title.checked)}&
        author=${JSON.stringify(author.checked)}&
        min_price=${min_price.value}&
        max_price=${max_price.value}&
        genres=${JSON.stringify(genre_names)}`,
        true);
        xmlhttp.send();
    }
}
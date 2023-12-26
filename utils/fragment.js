const fragments = [...document.querySelectorAll(".fragment")];
fragments.forEach(fragment => {
    const children = [...fragment.children];
    children.forEach(child => fragment.parentElement.insertBefore(child, fragment));
    fragment.remove();  
});
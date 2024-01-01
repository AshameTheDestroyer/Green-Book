const scrollContent = (dir,section_id)=>{
    var sectionContent = document.getElementById(section_id);
    const offset = window.innerWidth / 1.5;
    sectionContent.scrollLeft += (dir==="right" ? offset : -offset);
}
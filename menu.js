function openMenu() {
    document.querySelector(".dropdown").classList.add("menu-open");
    document.querySelector(".fa-xmark").style.display = "inline";
    document.querySelector(".fa-bars").style.display = "none";
}

function closeMenu() {
    document.querySelector(".dropdown").classList.remove("menu-open");
    document.querySelector(".fa-bars").style.display = "inline";
    document.querySelector(".fa-xmark").style.display = "none";
}
function dropdown() {
    document.getElementById("myDropdown").classList.toggle("show");
    document.getElementById("studentBtn").classList.toggle("show");
    console.log("dropdown()");
}

window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var button = document.getElementById("studentBtn");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
            button.classList.remove('show');
        }
        }
    }
}
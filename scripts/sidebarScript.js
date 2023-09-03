document.addEventListener("DOMContentLoaded", function() {
    const menuIcon = document.getElementById("menuIcon");
    const sideBar = document.getElementById("sidebar")
    menuIcon.addEventListener("click",function() {
            if(sideBar.style.width === "0px") {
                sideBar.style.width = "140px";
                
            } 
            else {
                sideBar.style.width = "0px";
            }
    })
});
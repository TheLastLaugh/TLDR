document.addEventListener("DOMContentLoaded", function() {
    const menuIcon = document.getElementById("menuIcon");
    const content = document.getElementById("content");
    const sideBar = document.querySelector("#sidebar")

    menuIcon.addEventListener("click",function() {
            if(sideBar.style.width === "0px") {
                sideBar.style.width = "140px";
                content.style.marginLeft = "140px";
            } 
            else {
                sideBar.style.width = "0px";
                content.style.marginLeft = "0px";
            }
    })
    document.getElementById("title").innerText = document.title;

});
document.addEventListener("DOMContentLoaded", function() {
    const menuIcon = document.getElementById("menuIcon");
    const content = document.getElementById("content");
    const sideBar = document.querySelector("#sidebar");

    sideBar.style.width = "140px";
    content.style.marginLeft = "140px";

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

});

function setMenuSelected()
{
    const menu = document.querySelectorAll("#sidebar ul li");
    const title = document.getElementsByTagName("title")[0].innerText;
    
    for (let opt of menu) {
        if (title === opt.innerText) {
            opt.classList.add("selected");
            break;
        }
    }
}

setMenuSelected();
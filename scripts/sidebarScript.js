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

function setMenuSelected()
{
    const menu = document.querySelectorAll("#sidebar ul li");
    const title = document.getElementsByTagName("title")[0].innerText;
    console.log(title)
    
    for (let opt of menu) {
        console.log(opt)
        if (title === opt.innerText) {
            opt.classList.add("selected");
            break;
        }
    }
}

setMenuSelected();
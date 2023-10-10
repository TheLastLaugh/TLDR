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
    //GET PAGE NAME AND READJUST IT TO APPROPRIATE GRAMMAR
    let page = window.location.pathname.split('/').slice(-1)[0].split('.')[0].split('-');
    if(document.title != 'CBT&A'){
        for(let i = 0; i < page.length; i++){
            page[i] = page[i][0].toUpperCase()+ page[i].substring(1);
        }
        page = page.join(' ')
    }else page = "CBT&A";
    
    document.getElementById("title").innerText = page;
}

setMenuSelected();
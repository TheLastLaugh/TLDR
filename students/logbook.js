function openTab(evt, tabName) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}

document.getElementById("detailed-button").click();

const url = new URL(window.location.href);
const searchParams = url.searchParams;

if (searchParams.has('view')) {

    const view = searchParams.get('view'); 

    if (view == 'pending') {
        console.log('pending button clicked from query string');
        document.getElementById("pending-button").click();
    } else if (view == 'day') {
        console.log('day button clicked from query string');
        document.getElementById("day-button").click();
    } else if (view == 'night') {
        console.log('night button clicked from query string');
        document.getElementById("night-button").click();
    } else if (view == 'detailed') {
        console.log('detailed button clicked from query string');
        document.getElementById("detailed-button").click();
    } 

}


function signTask (id) {

    id = encodeURIComponent(id);
    console.log(`ID: ${id}`);

    var params= `logbook_id=${id}`;

    var xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && (this.status == 200 || this.status == 302)) {
            console.log(xhttp.responseText);
            window.location.href = "./logbook.php?view=pending";
        } 
    };

    xhttp.open("POST", "../logbooks/process-logbook-confirmation.php", true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send(params);

}
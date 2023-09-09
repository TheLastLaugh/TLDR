if (document.getElementById("existing")) {
    document.getElementById("existing").addEventListener('click', function(event) {
        deleteAllRowsInTable();
        console.log("existing");
        document.getElementById("search-dl").style.display = "none";
        document.getElementById("search-name").style.display = "none";
        searchExisting();
    });
    deleteAllRowsInTable();
    searchExisting();
} else {
    document.getElementById("search-name").style.display = "block";
}

if (document.getElementById("student")) {
    document.getElementById("student").addEventListener('click', function(event) {
        document.getElementById("usertype1").value = "student";
        document.getElementById("usertype2").value = "student";
    });
}

if (document.getElementById("instructor")) {
    document.getElementById("instructor").addEventListener('click', function(event) {
        document.getElementById("usertype1").value = "instructor";
        document.getElementById("usertype2").value = "instructor";
    });
}

document.getElementById("name-dob").addEventListener('click', function(event) {
    deleteAllRowsInTable();
    searchStudentPlaceholder();
    console.log("name-dob");
    document.getElementById("search-dl").style.display = "none";
    document.getElementById("search-name").style.display = "block";
});

document.getElementById("dl").addEventListener('click', function(event) {
    deleteAllRowsInTable();
    searchStudentPlaceholder();
    console.log("dl");
    document.getElementById("search-name").style.display = "none";
    document.getElementById("search-dl").style.display = "block";
});

document.getElementById('search-name').addEventListener('submit', function(event) {

    event.preventDefault();
    console.log(event);
    const fname = event.target[0].value;
    var params;

    if (event.target[1].id == 'usertype1') {
        const userType = event.target[1].value;
        params = `type=${userType}&search=name&fname=${fname}`;
    } else {
        params = `search=name&fname=${fname}`;
    }

    var xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(xhttp.responseText);
            const result = JSON.parse(xhttp.responseText);
            addStudentsToTable(result);
        }
    };

    xhttp.open("POST", "./locateusers.php", true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send(params);
    

});

document.getElementById('search-name').addEventListener('reset', function(event) {

    event.preventDefault();
    deleteAllRowsInTable();
    document.getElementById("fname").value = "";

    var table = document.getElementById("studentsTable");
    var row = table.insertRow();
    var cell = row.insertCell(0)
    cell.innerHTML = "Please search a student above";
    cell.colSpan = "5";
    
});

document.getElementById('search-dl').addEventListener('submit', function(event) {

    event.preventDefault();
    console.log(event);
    const license = event.target[0].value;
    var params;

    if (event.target[1].id == 'usertype2') {
        const userType = event.target[1].value;
        params = `type=${userType}&search=dl&license=${license}`;
    } else {
        params = `search=dl&license=${license}`;
    }

    var xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(xhttp.responseText);
            const result = JSON.parse(xhttp.responseText);
            addStudentsToTable(result);
        }
    };

    xhttp.open("POST", "./locateusers.php", true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send(params);

});

document.getElementById('search-dl').addEventListener('reset', function(event) {

    event.preventDefault();
    deleteAllRowsInTable();
    document.getElementById("dlnumber").value = "";

    var table = document.getElementById("studentsTable");
    var row = table.insertRow();
    var cell = row.insertCell(0)
    cell.innerHTML = "Please search a student above";
    cell.colSpan = "5";

});

function addStudentsToTable (searchResults) {

    deleteAllRowsInTable();
    var table = document.getElementById("studentsTable");

    if (searchResults.length >= 1) {
        for (let i = 0; i < searchResults.length; i++) {
            console.log(searchResults[i]);
            var row = table.insertRow();
            row.insertCell(0).innerHTML = `<button onclick="selectUser('${searchResults[i].user_type}', '${searchResults[i].id}')">${searchResults[i].username}</button>`;
            row.insertCell(1).innerHTML = searchResults[i].license;
            row.insertCell(2).innerHTML = searchResults[i].dob;
            row.insertCell(3).innerHTML = searchResults[i].address;
            row.insertCell(4).innerHTML = "";
        }
    } else {
        var row = table.insertRow();
        var cell = row.insertCell(0)
        cell.innerHTML = "No results found";
        cell.colSpan = "5";
    }

}

function deleteAllRowsInTable () {

    var table = document.getElementById("studentsTable");
    console.log(table.rows.length);

    for (let i = 1; i < table.rows.length; i++) {
        table.deleteRow(i);
    }

}

function searchStudentPlaceholder () {

    var table = document.getElementById("studentsTable");
    var row = table.insertRow();
    var cell = row.insertCell(0)
    cell.innerHTML = "Please search a student above";
    cell.colSpan = "5";

}

function searchExisting () {

    const params = `search=existing`;

    var xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(xhttp.responseText);
            const result = JSON.parse(xhttp.responseText);
            addStudentsToTable(result);
        }
    };

    xhttp.open("POST", "./locateusers.php", true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send(params);

}

function selectUser (usertype, username) {

    const params = `usertype=${usertype}&username=${username}`;

    var xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(xhttp.responseText);
            console.log("user selected");
            window.location.href = "../dashboard/welcome.php";
        }
    };

    xhttp.open("POST", "./selectuser.php", true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send(params);

}
// document.getElementById("issue-date").addEventListener('change', function (event) {

//     console.log(event);

//     if (event.target.value != "") {
//         document.getElementById("due-date").min = event.target.value;
//         document.getElementById("due-date-row").style.display = "block";
//     } else {
//         document.getElementById("due-date").value = "";
//         document.getElementById("due-date").min = "";
//         document.getElementById("due-date-row").style.display = "none";
//     }

// });

document.getElementById("system").addEventListener('change', function (event) {

    document.getElementById("amount").value = "";
    console.log(event);

    document.getElementById("amount-row").style.display = "block";
    document.getElementById("hourly-rate-row").style.display = "block";
    document.getElementById("hourly-rate").value = document.getElementById("system").value;
    document.getElementById("hourly-rate").readOnly = true;


    if (event.target.value != "") {
        calculateTotal(document.getElementById("duration").value, document.getElementById("system").value);
    } 

});

document.getElementById("manual").addEventListener('change', function (event) {

    // document.getElementById("amount").value = "";
    console.log(event);

    document.getElementById("amount-row").style.display = "none";
    document.getElementById("amount").value = "";
    document.getElementById("hourly-rate-row").style.display = "block";
    document.getElementById("hourly-rate").value = "";
    document.getElementById("hourly-rate").readOnly = false;

    calculateTotal(document.getElementById("duration").value, document.getElementById("hourly-rate").value);


});

document.getElementById("duration").addEventListener('change', function (event) {

    console.log(event);



    if (event.target.value != "") {
        document.getElementById("hourly_rate_option_row").style.display = "block";
        calculateTotal(event.target.value, document.getElementById("hourly-rate").value);
    } else {
        document.getElementById("hourly_rate_option_row").style.display = "none";
        document.getElementById("system").checked = false;
        document.getElementById("manual").checked = false;

        document.getElementById("hourly-rate-row").style.display = "none";
        document.getElementById("hourly-rate").value = "";

        document.getElementById("amount-row").style.display = "none";
        document.getElementById("amount").value = "";

        // calculateTotal("", "");
    }

});

document.getElementById("hourly-rate").addEventListener('change', function (event) {

    // document.getElementById("amount").value = "";

    console.log(event);
    console.log(event.target.value);
 
    if (event.target.value != "") {
        document.getElementById("amount-row").style.display = "block";
        calculateTotal(document.getElementById("duration").value, event.target.value);
    } else {
        document.getElementById("amount").value = "";
        document.getElementById("amount-row").style.display = "none";
    }


});

document.getElementById("bill-entry").addEventListener("submit", function (event) {

    event.preventDefault();
    console.log(event);

    const due_date = encodeURIComponent(event.target[1].value);
    console.log(`Due Date: ${due_date}`);
    const duration = encodeURIComponent(event.target[2].value);
    console.log(`Duration: ${duration}`);
    var hourly_rate_option = "";
    if (document.getElementById("manual").checked == true) {
        hourly_rate_option = "manual";
    } else {
        hourly_rate_option = "system";
    }
    console.log(`Hourly Rate Option: ${hourly_rate_option}`);

    const hourly_rate = encodeURIComponent(event.target[5].value);
    console.log(`Hourly Rate: ${hourly_rate}`);

    var params = "";

    if (hourly_rate_option == "manual") {
        var params= `due_date=${due_date}&duration=${duration}&hourly_rate_option=${hourly_rate_option}&hourly_rate=${hourly_rate}`;
    } else {
        var params= `due_date=${due_date}&duration=${duration}&hourly_rate_option=${hourly_rate_option}`;
    }

    var xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(xhttp.responseText);
            // successAlert("Logbook entry created.");
            // document.getElementById("logbook-entry").reset();
            // document.getElementById("end_time_row").style.display = "none";
            successAlert("Bill issued to student.");
            document.getElementById("bill-entry").reset();
        } else {
            console.log(xhttp.responseText);
        }
    };

    xhttp.open("POST", "./process-bill.php", true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send(params);


});

function calculateTotal(duration, hourly_rate) {

    if (duration != "" && hourly_rate != "") {
        const total = ( Number( duration / 60 ) * Number(hourly_rate) );
        document.getElementById("amount").value = total.toFixed(2);
    } else {
        document.getElementById("amount").value = "";
    }

}

document.getElementById("bill-entry").addEventListener("reset", function (event) {

    document.getElementById("amount-row").style.display = "none";
    document.getElementById("amount").value = "";

    document.getElementById("hourly-rate-row").style.display = "none";
    document.getElementById("hourly-rate").value = "";
    document.getElementById("hourly-rate").readOnly = false;

    document.getElementById("hourly_rate_option_row").style.display = "none";
    document.getElementById("system").checked = false;
    document.getElementById("manual").checked = false;

});

function successAlert(message) {

    document.getElementById(`taskAlert`).innerHTML = `<div class="alert success">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        <strong>Success!</strong> ${message}
        </div>`;
    document.getElementById(`taskAlert`).style.display = "block";


}
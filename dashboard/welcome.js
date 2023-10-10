var geocoder;
var map;

function myMap() {
    var mapProp = {
        center: new google.maps.LatLng(-34.921230, 138.599503),
        zoom: 5,
    };
    map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
    geocoder = new google.maps.Geocoder();
    getDrives();
}

function codeAddress(drive) {

    const suburb_start = drive['start_location'];
    const suburb_end = drive['end_location'];
    var address1 = `${suburb_start}, SA`;
    var coordinates1;
    var address2 = `${suburb_end}, SA`;
    var coordinates2;

    geocoder.geocode({ 'address': address1 }, function (results, status) {
        if (status == 'OK') {
            console.log(results[0]);
            const lat = results[0].geometry.location.lat();
            const lng = results[0].geometry.location.lng();
            coordinates1 = { 
                lat: lat,
                lng: lng
            }

            geocoder.geocode({ 'address': address2 }, function (results, status) {
                if (status == 'OK') {
                    console.log(results[0]);
                    const lat = results[0].geometry.location.lat();
                    const lng = results[0].geometry.location.lng();
                    coordinates2 = { 
                        lat: lat,
                        lng: lng
                    }
                    console.log(coordinates1)
                    console.log(coordinates2);
                    drawLine(coordinates1, coordinates2);
                    createMarkers(coordinates1, coordinates2, drive);
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });

        } else {
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });

}

function drawLine(coordinates1, coordinates2) {

    var flightPlanCoordinates = [];
    flightPlanCoordinates.push(coordinates1);
    flightPlanCoordinates.push(coordinates2);
    console.log(JSON.stringify(flightPlanCoordinates));

    const flightPath = new google.maps.Polyline({
        path: flightPlanCoordinates,
        geodesic: true,
        strokeColor: "#000000",
        strokeOpacity: 1.0,
        strokeWeight: 2,
    });
    
    flightPath.setMap(map);

}

function createMarkers(coordinates1, coordinates2, drive) {

    var markers = [];
    const marker1 = {
        position: coordinates1,
        title: drive['start_location']
    }
    const marker2 = {
        position: coordinates2,
        title: drive['end_location']
    }
    markers.push(marker1);
    markers.push(marker2);
    console.log(JSON.stringify(markers));

    // Create an info window to share between markers.
    const infoWindow = new google.maps.InfoWindow();

    // Create the markers.
    markers.forEach(({ position, title }, i) => {

        var dateFormatted = new Date(drive['date']);
        var day = dateFormatted.getDate().toString().padStart(2,"0");
        var month = (dateFormatted.getMonth() + 1).toString().padStart(2,"0");
        var year = dateFormatted.getFullYear().toString().padStart(4,"0");
        dateFormatted = `${day}/${month}/${year}`;
        console.log(dateFormatted);

        const contentString =
        `<div id="content">
            <div id="siteNotice"></div>
            <h1 id="firstHeading" class="firstHeading">${drive['start_location']} to ${drive['end_location']}</h1>
            <div id="bodyContent">
                <p>
                    <b>Date: </b>${dateFormatted}<br>
                    <b>Duration: </b>${drive['duration']} minutes<br>
                    <b>Road Conditions: </b>${drive['road_type']}<br>
                    <b>Weather Conditions: </b>${drive['weather']}<br>
                    <b>Traffic: </b>${drive['traffic']}<br>
                </p>
            </div>
        </div>`;

        const infowindow = new google.maps.InfoWindow({
            content: contentString,
            ariaLabel: `notsurewhatthisisfor`,
        });

        const marker = new google.maps.Marker({
            position: position,
            map,
            title: title,
        });

        marker.addListener("click", () => {
            infowindow.open({
                anchor: marker,
                map,
            });
        });

    });

}

function getDrives () {

    const params = `action=getdrives`;

    var xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {
            console.log(xhttp.responseText);
            const drives = JSON.parse(xhttp.responseText);

            for (let i = 0; i < drives.length; i++) {
                codeAddress(drives[i]);
            }

        }

    };

    xhttp.open("POST", "./drives.php", true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send(params);

}

function dropdown() {
    document.getElementById("myDropdown").classList.toggle("show");
    document.getElementById("studentBtn").classList.toggle("show");
    console.log("dropdown()");
}

window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
        }
        }
    }
}
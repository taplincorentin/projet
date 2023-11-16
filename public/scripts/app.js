document.addEventListener('DOMContentLoaded', function () {
    
    //initialize map variable
    var map = L.map('map_add_balade').setView([51.505, -0.09], 13);

    //get opensteetmap tile and add attribution
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    //initialize marker variable
    var marker = L.marker([51.5, -0.09]).addTo(map);

    //when click get get lat and long values
    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        // Update input fields with latitude and longitude
        document.getElementById('balade_form_pointLatitude').value = e.latlng.lat;
        document.getElementById('balade_form_pointLongitude').value = e.latlng.lng;   
    });
});

document.addEventListener('DOMContentLoaded', function () {
    
    //initialize map variable
    var map = L.map('map_add_seance').setView([51.505, -0.09], 13);

    //get opensteetmap tile and add attribution
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    //initialize marker variable
    var marker = L.marker([51.5, -0.09]).addTo(map);

    //when click get get lat and long values
    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        // Update input fields with latitude and longitude
        document.getElementById('seance_form_pointLatitude').value = e.latlng.lat;
        document.getElementById('seance_form_pointLongitude').value = e.latlng.lng;   
    });
});



document.addEventListener('DOMContentLoaded', function () {

    //
        var mapDiv = document.getElementById('map_show');
        var latitude = parseFloat(mapDiv.dataset.latitude);
        var longitude = parseFloat(mapDiv.dataset.longitude);


        var map = L.map('map_show').setView([ latitude , longitude ], 12);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker([ latitude , longitude ]).addTo(map);
            
});






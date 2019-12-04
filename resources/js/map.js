// Leaflet map

//Get longtitutude, latitude and address from view
let lng = parseFloat(document.getElementById("lng").value);
let lat = parseFloat(document.getElementById("lat").value);
let address = document.getElementById("show-address").innerHTML;

let map = L.map("map").setView([lng, lat], 14);

L.tileLayer(
    "https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}",
    {
        attribution:
            'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: "mapbox.streets",
        accessToken:
            "pk.eyJ1IjoicnVoYW0iLCJhIjoiY2syNGNvM29oMTkybDNnbnlha3pxMmpodiJ9.HO4uZlRVSSO8AnMMw8brqg"
    }
).addTo(map);

//Add marker with popup to map
L.marker([lng, lat])
    .addTo(map)
    .bindPopup(address)
    .openPopup();

//Add circle to map
L.circle([lng, lat], {
    color: "blue",
    fillColor: "#003",
    fillOpacity: 0.2,
    radius: 100
}).addTo(map);

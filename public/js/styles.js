const getLocation = async () => {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((position) => {
            var latit = position.coords.latitude;
            var longit = position.coords.longitude;
            // this is just a marker placed in that position
            L.marker([latit, longit]).addTo(map);
            // move the map to have the location in its center
            map.panTo(new L.LatLng(latit, longit));
        });
    } else {
        alert("Geolocation is not supported by this browser.");
    }
};

// function setAstar(destiny) {}

// const initialMaps = async (destiny = []) => {
// };
var initialStateStart = [5.16781, 97.130688];
var initialStateGoal = [5.172116, 97.129916];

// var resCurrentLocation = await getLocation();
// initialStateGoal =
//     resCurrentLocation != undefined && resCurrentLocation.length > 0
//         ? resCurrentLocation
//         : initialStateGoal;

// if (destiny.length > 0) {
//     var initialStateStart = destiny;
// }

// console.log("initialStateStart", initialStateStart);
// console.log("initialStateStart", initialStateGoal);

let map = L.map("map").setView(initialStateStart, 13);
let latLng1 = L.latLng(initialStateGoal[0], initialStateGoal[1]);
let latLng2 = L.latLng(initialStateStart[0], initialStateStart[1]);
let wp1 = new L.Routing.Waypoint(latLng1, "bebas");
let wp2 = new L.Routing.Waypoint(latLng2, "bebas");

map.on("click", function (e) {
    document.getElementById("latitude").value = e.latlng.lat;
    document.getElementById("longitude").value = e.latlng.lng;
    initialStateStart = [e.latlng.lat, e.latlng.lng];

    console.log("change", initialStateStart);
});

L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution:
        '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
}).addTo(map);

L.Routing.control({
    createMarker: function (i, wp, nWps) {
        return L.marker(wp.latLng).bindPopup("I'm waypoint " + i);
    },
    waypoints: [latLng1, latLng2],
}).addTo(map);

let routeUs = L.Routing.osrmv1();
routeUs.route([wp1, wp2], (err, routes) => {
    if (!err) {
        let best = 100000000000000;
        let bestRoute = 0;
        for (i in routes) {
            if (routes[i].summary.totalDistance < best) {
                bestRoute = i;
                best = routes[i].summary.totalDistance;
            }
        }
        console.log("best route", routes[bestRoute]);
        L.Routing.line(routes[bestRoute], {
            styles: [
                {
                    color: "green",
                    weight: "10",
                },
            ],
        }).addTo(map);
    }
});

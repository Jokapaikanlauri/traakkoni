<html>
<head>
    <title>Multi-Waypoint Route Planner</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCq-kOTVIXT9u1_YXEsDbEBCIW3FQwYPZ4&libraries=places"></script>
    <style>
        #map {
            height: 90%;
            width: 100%;
        }
        #controls {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        #info {
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Multi-Waypoint Route Planner</h1>
    <div id="controls">
        <button id="button" onclick="calculateRoute()">Calculate Route</button>
        <button id="button" onclick="saveRoute()">Save Route</button>
    </div>
    <div id="elevation"></div>
    <div id="map"></div>
    <script>
        let map;
        let directionsService;
        let directionsRenderer;
        let waypoints = [];
        let h=0;
        let end;
        let start;

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -34.397, lng: 150.644},
                zoom: 8
            });
            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer();
            directionsRenderer.setMap(map);

            map.addListener('click', function(event) {
                addWaypoint(event.latLng);
            });
        }

        function addWaypoint(location) {
            if (h == 0) {
                start = location;
            }
            end = location;
            const marker = new google.maps.Marker({
                position: location,
                map: map
            });
            waypoints.push({
                location: location,
                stopover: true
            });
            h++;
        }
        function calculateRoute() {
            const request = {
                origin: start,
                destination: end,
                waypoints: waypoints,
                optimizeWaypoints: true,
                travelMode: 'WALKING'
            };

            directionsService.route(request, function(result, status) {
                if (status === 'OK') {
                    directionsRenderer.setDirections(result);
                    displayRouteInfo(result);
                } else {
                    alert('Could not calculate route: ' + status);
                }
            });
        }

         function displayRouteInfo(result) {
            const route = result.routes[0];
            let totalDistance = 0;
            let elevationService = new google.maps.ElevationService();
            let elevationGain = 0;

            route.legs.forEach(leg => {
                totalDistance += leg.distance.value;
                let path = leg.steps.map(step => {
                    return step.start_location;
                });
                path.push(leg.end_location);
                elevationService.getElevationAlongPath({
                    path: path,
                    samples: 256
                }, function(elevations, status) {
                    if (status === 'OK') {
                        let prevElevation = elevations[0].elevation;
                        elevations.forEach(elevation => {
                            if (elevation.elevation > prevElevation) {
                                elevationGain += (elevation.elevation - prevElevation);
                            }
                            prevElevation = elevation.elevation;
                        });

                        document.getElementById('elevation').innerText = 'Total Elevation Gain: ' + elevationGain.toFixed(2) + ' meters';
                    }
                });
            });
            document.getElementById('distance').innerText = 'Total Distance: ' + (totalDistance / 1000).toFixed(2) + ' km';
        }
         function saveRoute() {
            const waypointData = waypoints.map(point => ({
                lat: point.location.lat(),
                lng: point.location.lng()
            }));

            const routeData = {
                start: start,
                end: end,
                waypoints: waypointData
            };

            fetch('/save-route', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(routeData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Route saved successfully!');
                } else {
                    alert('Failed to save route.');
                }
            });
        }

        window.onload = initMap;
    </script>
</body>
</html>

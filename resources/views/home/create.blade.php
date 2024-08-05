<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div id="controls">
                        <input type="text" id="routeName" placeholder="Name your route" />
                        <button id="button" onclick="calculateRoute()">Calculate Route</button>
                        <button id="button" onclick="saveRoute()">Save Route</button>
                    </div>
                    <div id="elevation"></div>
                    <div id="distance"></div>
                    <div id="map" style="height: 500px;"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCq-kOTVIXT9u1_YXEsDbEBCIW3FQwYPZ4&libraries=places"></script>
    <script>
        let map;
        let directionsService;
        let directionsRenderer;
        let waypoints = [];
        let h = 0;
        let end;
        let start;
        let totalDistance = 0;
        let elevationGain = 0;

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: 60.192059, lng: 24.945831 },
                zoom: 11
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
            if (!start || !end) {
                alert('Please select start and end points for the route.');
                return;
            }

            const request = {
                origin: start,
                destination: end,
                waypoints: waypoints.slice(0, -1),
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

            let elevationService = new google.maps.ElevationService();

            route.legs.forEach(leg => {
                totalDistance += leg.distance.value;
                let path = leg.steps.map(step => step.start_location);
                path.push(leg.end_location);

                elevationService.getElevationAlongPath({
                    path: path,
                    samples: 256
                }, function(elevations, status) {
                    if (status === 'OK') {
                        let prevElevation = elevations[0].elevation;
                        elevations.forEach(elevation => {
                            if (elevation.elevation > prevElevation) {
                                if (prevElevation > -450) {
                                    elevationGain += (elevation.elevation - prevElevation);
                                }
                            }
                            prevElevation = elevation.elevation;
                        });

                        document.getElementById('elevation').innerText = 'Total Elevation Gain: ' +
                            elevationGain.toFixed(0) + ' meters';
                    }
                });
            });
            document.getElementById('distance').innerText = 'Total Distance: ' + (totalDistance / 1000).toFixed(2) + ' km';
        }

        function saveRoute() {
            const routeName = document.getElementById('routeName').value;
            if (!routeName) {
                alert('Please enter a route name.');
                return;
            }

            const waypointData = waypoints.map(point => ({
                lat: point.location.lat(),
                lng: point.location.lng()
            }));

            const routeData = {
                name: routeName,
                start: {
                    lat: start.lat(),
                    lng: start.lng()
                },
                end: {
                    lat: end.lat(),
                    lng: end.lng()
                },
                waypoints: waypointData,
                elevationGain: elevationGain,
                totalDistance: totalDistance
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
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while saving the route.');
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            initMap();
        });
    </script>
</x-app-layout>

<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- HTML and JavaScript for the map and route planner -->
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCq-kOTVIXT9u1_YXEsDbEBCIW3FQwYPZ4&libraries=places">
                    </script>
                    <style>
                        #map {
                            height: 500px;
                            /* Adjusted height for better visibility */
                            width: 100%;
                        }

                        .controls:hover {
                            box-shadow: 0 5px 7px rgba(0, 0, 0, 0.1);
                        }

                        .controls:active {
                            position: relative;
                            top: 1px;
                        }

                        #info {
                            padding: 20px;
                            text-align: center;
                        }
                    </style>

                    <div id="elevation"></div>
                    <div id="distance"></div>
                    <div id="map"></div>

                    <script>
                        let map;
                        let directionsService;
                        let directionsRenderer;
                        let waypoints = [];
                        let start;
                        let end;
                        let totalDistance = 0;
                        let elevationGain = 0;

                        function initMap() {
                            map = new google.maps.Map(document.getElementById('map'), {
                                center: {
                                    lat: 60.192059,
                                    lng: 24.945831
                                },
                                zoom: 11
                            });

                            directionsService = new google.maps.DirectionsService();
                            directionsRenderer = new google.maps.DirectionsRenderer();
                            directionsRenderer.setMap(map);
                            console.log("rivi 59");
                            loadAllRoutes();
                        }

                        function loadAllRoutes() {
                            console.log("rivi 64");
                            fetch('/myroutes')
                                .then(response => response.json())
                                .then(data => {
                                    data.forEach(route => {
                                        const start = JSON.parse(route.start);
                                        const end = JSON.parse(route.end);
                                        const waypoints = route.waypoints.map(point => ({
                                            location: new google.maps.LatLng(point.lat, point.lng),
                                            stopover: true
                                        }));
                                        displayRoute(start, end, waypoints);
                                    });
                                    error.log(response.json);
                                })
                                .catch(error => console.error('Error fetching routes:', error));
                        }

                        function displayRoute(start, end, waypoints) {
                            const request = {
                                origin: new google.maps.LatLng(start.lat, start.lng),
                                destination: new google.maps.LatLng(end.lat, end.lng),
                                waypoints: waypoints,
                                optimizeWaypoints: true,
                                travelMode: 'WALKING'
                            };

                            directionsService.route(request, function(result, status) {
                                if (status === 'OK') {
                                    // Create a new DirectionsRenderer for each route
                                    const directionsRenderer = new google.maps.DirectionsRenderer({
                                        suppressMarkers: true,
                                        preserveViewport: true
                                    });
                                    directionsRenderer.setMap(map);
                                    directionsRenderer.setDirections(result);
                                    allDirectionsRenderers.push(directionsRenderer); // Store the renderer
                                } else {
                                    console.error('Directions request failed due to ' + status);
                                }
                            });
                        }
                        window.onload = initMap;
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

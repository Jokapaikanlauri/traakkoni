<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCq-kOTVIXT9u1_YXEsDbEBCIW3FQwYPZ4&libraries=places">
                    </script>
                    <style>
                        #map {
                            height: 500px;
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
                    <div class="container">
                        <h1>My Routes</h1>
                        @foreach ($routes as $route)
                            <div class="route">
                                <h2>{{ $route->name }}</h2>
                                <p>Distance: {{ $route->distance }} m</p>
                                <p>Elevation Gain: {{ $route->elevation_gain }} m</p>
                                <div id="map-{{ $route->id }}" class="route-map" style="height: 300px;"></div>
                            </div>
                        @endforeach
                    </div>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            @foreach ($routes as $route)
                                initMap({{ $route->id }}, @json($route->start), @json($route->end),
                                    @json($route->waypoints));
                            @endforeach
                        });

                        function initMap(routeId, start, end, waypoints) {
                            const map = new google.maps.Map(document.getElementById('map-' + routeId), {
                                zoom: 10,
                                center: JSON.parse(start),
                            });

                            const directionsService = new google.maps.DirectionsService();
                            const directionsRenderer = new google.maps.DirectionsRenderer({
                                map: map
                            });

                            directionsService.route({
                                origin: JSON.parse(start),
                                destination: JSON.parse(end),
                                waypoints: JSON.parse(waypoints).map(point => ({
                                    location: point,
                                    stopover: true
                                })),
                                travelMode: google.maps.TravelMode.WALKING,
                            }, function(result, status) {
                                if (status === 'OK') {
                                    directionsRenderer.setDirections(result);
                                } else {
                                    console.error('Could not display route: ' + status);
                                }
                            });
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


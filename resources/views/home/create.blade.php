<x-layout>
    <!DOCTYPE html>
<html>
<head>
    <title>Route Designer</title>
    <style>
        #map {
            height: 100%;
        }
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <div id="map"></div>
    <script>
        // Initialize and add the map
        function initMap() {
            // The map, centered at a default location
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 8,
                center: { lat: -34.397, lng: 150.644 } // Change this to your desired default location
            });

            // Initialize the drawing manager
            var drawingManager = new google.maps.drawing.DrawingManager({
                drawingMode: google.maps.drawing.OverlayType.POLYLINE,
                drawingControl: true,
                drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_CENTER,
                    drawingModes: [
                        google.maps.drawing.OverlayType.POLYLINE
                    ]
                },
                polylineOptions: {
                    clickable: true,
                    editable: true,
                    strokeWeight: 3
                }
            });
            drawingManager.setMap(map);

            // Store drawn polylines
            var allPolylines = [];

            // Event listener for when a polyline is completed
            google.maps.event.addListener(drawingManager, 'polylinecomplete', function (polyline) {
                allPolylines.push(polyline);

                // Save the path to the server
                var path = polyline.getPath().getArray().map(function (latLng) {
                    return { lat: latLng.lat(), lng: latLng.lng() };
                });

                fetch('save_route.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ path: path })
                }).then(response => response.json()).then(data => {
                    console.log('Route saved', data);
                }).catch(error => {
                    console.error('Error saving route', error);
                });
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCq-kOTVIXT9u1_YXEsDbEBCIW3FQwYPZ4&libraries=drawing&callback=initMap" async defer></script>
</body>
</html>

</x-layout>
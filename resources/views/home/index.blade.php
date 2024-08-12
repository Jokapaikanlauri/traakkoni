<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCq-kOTVIXT9u1_YXEsDbEBCIW3FQwYPZ4&libraries=places">
                    </script>

                    <div class="container">
                        <h1 class="title">All routes</h1>
                        @foreach ($routes as $route)
                        <div class="route">
                            <h2>{{ $route->name }}</h2>
                            <p>Distance: {{ $route->distance }} meters</p>
                            <p>Elevation Gain: {{ $route->elevation_gain }} meters</p>
                            <p>Likes: <span id="like-count-{{ $route->id }}">{{ $route->likes }}</span></p>
                            <button class="like-button {{ $route->isLikedByUser(auth()->id()) ? 'disabled' : '' }}"
                                onclick="likeRoute({{ $route->id }})"
                                {{ $route->isLikedByUser(auth()->id()) ? 'disabled' : '' }}>
                                {{ $route->isLikedByUser(auth()->id()) ? 'Liked' : 'Like' }}
                            </button>

                            <div id="map-{{ $route->id }}" class="route-map" style="height: 300px;"></div>
                        </div>
                                <h3>Comments</h3>
                                @foreach ($route->comments as $comment)
                                    <div class="comment">
                                        <p>{{ $comment->content }}</p>

                                        <!-- Only show the delete button if the comment belongs to the logged-in user -->
                                        @if ($comment->user_id === auth()->id())
                                            <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this comment?')"
                                                    class="btn-delete">
                                                    Delete comment
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endforeach

                            </div>



                            <form action="{{ route('route.comment', $route) }}" method="POST">
                                @csrf
                                <textarea name="content" rows="3" class="w-full border rounded-md" placeholder="Write a comment..." required></textarea>
                                <button type="submit" class="like-button mt-2">Post Comment</button>
                            </form>
                          
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

                    function likeRoute(routeId) {
                        fetch('/routes/' + routeId + '/like', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    document.getElementById('like-count-' + routeId).textContent = data.likes;
                                    document.querySelector('.like-button[onclick="likeRoute(' + routeId + ')"]').classList.add(
                                        'disabled');
                                    document.querySelector('.like-button[onclick="likeRoute(' + routeId + ')"]').textContent =
                                        'Liked';
                                    document.querySelector('.like-button[onclick="likeRoute(' + routeId + ')"]').disabled = true;
                                } else {
                                    alert('Failed to like the route.');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                            });
                    }
                </script>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>

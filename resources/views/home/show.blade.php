<x-app-layout>
    <div class="routes-container py-12">
        
        <div class="routes">
            @foreach ($routes as $routes)
                <div class="routes">

                    <div class="routes-buttons">
                        <a href="{{ route('routes.show', $routes) }}" class="routes-edit-button">View</a>
                        <a href="{{ route('routes.edit', $routes) }}" class="routes-edit-button">Edit</a>
                        <form action="{{ route('routes.destroy', $routes) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="routes-delete-button">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="p-6">
            {{ $routes->links() }}
        </div>
    </div></x-app-layout>
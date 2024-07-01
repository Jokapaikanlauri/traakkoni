<x-app-layout>
    <div class="note-container py-12" >
        <a href="{{route('note.create')}}" class="new-note-btn">
            New Note
        </a>
        <div class="notes">
            @foreach ($notes as $note)
                <div class="note">
                    <div class="note-body">
                        {{ Str::words($note->note, 30)}}
                    </div>
                    <div>
                        <a href="{{route('note.show', $note)}}" class="note-edit-button">View</a>
                        <a href="{{route('note.edit', $note)}}" class="note-edit-button">Edit</a>
                        <form action="{{route('note.destroy', $note) }}"
                        method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="note-delete-button">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>     
        {{$notes -> links()}}
    </div>
</x-app-layout>

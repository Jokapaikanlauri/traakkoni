<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Other methods...

    public function destroy(Comment $comment)
    {
        // Ensure the user owns the comment
        if ($comment->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $comment->delete();

        return redirect()->back()->with('message', 'Comment deleted successfully.');
    }
}

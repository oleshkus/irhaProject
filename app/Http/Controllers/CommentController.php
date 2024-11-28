<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request)
    {
        $request->validate([
            'commentable_id' => 'required|integer',
            'commentable_type' => 'required|string',
            'content' => 'required|string',
        ]);

        Comment::create([
            'content' => $request->content,
            'user_id' => auth()->id(),
            'commentable_id' => $request->commentable_id,
            'commentable_type' => $request->commentable_type,
        ]);

        return back()->with('success', 'Комментарий добавлен!');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment); // Авторизация

        $comment->delete();

        return back()->with('success', 'Комментарий удален!');
    }
}

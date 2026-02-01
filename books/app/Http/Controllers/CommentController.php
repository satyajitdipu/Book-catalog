<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request)
    {
        $bookId = $request->query('book_id');
        if ($bookId) {
            return Comment::where('book_id', $bookId)->with('user')->paginate(20);
        }
        return Comment::with('user')->paginate(20);
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|string|exists:books,book_id',
            'content' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'book_id' => $request->book_id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return response()->json($comment->load('user'), 201);
    }

    public function show(Comment $comment)
    {
        return $comment->load('user');
    }

    public function update(Request $request, Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment->update($request->only('content'));

        return response()->json($comment->load('user'));
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted']);
    }
}
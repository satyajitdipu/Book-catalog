<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function index()
    {
        return Rating::with(['user', 'book'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $rating = Rating::updateOrCreate(
            ['user_id' => Auth::id(), 'book_id' => $request->book_id],
            ['rating' => $request->rating, 'comment' => $request->comment]
        );

        return response()->json($rating->load(['user', 'book']), 201);
    }

    public function show(Rating $rating)
    {
        return $rating->load(['user', 'book']);
    }

    public function update(Request $request, Rating $rating)
    {
        if ($rating->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $rating->update($request->only(['rating', 'comment']));

        return response()->json($rating->load(['user', 'book']));
    }

    public function destroy(Rating $rating)
    {
        if ($rating->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $rating->delete();

        return response()->json(['message' => 'Rating deleted']);
    }

    public function getRatingsForBook($bookId)
    {
        return Rating::where('book_id', $bookId)->with('user')->get();
    }
}
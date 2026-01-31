<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        return Auth::user()->wishlists()->with('book')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,book_id'
        ]);

        $wishlist = Auth::user()->wishlists()->create($request->only('book_id'));

        return response()->json($wishlist->load('book'), 201);
    }

    public function show(Wishlist $wishlist)
    {
        if ($wishlist->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $wishlist->load('book');
    }

    public function update(Request $request, Wishlist $wishlist)
    {
        if ($wishlist->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'book_id' => 'required|exists:books,book_id'
        ]);

        $wishlist->update($request->only('book_id'));

        return response()->json($wishlist->load('book'));
    }

    public function destroy(Wishlist $wishlist)
    {
        if ($wishlist->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $wishlist->delete();

        return response()->json(['message' => 'Wishlist item deleted']);
    }
}
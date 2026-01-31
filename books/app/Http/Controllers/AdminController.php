<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use App\Models\Author;
use App\Models\Review;
use App\Models\Rating;
use App\Models\Wishlist;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_books' => Book::count(),
            'total_authors' => Author::count(),
            'total_reviews' => Review::count(),
            'total_ratings' => Rating::count(),
            'total_wishlists' => Wishlist::count(),
        ];

        return response()->json($stats);
    }

    public function users()
    {
        return User::paginate(20);
    }

    public function books()
    {
        return Book::with('Author')->paginate(20);
    }

    public function authors()
    {
        return Author::paginate(20);
    }

    public function reviews()
    {
        return Review::with(['user', 'book'])->paginate(20);
    }

    public function ratings()
    {
        return Rating::with(['user', 'book'])->paginate(20);
    }

    public function wishlists()
    {
        return Wishlist::with(['user', 'book'])->paginate(20);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }

    public function deleteBook($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return response()->json(['message' => 'Book deleted']);
    }

    public function deleteAuthor($id)
    {
        $author = Author::findOrFail($id);
        $author->delete();
        return response()->json(['message' => 'Author deleted']);
    }

    public function promoteUser($id)
    {
        $user = User::findOrFail($id);
        $user->role = 'admin';
        $user->save();
        return response()->json(['message' => 'User promoted to admin']);
    }

    public function demoteUser($id)
    {
        $user = User::findOrFail($id);
        $user->role = 'user';
        $user->save();
        return response()->json(['message' => 'User demoted to user']);
    }
}
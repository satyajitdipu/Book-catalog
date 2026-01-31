<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;

class AdminBookController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return Book::with('Author')->paginate(20);
    }

    public function show($id)
    {
        return Book::with(['Author', 'reviews', 'ratings', 'wishlists'])->findOrFail($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|unique:books',
            'book_name' => 'required',
            'genre' => 'required',
            'price' => 'required|numeric',
            'author_id' => 'required|exists:authors,id',
            'isbn' => 'required',
        ]);

        $book = Book::create($request->all());
        return response()->json($book, 201);
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $book->update($request->all());
        return response()->json($book);
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return response()->json(['message' => 'Book deleted']);
    }

    public function approve($id)
    {
        $book = Book::findOrFail($id);
        $book->status = 'approved';
        $book->save();
        return response()->json(['message' => 'Book approved']);
    }

    public function reject($id)
    {
        $book = Book::findOrFail($id);
        $book->status = 'rejected';
        $book->save();
        return response()->json(['message' => 'Book rejected']);
    }
}
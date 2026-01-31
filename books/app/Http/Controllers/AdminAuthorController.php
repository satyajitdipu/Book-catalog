<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;

class AdminAuthorController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return Author::paginate(20);
    }

    public function show($id)
    {
        return Author::findOrFail($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'author_id' => 'required|unique:authors',
            'author_name' => 'required',
            'gender' => 'required',
            'genre' => 'required',
            'age' => 'required|integer',
            'email' => 'required|email',
        ]);

        $author = Author::create($request->all());
        return response()->json($author, 201);
    }

    public function update(Request $request, $id)
    {
        $author = Author::findOrFail($id);
        $author->update($request->all());
        return response()->json($author);
    }

    public function destroy($id)
    {
        $author = Author::findOrFail($id);
        $author->delete();
        return response()->json(['message' => 'Author deleted']);
    }

    public function approve($id)
    {
        $author = Author::findOrFail($id);
        $author->status = 'approved';
        $author->save();
        return response()->json(['message' => 'Author approved']);
    }

    public function reject($id)
    {
        $author = Author::findOrFail($id);
        $author->status = 'rejected';
        $author->save();
        return response()->json(['message' => 'Author rejected']);
    }
}
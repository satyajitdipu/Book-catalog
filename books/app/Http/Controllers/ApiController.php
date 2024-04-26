<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Book;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendNewBookEmail;
use Illuminate\Support\Facades\Event;
use App\Events\Books;
class ApiController extends Controller
{
    

    
    public function create(Request $request)
    {
        $author = new Author();
        $author->author_id = $request->input('author_id');
        if ($request->hasFile('main_image')) {
            $file = $request->file('main_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('oaky'), $filename);
            $author->main_image = 'oaky/' . $filename;
        } else {
            $author->main_image = $request->input('main_image');
        }
    
        $author->author_name = $request->input('author_name');
        $author->gender = $request->input('gender');
        $author->genre = $request->input('genre');
        $author->age = $request->input('age');
        $author->ratings = $request->input('ratings');
        $author->monthly_award = $request->input('monthly_award');
        $author->email = $request->input('email');
        $author->save();

        return response()->json($author);
    }

    public function createb(Request $request)
    {
        $book = new Book();
        $book->book_id = $request->input('book_id');
        $book->book_name = $request->input('book_name');
        $book->genre = $request->input('genre');
        $book->price = $request->input('price');
        $authorId = $request->input('author_id');
        $author = Author::find($authorId);
    
        if (!$author) {
            return response()->json(['error' => 'Invalid author_id'], 400);
        }
    
        if ($request->hasFile('main_img')) {
            $file = $request->file('main_img');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $book->main_img = 'images/' . $filename;
        } else {
            $book->main_img = $request->input('main_img');
        }
    
        $book->isbn = $request->input('isbn');
        $book->author_id = $authorId;
        $book->save();
        SendNewBookEmail::dispatch($book, $author);
    
        return response()->json($book);
    }
    

// public function sendBookAddedEmail($book, $author)
// {
//     $to_name = $author ? $author->author_name : null;
//     $to_email = $author ? $author->email : null;
//     $data = [
//         'title' => $book->book_name . ' add new book ' . $to_name,
//         'subject' => $book->book_name . ' book added',
//         'body' => 'Sir ' . $book->book_name . ' book added to your profile. Thanks for your contribution.',
//     ];

//     try {
//         Mail::send('mail', $data, function ($message) use ($to_name, $to_email) {
//             $message->to($to_email)->subject('New book alert');
//         });
//         echo "Email sent!";
//     } catch (\Exception $e) {
//         echo "Error sending email: " . $e->getMessage();
//     }
// }

    
    


    public function index($page)
    {
        $perPage = 10; 

        $offset = ($page - 1) * $perPage; 

        $Book = Book::orderBy('updated_at', 'DESC')
            ->offset($offset)
            ->limit($perPage)
            ->get();
    
        $Book->transform(function ($book) {
            $book->image_url = asset($book->main_img);
    
            
            $author = Author::find($book->author_id);
            $book->author_name = $author ? $author->author_name : null;
    
            return $book;
        });
    
        return response()->json(['status' => 200, 'Book' => $Book]);
    }
    
    
    public function indexa()
    {
       $Author = Author::orderBy('updated_at', 'DESC')->get();

        // Append the image URL to each book object
        $Author->transform(function ($author) {
            $author->image_url = asset($author->main_image);
            return $author;
        });

        return response()->json(['status' => 200, 'Author' => $Author]);
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);
        return response()->json($book);
    }
    public function Book()
    {
        return $this->hasMany(Book::class, 'author_id');
    }
    
    public function showauthor($id)
    {
        $author = Author::findOrFail($id);

        
    
        return response()->json($author);
    }

    public function updateauthor(Request $request, $id)
    {
        $author = Author::find($id);
        $author->author_id = $request->input('author_id');
        $author->author_name = $request->input('author_name');
        $author->gender = $request->input('gender');
        $author->genre = $request->input('genre');
        $author->age = $request->input('age');
        $author->ratings = $request->input('ratings');
        $author->monthly_award = $request->input('monthly_award');
        $author->email = $request->input('email');

        if ($author->save()) {
            return response()->json(["status" => 200, 'author' => $author]);
        }
    }

    public function updatebook(Request $request, $id)
    {
        $book = Book::find($id);
        $book->author_id = $request->input('author_id');
        $book->book_id = $request->input('book_id');
        $book->book_name = $request->input('book_name');
        $book->genre = $request->input('genre');
        $book->price = $request->input('price');
        if ($request->hasFile('main_img')) {
            $file = $request->file('main_img');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $book->main_img = 'images/' . $filename;
        } else {
            // Set the provided image path as the main_img value
            $book->main_img = $request->input('main_img');
        }
        $book->isbn = $request->input('isbn');
        $authorId = $request->input('author_id');
        $author = Author::find($authorId);

        if (!$author) {
            return response()->json(['error' => 'Invalid author_id'], 400);
        }

        $book->author_id = $authorId;

        if ($book->save()) {
            return response()->json(["status" => 200, 'book' => $book]);
        }
    }


    public function destroyauthor($id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json(["error" => "Author not found"], 404);
        }

        // Delete all Book associated with the author
        Book::where('author_id', $id)->delete();


        // Delete the author
        if ($author->delete()) {
            return response()->json(["status" => 200]);
        }
    }
    public function destorybook($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(["error" => "Author not found"], 404);
        }



        // Delete the author
        if ($book->delete()) {
            return response()->json(["status" => 200]);
        }
    }
    
}

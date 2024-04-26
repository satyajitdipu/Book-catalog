<?php

namespace App\Listeners;

use App\Events\Books;
use App\Mail\BookAddedEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class BookSavedListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  Books  $event
     * @return void
     */
    public function handle(Books $event)
    {
        $book = $event->book;
        $author = $book->author;

        $toName = $author ? $author->author_name : null;
        $toEmail = $author ? $author->email : null;
        $data = [
            'title' => $book->book_name . ' - New Book Added',
            'subject' => $book->book_name . ' - New Book Added',
            'body' => 'Dear ' . $toName . ',<br><br>' .
                'A new book has been added to your profile:<br>' .
                'Book Name: ' . $book->book_name . '<br>' .
                'Genre: ' . $book->genre . '<br>' .
                'Price: $' . $book->price . '<br><br>' .
                'Thank you for your contribution.',
        ];

        Mail::to($toEmail)->send(new BookAddedEmail($data));
    }
}

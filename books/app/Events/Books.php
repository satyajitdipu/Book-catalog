<?php

namespace App\Events;

use App\Mail\BookAddedEmail;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class Books
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $book;
    protected $author;

    /**
     * Create a new job instance.
     *
     * @param Book   $book
     * @param Author $author
     */
    public function __construct(Book $book, Author $author)
    {
        $this->book = $book;
        $this->author = $author;
        $this->handle2();
    }

    /**
     * Execute the job.
     */
    public function handle2()
    {
        $book = $this->book;
        $author = $this->author;

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

        try {
            Mail::send('mail', $data, function ($message) use ($toName, $toEmail) {
                $message->to($toEmail)->subject('New book alert');
            });
            
        } catch (\Exception $e) {
            
        }
    }
}
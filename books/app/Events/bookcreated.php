<?php

namespace App\Jobs;

use App\Models\Authors;
use App\Models\Books;
use App\Mail\BookAddedEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\ApiController;

class PodcastProcessed implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $book;
    protected $author;

    /**
     * Create a new job instance.
     *
     * @param Books   $book
     * @param Authors $author
     */
    public function __construct(Books $book, Authors $author)
    {
        $this->book = $book;
        $this->author = $author;
    }

    /**
     * Execute the job.
     */
    public function handle()
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
            Mail::to($toEmail)->send(new BookAddedEmail($data));
            // Mail sent successfully
        } catch (\Exception $e) {
            // Error sending email
            // You can handle the exception here or log the error
        }
    }
}

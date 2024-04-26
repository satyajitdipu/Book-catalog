<?php
namespace App\Jobs;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNewBookEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $book;
    protected $author;

    /**
     * Create a new job instance.
     *
     * @param  Book  $book
     * @param  Author  $author
     * @return void
     */
    public function __construct(Book $book, Author $author)
    {
        $this->book = $book;
        $this->author = $author;
        

    }

    /**
     * Execute the job.
     *
     * @return void
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
            Mail::send('mail', $data, function ($message) use ($toName, $toEmail) {
                $message->to($toEmail)->subject('New book alert');
            });
            
        } catch (\Exception $e) {
            
        }
    }
}

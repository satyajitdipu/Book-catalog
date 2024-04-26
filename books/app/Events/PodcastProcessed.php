<?php

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Authors;
use App\Models\Books;
use App\Mail\BookAddedEmail;
use Illuminate\Support\Facades\Mail;

class PodcastProcessed
{
    use Dispatchable, SerializesModels;

    public $book;
    public $author;

    /**
     * Create a new event instance.
     *
     * @param Books $book
     * @param Authors $author
     */
    public function __construct(Books $book, Authors $author)
    {
        $this->book = $book;
        $this->author = $author;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }

    /**
     * Send the book added email.
     *
     * @return void
     */
    public function toMail()
    {
        $book = $this->book;
        $author = $this->author;

        $toEmail = $author->email;
        $toName = $author->author_name;

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
            // You can handle the exception
        }
    }
}

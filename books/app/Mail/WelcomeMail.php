<?
namespace App\Mail;

use Illuminate\Mail\Mailable;

class BookMailer extends Mailable
{
    public $book;
    public $author;

    /**
     * Create a new message instance.
     *
     * @param $book
     * @param $author
     */
    public function __construct($book, $author)
    {
        $this->book = $book;
        $this->author = $author;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $to_name = $this->author ? $this->author->author_name : null;
        $to_email = $this->author ? $this->author->email : null;

        $data = [
            'title' => $this->book->book_name . ' added a new book by ' . $to_name,
            'subject' => 'New Book Added',
            'body' => 'Dear ' . $to_name . ', your book (' . $this->book->book_name . ') has been added. Thank you for your contribution!',
        ];

        return $this->view('mail', $data)
            ->to($to_email)
            ->subject('New book alert');
    }
}

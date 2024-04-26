<?php

namespace App\Listeners;

use App\Events\Books;
use App\Mail\BookAddedEmail;
use App\Notifications\mailsend;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;

class mailNotification implements ShouldQueue
{
  use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  books  $event
     * @return void
     */
    public function handle(Books $event)
    {
        $book = $event->book;

        // Prepare the email data
        $toName = 'Recipient Name';
        $toEmail = 'recipient@example.com';
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

        // Send the email
        Mail::to($toEmail)->send(new BookAddedEmail($data));
    }
}
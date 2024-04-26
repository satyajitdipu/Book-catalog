<?php

namespace App\Listeners;

use App\Events\bookCreated;
use App\Events\PodcastProcessed;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendNewBookEmail;

class mailNotification
{
    /**
     * @param \App\Events\PodcastProcessed $name
     * Handle the event.
     */
    public function handle(PodcastProcessed $event): void
    {
        $book = $event->book;
        $author = $event->author;

        $to_name = $author ? $author->author_name : null;
        $to_email = $author ? $author->email : null;
        $data = [
            'title' => $book->book_name . ' add new book ' . $to_name,
            'subject' => $book->book_name . ' book added',
            'body' => 'Sir ' . $book->book_name . ' book added to your profile. Thanks for your contribution.',
        ];

        Mail::send('mail', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email)->subject('New book alert');
        });
    }
}

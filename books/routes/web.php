<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $to_name = 'Satyajit';
    $to_email = 'satyajits101@gmail.com';
    $data = array(
        'title' => 'Web Email',
        'subject' => 'Web Email Subject',
        'body' => 'This is the email body text'
    );

    Mail::send('mail', $data, function($message) use ($to_name, $to_email) {
        $message->to($to_email)->subject('Web Email Subject');
    });
    echo "Email sent!";
});
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Book extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = 'books';
    protected $primaryKey = 'book_id';
    public $incrementing = false;

    protected $fillable = [
        'book_id',
        'book_name',
        'genre',
        'price',
        'main_img',
        'isbn',
        'author_id',
    ];

    // protected static function booted()
    // {
    //     static::created(function ($book) {
            
    //     });
    // }

    public function Author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }
    public function run(): void
{
    Book::factory()
            ->count(10000)
            ->create();
}
}

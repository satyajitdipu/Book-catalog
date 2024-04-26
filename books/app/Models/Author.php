<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $table = 'authors';protected $primaryKey = "author_id"; // Specify the primary key column name
    public $incrementing = false;
    

    protected $fillable = [
        'author_id',
        'main_image',
        'author_name',
        'gender',
        'genre',
        'age',
        'ratings',
        'monthly_award',
        'email'
    ];
    public function run(): void
    {
        Book::factory()
                ->count(10)
                ->create();
    }
    

}

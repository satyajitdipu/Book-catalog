<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Support\Facades\Validator;
use App\Models\Book;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $authorIds = DB::table('authors')->pluck('author_id')->toArray();
    
        for ($i = 1; $i <= 10000; $i++) {
            $bookId = $this->generateUniqueBookId();
            $authorId = $this->getRandomAuthorId($authorIds);
    
            DB::table('books')->insert([
                'book_id' => $bookId,
                'book_name' => Str::random(10),
                'genre' => Str::random(10),
                'price' => random_int(1, 100),
                'main_img' => 'example.jpg',
                'isbn' => '1234567890',
                'author_id' => $authorId,
            ]);
        }
    }
    
    private function getRandomAuthorId(array $authorIds): int
    {
        return $authorIds[array_rand($authorIds)];
    }
    private function generateUniqueBookId(): int
    {
        $bookId = random_int(1, 100000);
        
        while (DB::table('books')->where('book_id', $bookId)->exists()) {
            $bookId = random_int(1, 100000);
        }
        
        return $bookId;
    }
}    
<?php
 
namespace Database\Seeders;
 
use Faker\Core\Number;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Book;
 
class BookSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10000; $i++) {
            DB::table('books')->insert([
                'book_id' => random_int(1, 100000),
                'book_name' => Str::random(10),
                'genre' => Str::random(10),
                'price' => random_int(1, 100),
                'main_img' => 'example.jpg',
                'isbn' => '1234567890',
                'author_id' => 1,
            ]);
        }
    
        
    }
}
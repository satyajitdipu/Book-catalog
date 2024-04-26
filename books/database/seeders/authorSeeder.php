<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            $authorId = $this->generateUniqueAuthorId();
            
            DB::table('authors')->insert([
                'author_id' => $authorId,
                'author_name' => Str::random(10),
                'genre' => Str::random(10),
                'gender' => Str::random(10),
                'main_img' => 'example.jpg',
                'monthly_award' => '1234567890',
                'ratings' => random_int(1, 100000),
                'email' => Str::random(10).'@gmail.com',
                'age' => random_int(19, 100),
            ]);
        }
    }

    private function generateUniqueAuthorId(): int
    {
        $authorId = random_int(1, 100000);

        while (DB::table('authors')->where('author_id', $authorId)->exists()) {
            $authorId = random_int(1, 100000);
        }

        return $authorId;
    }
}

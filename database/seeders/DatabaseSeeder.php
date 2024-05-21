<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Author;
use App\Models\Book;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');
        Author::factory(10)->create()->each(function ($author) {
            $booksCount = rand(1, 5);
            while ($booksCount > 0) {
                $author->books()->save(Book::factory()->make());
                $booksCount--;
            }
        });
    }
}

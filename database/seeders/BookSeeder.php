<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;
use App\Models\Author;


class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Author::factory(10)->create()->each(function ($author) {
            $booksCount = rand(1, 5);
            while ($booksCount > 0) {
                $author->books()->save(Book::factory()->make());
                $booksCount--;
            }
        });

        
    }
}

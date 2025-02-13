<?php

namespace Modules\Book\Database\Seeders;

use Illuminate\Support\Str;
use Modules\Book\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class BookDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();
        // $book = Book::create([
        //     'name' => 'Book One',
        //     'description' => 'Description for Book One.',
        //     'published_date' => now(),
        //     'isbn' => Str::random(16),
        // ]);
    }
}

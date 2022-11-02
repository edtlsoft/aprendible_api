<?php

namespace Tests\Feature\Api\Books;

use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CanListBooksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_list_books()
    {
        $books = Book::factory()->count(5)->create();

        $response = $this->getJson(
            route('books.index')
        );

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'author',
                    'created_at',
                    'updated_at',
                ]
            ],
        ]);
        $response->assertJsonCount(5, 'data');
        $books->each(function ($book) use ($response) {
            $response->assertJsonFragment([
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
                'created_at' => $book->created_at->toJSON(),
                'updated_at' => $book->updated_at->toJSON(),
            ]);
        });
    }
}

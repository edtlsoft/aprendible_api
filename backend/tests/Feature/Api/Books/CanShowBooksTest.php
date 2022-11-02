<?php

namespace Tests\Feature\Api\Books;

use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CanShowBooksTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function can_show_a_book()
    {
        $book = Book::factory()->create();
        
        $response = $this->getJson(
            route('books.show', $book)
        );

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $book->id,
            'title' => $book->title,
            'author' => $book->author,
            'created_at' => $book->created_at->toJSON(),
            'updated_at' => $book->updated_at->toJSON(),
        ]);
    }
}

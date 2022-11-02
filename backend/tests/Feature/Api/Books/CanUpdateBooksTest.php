<?php

namespace Tests\Feature\Api\Books;

use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CanUpdateBooksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_update_a_book()
    {
        $book = Book::factory()->create();
        
        $response = $this->patchJson(
            route('books.update', $book),
            [
                'title' => 'The Lord of the Rings',
                'author' => 'J. R. R. Tolkien',
            ]
        );

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'title' => 'The Lord of the Rings',
            'author' => 'J. R. R. Tolkien',
        ]);
        $this->assertDatabaseHas('books', [
            'title' => 'The Lord of the Rings',
            'author' => 'J. R. R. Tolkien',
        ]);
    }

    /** @test */
    public function title_is_required()
    {
        $book = Book::factory()->create();

        $response = $this->patchJson(
            route('books.update', $book),
            [
                'title' => '',
                'author' => 'J. R. R. Tolkien',
            ]
        );

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('title');
    }

    /** @test */
    public function author_is_required()
    {
        $book = Book::factory()->create();
        
        $response = $this->patchJson(
            route('books.update', $book),
            [
                'title' => 'The Lord of the Rings',
                'author' => '',
            ]
        );

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('author');
    }
}

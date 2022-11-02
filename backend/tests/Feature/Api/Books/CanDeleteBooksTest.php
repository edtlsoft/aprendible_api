<?php

namespace Tests\Feature\Api\Books;

use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CanDeleteBooksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_delete_a_book()
    {
        $book = Book::factory()->create();
        
        $response = $this->deleteJson(
            route('books.destroy', $book)
        );

        $response->assertStatus(204);
        $this->assertDatabaseMissing('books', [
            'id' => $book->id,
        ]);
    }
}

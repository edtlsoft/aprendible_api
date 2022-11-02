<?php

namespace Tests\Feature\Api\Books;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CanCreateBooksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_a_book()
    {
        $response = $this->postJson(
            route('books.store'),
            [
                'title' => 'The Lord of the Rings',
                'author' => 'J. R. R. Tolkien',
            ]
        );

        $response->assertStatus(201);
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
        $response = $this->postJson(
            route('books.store'),
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
        $response = $this->postJson(
            route('books.store'),
            [
                'title' => 'The Lord of the Rings',
                'author' => '',
            ]
        );

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('author');
    }
}

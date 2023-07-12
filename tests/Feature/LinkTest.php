<?php

namespace Tests\Feature;

use App\Models\Link;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LinkTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    public function test_the_application_returns_successful_response(): void
    {
        $response = $this->get(route('links.index'));

        $response->assertStatus(200);
    }

    public function test_the_application_returns_correct_message_in_case_of_empty_table(): void
    {
        $response = $this->get(route('links.index'));

        $response->assertStatus(200);
        $response->assertSee('No URL entered');
    }

    public function test_the_application_returns_non_empty_table(): void
    {
        Link::create([
            'url' => 'https://cnn.com',
        ]);
        $response = $this->get(route('links.index'));

        $response->assertStatus(200);
        $response->assertDontSee('No URL entered');
    }

    public function test_add_link_successful(): void
    {
        $link = [
            'url' => 'https://cnn.com',
        ];

        $this->post(route('links.store'), $link);

        $this->assertDatabaseHas('links', [
            'url' => 'https://cnn.com',
        ]);
    }

    public function test_update_link_successful(): void
    {
        $link = Link::create([
            'url' => 'https://cnn.com',
        ]);

        $updatedData = [
            'url' => 'https://bbc.com',
        ];

        $this->put(route('links.update', $link->id), $updatedData);

        $this->assertDatabaseHas('links', [
            'url' => 'https://bbc.com',
        ]);
    }

    public function test_delete_link_successful(): void
    {
        $link = Link::create([
            'url' => 'http://imdb.com',
        ]);

        $this->delete(route('links.destroy', $link->id));

        $this->assertDatabaseMissing('links', [
            'url' => 'http://imdb.com',
        ]);

        $this->assertDatabaseCount('links', 0);
    }

    public function test_link_of_list_correctly(): void
    {
        Link::create([
            'url' => 'https://cnn.com',
        ]);

        Link::create([
            'url' => 'http://bbc.com',
        ]);

        Link::create([
            'url' => 'https://anotherlink.com',
        ]);

        Link::create([
            'url' => 'http://imdb.com',
        ]);

        $response = $this->get(route('links.index'));

        $response->assertStatus(200);
        $response->assertSee('https://cnn.com');
        $response->assertSee('http://bbc.com');
        $response->assertSee('https://anotherlink.com');
        $response->assertSee('http://imdb.com');

        $this->assertDatabaseCount('links', 4);
    }

    public function test_show_message_in_case_link_is_broken(): void
    {
        $link = [
            'url' => 'https://this_is_really_broken_link_11111122222.com',
        ];

        $this->post(route('links.store'), $link);
        $response = $this->get(route('links.index'));

        $response->assertStatus(200);
        $response->assertSee('Link is broken');
        $response->assertDontSee('Results');
    }

    public function test_show_result_link_in_case_link_is_working(): void
    {
        $link = [
            'url' => 'https://cnn.com',
        ];

        $this->post(route('links.store'), $link);
        $response = $this->get(route('links.index'));

        $response->assertStatus(200);
        $response->assertSee('Results');
        $response->assertDontSee('Link is broken');
    }

    public function test_validation_pass_correct_format_url_input()
    {
        $link = [
            'url' => 'https://correct-format-url.com',
        ];

        $this->post(route('links.store'), $link)->assertStatus(302);
        $this->assertDatabaseHas('links', ['url' => 'https://correct-format-url.com']);
    }

    public function test_validation_reject_invalid_format_url_input()
    {
        $link = [
            'url' => 'wrong-format-url.com',
        ];

        $this->post(route('links.store'), $link)
            ->assertSessionHasErrors('url')
            ->assertStatus(302);

        $this->assertDatabaseMissing('links', ['url' => 'wrong-format-url']);
    }
}

<?php

namespace Tests\Feature;

use App\Http\Livewire\CreateIdea;
use App\Models\Category;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CreateIdeaTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_idea_form_does_not_show_when_logged_out() {
        $response = $this->get(route('idea.index'));

        $response->assertSee('Please login to create an idea.');
        $response->assertDontSee('Let us know what you would like and we\'ll take a look over!');
    }

    public function test_create_idea_form_does_show_when_logged_in() {
        $response = $this->actingAs(User::factory()->create())->get(route('idea.index'));

        $response->assertSuccessful();
        $response->assertDontSee('Please login to create an idea.');
        $response->assertSee('Let us know what you would like and we\'ll take a look over!', false);
    }

    public function test_main_page_contains_create_idea_livewire_component() {
        $this->actingAs(User::factory()->create())->get(route('idea.index'))
            ->assertSuccessful()
            ->assertSeeLivewire('create-idea');
    }

    public function test_create_idea_form_validation_works() {
        Livewire::actingAs(User::factory()->create())
            ->test(CreateIdea::class)
            ->set('title', '')
            ->set('category', '')
            ->set('description', '')
            ->call('createIdea')
            ->assertHasErrors(['title', 'category', 'description'])
            ->assertSee('The title field is required.')
            ->assertSee('The description field is required.');
    }

    public function test_creating_an_idea_works_correctly() {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create([
            'name' => 'Category 1',
        ]);

        $statusOpen = Status::factory()->create([
            'name' => 'Open',
        ]);

        Livewire::actingAs($user)
            ->test(CreateIdea::class)
            ->set('title', 'My first idea')
            ->set('category', $categoryOne->id)
            ->set('description', 'This is my first idea')
            ->call('createIdea')
            ->assertRedirect(route('idea.index'));

        $response = $this->actingAs($user)->get(route('idea.index'));
        $response->assertSuccessful();
        $response->assertSee('My first idea');
        $response->assertSee('This is my first idea');

        $this->assertDatabaseHas('ideas', [
            'title' => 'My first idea',
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'description' => 'This is my first idea',
            'user_id' => $user->id,
        ]);
    }

    public function test_creating_two_ideas_with_same_title_still_works_but_has_different_slugs() {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create([
            'name' => 'Category 1',
        ]);

        $statusOpen = Status::factory()->create([
            'name' => 'Open',
        ]);

        Livewire::actingAs($user)
            ->test(CreateIdea::class)
            ->set('title', 'My first idea')
            ->set('category', $categoryOne->id)
            ->set('description', 'This is my first idea')
            ->call('createIdea')
            ->assertRedirect(route('idea.index'));

        $this->assertDatabaseHas('ideas', [
            'title' => 'My first idea',
            'slug' => 'my-first-idea',
        ]);

        Livewire::actingAs($user)
            ->test(CreateIdea::class)
            ->set('title', 'My first idea')
            ->set('category', $categoryOne->id)
            ->set('description', 'This is my first idea')
            ->call('createIdea')
            ->assertRedirect(route('idea.index'));

        $this->assertDatabaseHas('ideas', [
            'title' => 'My first idea',
            'slug' => 'my-first-idea-2',
        ]);
    }
}

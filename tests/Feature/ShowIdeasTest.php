<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowIdeasTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_of_ideas_shows_on_main_page() {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create([
            'name' => 'Category 1',
        ]);
        $categoryTwo = Category::factory()->create([
            'name' => 'Category 2',
        ]);

        $statusOpen = Status::factory()->create([
            'name' => 'Open',
        ]); 
        $statusConsidering = Status::factory()->create([
            'name' => 'Considering',
        ]); 

        $ideaOne = Idea::factory()->create([
            'title' => 'My first idea',
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'description' => 'This is my first idea',
        ]);

        $ideaTwo = Idea::factory()->create([
            'title' => 'My second idea',
            'user_id' => $user->id,
            'category_id' => $categoryTwo->id,
            'status_id' => $statusConsidering->id,
            'description' => 'This is my second idea',
        ]);

        $response = $this->get(route('idea.index'));

        $response->assertSuccessful();
        $response->assertSee($ideaOne->title);
        $response->assertSee($ideaOne->description);
        $response->assertSee($categoryOne->name);
        $response->assertSee('<div class="bg-gray-200 text-xxs font-bold uppercase leading-none rounded-full text-center w-28 h-7 py-2 px-4">Open</div>', false);
        $response->assertSee($ideaTwo->title);
        $response->assertSee($ideaTwo->description);
        $response->assertSee($categoryTwo->name);
        $response->assertSee('<div class="bg-purple text-white text-xxs font-bold uppercase leading-none rounded-full text-center w-28 h-7 py-2 px-4">Considering</div>', false);
    }
    
    public function test_single_idea_shows_correctly_on_the_show_page() {
        $user = User::factory()->create();

        $category = Category::factory()->create([
            'name' => 'Category 1',
        ]);
        $statusOpen = Status::factory()->create([
            'name' => 'Open',
        ]);

        $idea = Idea::factory()->create([
            'title' => 'My first idea',
            'user_id' => $user->id,
            'category_id' => $category->id,
            'status_id' => $statusOpen->id,
            'description' => 'This is my first idea',
        ]);

        $response = $this->get(route('idea.index'));

        $response->assertSuccessful();
        $response->assertSee($idea->title);
        $response->assertSee($idea->description);
        $response->assertSee($category->name);
        $response->assertSee('<div class="bg-gray-200 text-xxs font-bold uppercase leading-none rounded-full text-center w-28 h-7 py-2 px-4">Open</div>', false);
    }

    public function test_ideas_pagination_works() {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create([
            'name' => 'Category 1',
        ]);
        $statusOpen = Status::factory()->create([
            'name' => 'Open',
        ]);

        Idea::factory(Idea::PAGINATION_COUNT + 1)->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
        ]);

        $ideaOne = Idea::find(1);
        $ideaOne->title = 'My first idea';
        $ideaOne->save();

        $ideaSix = Idea::find(6);
        $ideaSix->title = 'My six idea';
        $ideaSix->save();

        $response = $this->get('/');

        $response->assertDontSee($ideaOne->title);
        $response->assertSee($ideaSix->title);

        $response = $this->get('/?page=2');

        $response->assertSee($ideaOne->title);
        $response->assertDontSee($ideaSix->title);
    }

    public function test_same_idea_title_different_slugs() {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create([
            'name' => 'Category 1',
        ]);
        $statusOpen = Status::factory()->create([
            'name' => 'Open',
        ]);

        $ideaOne = Idea::factory()->create([
            'title' => 'My first idea',
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'description' => 'This is my first idea',
        ]);
        
        $ideaTwo = Idea::factory()->create([
            'title' => 'My first idea',
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'description' => 'This is my first idea',
        ]);
        
        $response = $this->get(route('idea.show', $ideaOne));
        $response->assertSuccessful();
        $this->assertTrue(request()->path() == 'ideas/my-first-idea');

        $response = $this->get(route('idea.show', $ideaTwo));
        $response->assertSuccessful();
        $this->assertTrue(request()->path() == 'ideas/my-first-idea-2');
    }
}

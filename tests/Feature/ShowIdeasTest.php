<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Idea;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowIdeasTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_of_ideas_shows_on_main_page() {
        $categoryOne = Category::factory()->create([
            'name' => 'Category 1',
        ]);
        $categoryTwo = Category::factory()->create([
            'name' => 'Category 2',
        ]);

        $ideaOne = Idea::factory()->create([
            'title' => 'My first idea',
            'category_id' => $categoryOne->id,
            'description' => 'This is my first idea',
        ]);

        $ideaTwo = Idea::factory()->create([
            'title' => 'My second idea',
            'category_id' => $categoryTwo->id,
            'description' => 'This is my second idea',
        ]);

        $response = $this->get(route('idea.index'));

        $response->assertSuccessful();
        $response->assertSee($ideaOne->title);
        $response->assertSee($ideaOne->description);
        $response->assertSee($categoryOne->name);
        $response->assertSee($ideaTwo->title);
        $response->assertSee($ideaTwo->description);
        $response->assertSee($categoryTwo->name);
    }
    
    public function test_single_idea_shows_correctly_on_the_show_page() {
        $category = Category::factory()->create([
            'name' => 'Category 1',
        ]);

        $idea = Idea::factory()->create([
            'title' => 'My first idea',
            'category_id' => $category->id,
            'description' => 'This is my first idea',
        ]);

        $response = $this->get(route('idea.index'));

        $response->assertSuccessful();
        $response->assertSee($idea->title);
        $response->assertSee($idea->description);
        $response->assertSee($category->name);
    }

    public function test_ideas_pagination_works() {
        $categoryOne = Category::factory()->create([
            'name' => 'Category 1',
        ]);

        Idea::factory(Idea::PAGINATION_COUNT + 1)->create([
            'category_id' => $categoryOne->id,
        ]);

        $ideaOne = Idea::find(1);
        $ideaOne->title = 'My first idea';
        $ideaOne->save();

        $ideaSix = Idea::find(6);
        $ideaSix->title = 'My six idea';
        $ideaSix->save();

        $response = $this->get('/');

        $response->assertSee($ideaOne->title);
        $response->assertDontSee($ideaSix->title);

        $response = $this->get('/?page=2');

        $response->assertDontSee($ideaOne->title);
        $response->assertSee($ideaSix->title);
    }

    public function test_same_idea_title_different_slugs() {
        $categoryOne = Category::factory()->create([
            'name' => 'Category 1',
        ]);

        $ideaOne = Idea::factory()->create([
            'title' => 'My first idea',
            'category_id' => $categoryOne->id,
            'description' => 'This is my first idea',
        ]);
        
        $ideaTwo = Idea::factory()->create([
            'title' => 'My first idea',
            'category_id' => $categoryOne->id,
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

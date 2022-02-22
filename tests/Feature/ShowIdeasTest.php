<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

        $statusOpen = Status::factory()->create([
            'name' => 'OpenUnique',
        ]); 
        $statusConsidering = Status::factory()->create([
            'name' => 'ConsideringUnique',
        ]); 

        $ideaOne = Idea::factory()->create([
            'title' => 'My first idea',
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
        ]);

        $ideaTwo = Idea::factory()->create([
            'title' => 'My second idea',
            'category_id' => $categoryTwo->id,
            'status_id' => $statusConsidering->id,
        ]);

        $response = $this->get(route('idea.index'));

        $response->assertSuccessful();
        $response->assertSee($ideaOne->title);
        $response->assertSee($ideaOne->description);
        $response->assertSee($categoryOne->name);
        $response->assertSee('OpenUnique');
        $response->assertSee($ideaTwo->title);
        $response->assertSee($ideaTwo->description);
        $response->assertSee($categoryTwo->name);
        $response->assertSee('ConsideringUnique');
    }
    
    public function test_single_idea_shows_correctly_on_the_show_page() {
        $category = Category::factory()->create([
            'name' => 'Category 1',
        ]);
        $statusOpen = Status::factory()->create([
            'name' => 'OpenUnique',
        ]);

        $idea = Idea::factory()->create([
            'title' => 'My first idea',
            'category_id' => $category->id,
            'status_id' => $statusOpen->id,
        ]);

        $response = $this->get(route('idea.index'));

        $response->assertSuccessful();
        $response->assertSee($idea->title);
        $response->assertSee($idea->description);
        $response->assertSee($category->name);
        $response->assertSee('OpenUnique');
    }

    public function test_ideas_pagination_works() {
        $ideaOne = Idea::factory()->create();

        Idea::factory($ideaOne->getPerPage())->create();

        $response = $this->get('/');

        $response->assertSee(Idea::find(Idea::count())->title);
        $response->assertDontSee($ideaOne->title);

        $response = $this->get('/?page=2');

        $response->assertDontSee(Idea::find(Idea::count())->title);
        $response->assertSee($ideaOne->title);
    }

    public function test_same_idea_title_different_slugs() {
        $ideaOne = Idea::factory()->create([
            'title' => 'My first idea',
        ]);
        
        $ideaTwo = Idea::factory()->create([
            'title' => 'My first idea',
        ]);
        
        $response = $this->get(route('idea.show', $ideaOne));
        $response->assertSuccessful();
        $this->assertTrue(request()->path() == 'ideas/my-first-idea');

        $response = $this->get(route('idea.show', $ideaTwo));
        $response->assertSuccessful();
        $this->assertTrue(request()->path() == 'ideas/my-first-idea-2');
    }

    public function test_in_app_back_button_works_when_index_page_visited_first()
    {
        $ideaOne = Idea::factory()->create();

        $response = $this->get('/?category=Category%202&status=Considering');
        $response = $this->get(route('idea.show', $ideaOne));

        $this->assertStringContainsString('/?category=Category%202&status=Considering', $response['backUrl']);
    }

    public function test_in_app_back_button_works_when_show_page_only_page_visited()
    {
        $ideaOne = Idea::factory()->create();

        $response = $this->get(route('idea.show', $ideaOne));

        $this->assertEquals(route('idea.index'), $response['backUrl']);
    }
}

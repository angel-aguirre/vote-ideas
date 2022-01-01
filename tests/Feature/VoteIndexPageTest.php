<?php

namespace Tests\Feature;

use App\Http\Livewire\IdeaIndex;
use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class VoteIndexPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_page_contains_idea_index_livewire_component() {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);

        $statusOpen = Status::factory()->create(['name' => 'Open']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'title' => 'Idea Title',
            'description' => 'Idea Description',
        ]);

        $this->get(route('idea.index'))
            ->assertSeeLivewire('idea-index');
    }

    public function test_index_page_correctly_receives_votes_count() {
        $userOne = User::factory()->create();
        $userTwo = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);

        $statusOpen = Status::factory()->create(['name' => 'Open']);

        $idea = Idea::factory()->create([
            'user_id' => $userOne->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'title' => 'Idea Title',
            'description' => 'Idea Description',
        ]);

        Vote::factory()->create([
            'user_id' => $userOne->id,
            'idea_id' => $idea->id,
        ]);

        Vote::factory()->create([
            'user_id' => $userTwo->id,
            'idea_id' => $idea->id,
        ]);

        $this->get(route('idea.index'))
            ->assertViewHas('ideas', function($ideas) {
                return $ideas->first()->votes_count == 2;
            });
    }

    public function test_votes_count_shows_correctly_on_index_page_livewire_component() {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);

        $statusOpen = Status::factory()->create(['name' => 'Open']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'title' => 'Idea Title',
            'description' => 'Idea Description',
        ]);

        Livewire::test(IdeaIndex::class, [
            'idea' => $idea,
            'votesCount' => 5,
        ])
            ->assertSet('votesCount', 5)
            ->assertSeeHtml('<div class="font-semibold text-2xl">5</div>')
            ->assertSeeHtml('<div class="text-sm font-bold leading-none">5</div>');
    }
}

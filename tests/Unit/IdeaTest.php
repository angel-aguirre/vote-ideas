<?php

namespace Tests\Unit;

use App\Models\Idea;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IdeaTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_check_if_idea_is_voted_for_by_user() {
        $userOne = User::factory()->create();
        $userTwo = User::factory()->create();

        $idea = Idea::factory()->create();

        Vote::factory()->create([
            'user_id' => $userOne->id,
            'idea_id' => $idea->id,
        ]);

        $this->assertTrue($idea->isVotedByUser($userOne));
        $this->assertFalse($idea->isVotedByUser($userTwo));
        $this->assertFalse($idea->isVotedByUser(null));
    }

    public function test_user_can_vote_for_idea() {
        $userOne = User::factory()->create();

        $idea = Idea::factory()->create();

        $this->assertFalse($idea->isVotedByUser($userOne));
        $idea->vote($userOne);
        $this->assertTrue($idea->isVotedByUser($userOne));
    }

    public function test_user_can_remove_vote_for_idea() {
        $userOne = User::factory()->create();

        $idea = Idea::factory()->create();

        Vote::create([
            'user_id' => $userOne->id,
            'idea_id' => $idea->id,
        ]);

        $this->assertTrue($idea->isVotedByUser($userOne));
        $idea->removeVote($userOne);
        $this->assertFalse($idea->isVotedByUser($userOne));
    }
}

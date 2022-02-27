<?php

namespace Tests\Feature\Comments;

use App\Http\Livewire\IdeaComment;
use App\Http\Livewire\MarkCommentAsNotSpam;
use App\Http\Livewire\MarkCommentAsSpam;
use App\Models\Comment;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Livewire\Livewire;
use Tests\TestCase;

class CommentsSpamManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_shows_mark_comment_as_spam_livewire_component_when_user_has_authorization() {
        $user = User::factory()->create();
        $idea = Idea::factory()->create();

        $comment = Comment::factory()->create([
            'idea_id' => $idea->id,
            'user_id' => $user->id,
            'body' => 'This is my first comment',
        ]);

        $this->actingAs($user)
            ->get(route('idea.show', $idea))
            ->assertSeeLivewire('mark-comment-as-spam');
    }

    public function test_does_not_show_mark_comment_as_spam_livewire_component_when_user_does_not_have_authorization() {
        $idea = Idea::factory()->create();

        $comment = Comment::factory()->create([
            'idea_id' => $idea->id,
            'body' => 'This is my first comment',
        ]);

        $this->get(route('idea.show', $idea))
            ->assertDontSeeLivewire('mark-comment-as-spam');
    }

    public function test_marking_a_comment_as_spam_works_when_user_has_authorization() {
        $user = User::factory()->create();
        $idea = Idea::factory()->create();

        $comment = Comment::factory()->create([
            'idea_id' => $idea->id,
            'user_id' => $user->id,
            'body' => 'This is my first comment',
        ]);

        Livewire::actingAs($user)
            ->test(MarkCommentAsSpam::class)
            ->call('setMarkAsSpamComment', $comment->id)
            ->assertDispatchedBrowserEvent('custom-show-mark-comment-as-spam-modal')
            ->call('markCommentAsSpam');

        $this->assertEquals(1, Comment::first()->spam_reports);
    }

    public function test_marking_a_comment_as_spam_does_not_work_when_user_does_not_have_authorization() {
        $idea = Idea::factory()->create();

        $comment = Comment::factory()->create([
            'idea_id' => $idea->id,
            'body' => 'This is my first comment',
        ]);

        Livewire::test(MarkCommentAsSpam::class)
            ->call('setMarkAsSpamComment', $comment->id)
            ->call('markCommentAsSpam')
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_marking_a_comment_as_spam_shows_on_menu_when_user_has_authorization() {
        $user = User::factory()->create();
        $idea = Idea::factory()->create();

        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'idea_id' => $idea->id,
            'body' => 'This is my first comment',
        ]);

        Livewire::actingAs($user)
            ->test(IdeaComment::class, [
                'comment' => $comment,
                'ideaUserId' => $idea->user_id
            ])
            ->assertSee('Mark as spam');
    }

    public function test_marking_a_comment_as_spam_does_not_show_on_menu_when_user_does_not_have_authorization() {
        $user = User::factory()->create();
        $idea = Idea::factory()->create();

        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'idea_id' => $idea->id,
            'body' => 'This is my first comment',
        ]);

        Livewire::test(IdeaComment::class, [
                'comment' => $comment,
                'ideaUserId' => $idea->user_id
            ])
            ->assertDontSee('Mark as Spam');
    }

    public function test_shows_mark_comment_as_not_spam_livewire_component_when_user_has_authorization() {
        $user = User::factory()->admin()->create();
        $idea = Idea::factory()->create();

        $comment = Comment::factory()->create([
            'idea_id' => $idea->id,
            'user_id' => $user->id,
            'body' => 'This is my first comment',
        ]);

        $this->actingAs($user)
            ->get(route('idea.show', $idea))
            ->assertSeeLivewire('mark-comment-as-not-spam');
    }

    public function test_does_not_show_mark_comment_as_not_spam_livewire_component_when_user_does_not_have_authorization() {
        $user = User::factory()->create();
        $idea = Idea::factory()->create();

        $comment = Comment::factory()->create([
            'idea_id' => $idea->id,
            'body' => 'This is my first comment',
        ]);

        $this->actingAs($user)
            ->get(route('idea.show', $idea))
            ->assertDontSeeLivewire('mark-comment-as-not-spam');
    }

    public function test_marking_a_comment_as_not_spam_works_when_user_has_authorization() {
        $user = User::factory()->admin()->create();
        $idea = Idea::factory()->create();

        $comment = Comment::factory()->create([
            'idea_id' => $idea->id,
            'user_id' => $user->id,
            'body' => 'This is my first comment',
        ]);

        Livewire::actingAs($user)
            ->test(MarkCommentAsNotSpam::class)
            ->call('setMarkAsNotSpamComment', $comment->id)
            ->assertDispatchedBrowserEvent('custom-show-mark-comment-as-not-spam-modal')
            ->call('markCommentAsNotSpam');

        $this->assertEquals(0, Comment::first()->spam_reports);
    }

    public function test_marking_a_comment_as_not_spam_does_not_work_when_user_does_not_have_authorization() {
        $user = User::factory()->create();
        $idea = Idea::factory()->create();

        $comment = Comment::factory()->create([
            'idea_id' => $idea->id,
            'body' => 'This is my first comment',
        ]);

        Livewire::actingAs($user)
            ->test(MarkCommentAsNotSpam::class)
            ->call('setMarkAsNotSpamComment', $comment->id)
            ->assertDispatchedBrowserEvent('custom-show-mark-comment-as-not-spam-modal')
            ->call('markCommentAsNotSpam')
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_marking_a_comment_as_not_spam_shows_on_menu_when_user_has_authorization() {
        $user = User::factory()->admin()->create();
        $idea = Idea::factory()->create();

        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'idea_id' => $idea->id,
            'body' => 'This is my first comment',
            'spam_reports' => 1,
        ]);

        Livewire::actingAs($user)
            ->test(IdeaComment::class, [
                'comment' => $comment,
                'ideaUserId' => $idea->user_id
            ])
            ->assertSee('Not Spam');
    }

    public function test_marking_a_comment_as_not_spam_does_not_show_on_menu_when_user_does_not_have_authorization() {
        $user = User::factory()->create();
        $idea = Idea::factory()->create();

        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'idea_id' => $idea->id,
            'body' => 'This is my first comment',
        ]);

        Livewire::actingAs($user)
            ->test(IdeaComment::class, [
                'comment' => $comment,
                'ideaUserId' => $idea->user_id
            ])
            ->assertDontSee('Not Spam');
    }
}
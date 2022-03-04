<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Traits\WithAuthRedirects;
use App\Notifications\CommentAdded;
use App\Models\Comment;
use App\Models\Idea;
use Illuminate\Http\Response;
use Livewire\Component;

class AddComment extends Component
{
    use WithAuthRedirects;

    public $idea;
    public $comment;

    protected $rules = [
        'comment' => 'required|min:3|max:400',
    ];

    public function mount(Idea $idea) {
        $this->idea = $idea;
    }

    public function render()
    {
        return view('livewire.add-comment');
    }

    /**
     * Custom methods
     */
    public function addComment() {
        if (auth()->guest()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $this->validate();

        $comment = Comment::create([
            'user_id' => auth()->user()->id,
            'idea_id' => $this->idea->id,
            'body' => $this->comment,
        ]);

        $this->reset('comment');

        $this->idea->user->notify( new CommentAdded( $comment ) );

        // get the comment inserted id
        $this->emit('commentWasAdded', $comment->id);
        $this->emit('openSuccessNotification', 'Comment was posted!');
    }
}

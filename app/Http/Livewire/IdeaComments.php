<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Idea;
use Livewire\Component;

class IdeaComments extends Component
{
    public $idea;
    public $comments;

    public $listeners = ['commentWasAdded'];

    public function mount(Idea $idea) {
        $this->idea = $idea;
    }

    public function render()
    {
        $this->comments = $this->idea->comments;
        return view('livewire.idea-comments', [
            'comments' => $this->comments,
        ]);
    }

    /**
     * Listeners
     */
    public function commentWasAdded($commentID) {
        // $this->idea->refresh();

        $this->comments->push(Comment::find($commentID));
        $this->dispatchBrowserEvent('comment-was-added', $this->comments->last());
    }
}

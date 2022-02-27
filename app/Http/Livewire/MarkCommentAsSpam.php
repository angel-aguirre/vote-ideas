<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Illuminate\Http\Response;
use Livewire\Component;

class MarkCommentAsSpam extends Component
{
    public Comment $comment;

    protected $listeners = ['setMarkAsSpamComment'];

    public function render()
    {
        return view('livewire.mark-comment-as-spam');
    }

    /**
     * Custom methods
     */
    public function setMarkAsSpamComment($commentId) {
        $this->comment = Comment::findOrFail($commentId);

        $this->dispatchBrowserEvent('custom-show-mark-comment-as-spam-modal');
    }

    public function markCommentAsSpam() {
        if (auth()->guest()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        Comment::find($this->comment->id)->increment('spam_reports', 1);

        $this->emit('commentWasMarkedAsSpam');
        $this->emit('openSuccessNotification', 'Comment was marked as spam!');
    }
}

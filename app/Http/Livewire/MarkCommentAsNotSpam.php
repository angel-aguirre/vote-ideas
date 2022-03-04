<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Illuminate\Http\Response;
use Livewire\Component;

class MarkCommentAsNotSpam extends Component
{
    public Comment $comment;

    protected $listeners = ['setMarkAsNotSpamComment'];

    public function render()
    {
        return view('livewire.mark-comment-as-not-spam');
    }

    /**
     * Custom methods
     */
    public function setMarkAsNotSpamComment($commentId) {
        $this->comment = Comment::findOrFail($commentId);

        $this->dispatchBrowserEvent('custom-show-mark-comment-as-not-spam-modal');
    }

    public function markCommentAsNotSpam() {
        if (auth()->guest() || !auth()->user()->isAdmin()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $this->comment->spam_reports = 0;
        $this->comment->save();

        $this->emit('commentWasMarkedAsNotSpam');
        $this->emit('openNotification', [
            'message' => 'Comment spam counter was reset!',
            'type' => 'success',
        ]);
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Illuminate\Http\Response;
use Livewire\Component;

class DeleteComment extends Component
{
    public Comment $comment;

    protected $listeners = ['setDeleteComment'];

    public function render()
    {
        return view('livewire.delete-comment');
    }

    /**
     * Custom methods
     */
    public function setDeleteComment($commentId) {
        $this->comment = Comment::findOrFail($commentId);

        $this->dispatchBrowserEvent('custom-show-delete-comment-modal');
    }

    public function deleteComment() {
        if (auth()->guest() || auth()->user()->cannot('delete', $this->comment)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        Comment::destroy($this->comment->id);

        $this->comment = Comment::make();

        $this->emit('commentWasDeleted');
        $this->emit('openNotification', [
            'message' => 'Comment was deleted!',
            'type' => 'success',
        ]);
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use App\Models\Idea;
use Livewire\Component;
use Livewire\WithPagination;

class IdeaComments extends Component
{
    use WithPagination;

    public $idea;
    // public $comments;

    public $listeners = [
        'commentWasAdded',
        'commentWasDeleted',
    ];

    public function mount(Idea $idea) {
        $this->idea = $idea;
    }

    public function render()
    {
        // $this->comments = $this->idea->comments;
        return view('livewire.idea-comments', [
            'comments' => $this->idea->comments()->with(['user'])->paginate()->withQueryString(),
        ]);
    }

    /**
     * Listeners
     */
    public function commentWasAdded() {
        $this->idea->refresh();

        $this->gotoPage($this->idea->comments()->paginate()->lastPage());
        $this->dispatchBrowserEvent('comment-was-added');
    }

    public function commentWasDeleted() {
        $this->idea->refresh();
        $this->gotoPage(1);
    }
}

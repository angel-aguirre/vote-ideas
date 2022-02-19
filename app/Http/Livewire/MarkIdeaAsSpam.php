<?php

namespace App\Http\Livewire;

use App\Models\Idea;
use Illuminate\Http\Response;
use Livewire\Component;

class MarkIdeaAsSpam extends Component
{
    public $idea;

    public function mount(Idea $idea) {
        $this->idea = $idea;
    }

    public function render()
    {
        return view('livewire.mark-idea-as-spam');
    }

    /**
     * Custom methods
     */
    public function markAsSpam() {
        if (auth()->guest()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        Idea::find($this->idea->id)->increment('spam_reports', 1);

        $this->emit('ideaWasMarkedAsSpam');
        $this->emit('openSuccessNotification', 'Idea was marked as spam!');
    }
}

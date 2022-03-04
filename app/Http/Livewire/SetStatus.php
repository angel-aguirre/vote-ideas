<?php

namespace App\Http\Livewire;

use App\Jobs\NotifyAllVoters;
use App\Models\Comment;
use App\Models\Idea;
use Illuminate\Http\Response;
use Livewire\Component;

class SetStatus extends Component
{
    public $idea;
    public $status;
    public $comment;
    public $notifyAllVoters;

    public function mount(Idea $idea) {
        $this->idea = $idea;
        $this->status = $this->idea->status_id;
    }

    public function render()
    {
        return view('livewire.set-status');
    }

    /**
     * Custom Methods
     */
    public function setStatus() {
        if ( !auth()->check() || !auth()->user()->isAdmin() ){
            return Response::HTTP_FORBIDDEN;
        }
        
        if ( $this->idea->status_id == $this->status ) {
            $this->emit('statusWasUpdated');
            $this->emit('openNotification', [
                'message' => 'Status is the same.',
                'type' => 'error',
            ]);

            return;
        }

        $this->idea->status_id = $this->status;
        $this->idea->save();

        if ( $this->notifyAllVoters ) {
            NotifyAllVoters::dispatch($this->idea);
        }

        Comment::create([
            'user_id' => auth()->id(),
            'idea_id' => $this->idea->id,
            'status_id' => $this->status,
            'body' => $this->comment ?? 'Status Changed, no comment provided.',
            'is_status_update' => true,
        ]);

        $this->reset('comment');

        $this->emit('statusWasUpdated');
        $this->emit('openNotification', [
            'message' => 'Status was updated successfully.',
            'type' => 'success',
        ]);
    }
}

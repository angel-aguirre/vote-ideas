<?php

namespace App\Http\Livewire;

use App\Models\Idea;
use App\Mail\IdeaStatusUpdatedMailable;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class SetStatus extends Component
{
    public $idea;
    public $status;
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

        $this->idea->status_id = $this->status;
        $this->idea->save();

        if ( $this->notifyAllVoters ) {
            $this->notifyAllVoters();
        }

        $this->emit('statusWasUpdated');
    }

    public function notifyAllVoters() {
        $this->idea->votes()
            ->select('name', 'email')
            ->chunk(100, function ($voters) {
                foreach ($voters as $voter) {
                    Mail::to($voter)
                        ->queue( new IdeaStatusUpdatedMailable( $this->idea ) );
                }
           });
    }
}

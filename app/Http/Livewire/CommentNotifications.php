<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CommentNotifications extends Component
{

    public $notifications;
    
    protected $listeners = ['getNotifications'];

    public function mount() {
        $this->notifications = collect([]);
    }

    public function render()
    {
        return view('livewire.comment-notifications');
    }

    /**
     * Listeners
     */
    public function getNotifications() {
        $this->notifications = auth()->user()->unreadNotifications;
    }
}

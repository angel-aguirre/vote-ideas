<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CommentNotifications extends Component
{
    const NOTIFICATION_THRESHOLD = 10;

    public $notifications;
    public $notificationCount;
    public $isLoading;
    
    protected $listeners = ['getNotifications'];

    public function mount() {
        $this->notifications = collect([]);
        $this->isLoading = true;
        $this->getNotificationCount();
    }

    public function render()
    {
        return view('livewire.comment-notifications');
    }

    /**
     * Listeners
     */
    public function getNotifications() {
        $this->notifications = auth()
            ->user()
            ->unreadNotifications()
            ->latest()
            ->take(self::NOTIFICATION_THRESHOLD)
            ->get();
        
        $this->isLoading = false;
    }

    /**
     * Custom methods
     */
    public function getNotificationCount() {
        $this->notificationCount = auth()->user()->unreadNotifications()->count();

        if ($this->notificationCount > self::NOTIFICATION_THRESHOLD) {
            $this->notificationCount = '10+';
        }
    }
}

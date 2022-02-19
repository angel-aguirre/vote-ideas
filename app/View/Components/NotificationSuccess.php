<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NotificationSuccess extends Component
{
    public $message;
    public $showOnPageLoad;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($message = '', $showOnPageLoad = false)
    {
        $this->message = $message;
        $this->showOnPageLoad = $showOnPageLoad;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.notification-success');
    }
}

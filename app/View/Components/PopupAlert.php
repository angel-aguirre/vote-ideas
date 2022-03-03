<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PopupAlert extends Component
{
    public $message;
    public $showOnPageLoad;
    public $type;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($message = '', $showOnPageLoad = false, $type = 'success')
    {
        $this->message = $message;
        $this->showOnPageLoad = $showOnPageLoad;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.popup-alert');
    }
}

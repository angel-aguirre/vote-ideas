<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ModalsContainer extends Component
{
    public $idea;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($idea)
    {
        $this->idea = $idea;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modals-container');
    }
}

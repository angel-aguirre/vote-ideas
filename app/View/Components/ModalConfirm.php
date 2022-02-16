<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ModalConfirm extends Component
{
    public $eventToOpenModal;
    public $eventToCloseModal;
    public $title;
    public $description;
    public $confirmButtonText;
    public $wireClick;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($eventToOpenModal, $eventToCloseModal, $title, $description, $confirmButtonText, $wireClick)
    {
        $this->eventToOpenModal = $eventToOpenModal;
        $this->eventToCloseModal = $eventToCloseModal;
        $this->title = $title;
        $this->description = $description;
        $this->confirmButtonText = $confirmButtonText;
        $this->wireClick = $wireClick;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal-confirm');
    }
}

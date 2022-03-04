<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Traits\WithAuthRedirects;
use App\Models\Category;
use App\Models\Idea;
use Illuminate\Http\Response;
use Livewire\Component;

class CreateIdea extends Component
{
    use WithAuthRedirects;

    public $title;
    public $category = 1;
    public $description;

    private $idea_status_on_create = 1; //Open status

    protected $rules = [
        'title'         => 'required|min:4',
        'category'      => 'required|integer|exists:categories,id',
        'description'   => 'required|min:4',
    ];

    public function render()
    {
        return view('livewire.create-idea', [
            'categories' => Category::all(),
        ]);
    }
    
    /**
     * Create a new idea and reload the index page
     */
    public function createIdea() {
        if (auth()->guest()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $this->validate();

        $idea = Idea::create([
            'user_id' => auth()->id(),
            'category_id' => $this->category,
            'status_id' => $this->idea_status_on_create,
            'title' => $this->title,
            'description' => $this->description,
        ]);

        $idea->vote(auth()->user());

        session()->flash('success_message', 'Idea created successfully!');

        $this->reset();

        return redirect()->route('idea.index');
    }
}

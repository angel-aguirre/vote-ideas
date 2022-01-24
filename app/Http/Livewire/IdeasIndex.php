<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Idea;
use App\Models\Vote;
use Livewire\Component;
use Livewire\WithPagination;

class IdeasIndex extends Component
{
    use WithPagination;

    public $status = 'All';
    public $category;


    protected $queryString = [
        'status',
        'category',
    ];

    protected $listeners = ['queryStringUpdatedStatus'];

    public function mount() {
        $this->status = request()->status ?? 'All';
    }

    public function render()
    {
        return view('livewire.ideas-index', [
            'ideas' => Idea::with('user', 'category', 'status')
                ->join('statuses', 'statuses.id', '=', 'ideas.status_id')
                ->when($this->status && $this->status != 'All', function($query) {
                    $query->where('statuses.name', $this->status);
                })
                ->join('categories', 'categories.id', '=', 'ideas.category_id')
                ->when($this->category && $this->category != 'All Categories', function($query) {
                    $query->where('categories.name', $this->category);
                })
                ->addSelect(['voted_by_user' => Vote::select('id')
                    ->where('user_id', auth()->id())
                    ->whereColumn('idea_id', 'ideas.id')
                ])
                ->withCount('votes')
                ->orderBy('id', 'desc')
                ->simplePaginate(Idea::PAGINATION_COUNT),
            'categories' => Category::all(),
        ]);
    }

    /**
     * Custom Methods
     */
    public function udatingCategory() {
        $this->resetPage();
    }

    /**
     * Event Listeners
     */
    public function queryStringUpdatedStatus($newStatus) {
        $this->status = $newStatus;
        $this->resetPage();
    }
}

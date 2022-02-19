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
    public $filter;
    public $search;

    protected $queryString = [
        'status',
        'category',
        'filter',
        'search',
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
                ->when($this->filter && $this->filter == 'Top Voted', function($query) {
                    return $query->orderByDesc('votes_count');
                })
                ->when($this->filter && $this->filter == 'My Ideas', function($query) {
                    return $query->where('user_id', auth()->id());
                })
                ->when($this->filter && $this->filter == 'Spam Ideas', function($query) {
                    return $query->where('spam_reports', '>', 0)->orderByDesc('spam_reports');
                })
                ->when(strlen($this->search) > 3, function($query) {
                    return $query->where('title', 'like', "%{$this->search}%");
                })
                ->withCount('votes')
                ->withCount('comments')
                ->orderBy('id', 'desc')
                ->simplePaginate(Idea::PAGINATION_COUNT),
            'categories' => Category::all(),
        ]);
    }

    /**
     * Custom Methods
     */
    public function updatingCategory() {
        $this->resetPage();
    }

    public function updatedFilter() {
        if ($this->filter == 'My Ideas') {
            if ( !auth()->check() ) {
                return redirect()->route('login');
            }
        }
    }

    /**
     * Event Listeners
     */
    public function queryStringUpdatedStatus($newStatus) {
        $this->status = $newStatus;
        $this->resetPage();
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;
use App\Models\Post;
use App\Models\Category;

class PostList extends Component
{

    use WithPagination;

    #[Url()]
    public $sort = 'desc';
    #[Url()]
    public $search = '';
    #[Url()]
    public $category = '';

    public function setSort($sort){
        $this->sort = ($sort === 'desc') ? 'desc' : 'asc';
    }

    #[On('search')]
    public function updateSearch($search){
        $this->search = $search;
    }

    #[Computed()]
    public function posts(){
        return Post::published()
        ->orderBy('published_at', $this->sort)
        ->when(Category::where('slug',$this->category)->first(), function($query){
            $query->withCategory($this->category);
        })
        ->where('title','like',"%{$this->search}%")
        ->paginate(3);
    }

    public function render()
    {
        return view('livewire.post-list');
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;

class SearchBox extends Component
{

    public $search = '';

    public function updateSearch(){
        $this->dispatch('search',search: $this->search);
    }

    // public function updatedSearch(){ pra os resultados ficarem atualizando ao digitar
    //     $this->dispatch('search',search: $this->search);
    // }

    public function render()
    {
        return view('livewire.search-box');
    }
}
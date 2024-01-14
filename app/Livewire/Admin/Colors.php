<?php

namespace App\Livewire\Admin;

use App\Models\Brand;
use App\Models\Color;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Colors extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;

    protected $listeners = [
        'destroyColor',
        'refreshComponent' => '$refresh'
    ];
    public function deleteColor($id)
    {
        $this->dispatch('deleteColor',['id'=>$id]);
    }


    public function destroyColor($id)
    {
        Color::destroy($id);
        $this->dispatch('refreshComponent');
    }

    public function render()
    {
        $colors = Color::query()->
        where('title', 'like', '%' . $this->search . '%')->
        paginate(10);
        return view('livewire.admin.colors',compact('colors'));
    }
}

<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Property;
use Livewire\Component;
use Livewire\WithPagination;

class Properties extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;

    protected $listeners = [
        'destroyProperty',
        'refreshComponent' => '$refresh'
    ];
    public function deleteProperty($id)
    {
        $this->dispatch('deleteProperty',['id'=>$id]);
    }


    public function destroyProperty($id)
    {
        Property::destroy($id);
        $this->dispatch('refreshComponent');
    }

    public function render()
    {
        $properties = Property::query()->
        where('title', 'like', '%' . $this->search . '%')->
        paginate(10);
        return view('livewire.admin.properties',compact('properties'));
    }
}

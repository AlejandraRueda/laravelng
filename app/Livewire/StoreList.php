<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Store;

class StoreList extends Component
{
    public $stores = [];
    public $showDeleteModal = false;
    public $storeToToggle;

    public function mount()
    {
        $this->refreshStores();
    }

    public function refreshStores()
    {
        $this->stores = Store::all()->toArray();  // Convertimos a array
    }

    public function render()
    {
        return view('livewire.store-list');
    }

    public function confirmToggleStatus($id)
    {
        $this->storeToToggle = collect($this->stores)->firstWhere('id', $id);
        $this->showDeleteModal = true;
    }

    public function toggleStatus()
    {
        if ($this->storeToToggle) {
            $stores = collect($this->stores)->map(function ($store) {
                if ($store['id'] === $this->storeToToggle['id']) {
                    $store['status'] = $store['status'] === 'Activo' ? 'Inactivo' : 'Activo';
                }
                return $store;
            });
            
            Store::save($stores);
            $this->refreshStores();
            $this->showDeleteModal = false;
            session()->flash('message', 'Estado actualizado correctamente');
        }
    }
}
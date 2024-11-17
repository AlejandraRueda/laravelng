<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;

class Store
{
    public $id;
    public $name;
    public $location;
    public $status;

    public function __construct($id, $name, $location, $status = 'Activo')
    {
        $this->id = $id;
        $this->name = $name;
        $this->location = $location;
        $this->status = $status;
    }

    public static function all()
    {
        $json = Storage::disk('local')->exists('stores.json') 
            ? Storage::disk('local')->get('stores.json')
            : '[]';
        
        $stores = json_decode($json, true);
        
        return collect($stores)->map(function ($store) {
            return new static(
                $store['id'],
                $store['name'],
                $store['location'],
                $store['status'] ?? 'Activo'
            );
        });
    }

    public static function save($stores)
    {
        Storage::disk('local')->put('stores.json', json_encode(
            $stores->map(function ($store) {
                return [
                    'id' => $store->id,
                    'name' => $store->name,
                    'location' => $store->location,
                    'status' => $store->status,
                ];
            })->toArray()
        ));
    }
}
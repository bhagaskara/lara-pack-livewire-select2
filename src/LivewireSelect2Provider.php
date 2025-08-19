<?php

namespace LaraPack\LivewireSelect2;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class LivewireSelect2Provider extends ServiceProvider
{
    public function boot()
    {
        // Daftarkan Livewire component
        Livewire::component('lara-pack.livewire-select2', Input::class);

        // Muat file view dari folder "resources/views"
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'lara-pack.livewire-select2');
    }
}
<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Artisan;
use Laravel\Pulse\Livewire\Card;

class About extends Card
{
    public function render()
    {
        Artisan::call('about --json');
        $data = json_decode(Artisan::output(), true);

        return view('livewire.about', [
            'data' => $data,
        ]);
    }
}

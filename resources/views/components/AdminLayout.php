<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AdminLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        // Ini memberitahu Laravel: 
        // "Kalau ada yang panggil <x-admin-layout>, tolong ambil file di resources/views/layouts/admin.blade.php"
        return view('layouts.admin');
    }
}
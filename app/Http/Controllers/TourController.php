<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TourController extends Controller
{
    public function complete()
    {
        $user = Auth::user();
        
        // Update status user agar tour tidak muncul lagi
        $user->update(['has_seen_tour' => true]);
        
        return response()->json(['status' => 'success']);
    }
}
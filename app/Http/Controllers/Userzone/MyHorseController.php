<?php

namespace App\Http\Controllers\Userzone;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MyHorseController extends Controller
{
    /**
     * Show the horses of the logged-in user, including hidden ones.
     */
    public function index(Request $request): View
    {
        $horses = $request->user()->horses()
            ->with('breed')
            ->latest()
            ->get();

        return view('userzone.my-horses.index', compact('horses'));
    }
}

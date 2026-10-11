<?php

namespace App\Http\Controllers;

use App\Models\Horse;
use App\Models\Like;
use Illuminate\View\View;

class WelcomeController extends Controller
{
    /**
     * Show the landing page with the newest horses and a few numbers.
     */
    public function __invoke(): View
    {
        $newestHorses = Horse::with('breed')
            ->where('is_active', true)
            ->latest()
            ->take(3)
            ->get();

        $horseCount = Horse::where('is_active', true)->count();
        $matchCount = Like::matched()->count() / 2;

        return view('welcome', compact('newestHorses', 'horseCount', 'matchCount'));
    }
}

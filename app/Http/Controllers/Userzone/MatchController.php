<?php

namespace App\Http\Controllers\Userzone;

use App\Http\Controllers\Controller;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MatchController extends Controller
{
    /**
     * Show the matches of the logged-in user's horses: likes they gave that were liked back.
     */
    public function index(Request $request): View
    {
        $matches = Like::whereIn('horse_id', $request->user()->horses()->pluck('id'))
            ->matched()
            ->with('horse', 'targetHorse.owner')
            ->latest()
            ->get();

        return view('userzone.matches.index', compact('matches'));
    }
}

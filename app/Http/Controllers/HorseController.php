<?php

namespace App\Http\Controllers;

use App\Models\Horse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HorseController extends Controller
{
    /**
     * Show all active horses, newest first.
     */
    public function index(): View
    {
        $horses = Horse::with('breed')
            ->where('is_active', true)
            ->latest()
            ->paginate(12);

        return view('horses.index', compact('horses'));
    }

    /**
     * Show the profile of one horse. Hidden horses are only visible to their owner.
     */
    public function show(Request $request, Horse $horse): View
    {
        if (! $horse->is_active && $horse->user_id !== $request->user()?->id) {
            abort(404);
        }

        $horse->load('breed', 'owner');

        return view('horses.show', compact('horse'));
    }
}

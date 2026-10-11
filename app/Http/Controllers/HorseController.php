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
     * Show the profile of one horse, with the likes it got from the visitor's horses.
     * Hidden horses are only visible to their owner and to admins.
     */
    public function show(Request $request, Horse $horse): View
    {
        if (! $horse->is_active && $horse->user_id !== $request->user()?->id && ! $request->user()?->isAdmin()) {
            abort(404);
        }

        $horse->load('breed', 'owner');

        $myHorses = $request->user()?->horses()->orderBy('name')->get() ?? collect();
        $myLikes = $horse->receivedLikes()->whereIn('horse_id', $myHorses->pluck('id'))->with('horse')->get();
        $myHorsesThatCanLike = $myHorses->whereNotIn('id', $myLikes->pluck('horse_id'));

        return view('horses.show', compact('horse', 'myHorses', 'myLikes', 'myHorsesThatCanLike'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Breed;
use Illuminate\View\View;

class BreedController extends Controller
{
    /**
     * Show all breeds in alphabetical order, with how many active horses each has.
     */
    public function index(): View
    {
        $breeds = Breed::withCount(['horses' => fn ($query) => $query->where('is_active', true)])
            ->orderBy('name')
            ->get();

        return view('breeds.index', compact('breeds'));
    }

    /**
     * Show one breed with its active horses.
     */
    public function show(Breed $breed): View
    {
        $horses = $breed->horses()
            ->with('breed')
            ->where('is_active', true)
            ->latest()
            ->get();

        return view('breeds.show', compact('breed', 'horses'));
    }
}

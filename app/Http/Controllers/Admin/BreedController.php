<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BreedRequest;
use App\Models\Breed;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BreedController extends Controller
{
    /**
     * Show all breeds with how many horses each has.
     */
    public function index(): View
    {
        $breeds = Breed::withCount('horses')->orderBy('name')->get();

        return view('admin.breeds.index', compact('breeds'));
    }

    /**
     * Show the form to add a new breed.
     */
    public function create(): View
    {
        return view('admin.breeds.create', ['breed' => new Breed]);
    }

    /**
     * Save a new breed.
     */
    public function store(BreedRequest $request): RedirectResponse
    {
        $breed = Breed::create($request->validated());

        return redirect()->route('admin.breeds.index')
            ->with('status', "{$breed->name} was added.");
    }

    /**
     * Show one breed with all its horses, also the hidden ones.
     */
    public function show(Breed $breed): View
    {
        $breed->load(['horses' => fn ($query) => $query->with('owner')->orderBy('name')]);

        return view('admin.breeds.show', compact('breed'));
    }

    /**
     * Show the form to edit a breed.
     */
    public function edit(Breed $breed): View
    {
        return view('admin.breeds.edit', compact('breed'));
    }

    /**
     * Save the changes to a breed.
     */
    public function update(BreedRequest $request, Breed $breed): RedirectResponse
    {
        $breed->update($request->validated());

        return redirect()->route('admin.breeds.index')
            ->with('status', "{$breed->name} was updated.");
    }

    /**
     * Delete a breed, but only when no horse belongs to it anymore.
     */
    public function destroy(Breed $breed): RedirectResponse
    {
        if ($breed->horses()->exists()) {
            return redirect()->route('admin.breeds.index')
                ->with('error', "{$breed->name} still has horses, so it can't be deleted.");
        }

        $breed->delete();

        return redirect()->route('admin.breeds.index')
            ->with('status', "{$breed->name} was deleted.");
    }
}

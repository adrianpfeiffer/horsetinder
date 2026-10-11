<?php

namespace App\Http\Controllers\Userzone;

use App\Http\Controllers\Controller;
use App\Http\Requests\HorseRequest;
use App\Models\Breed;
use App\Models\Horse;
use Illuminate\Http\RedirectResponse;
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

    /**
     * Show the form to add a new horse.
     */
    public function create(): View
    {
        $breeds = Breed::orderBy('name')->get();

        return view('userzone.my-horses.create', compact('breeds'));
    }

    /**
     * Save a new horse for the logged-in user.
     */
    public function store(HorseRequest $request): RedirectResponse
    {
        $horse = $request->user()->horses()->create($request->validated());

        return redirect()->route('my.horses.index')
            ->with('status', "{$horse->name} was added.");
    }

    /**
     * Show the form to edit one of the logged-in user's horses.
     */
    public function edit(Request $request, Horse $horse): View
    {
        $this->ensureOwnedBy($request, $horse);

        $breeds = Breed::orderBy('name')->get();

        return view('userzone.my-horses.edit', compact('horse', 'breeds'));
    }

    /**
     * Save the changes to one of the logged-in user's horses.
     */
    public function update(HorseRequest $request, Horse $horse): RedirectResponse
    {
        $this->ensureOwnedBy($request, $horse);

        $horse->update($request->validated());

        return redirect()->route('my.horses.index')
            ->with('status', "{$horse->name} was updated.");
    }

    /**
     * Delete one of the logged-in user's horses.
     */
    public function destroy(Request $request, Horse $horse): RedirectResponse
    {
        $this->ensureOwnedBy($request, $horse);

        $horse->delete();

        return redirect()->route('my.horses.index')
            ->with('status', "{$horse->name} was deleted.");
    }

    /**
     * Stop with a 403 error when the horse belongs to someone else.
     */
    private function ensureOwnedBy(Request $request, Horse $horse): void
    {
        if ($horse->user_id !== $request->user()->id) {
            abort(403);
        }
    }
}

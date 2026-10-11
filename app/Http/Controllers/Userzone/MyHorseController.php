<?php

namespace App\Http\Controllers\Userzone;

use App\Http\Controllers\Controller;
use App\Http\Requests\HorseRequest;
use App\Models\Breed;
use App\Models\Horse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $data = $request->safe()->except('photo');

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('horses', 'public');
        }

        $horse = $request->user()->horses()->create($data);

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

        $data = $request->safe()->except('photo');

        if ($request->hasFile('photo')) {
            $this->deletePhoto($horse);
            $data['photo_path'] = $request->file('photo')->store('horses', 'public');
        }

        $horse->update($data);

        return redirect()->route('my.horses.index')
            ->with('status', "{$horse->name} was updated.");
    }

    /**
     * Delete one of the logged-in user's horses.
     */
    public function destroy(Request $request, Horse $horse): RedirectResponse
    {
        $this->ensureOwnedBy($request, $horse);

        $this->deletePhoto($horse);
        $horse->delete();

        return redirect()->route('my.horses.index')
            ->with('status', "{$horse->name} was deleted.");
    }

    /**
     * Remove the horse's photo file from storage, if it has one.
     */
    private function deletePhoto(Horse $horse): void
    {
        if ($horse->photo_path) {
            Storage::disk('public')->delete($horse->photo_path);
        }
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

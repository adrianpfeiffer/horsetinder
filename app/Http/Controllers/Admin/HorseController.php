<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Horse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HorseController extends Controller
{
    /**
     * Show all horses of all owners, also the hidden ones.
     */
    public function index(): View
    {
        $horses = Horse::with('owner', 'breed')->orderBy('name')->paginate(20);

        return view('admin.horses.index', compact('horses'));
    }

    /**
     * Remove a horse profile, together with its photo and likes.
     */
    public function destroy(Horse $horse): RedirectResponse
    {
        $horse->deletePhoto();
        $horse->delete();

        return redirect()->route('admin.horses.index')
            ->with('status', "{$horse->name} was removed.");
    }
}

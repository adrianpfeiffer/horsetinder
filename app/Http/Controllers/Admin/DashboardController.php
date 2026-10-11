<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Breed;
use App\Models\Horse;
use App\Models\Like;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the admin overview with how many records there are of everything.
     */
    public function __invoke(): View
    {
        $stats = [
            'Owners' => User::where('role', 'user')->count(),
            'Horses' => Horse::count(),
            'Breeds' => Breed::count(),
            'Likes' => Like::count(),
            'Matches' => Like::matched()->count() / 2,
        ];

        return view('admin.dashboard', compact('stats'));
    }
}

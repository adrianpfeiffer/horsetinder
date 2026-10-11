<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class AboutController extends Controller
{
    /**
     * Show the page that explains what Neigh is and how matching works.
     */
    public function __invoke(): View
    {
        return view('about');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class CompetitionController extends Controller
{
    /**
     * @return View
     */
    public function list(): View
    {
        return view('home', [
            'component' => 'competition',
            'data' => ''
        ]);
    }
}

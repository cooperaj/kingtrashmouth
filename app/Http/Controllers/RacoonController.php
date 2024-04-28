<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Racoon\RacoonInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Contracts\View\View as ViewResponse;

class RacoonController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, RacoonInterface $racoon): ViewResponse
    {
        return view('index', ['photo' => $racoon->getRandom()]);
    }
}

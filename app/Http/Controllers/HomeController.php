<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Home', [
            'siteSettings' => SiteSetting::query()->firstOrFail(),
            'status' => session('status'),
        ]);
    }
}

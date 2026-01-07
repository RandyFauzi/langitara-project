<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;

class PublicHomeController extends Controller
{
    /**
     * Show the application landing page.
     */
    public function index()
    {
        // Example data retrieval
        $featuredTemplates = Template::where('status', 'active')
            ->where('is_premium', true)
            ->take(3)
            ->get();

        // Fetch active promo
        $activePromo = \App\Models\Promo::active()->latest()->first();

        return view('pages.public.home', compact('featuredTemplates', 'activePromo'));
    }
}

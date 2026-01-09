<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Package;

class PricingController extends Controller
{
    public function index()
    {
        $packages = Package::where('status', 'active')
            ->orderBy('price', 'asc')
            ->get();

        return view('pages.public.pricing.index', compact('packages'));
    }
}

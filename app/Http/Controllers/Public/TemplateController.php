<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index()
    {
        return view('pages.public.templates.index');
    }

    public function show($slug)
    {
        return view('pages.public.templates.show');
    }
}

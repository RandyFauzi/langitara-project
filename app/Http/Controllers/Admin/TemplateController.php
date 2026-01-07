<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Template::query(); // Start with query builder

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', "%{$request->search}%")
                ->orWhere('category', 'like', "%{$request->search}%");
        }

        if ($request->has('category') && $request->category && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        if ($request->has('access') && $request->access && $request->access !== 'all') {
            $query->where('package_access', $request->access);
        }

        $templates = $query->withCount('invitations')->latest()->paginate(12)->withQueryString();

        return view('admin.templates.index', compact('templates'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'style' => 'nullable|string',
            'folder_name' => 'required|string|unique:templates,folder_name',
            'package_access' => 'required|in:free,premium,exclusive,wo',
            'preview_image' => 'nullable|string', // Assuming path string for now
        ]);

        Template::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category' => $request->category,
            // 'style' => $request->style, // Removed as per request
            'folder_name' => $request->folder_name,
            'base_path' => 'templates/' . $request->folder_name, // Convention
            'package_access' => $request->package_access,
            'preview_image_path' => $request->preview_image,
            'status' => 'active',
            'is_premium' => $request->package_access !== 'free',
        ]);

        return back()->with('success', 'Template registered successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $template = Template::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'style' => 'nullable|string',
            'package_access' => 'required|in:free,premium,exclusive,wo',
            'status' => 'required|in:active,inactive',
        ]);

        $template->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category' => $request->category,
            'style' => $request->style,
            'package_access' => $request->package_access,
            'status' => $request->status,
            'is_premium' => $request->package_access !== 'free',
        ]);

        if ($request->has('preview_image') && $request->preview_image) {
            $template->update(['preview_image_path' => $request->preview_image]);
        }

        return back()->with('success', 'Template updated successfully.');
    }

    /**
     * Preview the template with dummy data.
     */
    public function preview($id)
    {
        $template = Template::findOrFail($id);

        // Dummy Payload
        $invitation = (object) [
            'slug' => 'preview-template',
            'title' => 'The Wedding of Romeo & Juliet',
            'event_date' => now()->addMonth(),
            'location' => 'Grand Ballroom, Hotel Mulia, Jakarta',
            'guests' => [],
            'rsvps' => [],
        ];

        // Advanced Dummy Data if needed by specific templates
        $dummyData = [
            'invitation' => $invitation,
            'bride_name' => 'Juliet Capulet',
            'bride_parents' => 'Mr. Capulet & Mrs. Capulet',
            'bride_instagram' => 'juliet_capulet',
            'groom_name' => 'Romeo Montague',
            'groom_parents' => 'Mr. Montague & Mrs. Montague',
            'groom_instagram' => 'romeo_montague',
            'event_date' => now()->addMonth()->format('d F Y'),
            'event_time' => '19:00 WIB',
            'location_name' => 'Grand Ballroom, Hotel Mulia',
            'location_address' => 'Jl. Asia Afrika, Senayan, Jakarta',
            'location_map_link' => 'https://maps.google.com',
            'love_quote' => "And now these three remain: faith, hope and love. But the greatest of these is love.",
            'love_quote_source' => "1 Corinthians 13:13",
            'love_story' => [
                ['year' => '2020', 'title' => 'First Meet', 'story' => 'We met at a coffee shop...'],
                ['year' => '2022', 'title' => 'Engagement', 'story' => 'He proposed under the stars...']
            ],
            'events' => [
                [
                    'name' => 'Akad Nikah',
                    'date' => now()->addMonth()->format('d F Y'),
                    'time' => '08:00 - 10:00',
                    'location' => 'Masjid Al-Ikhlas'
                ],
                [
                    'name' => 'Resepsi',
                    'date' => now()->addMonth()->format('d F Y'),
                    'time' => '11:00 - 13:00',
                    'location' => 'Grand Ballroom'
                ]
            ],
            'gallery' => [
                'https://placehold.co/600x400?text=Gallery+1',
                'https://placehold.co/600x400?text=Gallery+2',
                'https://placehold.co/600x400?text=Gallery+3',
                'https://placehold.co/600x400?text=Gallery+4',
                'https://placehold.co/600x400?text=Gallery+5',
                'https://placehold.co/600x400?text=Gallery+6'
            ],
            'gift_bank_name' => 'BCA',
            'gift_account_number' => '1234567890',
            'gift_account_holder' => 'Romeo Montague',
        ];

        // This assumes the view exists at resources/views/templates/{folder_name}/layout.blade.php
        // Or if the template uses specific entry point. Standardizing on 'layout' or 'index'.
        $viewPath = 'templates.' . $template->folder_name . '.layout';

        if (!view()->exists($viewPath)) {
            return "Template view not found: resources/views/{$viewPath}.blade.php";
        }

        return view($viewPath, $dummyData);
    }
}

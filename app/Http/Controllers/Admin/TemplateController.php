<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Services\Template\TemplateRendererService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected TemplateRendererService $renderer;

    public function __construct(TemplateRendererService $renderer)
    {
        $this->renderer = $renderer;
    }

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

        // Standardized Contract Data (Matches TemplateDataContract)
        $dummyData = [
            'features' => [
                'cover' => true,
                'quote' => true,
                'couple' => true,
                'love_story' => true,
                'carousel' => true,
                'events' => true,
                'countdown' => true,
                'location' => true,
                'gallery' => true,
                'rsvp' => true,
                'gift' => true,
                'wishes' => true,
                'closing' => true,
            ],
            'meta' => [
                'title' => 'The Wedding of Romeo & Juliet',
                'description' => 'We appear to be getting married.',
                'song_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3', // Sample
                'event_date' => now()->addMonth()->format('d . m . Y'),
                'event_timestamp' => now()->addMonth()->timestamp,
                'cover_image' => 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&q=80&w=2000'
            ],
            'couple' => [
                'bride_name' => 'Juliet Capulet',
                'bride_photo' => 'https://images.unsplash.com/photo-1510419262272-91136b856b3b?w=500',
                'bride_parents' => 'Mr. Capulet & Mrs. Capulet',
                'bride_instagram' => 'juliet_capulet',
                'groom_name' => 'Romeo Montague',
                'groom_photo' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=500',
                'groom_parents' => 'Mr. Montague & Mrs. Montague',
                'groom_instagram' => 'romeo_montague',
            ],
            'quote' => [
                'text' => "And now these three remain: faith, hope and love. But the greatest of these is love.",
                'source' => "1 Corinthians 13:13"
            ],
            'love_story' => [
                ['year' => '2020', 'title' => 'First Meet', 'story' => 'We met at a coffee shop and fell in love instantly.'],
                ['year' => '2022', 'title' => 'Engagement', 'story' => 'He proposed under the stars. She said yes!']
            ],
            'gallery' => [
                'https://placehold.co/600x400?text=Gallery+1',
                'https://placehold.co/600x400?text=Gallery+2',
                'https://placehold.co/600x400?text=Gallery+3'
            ],
            'events' => [
                [
                    'title' => 'Akad Nikah',
                    'date_label' => now()->addMonth()->format('d F Y'),
                    'time_label' => '08:00 - 10:00',
                    'location_name' => 'Masjid Al-Ikhlas',
                    'address' => 'Jl. Kebahagiaan No. 1, Jakarta',
                    'map_url' => 'https://maps.google.com'
                ],
                [
                    'title' => 'Resepsi',
                    'date_label' => now()->addMonth()->format('d F Y'),
                    'time_label' => '11:00 - 13:00',
                    'location_name' => 'Grand Ballroom',
                    'address' => 'Hotel Mulia Senayan, Jakarta',
                    'map_url' => 'https://maps.google.com'
                ]
            ],
            'location' => [
                'name' => 'Grand Ballroom, Hotel Mulia',
                'address' => 'Jl. Asia Afrika, Senayan, Jakarta',
                'map_embed' => 'https://www.google.com/maps/embed?pb=...'
            ],
            'gift' => [
                'bank_name' => 'BCA',
                'account_number' => '1234567890',
                'account_holder' => 'Romeo Montague',
            ],
            'wishes' => [
                ['name' => 'Mercutio', 'message' => 'Best wishes!', 'initials' => 'M', 'time' => '2 mins ago'],
                ['name' => 'Benvolio', 'message' => 'Congrats!', 'initials' => 'B', 'time' => '1 hour ago'],
            ],
            'rsvp' => [
                'action' => '#',
            ]
        ];

        // Delegate rendering to the service
        // The service will:
        // 1. Validate the data
        // 2. Inject system metadata (assets, slug)
        // 3. Wrap it in ['data' => ...]
        // 4. Return the View
        return $this->renderer->render($template->slug, $dummyData, 'preview');
    }
}

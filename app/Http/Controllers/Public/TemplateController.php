<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    protected $renderer;

    public function __construct(\App\Services\Template\TemplateRendererService $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * Display templates listing with category filter and pagination
     */
    public function index(Request $request)
    {
        $category = $request->get('category', 'all');
        $perPage = 6; // Show 6 templates per load

        $query = Template::active()->orderBy('created_at', 'desc');

        if ($category !== 'all') {
            $query->where('category', $category);
        }

        // For AJAX requests (infinite scroll), return JSON
        if ($request->ajax()) {
            $templates = $query->paginate($perPage);

            return response()->json([
                'templates' => $templates->map(function ($template) {
                    return [
                        'id' => $template->id,
                        'name' => $template->name,
                        'slug' => $template->slug,
                        'category' => $template->category,
                        'preview_image' => $template->preview_image_path ? asset($template->preview_image_path) : null,
                        'is_premium' => $template->is_premium,
                        'url' => $template->slug ? route('public.templates.show', $template->slug) : route('public.templates.index'),
                    ];
                }),
                'hasMore' => $templates->hasMorePages(),
                'nextPage' => $templates->currentPage() + 1,
            ]);
        }

        // Initial page load - get first batch
        $templates = $query->paginate($perPage);
        $categories = Template::active()
            ->select('category')
            ->distinct()
            ->whereNotNull('category')
            ->pluck('category');

        return view('pages.public.templates.index', compact('templates', 'categories', 'category'));
    }

    /**
     * Show single template preview
     */
    public function show($slug)
    {
        // Mocking data for 'Gardenia Love' template preview
        // STRICT DATA CONTRACT (Blueprint Philosophy)

        $data = [];

        if ($slug === 'gardenia-love') {
            $data = [
                // 1. Meta & Global Config
                'meta' => [
                    'title' => 'The Wedding of Romeo & Juliet',
                    'description' => 'We are getting married!',
                    'cover_image' => 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&q=80&w=2000',
                    'song_url' => asset('assets/music/romantic.mp3'),
                    'event_date' => '01 . 01 . 2026',
                    'event_timestamp' => strtotime('2026-01-01 10:00:00'),
                ],

                // 2. Feature Flags (Strict Boolean)
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

                // 3. Section Data Groups
                'quote' => [
                    'text' => 'We loved with a love that was more than love.',
                    'source' => 'Edgar Allan Poe'
                ],

                'couple' => [
                    'bride_name' => 'Juliet Capulet',
                    'bride_photo' => 'https://images.unsplash.com/photo-1510419262272-91136b856b3b?w=500&auto=format&fit=crop&q=60',
                    'bride_parents' => 'Mr. & Mrs. Capulet',
                    'bride_instagram' => 'juliet.cap',
                    'groom_name' => 'Romeo Montague',
                    'groom_photo' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=500&auto=format&fit=crop&q=60',
                    'groom_parents' => 'Mr. & Mrs. Montague',
                    'groom_instagram' => 'romeo.mont',
                ],

                'events' => [
                    [
                        'title' => 'Akad Nikah',
                        'date_label' => 'Saturday, 01 Jan 2026',
                        'time_label' => '08:00 AM - 10:00 AM',
                        'location_name' => 'Masjid Agung Trans Studio',
                        'address' => 'Jl. Gatot Subroto No.289, Bandung',
                        'map_url' => 'https://maps.google.com'
                    ],
                    [
                        'title' => 'Wedding Reception',
                        'date_label' => 'Saturday, 01 Jan 2026',
                        'time_label' => '11:00 AM - 02:00 PM',
                        'location_name' => 'Trans Luxury Hotel',
                        'address' => 'Jl. Gatot Subroto No.289, Bandung',
                        'map_url' => 'https://maps.google.com'
                    ]
                ],

                'love_story' => [
                    [
                        'year' => '2020',
                        'title' => 'First Meeting',
                        'story' => 'We met at a coffee shop...'
                    ],
                    [
                        'year' => '2024',
                        'title' => 'She Said Yes',
                        'story' => 'Under the stars, he proposed...'
                    ]
                ],

                'gallery' => [
                    'https://images.unsplash.com/photo-1519225468359-2967ea01d529?w=500',
                    'https://images.unsplash.com/photo-1511285560982-1356c11d460e?w=500',
                    'https://images.unsplash.com/photo-1519741347686-c1e3aa4a7966?w=500',
                    'https://images.unsplash.com/photo-1520854221256-174518dad3c3?w=500'
                ],

                'rsvp' => [
                    'action' => route('public.home'),
                ],

                'gift' => [
                    'bank_name' => 'BCA',
                    'account_number' => '1234567890',
                    'account_holder' => 'Romeo & Juliet'
                ],

                'wishes' => [
                    ['name' => 'Sahabat 1', 'initials' => 'S1', 'time' => '10m ago', 'message' => 'Selamat menempuh hidup baru!'],
                    ['name' => 'Keluarga Besar', 'initials' => 'KB', 'time' => '1h ago', 'message' => 'Semoga bahagia selalu.'],
                ],

                'location' => [
                    'name' => 'The Trans Luxury Hotel',
                    'address' => 'Jl. Gatot Subroto No.289, Cibangkong, Kec. Batununggal, Kota Bandung, Jawa Barat 40273',
                    'map_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.8399332121584!2d107.63390237587574!3d-6.914744393084803!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e62c54ca5d51%3A0x6335123d54832439!2sThe%20Trans%20Luxury%20Hotel!5e0!3m2!1sen!2sid!4v1709800000000!5m2!1sen!2sid',
                ]
            ];

            return $this->renderer->render('gardenia-love', $data);
        }

        return view('pages.public.templates.show');
    }
}

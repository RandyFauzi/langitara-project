<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Services\Template\TemplateRendererService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

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

        // Create a dummy Invitation model with new database schema attributes
        $invitation = new \App\Models\Invitation([
            'groom_nickname' => 'Romeo',
            'bride_nickname' => 'Juliet',
            'groom_name' => 'Romeo Montague',
            'bride_name' => 'Juliet Capulet',
            'groom_father' => 'Mr. Montague',
            'groom_mother' => 'Mrs. Montague',
            'bride_father' => 'Mr. Capulet',
            'bride_mother' => 'Mrs. Capulet',
            'akad_date' => now()->addMonth()->setTime(8, 0),
            'akad_location' => 'Masjid Al-Ikhlas',
            'akad_address' => 'Jl. Kebahagiaan No. 1, Jakarta',
            'akad_map_link' => 'https://maps.google.com',
            'resepsi_date' => now()->addMonth()->setTime(11, 0),
            'resepsi_location' => 'Grand Ballroom Hotel Mulia',
            'resepsi_address' => 'Jl. Asia Afrika, Senayan, Jakarta',
            'resepsi_map_link' => 'https://maps.google.com',
            'cover_image' => 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&q=80&w=2000',
            'music_path' => 'music/sample.mp3', // Dummy path
            'quote_text' => "And now these three remain: faith, hope and love. But the greatest of these is love.",
            'quote_author' => "1 Corinthians 13:13",
            'gallery_photos' => [
                'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&q=80&w=600',
                'https://images.unsplash.com/photo-1510419262272-91136b856b3b?w=500',
                'https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=500'
            ],
            // Add other fields as necessary for the view
        ]);

        // Manually set photos if accessors/mutators act up (though array in constructor should work with Fillable)
        $invitation->groom_photo = 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=500';
        $invitation->bride_photo = 'https://images.unsplash.com/photo-1510419262272-91136b856b3b?w=500';

        // Prepare data for renderer
        // We pass 'invitation' key so it becomes $invitation in the view
        $templateData = [
            'invitation' => $invitation,
            'guest_name' => 'Tamu Undangan', // Default guest name for preview
        ];

        return $this->renderer->render($template->slug, $templateData, 'preview');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $template = Template::findOrFail($id);

        // Safety: Check if used
        if ($template->invitations()->count() > 0) {
            return back()->with('error', 'Cannot delete template because it is being used by invitations. Please delete the invitations first.');
        }

        // 1. Delete View Files
        $viewPath = resource_path('views/templates/' . $template->folder_name);
        if (File::exists($viewPath)) {
            File::deleteDirectory($viewPath);
        }

        // 2. Delete Asset Files
        $assetPath = public_path('assets/templates/' . $template->folder_name);
        if (File::exists($assetPath)) {
            File::deleteDirectory($assetPath);
        }

        // 3. Delete DB Record
        $template->delete();

        return back()->with('success', 'Template and all associated files deleted successfully.');
    }

    /**
     * Toggle the status of the specified resource.
     */
    public function toggleStatus($id)
    {
        $template = Template::findOrFail($id);
        $template->status = $template->status === 'active' ? 'inactive' : 'active';
        $template->save();

        return back()->with('success', 'Template status updated successfully.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Song::latest();

        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', "%{$request->search}%")
                ->orWhere('artist', 'like', "%{$request->search}%");
        }

        $songs = $query->paginate(10);
        return view('admin.songs.index', compact('songs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'artist' => 'nullable|string|max:150',
            'category' => 'nullable|string|max:50',
            'file' => 'required|file|mimes:mp3,mpeg|max:10240',
            'min_package_level' => 'required|in:free,basic,premium,exclusive',
            'status' => 'required|in:active,inactive',
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . preg_replace('/[^a-z0-9.]/i', '_', $file->getClientOriginalName());

        // Define path based on package level (optional structure, aiming for cleaner organization)
        $directory = 'assets/music/' . $request->min_package_level;
        $path = public_path($directory);

        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        $file->move($path, $fileName);
        $filePath = $directory . '/' . $fileName;

        Song::create([
            'title' => $request->title,
            'artist' => $request->artist,
            'category' => $request->category,
            'file_path' => $filePath,
            'min_package_level' => $request->min_package_level,
            'status' => $request->status,
            'is_premium' => $request->min_package_level !== 'free',
        ]);

        return redirect()->back()->with('success', 'Lagu berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $song = Song::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:150',
            'artist' => 'nullable|string|max:150',
            'category' => 'nullable|string|max:50',
            'file' => 'nullable|file|mimes:mp3,mpeg|max:10240',
            'min_package_level' => 'required|in:free,basic,premium,exclusive',
            'status' => 'required|in:active,inactive',
        ]);

        // Handle File Replacement
        if ($request->hasFile('file')) {
            // Delete old file
            if (File::exists(public_path($song->file_path))) {
                File::delete(public_path($song->file_path));
            }

            $file = $request->file('file');
            $fileName = time() . '_' . preg_replace('/[^a-z0-9.]/i', '_', $file->getClientOriginalName());
            $directory = 'assets/music/' . $request->min_package_level;
            $path = public_path($directory);

            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            $file->move($path, $fileName);
            $song->file_path = $directory . '/' . $fileName;
        }

        $song->update([
            'title' => $request->title,
            'artist' => $request->artist,
            'category' => $request->category,
            'min_package_level' => $request->min_package_level,
            'status' => $request->status,
            'is_premium' => $request->min_package_level !== 'free',
        ]);

        return redirect()->back()->with('success', 'Lagu berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $song = Song::findOrFail($id);

        if (File::exists(public_path($song->file_path))) {
            File::delete(public_path($song->file_path));
        }

        $song->delete();
        return redirect()->back()->with('success', 'Lagu berhasil dihapus.');
    }
}

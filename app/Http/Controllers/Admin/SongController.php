<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

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
            'file' => [
                'required',
                'file',
                'max:10240', // 10MB
                'extensions:mp3,wav,ogg', // Strict extension check
            ],
            'min_package_level' => 'required|in:free,basic,premium,exclusive',
            'status' => 'required|in:active,inactive',
        ]);

        $file = $request->file('file');

        // Generate unique filename: timestamp_uuid.extension
        $extension = $file->getClientOriginalExtension();
        $fileName = time() . '_' . Str::uuid() . '.' . $extension;

        // Clean relative path: assets/music/{package}/filename.mp3
        $relativeDir = 'assets/music/' . $request->min_package_level;
        $absolutePath = public_path($relativeDir);

        if (!File::exists($absolutePath)) {
            File::makeDirectory($absolutePath, 0755, true);
        }

        $file->move($absolutePath, $fileName);

        // Store RELATIVE path for portability
        $dbPath = $relativeDir . '/' . $fileName;

        Song::create([
            'title' => $request->title,
            'artist' => $request->artist,
            'category' => $request->category,
            'file_path' => $dbPath,
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
            'file' => [
                'nullable',
                'file',
                'max:10240',
                'extensions:mp3,wav,ogg',
            ],
            'min_package_level' => 'required|in:free,basic,premium,exclusive',
            'status' => 'required|in:active,inactive',
        ]);

        // Handle File Replacement
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if (File::exists(public_path($song->file_path))) {
                File::delete(public_path($song->file_path));
            }

            $file = $request->file('file');

            // Generate unique filename
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '_' . Str::uuid() . '.' . $extension;

            // Determine new path (might change if package level changed)
            $targetPackage = $request->min_package_level; // Move to new package folder if changed? logic-wise yes.
            $relativeDir = 'assets/music/' . $targetPackage;
            $absolutePath = public_path($relativeDir);

            if (!File::exists($absolutePath)) {
                File::makeDirectory($absolutePath, 0755, true);
            }

            $file->move($absolutePath, $fileName);
            $song->file_path = $relativeDir . '/' . $fileName;
        }
        // If package level changes but NO file upload, we *could* move the file, 
        // but for now keeping it in original folder is safer unless we strictly want to enforce folder structure.
        // Let's keep it simple: only physical move on re-upload.

        $song->update([
            'title' => $request->title,
            'artist' => $request->artist,
            'category' => $request->category,
            'min_package_level' => $request->min_package_level,
            'status' => $request->status,
            'is_premium' => $request->min_package_level !== 'free',
            // file_path is already updated above if file was present
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

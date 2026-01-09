<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvitationMediaController extends Controller
{
    /**
     * Upload an image file for the invitation editor.
     * POST /admin/editor/media/upload
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:5120', // Max 5MB
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('invitations/uploads', 'public');
            return response()->json([
                'url' => Storage::url($path),
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}

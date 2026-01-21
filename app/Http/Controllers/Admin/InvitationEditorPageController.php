<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use Illuminate\Http\Request;

class InvitationEditorPageController extends Controller
{
    /**
     * Render the Editor Interface (UI Shell).
     * 
     * This controller ONLY mounts the view. 
     * Data loading is handled by the Editor API via JS.
     */
    public function show(Invitation $invitation)
    {
        // Redirect to the new JSON-based Editor
        return redirect()->route('editor.edit', $invitation->slug);
    }
}

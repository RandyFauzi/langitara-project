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
        // Pass essential IDs for JS mounting
        return view('admin.invitations.editor', [
            'invitation' => $invitation,
            'invitationId' => $invitation->id,
            'invitationSlug' => $invitation->slug,
        ]);
    }
}

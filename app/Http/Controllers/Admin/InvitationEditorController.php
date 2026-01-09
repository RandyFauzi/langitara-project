<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Services\Invitation\EditorStateValidator;
use App\Services\Invitation\InvitationEditorService;
use App\Services\Template\TemplateRendererService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InvitationEditorController extends Controller
{
    protected $editorService;
    protected $validator;
    protected $renderer;

    public function __construct(
        InvitationEditorService $editorService,
        EditorStateValidator $validator,
        TemplateRendererService $renderer
    ) {
        $this->editorService = $editorService;
        $this->validator = $validator;
        $this->renderer = $renderer;
    }

    /**
     * GET /admin/editor/invitations/{invitation}
     * Load the editor state.
     */
    public function show($id, Request $request)
    {
        $invitation = Invitation::findOrFail($id);

        // API ONLY: Return JSON state
        $data = $this->editorService->load($invitation);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * POST /admin/editor/invitations/{invitation}
     * Save the editor state.
     */
    public function update(Request $request, Invitation $invitation)
    {
        // 1. Validate
        $validatedData = $this->validator->validate($request->all());

        // 2. Save
        $this->editorService->save($invitation, $validatedData);

        return response()->json([
            'message' => 'Invitation updated successfully'
        ]);
    }

    /**
     * POST /admin/editor/invitations/{invitation}/preview
     * Preview the editor state without saving.
     */
    public function preview(Request $request, Invitation $invitation)
    {
        // 1. Validate
        $validatedData = $this->validator->validate($request->all());

        // 2. Build Preview Data (Contract)
        $contractData = $this->editorService->buildPreviewData($invitation, $validatedData);

        // 3. Render
        // Mode 'preview' is used to enable debug tools or specific preview logic in renderer
        return $this->renderer->render($invitation->template->slug, $contractData, 'preview');
    }
}

<?php

namespace App\Services\Template;

use App\Exceptions\Template\TemplateNotFoundException;
use App\Exceptions\Template\TemplateRenderException;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\View\View;

class TemplateRendererService
{
    protected ViewFactory $viewFactory;

    public function __construct(ViewFactory $viewFactory)
    {
        $this->viewFactory = $viewFactory;
    }

    /**
     * Render the specified template with the provided data.
     *
     * @param string $templateSlug The slug of the template (e.g., 'gardenia-love').
     * @param array $templateData The data array adhering to TemplateDataContract.
     * @param string $mode The render mode ('preview' or 'live').
     * @return \Illuminate\View\View
     * @throws TemplateNotFoundException
     * @throws TemplateRenderException
     */
    public function render(string $templateSlug, array $templateData, string $mode = 'preview'): View
    {
        // 1. Resolve View Path
        $viewPath = "templates.{$templateSlug}.index";

        // 2. Validate Template Existence
        if (!$this->viewFactory->exists($viewPath)) {
            throw new TemplateNotFoundException("Template with slug '{$templateSlug}' not found at path: {$viewPath}");
        }

        // 3. Validate Data Structure (Basic contract check)
        if (!isset($templateData['features']) || !is_array($templateData['features'])) {
            throw new TemplateRenderException("Invalid template data: 'features' key is missing or invalid.");
        }

        // 4. Inject Meta (Safe Mode Injection)
        // We inject system-level metadata strictly for asset resolution.
        // This does not modify the user's data payload structure but augments it for the renderer.
        $templateData['__template'] = [
            'slug' => $templateSlug,
            'asset_path' => url("templates/{$templateSlug}/assets"),
        ];

        // 5. Render
        try {
            // STRICT MODE: Enforce $data contract validation
            // We ONLY pass 'data' to the view. No unwrapped variables allowed.
            return $this->viewFactory->make($viewPath, ['data' => $templateData]);
        } catch (\Exception $e) {
            throw new TemplateRenderException("Failed to render template '{$templateSlug}': " . $e->getMessage(), 0, $e);
        }
    }
}

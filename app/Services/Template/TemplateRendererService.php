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

        // 3. Validate Data Structure (Optional / Loose check now)
        // if (!isset($templateData['features'])) { ... } 

        // 4. Inject Meta (Safe Mode Injection)
        $templateData['__template'] = [
            'slug' => $templateSlug,
            'asset_path' => url("templates/{$templateSlug}/assets"),
        ];

        // 5. Render
        try {
            // UNWRAPPED MODE: Pass $templateData keys as root variables to the view
            // This allows $invitation, $guest_name, etc. to be accessed directly.
            return $this->viewFactory->make($viewPath, $templateData);
        } catch (\Exception $e) {
            throw new TemplateRenderException("Failed to render template '{$templateSlug}': " . $e->getMessage(), 0, $e);
        }
    }
}

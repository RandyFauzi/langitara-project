<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TemplateAssetController extends Controller
{
    /**
     * Serve a specific asset for a template.
     *
     * @param string $slug Template slug
     * @param string $type Asset type (css, js, images, icons)
     * @param string $file Filename
     * @return BinaryFileResponse
     */
    public function show(string $slug, string $type, string $file)
    {
        // 1. Validate Asset Type
        if (!in_array($type, ['css', 'js', 'images', 'icons', 'assets'])) {
            abort(404);
        }

        // 2. Sanitize Inputs (Prevent Directory Traversal)
        $slug = basename($slug);
        $file = basename($file);

        // 3. Construct Path
        // Path: resources/views/templates/{slug}/{type}/{file}
        // Note: Removed extra 'assets/' segment to match actual structure
        $path = resource_path("views/templates/{$slug}/{$type}/{$file}");

        // 4. Check Existence
        if (!File::exists($path)) {
            abort(404);
        }

        // 5. Determine Response Type
        $mimeType = File::mimeType($path);

        // Manual override for CSS/JS if detection fails or is generic
        if ($type === 'css') {
            $mimeType = 'text/css';
        } elseif ($type === 'js') {
            $mimeType = 'application/javascript';
        }

        // 6. Return File
        $headers = [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'public, max-age=31536000', // Cache for 1 year
        ];

        return response()->file($path, $headers);
    }
}

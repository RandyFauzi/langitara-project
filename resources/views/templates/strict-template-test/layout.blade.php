<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['meta']['title'] ?? 'Invitation' }}</title>
    <meta name="description" content="{{ $data['meta']['description'] ?? '' }}">
    
    {{-- Fonts & Styles --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ $data['__template']['asset_path'] }}/css/style.css">
</head>
<body class="antialiased text-gray-800 bg-white">
    
    {{-- Main Content Injection --}}
    @yield('content')

    <script src="{{ $data['__template']['asset_path'] }}/js/template.js" defer></script>

</body>
</html>
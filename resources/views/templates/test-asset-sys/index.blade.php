@extends('templates.test-asset-sys.layout')

@section('content')

    {{-- 
      Template: test-asset-sys
      Philosophy: Template = Blueprint. Logic free.
    --}}

    @if($data['features']['cover'] ?? false)
        @include('templates.test-asset-sys.sections.cover')
    @endif

    @if($data['features']['quote'] ?? false)
        @include('templates.test-asset-sys.sections.quote')
    @endif

    @if($data['features']['couple'] ?? false)
        @include('templates.test-asset-sys.sections.couple')
    @endif

    @if($data['features']['love_story'] ?? false)
        @include('templates.test-asset-sys.sections.love_story')
    @endif

    @if($data['features']['events'] ?? false)
        @include('templates.test-asset-sys.sections.events')
    @endif

    @if($data['features']['countdown'] ?? false)
        @include('templates.test-asset-sys.sections.countdown')
    @endif

    @if($data['features']['location'] ?? false)
        @include('templates.test-asset-sys.sections.location')
    @endif

    @if($data['features']['gallery'] ?? false)
        @include('templates.test-asset-sys.sections.gallery')
    @endif

    @if($data['features']['rsvp'] ?? false)
        @include('templates.test-asset-sys.sections.rsvp')
    @endif

    @if($data['features']['gift'] ?? false)
        @include('templates.test-asset-sys.sections.gift')
    @endif

    @if($data['features']['wishes'] ?? false)
        @include('templates.test-asset-sys.sections.wishes')
    @endif

    @if($data['features']['closing'] ?? false)
        @include('templates.test-asset-sys.sections.closing')
    @endif

@endsection
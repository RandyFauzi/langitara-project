@extends('templates.gardenia-love.layout')

@section('content')
    <!-- Sections -->
    @if($data['features']['cover'] ?? true)
        @include('templates.gardenia-love.sections.cover')
    @endif

    @if($data['features']['quote'] ?? false)
        @include('templates.gardenia-love.sections.quote')
    @endif

    @if($data['features']['couple'] ?? true)
        @include('templates.gardenia-love.sections.couple')
    @endif

    @if($data['features']['love_story'] ?? false)
        @include('templates.gardenia-love.sections.love-story')
    @endif

    @if($data['features']['carousel'] ?? false)
        @include('templates.gardenia-love.sections.carousel')
    @endif

    @if($data['features']['events'] ?? true)
        @include('templates.gardenia-love.sections.events')
    @endif

    @if($data['features']['countdown'] ?? false)
        @include('templates.gardenia-love.sections.countdown')
    @endif

    @if($data['features']['location'] ?? true)
        @include('templates.gardenia-love.sections.location')
    @endif

    @if($data['features']['gallery'] ?? false)
        @include('templates.gardenia-love.sections.gallery')
    @endif

    @if($data['features']['rsvp'] ?? true)
        @include('templates.gardenia-love.sections.rsvp')
    @endif

    @if($data['features']['gift'] ?? false)
        @include('templates.gardenia-love.sections.gift')
    @endif

    @if($data['features']['wishes'] ?? false)
        @include('templates.gardenia-love.sections.wishes')
    @endif

    @if($data['features']['closing'] ?? true)
        @include('templates.gardenia-love.sections.closing')
    @endif
@endsection
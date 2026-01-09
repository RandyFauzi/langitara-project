@extends('templates.strict-template-test.layout')

@section('content')

    {{-- 
      Template: strict-template-test
      Philosophy: Template = Blueprint. Logic free.
    --}}

    @if($data['features']['cover'] ?? false)
        @include('templates.strict-template-test.sections.cover')
    @endif

    @if($data['features']['quote'] ?? false)
        @include('templates.strict-template-test.sections.quote')
    @endif

    @if($data['features']['couple'] ?? false)
        @include('templates.strict-template-test.sections.couple')
    @endif

    @if($data['features']['love_story'] ?? false)
        @include('templates.strict-template-test.sections.love_story')
    @endif

    @if($data['features']['events'] ?? false)
        @include('templates.strict-template-test.sections.events')
    @endif

    @if($data['features']['countdown'] ?? false)
        @include('templates.strict-template-test.sections.countdown')
    @endif

    @if($data['features']['location'] ?? false)
        @include('templates.strict-template-test.sections.location')
    @endif

    @if($data['features']['gallery'] ?? false)
        @include('templates.strict-template-test.sections.gallery')
    @endif

    @if($data['features']['rsvp'] ?? false)
        @include('templates.strict-template-test.sections.rsvp')
    @endif

    @if($data['features']['gift'] ?? false)
        @include('templates.strict-template-test.sections.gift')
    @endif

    @if($data['features']['wishes'] ?? false)
        @include('templates.strict-template-test.sections.wishes')
    @endif

    @if($data['features']['closing'] ?? false)
        @include('templates.strict-template-test.sections.closing')
    @endif

@endsection
@extends('layouts.public')

@section('content')
    @include('pages.public.partials.hero')
    @include('pages.public.partials.highlights')
    @include('pages.public.partials.about')
    @include('pages.public.partials.templates')
    @include('pages.public.partials.portfolio')
    @include('pages.public.partials.how-it-works')
    @include('pages.public.partials.features')
    @include('pages.public.partials.pricing')
    @include('pages.public.partials.testimonials')
    @include('pages.public.partials.faq')
    @include('pages.public.partials.cta')

    <!-- Promo Popup -->
    <x-promo-popup :promo="$activePromo ?? null" />
@endsection
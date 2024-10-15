@extends('layouts.blank', [
    'title' => $profile->name . ' (@' . $acct . ') - Pixelfed',
    'ogTitle' => $profile->name . ' (@' . $acct . ')',
    'ogType' => 'profile'
])

@php
$acct = $profile->username . '@' . config('pixelfed.domain.app');
$metaDescription = \App\Services\AccountService::getMetaDescription($profile->id);
@endphp

@section('content')
@if (session('error'))
        <div class="alert alert-danger text-center font-weight-bold mb-0">
                {{ session('error') }}
        </div>
@endif

<profile-carousel profile-id="{{$profile->id}}" />

@endsection

@push('meta')<meta name="description" content="{{$metaDescription}}">
    <meta property="og:description" content="{{$metaDescription}}">
    <meta property="og:image" content="{{$profile->avatarUrl()}}">
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">
    <meta property="twitter:card" content="summary">
    <meta property="profile:username" content="{{$acct}}">
    <link href="{{$profile->permalink('.atom')}}" rel="alternate" title="{{$profile->username}} on Pixelfed" type="application/atom+xml">
    <link href="{{$profile->permalink()}}" rel="alternate" type="application/activity+json">
    <meta name="application-name" content="Pixelfed">
    <meta name="generator" content="pixelfed">
    <link href="{{ mix('css/profile.css') }}" rel="stylesheet">
    @if($profile->website)<link href="{{$profile->website}}" rel="me" type="text/html">
@endif
    @if(false == $settings['crawlable'] || $profile->remote_url)<meta name="robots" content="noindex, nofollow">@endif
@endpush

@push('scripts')<script type="text/javascript" src="{{ mix('js/profile.js') }}"></script>
<script type="text/javascript" defer>App.boot();</script>
@endpush

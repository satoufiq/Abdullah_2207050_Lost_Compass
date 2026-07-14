@extends('layouts.app')

@section('title', 'Lore Archives | The Lost Compass')
@section('meta_description', 'Discover the lore, legends, and history of the Pirate universe.')
@section('body_class', 'trivia-page')
@section('use_base_css', true)

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Cinzel+Decorative:wght@700&family=Lora:ital,wght@0,400;0,600;1,400&family=Pirata+One&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/trivia.css') }}?v={{ time() }}">
@endsection

@section('content')
@include('partials.loading', ['message' => 'Consulting the Archives...'])
@include('partials.nav')

<section class="trivia-hero">
    <div class="trivia-hero__bg">
        <!-- Using a default asset image, we can reuse tavern or map background -->
        <img src="{{ asset('assets/images/home/hero-bg.jpg') }}" alt="" class="trivia-hero__bg-img">
        <div class="trivia-hero__bg-overlay"></div>
    </div>
    
    <div class="trivia-hero__content">
        <h1 class="trivia-title">The Lore Archives</h1>
        <p class="trivia-subtitle">Tales and truths from across the Seven Seas</p>
    </div>
</section>

<div class="trivia-container">
    <div class="trivia-layout">
        <!-- Sidebar Index -->
        <aside class="trivia-sidebar">
            <h2 class="sidebar-title">Index of Legends</h2>
            <ul class="topic-list" id="topic-list">
                <!-- Topics populated by JS -->
            </ul>
        </aside>

        <!-- Main Content Area (The Journal) -->
        <main class="trivia-main">
            <div class="journal-card" id="journal-card">
                <div class="journal-initial" id="journal-initial">
                    <img src="{{ asset('assets/images/home/compass-rose.png') }}" alt="Compass" class="journal-compass">
                    <p>Select a tale from the archives to unveil its secrets.</p>
                </div>
                
                <div class="journal-content hidden" id="journal-content">
                    <div class="journal-header">
                        <img src="" alt="" id="topic-image" class="topic-image hidden">
                        <h2 id="topic-title" class="topic-title"></h2>
                    </div>
                    <div id="topic-text" class="topic-text">
                        <!-- API Content goes here -->
                    </div>
                    <div class="journal-footer">
                        <p>Source: <a href="#" id="wiki-link" target="_blank" rel="noopener noreferrer">Pirates of the Caribbean Wiki</a></p>
                    </div>
                </div>

                <div class="journal-loading hidden" id="journal-loading">
                    <div class="spinner"></div>
                    <p>Dusting off the tomes...</p>
                </div>
            </div>
        </main>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('js/trivia.js') }}"></script>
@endsection

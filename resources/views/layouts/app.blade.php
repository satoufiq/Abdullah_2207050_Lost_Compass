<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'The Lost Compass - An Interactive Pirates Universe Experience')">
    <title>@yield('title', 'The Lost Compass')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pirata+One&family=Playfair+Display:wght@400;600;700;800&family=Cormorant+Garamond:wght@300;400;500;600;700&family=Cinzel:wght@400;600;700;800&family=Cinzel+Decorative:wght@700&family=Lora:wght@400;500;600;700&family=Merriweather:wght@400;700&family=IM+Fell+English+SC&display=swap" rel="stylesheet">

    <!-- Base Stylesheet -->
    @hasSection('use_base_css')
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    @endif

    <!-- Page-specific Styles -->
    @yield('styles')
</head>
<body @hasSection('body_class') class="@yield('body_class')" @endif @hasSection('body_attributes') @yield('body_attributes') @endif>

    @yield('content')

    <!-- Base Script -->
    @hasSection('use_base_js')
        <script src="{{ asset('js/main.js') }}"></script>
    @endif

    <!-- Page-specific Scripts -->
    @yield('scripts')

</body>
</html>

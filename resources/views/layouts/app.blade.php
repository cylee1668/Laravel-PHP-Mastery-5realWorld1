<!DOCTYPE html>
<html>

<head>
    <title>Lara 10 Task List App</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    @yield('styles')
</head>


<body class="container mx-auto mt-10 mb-10 max-w-lg">
    
    <h1 class="mb-4 text-2xl">@yield('title')</h1>
    <div>
        @if (session()->has('success'))
            <div>{{ session('success') }}</div>
        @endif
        @yield('content')
        
    </div>
</body>

</html>
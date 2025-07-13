{{-- resources/views/layouts/app-sidebar.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HydroSync</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased min-h-screen">

<div class="min-h-screen flex">
    @include('layouts.sidebar') {{-- This is the actual sidebar --}}

    <main class="flex-1 p-6 overflow-auto">
        @yield('content')
    </main>
</div>

</body>
</html>

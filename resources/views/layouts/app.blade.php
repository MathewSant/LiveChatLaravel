<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    
    {{-- Carrega tanto CSS quanto JS da pasta resources através do Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js']) 
    @livewireStyles
</head>
<body class="bg-gray-100 p-6">
    <div class="container mx-auto">
        {{ $slot }}
    </div>

    @livewireScripts
</body>
</html>

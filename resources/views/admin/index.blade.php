@extends('layouts.base')

@section('title', 'Organización de Mesas en el Evento')

@section('content')

<body>
    <nav class="navbar">
        <div class="logo">
          <img src="{{ asset('images/logo.png') }}" alt="Logo"> 
        </div>
        <ul class="nav-links">
            <li id="countdown-container" class="flex-grow-1 text-center">
                @if ($fechaHoraEvento)
                   Faltan: <span id="countdown"></span>
                @else
                    <p>Fecha y hora aún no ingresadas</p>
                @endif
            </li>
            
            <button type="button" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#configModal">
                <i class="bi bi-list-stars"></i> Lista de Invitados
            </button>
            <button type="button" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#configModal">
                <i class="bi bi-gear"></i> Configuración
            </button>
        </ul>

        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>

    <div id="salon1" class="salon">
        <div id="mesasContainer">
        <div id="mainTable" class="mesa mesa-principal" data-id="{{ $mesaPrincipal->id }}" style="left: {{ $mesaPrincipal->x }}px; top: {{ $mesaPrincipal->y }}px;">
            {{ $mesaPrincipal->titulo }}
        </div>
    
        @foreach ($mesas as $mesa)
            <div class="mesa" data-id="{{ $mesa->id }}" style="left: {{ $mesa->x }}px; top: {{ $mesa->y }}px;">
                {{ $mesa->titulo }}
            </div>
        @endforeach
    </div>
    </div>
    
    

    <!-- Modal -->
    <div class="modal fade" id="configModal" tabindex="-1" aria-labelledby="configModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="configModalLabel">Configuraciones del Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('admin.config', ['config' => $config])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    
    @if ($fechaHoraEvento)
        <script>
           document.addEventListener('DOMContentLoaded', function() {
    var eventDate = new Date("{{ $fechaHoraEvento }}").getTime();
    var countdownElement = document.getElementById('countdown');

    function updateCountdown() {
        var now = new Date().getTime();
        var distance = eventDate - now;

        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        countdownElement.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;

        if (distance < 0) {
            clearInterval(x);
            countdownElement.innerHTML = "¡El evento ha comenzado!";
            countdownElement.classList.remove('pulse');
        } else {
            countdownElement.classList.add('pulse');
        }
    }

    var x = setInterval(updateCountdown, 1000);
});

        </script>
    @endif

@endsection

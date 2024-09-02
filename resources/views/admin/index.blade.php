<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Organización de Mesas en el Evento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar">
        <div class="logo">
            {{-- <img src="{{ asset('images/logo.png') }}" alt="Logo"> --}}
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

    <div id="mainTable" class="main-table">
        Mesa Principal
    </div>

    <div class="tables-container d-flex">
        <div id="leftList" class="list flex-grow-1">
            @foreach ($mesas->where('lista', 'izquierda') as $mesa)
                <div class="item" data-id="{{ $mesa->id }}">
                    {{ $mesa->titulo }}
                    <div class="chair-left"></div>
                    <div class="chair-right"></div>
                </div>
            @endforeach
        </div>
        <div id="rightList" class="list flex-grow-1">
            @foreach ($mesas->where('lista', 'derecha') as $mesa)
                <div class="item" data-id="{{ $mesa->id }}">
                    {{ $mesa->titulo }}
                    <div class="chair-left"></div>
                    <div class="chair-right"></div>
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

    <!-- jsDelivr :: Sortable :: Latest -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>

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

</body>

</html>

@extends('layouts.base')

@section('title', 'Organización de Mesas en el Evento')

@section('content')

    <body>
        <nav class="navbar">
            <div class="countdown-container flex-grow-1 text-center">
                @if ($fechaHoraEvento)
                    Faltan: <span id="countdown"></span>
                @else
                    <p>Fecha y hora aún no ingresadas</p>
                @endif
            </div>

            <div class="nav-buttons">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#invitadosModal">
                    Gestionar Invitados
                </button>
                <button type="button" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#configModal">
                    <i class="bi bi-gear"></i> Configuración
                </button>
            </div>

            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </nav>

        <div id="salon1" class="salon">
            <div id="mesasContainer">
                <!-- Mesa principal -->
                <div id="mainTable" class="mesa mesa-principal" data-id="{{ $mesaPrincipal->id }}"
                    style="left: {{ $mesaPrincipal->x }}px; top: {{ $mesaPrincipal->y }}px;"
                    onclick="mostrarInfoMesa(event, {{ $mesaPrincipal->id }})">
                    {{ $mesaPrincipal->titulo }}

                    <!-- Contenedor de fotos de invitados para la mesa principal -->
                    <div class="invitados-fotos">
                        @foreach ($mesaPrincipal->invitados as $invitado)
                            @if ($invitado->confirmacion !== 'rechazado')
                                <!-- No muestra invitados rechazados -->
                                <img src="{{ asset('images/' . $invitado->foto) }}"
                                    class="invitado-foto 
                                        @if ($invitado->confirmacion == 'aceptado') confirmado 
                                        @elseif($invitado->confirmacion == 'en espera') en-espera @endif"
                                    alt="{{ $invitado->nombre }}">
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Otras mesas -->
                @foreach ($mesas as $mesa)
                    <div class="mesa" data-id="{{ $mesa->id }}"
                        style="left: {{ $mesa->x }}px; top: {{ $mesa->y }}px;"
                        onclick="mostrarInfoMesa(event, {{ $mesa->id }})">
                        {{ $mesa->titulo }}

                        <!-- Contenedor de fotos de invitados para cada mesa -->
                        <div class="invitados-fotos">
                            @foreach ($mesa->invitados as $invitado)
                                @if ($invitado->confirmacion !== 'rechazado')
                                    <!-- No muestra invitados rechazados -->
                                    <img src="{{ asset('images/' . $invitado->foto) }}"
                                        class="invitado-foto 
                                            @if ($invitado->confirmacion == 'aceptado') confirmado 
                                            @elseif($invitado->confirmacion == 'en espera') en-espera @endif"
                                        alt="{{ $invitado->nombre }}">
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>


        <!-- Información de la mesa (oculto inicialmente) -->
        <div id="infoMesa" class="info-mesa" style="display:none;">
            <button id="cerrarInfoMesa" class="cerrar-btn">&times;</button> <!-- Botón con la X -->
            <p id="nombresInvitados"></p>
            <p id="sillasRestantes"></p>
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


        <!-- Modal para gestionar invitados -->
        <div class="modal fade" id="invitadosModal" tabindex="-1" aria-labelledby="invitadosModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center justify-content-between">
                        <h5 class="modal-title" id="invitadosModalLabel">Gestionar Invitados</h5>
                        <!-- Botón de cerrar -->
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <!-- Contenedores de estadísticas -->
                        <div class="d-flex align-items-center ms-3">
                            <div class="me-2">
                                <span class="badge bg-warning" id="en-espera-count">En Espera: {{ $enEsperaCount }}</span>
                            </div>
                            <div class="me-2">
                                <span class="badge bg-danger" id="rechazados-count">Rechazados:
                                    {{ $rechazadosCount }}</span>
                            </div>
                            <div class="me-2">
                                <span class="badge bg-success" id="confirmados-count">Confirmados:
                                    {{ $confirmadosCount }}</span>
                            </div>
                            <span class="badge bg-secondary d-flex align-items-center" id="sin-mesa-count">
                                <i class="fas fa-exclamation-triangle me-1"></i> Sin Mesa: {{ $sinMesaCount }}
                            </span>
                        </div>
                    </div>
                    <div class="modal-body">
                        @include('admin.invitados', ['mesas' => $mesas1])
                        <!-- Buscador y botón Ver lista completa -->
                        <div class="d-flex justify-content-end align-items-center mb-3">
                            <input type="text" id="modalSearchInput" class="form-control form-control-sm" placeholder="Buscar...">
                            <a href="{{ route('listaInvitados') }}" class="btn btn-info">Ver lista completa</a>
                        </div>
                        <!-- Tabla de Invitados -->
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre Completo</th>
                                        <th>Edad</th>
                                        <th>Sexo</th>
                                        <th>Mesa</th>
                                        <th>Menú</th>
                                        <th>Confirmación</th>
                                        <th>Acompañantes</th>
                                        <th>Código</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="listaInvitados">
                                    @foreach ($invitados as $invitado)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $invitado->nombre }} {{ $invitado->apellido }}</td>
                                            <td>{{ ucfirst($invitado->edad) }}</td>
                                            <td>{{ $invitado->sexo }}</td>
                                            <td>{{ $invitado->mesa ? 'Mesa ' . $invitado->mesa->numero_mesa : 'Sin Mesa' }}
                                            </td>
                                            <td>{{ $invitado->menu }}</td>
                                            <td>
                                                @if ($invitado->confirmacion == 'aceptado')
                                                    <span
                                                        class="badge bg-success">{{ ucfirst($invitado->confirmacion) }}</span>
                                                @elseif ($invitado->confirmacion == 'rechazado')
                                                    <span
                                                        class="badge bg-danger">{{ ucfirst($invitado->confirmacion) }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-warning">{{ ucfirst($invitado->confirmacion) }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $invitado->cant_acompanantes ?? 'N/A' }}</td>
                                            <td>{{ $invitado->codigo }}</td>
                                            <td>
                                                <!-- Botón Editar -->
                                                <button class="btn btn-primary btn-sm"
                                                    onclick="editarInvitado({{ $invitado->id }})">Editar</button>
                                                <!-- Botón Eliminar -->
                                                <button class="btn btn-danger btn-sm"
                                                    onclick="eliminarInvitado({{ $invitado->id }})">Eliminar</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Submodal para edición de invitados -->
        <div class="modal fade" id="submodal" tabindex="-1" aria-labelledby="submodalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="submodalLabel">Editar Invitado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if (isset($invitado) && $invitado)
                            @include('admin.edit_invitado', ['invitado' => $invitado])
                        @else
                            <p>No hay invitados disponibles para editar.</p>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>



        <script>
            async function editarInvitado(id) {
                // Mostrar el submodal inmediatamente con un indicador de carga
                const submodal = new bootstrap.Modal(document.getElementById('submodal'));
                const submodalBody = document.querySelector('#submodal .modal-body');

                // Mostrar el submodal de inmediato con un spinner de carga

                submodal.show();

                try {
                    // Realizar la petición fetch para obtener el formulario de edición
                    const response = await fetch(`/invitados/${id}/edit`);
                    const html = await response.text();

                    // Reemplazar el contenido del submodal con el formulario de edición
                    submodalBody.innerHTML = html;

                    // Configurar la acción del formulario con el ID del invitado
                    document.getElementById('formInvitadoEdit').action = `/invitados/${id}`;

                } catch (error) {
                    console.error('Error al cargar el formulario de edición:', error);
                    // Mostrar un mensaje de error en caso de que la carga falle
                    submodalBody.innerHTML =
                        '<p class="text-danger">Error al cargar los datos del invitado. Intenta nuevamente.</p>';
                }
            }

            function eliminarInvitado(id) {
                if (confirm('¿Estás seguro de que deseas eliminar este invitado?')) {
                    $.ajax({
                        url: `/invitados/${id}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            alert(response.success);
                            recargarListaInvitados(); // Recargar solo la lista de invitados
                        }
                    });
                }
            }
        </script>

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

        <script>
            // Escuchar el evento cuando el modal se cierra completamente
            $('#invitadosModal').on('hidden.bs.modal', function() {
                // Recargar la página completa
                location.reload();
            });
        </script>
        <script>
            document.getElementById('cerrarInfoMesa').addEventListener('click', function() {
                document.getElementById('infoMesa').style.display = 'none';
            });

            function mostrarInfoMesa(event, mesaId) {
                const infoMesa = document.getElementById('infoMesa');

                // Obtener la mesa correspondiente con sus datos
                $.ajax({
                    url: `/mesas/${mesaId}/info`,
                    method: 'GET',
                    success: function(response) {
                        const invitados = response.invitados;
                        const maxSillas = response.cant_sillas;
                        const invitadosCount = invitados.length;
                        const sillasRestantes = maxSillas - invitadosCount;

                        // Mostrar los nombres de los invitados y las sillas restantes
                        document.getElementById('nombresInvitados').innerHTML = 'Invitados: ' + invitados.map(i => i
                            .nombre).join(', ');
                        document.getElementById('sillasRestantes').innerHTML = 'Sillas restantes: ' +
                            sillasRestantes;

                        // Posicionar el cuadro de información cerca del clic
                        infoMesa.style.left = event.pageX + 'px';
                        infoMesa.style.top = event.pageY + 'px';
                        infoMesa.style.display = 'block';
                    }
                });
            }

            function ocultarInfoMesa() {
                document.getElementById('infoMesa').style.display = 'none';
            }
        </script>

        <script>
            // Función para filtrar la tabla en el modal
            document.getElementById('modalSearchInput').addEventListener('keyup', function() {
                const searchValue = this.value.toLowerCase();
                const rows = document.querySelectorAll('#listaInvitados tr');

                rows.forEach(row => {
                    const cells = row.getElementsByTagName('td');
                    let isVisible = false;

                    for (let i = 0; i < cells.length; i++) {
                        if (cells[i].textContent.toLowerCase().includes(searchValue)) {
                            isVisible = true;
                            break;
                        }
                    }

                    if (isVisible) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        </script>


    @endsection

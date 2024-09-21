<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="img/ico.png" rel="icon"> 
    <title>@yield('title', 'Organización de Mesas en el Evento')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        html,
        body {
            overflow: hidden;
            /* Oculta las barras de desplazamiento */
            height: 100%;
            /* Asegura que el body ocupe toda la altura */
            margin: 0;
            /* Elimina el margen predeterminado */
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff
        }

        h1,
        h2,
        h3 {
            font-family: 'Poppins', sans-serif;

            /* Ejemplo de cómo controlar el peso de la fuente */
        }

        p {
            font-family: 'Poppins', sans-serif;

            /* Peso normal de la fuente */
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100%;
            background-color: #7c1034;
            padding-top: 20px;
            color: #fff;
            z-index: 1000;

        }

        .sidebar .logo {
            text-align: center;
            margin-bottom: 50px;
        }

        .sidebar .logo img {
            max-width: 50%;
            height: 73%;

        }

        .sidebar a,
        .sidebar button {
            display: block;
            margin-bottom: 1rem;
            color: #000000;
            padding: 15px;
            width: 99%;
            text-decoration: none;
            border: none;
            background-color: #cfe5ff;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            border-radius: 10px;
        }

        .sidebar a:hover {
            background-color: #ffffff;
            color: #333;
            border: #333;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .sidebar button:hover {
            background-color: #ffffff;
            color: #333;
            border: #333;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .sidebar button:active {
            transform: translateY(1px);
        }


        .sidebar .bottom-container {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
        }

        .sidebar .bottom-container p {
            margin: 0;
            color: #fff;
            padding: 10px;
            background-color: #333;
            border-radius: 5px;
        }

        .main-content {
            margin-left: 250px;

        }

        /* Estilo para el botón de salir */
        .logout-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #dc3545;
        }

        .logout-btn i {
            margin-right: 10px;
        }

        #instructionsBtn {
            display: block;
            margin-bottom: 1rem;
            color: #000000;
            padding: 15px;
            width: 100%;
            text-decoration: none;
            border: none;
            background-color: #ffbd00;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            border-radius: 5px;
        }

        #instructionsBtn:hover {
            background-color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Estilos del modal personalizado */
        .custom-modal {
            display: none;
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            overflow: hidden;
        }

        .custom-modal-content {
            background-color: #f7f7f7;
            margin: 10% auto;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 600px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .custom-close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .custom-close:hover,
        .custom-close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        /* Botón de paso siguiente */
        #nextStep {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="logo">
            <img src="{{ asset('img/logo.png') }}" alt="Logo">
        </div>
        <button id="addTableBtn">Agregar Mesa</button>
        <button id="removeTableBtn">Eliminar Última Mesa</button>
        <a href="{{ route('listaInvitados') }}" class="btn btn-info">Ver lista completa</a>

        <button id="instructionsBtn" class="btn btn-secondary">Instrucciones</button>
        <!-- Botón de salir con ícono -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger mt-3">
                <i class="fas fa-sign-out-alt"></i> Salir
            </button>
        </form>



    </div>

    <div id="instructionModal" class="custom-modal">
        <div class="custom-modal-content">
            <span class="custom-close">&times;</span>
            <h2 id="stepTitle">Paso 1: Configuración del evento</h2>
            <p id="stepDescription">Comienza abriendo la sección de configuración para ajustar los detalles del evento.
            </p>
            <button id="nextStep" class="btn btn-primary">Siguiente</button>
        </div>
    </div>

    <div class="main-content">
        <main>
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addTableBtn = document.getElementById('addTableBtn');
            const removeTableBtn = document.getElementById('removeTableBtn');
            const selectedTable = document.getElementById('selectedTable');

            if (addTableBtn) {
                addTableBtn.addEventListener('click', function() {
                    fetch('{{ route('admin.addTable') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            },
                            body: JSON.stringify({
                                titulo: 'Nueva Mesa',
                                x: 0,
                                y: 0
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Mesa agregada exitosamente');
                                window.location.reload(); // Recarga la página para reflejar los cambios
                            } else {
                                alert('Error al agregar la mesa');
                            }
                        });
                });
            }

            if (removeTableBtn) {
                removeTableBtn.addEventListener('click', function() {
                    fetch('{{ route('admin.removeLastTable') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Última mesa eliminada exitosamente');
                                window.location.reload(); // Recarga la página para reflejar los cambios
                            } else {
                                alert('Error al eliminar la mesa');
                            }
                        });
                });
            }


        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const instructionModal = document.getElementById('instructionModal');
            const instructionsBtn = document.getElementById('instructionsBtn');
            const closeModal = document.querySelector('.custom-close');
            const nextStepBtn = document.getElementById('nextStep');
            const stepTitle = document.getElementById('stepTitle');
            const stepDescription = document.getElementById('stepDescription');

            // Al hacer clic en el botón de instrucciones, se abre el modal y reinicia al paso 1
            instructionsBtn.addEventListener('click', function() {
                instructionModal.style.display = 'block';
                resetToStepOne();
            });

            // Cerrar el modal al hacer clic en el botón de cierre
            closeModal.addEventListener('click', function() {
                instructionModal.style.display = 'none';
            });

            // Pasos del modal
            let currentStep = 1;
            nextStepBtn.addEventListener('click', function() {
                if (currentStep === 1) {
                    stepTitle.textContent = 'Paso 2: Organización de mesas';
                    stepDescription.textContent =
                        'Arrastra las mesas para colocarlas en la disposición que prefieras. Ajusta las mesas en la vista de la sala para que se asemeje a la distribución real del salón.';
                    currentStep++;
                } else if (currentStep === 2) {
                    stepTitle.textContent = 'Paso 3: Agregar invitados';
                    stepDescription.textContent =
                        'Agrega los invitados a las mesas disponibles. Asegúrate de que cada mesa tenga el número correcto de sillas y que los invitados se asignen adecuadamente.';
                    currentStep++;
                } else if (currentStep === 3) {
                    stepTitle.textContent = 'Paso 4: Descargar el listado';
                    stepDescription.textContent =
                        'Ve a la sección de "Ver lista completa" para revisar y descargar el listado de invitados. Puedes ordenar el listado según tus preferencias antes de descargarlo.';
                    currentStep++;
                } else if (currentStep === 4) {
                    stepTitle.textContent = 'Paso 5: Exportar a PDF';
                    stepDescription.textContent =
                        'Una vez que hayas revisado y ordenado el listado, puedes exportarlo a PDF. Utiliza la opción de exportar en la vista del listado para generar el archivo PDF.';
                    currentStep++;
                } else if (currentStep === 5) {
                    stepTitle.textContent = 'Paso 6: Gestión de invitados';
                    stepDescription.textContent =
                        'En la sección de gestión de invitados, puedes editar los detalles de los invitados y cambiarlos de mesa si es necesario. Asegúrate de actualizar la asignación de mesas según los cambios realizados.';
                    currentStep++;
                } else {
                    // Cuando se alcanza el último paso, cerrar el modal
                    instructionModal.style.display = 'none';
                    resetToStepOne();
                }
            });

            // Función para reiniciar al paso 1
            function resetToStepOne() {
                currentStep = 1;
                stepTitle.textContent = 'Paso 1: Configuración del evento';
                stepDescription.textContent =
                    'Comienza abriendo la sección de configuración para ajustar los detalles del evento.';
            }
        });
    </script>


</body>

</html>

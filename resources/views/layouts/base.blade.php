<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Organización de Mesas en el Evento')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100%;
            background-color: #000000b5;
            padding-top: 20px;
            color: #fff;
            z-index: 1000;
        }

        .sidebar .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar .logo img {
            max-width: 80%;
            height: auto;
        }

        .sidebar a,
        .sidebar button {
            display: block;
            color: #fff;
            padding: 15px;
            text-decoration: none;
            border: none;
            background: none;
            text-align: center;
            cursor: pointer;
        }

        .sidebar a:hover,
        .sidebar button:hover {
            background-color: #575757;
        }

        .sidebar button {
            border: 1px solid transparent;
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
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
        </div>
        <button id="addTableBtn">Agregar Mesa</button>
        <button id="removeTableBtn">Eliminar Última Mesa</button>

        <div class="bottom-container">
            <p id="selectedTable">Selecciona una mesa para ver su número</p>
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

            // Lógica para mostrar el número de la mesa seleccionada
            function selectTable(number) {
                if (selectedTable) {
                    selectedTable.textContent = 'Usted eligió la mesa número ' + number;
                }
            }
        });
    </script>
</body>

</html>

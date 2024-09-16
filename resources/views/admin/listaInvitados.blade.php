<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Completa de Invitados</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <style>
        body {
            background: #f4f4f9;
            font-family: 'Poppins', sans-serif;
        }

        .navbar-custom {
            background-color: #28293e;
            padding: 0.5rem 1rem;
            color: white;
            height: auto;
        }

        .navbar-custom a {
            color: #00d1b2;
            font-size: 1.2rem;
            font-weight: 500;
            text-decoration: none;
        }

        .container {
            margin-top: 80px;
            /* Espacio para evitar superposición con el navbar */
        }

        /* Estilo para la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #333;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #28293e;
            color: #fff;
        }

        td {
            background-color: #fff;
            color: #333;
        }

        /* Hacer la tabla "scrollable" */
        .table-wrapper {
            max-height: 500px;
            overflow-y: auto;
        }

        /* Estilo del buscador */
        .search-input {
            margin-bottom: 20px;
            padding: 10px;
            font-size: 14px;
            width: 200px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .search-container {
            position: relative;
        }

        .search-container input[type="text"] {
            padding-left: 30px; /* Espacio para el ícono */
        }

        .search-container i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #333;
        }

        /* Estilo para los botones de orden */
        .sort-buttons {
            margin-bottom: 20px;
        }

        .sort-buttons button {
            margin-right: 10px;
            padding: 8px 15px;
            border: none;
            background-color: #00d1b2;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .sort-buttons button:hover {
            background-color: #00bfa5;
        }

        /* Estilo del botón de exportar a PDF */
        .export-btn {
            padding: 8px 15px;
            border: none;
            background-color: #ff0000 !important;
            color: rgb(8, 8, 8);
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
        }

        .export-btn:hover {
            background-color: #0056b3;
            color: #fff;
        }

        .sort-buttons button.selected {
            background-color: #00695c;
            border-color: #00695c;
            color: white;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar-custom">
        <div class="container d-flex justify-content-between align-items-center">
            <span class="navbar-brand">Lista de Invitados</span>
            <a href="{{ route('admin.index') }}" class="btn btn-outline-light">
                <i class="fas fa-arrow-left"></i> Regresar a Administración
            </a>
        </div>
    </nav>

    <!-- Contenedor principal -->
    <div class="container">
        <!-- Buscador, botones de orden y botón de exportar -->
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <input type="text" id="searchInput" class="search-input" placeholder="Buscar...">

            <div class="sort-buttons">
                <button id="sortNombre" onclick="sortTable('nombre')">Ordenar por Nombre</button>
                <button id="sortApellido" onclick="sortTable('apellido')">Ordenar por Apellido</button>
                <button id="sortMesa" onclick="sortTable('mesa')">Ordenar por Mesa</button>
                <a id="exportPDF" href="{{ route('invitados.exportPDF') }}" class="export-btn">Exportar a PDF</a>
            </div>
        </div>

        <!-- Tabla de invitados con scrollable -->
        <div class="table-wrapper">
            <table id="invitadosTable">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Mesa</th>
                    </tr>
                </thead>
                <tbody id="listaInvitados">
                    @foreach ($invitados as $invitado)
                    @if ($invitado->confirmacion !== 'rechazado' && $invitado->especial !== 'si')
                            <!-- Excluyendo a los rechazados -->
                            <tr>
                                <td>{{ $invitado->nombre }}</td>
                                <td>{{ $invitado->apellido }}</td>
                                <td>{{ $invitado->mesa ? 'Mesa ' . $invitado->mesa->numero_mesa : 'Sin Mesa' }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Iconos -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <!-- Script para la búsqueda y ordenamiento -->
    <script>
        // Función para la búsqueda en la tabla
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#listaInvitados tr');

            rows.forEach(row => {
                const name = row.cells[0].textContent.toLowerCase();
                const surname = row.cells[1].textContent.toLowerCase();
                const mesa = row.cells[2].textContent.toLowerCase();

                if (name.includes(searchValue) || surname.includes(searchValue) || mesa.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Función para ordenar la tabla
        function sortTable(criteria) {
            const table = document.getElementById('invitadosTable');
            const rows = Array.from(table.rows).slice(1); // Ignorar el encabezado
            const isAscending = table.getAttribute('data-sort-direction') === 'asc';
            const direction = isAscending ? 'desc' : 'asc';
            table.setAttribute('data-sort-direction', direction);

            rows.sort((rowA, rowB) => {
                let cellA, cellB;

                if (criteria === 'nombre') {
                    cellA = rowA.cells[0].textContent.trim().toLowerCase();
                    cellB = rowB.cells[0].textContent.trim().toLowerCase();
                } else if (criteria === 'apellido') {
                    cellA = rowA.cells[1].textContent.trim().toLowerCase();
                    cellB = rowB.cells[1].textContent.trim().toLowerCase();
                } else if (criteria === 'mesa') {
                    cellA = rowA.cells[2].textContent.trim().toLowerCase();
                    cellB = rowB.cells[2].textContent.trim().toLowerCase();
                }

                if (cellA < cellB) {
                    return direction === 'asc' ? -1 : 1;
                }
                if (cellA > cellB) {
                    return direction === 'asc' ? 1 : -1;
                }
                return 0;
            });

            rows.forEach(row => table.tBodies[0].appendChild(row));

            // Actualizar el estado de los botones
            document.querySelectorAll('.sort-buttons button').forEach(button => {
                button.classList.remove('selected');
            });
            document.getElementById('sort' + criteria.charAt(0).toUpperCase() + criteria.slice(1)).classList.add('selected');

            // Actualizar el enlace de exportación con el criterio de ordenamiento
            document.getElementById('exportPDF').href = `{{ route('invitados.exportPDF') }}?sort=${criteria}&direction=${direction}`;
        }
    </script>
</body>

</html>

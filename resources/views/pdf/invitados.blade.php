<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Invitados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Lista de Invitados</h1>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Mesa</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invitados as $invitado)
                @if ($invitado->confirmacion !== 'rechazado')
                    <tr>
                        <td>{{ $invitado->nombre }}</td>
                        <td>{{ $invitado->apellido }}</td>
                        <td>{{ $invitado->mesa ? 'Mesa ' . $invitado->mesa->numero_mesa : 'Sin Mesa' }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="img/ico.png" rel="icon"> 
    <title>Confirmar Asistencia</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            border: 2px solid #7c1034; /* Borde con color de tu paleta */
        }

        h2 {
            text-align: center;
            color: #7c1034; /* Color del título */
            margin-bottom: 20px;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: border 0.3s;
        }

        input[type="text"]:focus {
            border-color: #7c1034; /* Borde al enfocarse */
            outline: none;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #cfe5ff; /* Color del botón */
            color: #7c1034; /* Color del texto del botón */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #a3c3ff; /* Color de fondo en hover */
        }

        .alert {
            margin-top: 15px;
            color: red;
            background-color: #ffe6e6; /* Fondo para mensajes de error */
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #f5c6cb; /* Borde para mensajes de error */
        }

        .success {
            color: green;
            background-color: #e6ffed; /* Fondo para mensajes de éxito */
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #c3e6cb; /* Borde para mensajes de éxito */
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ url('/index') }}">← Volver al inicio</a>
        <h2>Confirmar Asistencia</h2>
        
        <form action="{{ route('confirmacion.confirmar') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="codigo">Código de Invitación</label>
                <input type="text" name="codigo" id="codigo" class="form-control" placeholder="Ingresa tu código" required>
            </div>

            <button type="submit">Enviar</button>

            <!-- Mensaje de éxito -->
            @if (session('success'))
                <div class="success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Mensajes de error de validación -->
            @if ($errors->any())
                <div class="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>
    </div>
</body>
</html>

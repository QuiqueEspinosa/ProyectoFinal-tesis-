<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link href="img/ico.png" rel="icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <style>
        /* Estilos generales */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        /* Estilo para el fondo de video */
        .video-background {
            position: fixed;
            top: 0;
            left: 0;
            min-width: 100%;
            min-height: 100%;
            z-index: -1;
            object-fit: cover;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Añade una capa de oscurecimiento */
            z-index: 1;
        }

        /* Estilo del contenedor de registro */
        .register-container {
            z-index: 2;
            width: 400px;
            padding: 2rem;
            background-color: #7c1034; /* Color de la tarjeta */
            color: white; /* Color de texto */
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .register-container h2 {
            margin-bottom: 1.5rem;
            color: white; /* Color de título */
        }

        .register-container form {
            display: flex;
            flex-direction: column;
        }

        .register-container input {
            margin-bottom: 1rem;
            padding: 10px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #ccc;
            transition: border-color 0.3s;
        }

        .register-container input:focus {
            border-color: #cfe5ff; /* Resaltado con el color de la paleta */
        }

        .register-container button {
            background-color: #cfe5ff; /* Color del botón */
            color: #7c1034; /* Color de texto del botón */
            padding: 10px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        .register-container button:hover {
            background-color: white; /* Hover blanco */
            color: #7c1034; /* Texto del hover */
        }

        .register-container .back-button {
            text-align: left;
            margin-bottom: 1rem;
        }

        .back-button a {
            color: #cfe5ff;
            text-decoration: none;
            font-size: 18px;
        }

        .back-button a:hover {
            text-decoration: underline;
        }

        .register-container p {
            margin-top: 1rem;
            color: white;
        }

        .register-container a {
            color: #cfe5ff;
            text-decoration: none;
        }

        .register-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Fondo de video -->
    <video autoplay muted loop class="video-background">
        <source src="{{ asset('videos/video.mp4') }}" type="video/mp4">
        Tu navegador no soporta la reproducción de videos.
    </video>
   

    <!-- Contenedor de registro -->
    <div class="register-container">
        <div class="back-button">
            <a href="{{ url('/index') }}">← Volver al inicio</a>
        </div>
        <h2>Registro</h2>
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <input type="text" name="name" placeholder="Nombre Completo" required>
            <input type="email" name="email" placeholder="Correo Electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <input type="password" name="password_confirmation" placeholder="Confirmar Contraseña" required>
            <button type="submit">Registrarse</button>
        </form>
        <p>¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a></p>
    </div>
</body>
</html>

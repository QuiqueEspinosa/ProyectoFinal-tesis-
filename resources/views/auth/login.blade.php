<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link href="img/ico.png" rel="icon"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicia Sesion</title>
    <style>
        /* Animación de entrada */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
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
            width: 100%;
            height: 100%;
            z-index: -1;
            object-fit: cover;
            background: #000; /* Color de fondo para navegadores que no soportan video */
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

        .login-container {
            width: 400px;
            padding: 2rem;
            background-color: #7c1034;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            color: white;
            animation: fadeIn 1.2s ease-in-out;
            z-index: 2; /* Asegúrate de que el contenedor esté por encima de la capa de oscurecimiento */
        }

        .login-container h2 {
            margin-bottom: 1.5rem;
        }

        .login-container form {
            display: flex;
            flex-direction: column;
        }

        .login-container input {
            margin-bottom: 1rem;
            padding: 10px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #ccc;
            transition: border-color 0.3s;
            outline: none;
        }

        .login-container input:focus {
            border-color: #cfe5ff;
        }

        .login-container button {
            background-color: #cfe5ff;
            color: #7c1034;
            padding: 10px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        .login-container button:hover {
            background-color: white;
            color: #7c1034;
        }

        .login-container .back-button {
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

        .login-container .register {
            margin-top: 1rem;
            color: #cfe5ff;
        }

        .login-container .register a {
            color: #cfe5ff;
            text-decoration: none;
        }

        .login-container .register a:hover {
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
    
    <!-- Capa oscura para mejorar visibilidad del contenido -->
    <div class="overlay"></div>
    
    <!-- Contenedor de login -->
    <div class="login-container">
        <div class="back-button">
            <a href="{{ url('/index') }}">← Volver al inicio</a>
        </div>
        <h2>Iniciar Sesión</h2>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <input type="email" name="email" placeholder="Correo Electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <div>
                <label>
                    <input type="checkbox" name="remember"> Recuérdame
                </label>
            </div>
            <button type="submit">Entrar</button>
        </form>
        <p class="register">¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate</a></p>
    </div>
</body>
</html>

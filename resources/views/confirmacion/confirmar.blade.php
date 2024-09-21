<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="img/ico.png" rel="icon"> 
    <title>Confirmación de Invitados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        h2 {
            text-align: center;
            color: #7c1034;
        }
        .input-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        input[type="text"], select {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        input[type="submit"], button {
            background-color: #cfe5ff;
            color: #333;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover, button:hover {
            background-color: #a0c1ff;
        }
        .acompanantes-container {
            margin-top: 20px;
        }
        .acompanante {
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            border-radius: 8px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Confirmación para {{ $invitado->nombre }} {{ $invitado->apellido }}</h2>
        <form method="POST" action="{{ route('confirmacion.guardar') }}" onsubmit="return showModal()">
            @csrf
            <input type="hidden" name="invitado_id" value="{{ $invitado->id }}">
            <input type="hidden" name="acompanantes_maximos" value="{{ $acompanantes_maximos }}">
            
            <label for="confirmacion">Confirmación:</label>
            <select name="confirmacion" id="confirmacion">
                <option value="aceptado">Aceptado</option>
                <option value="rechazado">Rechazado</option>
            </select>

            @if($acompanantes_maximos > 0)
                <p>Usted tiene {{ $acompanantes_maximos }} acompañantes disponibles. Seleccione cuántos desea agregar:</p>
                <label for="num_acompanantes">Número de Acompañantes:</label>
                <select id="num_acompanantes" name="num_acompanantes" onchange="mostrarAcompanantes(this.value, {{ $acompanantes_maximos }})">
                    @for($i = 0; $i <= $acompanantes_maximos; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            @endif
        
            <div id="acompanantes_fields"></div>
        
            <input type="submit" value="Guardar Confirmación">
        </form>
        
        <div id="modal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <p>¡Gracias por aceptar nuestra invitación! Te esperamos.</p>
            </div>
        </div>

        <script>
            function mostrarAcompanantes(num, max) {
                const container = document.getElementById('acompanantes_fields');
                container.innerHTML = ''; // Limpiar campos existentes
                for (let i = 0; i < num; i++) {
                    container.innerHTML += `
                        <div class="acompanante">
                            <h4>Acompañante ${i + 1}</h4>
                            <label>Nombre:</label>
                            <input type="text" name="acompanantes[${i}][nombre]" required>
                            <label>Apellido:</label>
                            <input type="text" name="acompanantes[${i}][apellido]" required>
                            <label>Edad:</label>
                            <select name="acompanantes[${i}][edad]" required>
                                <option value="bebe">Bebé</option>
                                <option value="niño">Niño</option>
                                <option value="adulto">Adulto</option>
                            </select>
                            <label>Sexo:</label>
                            <select name="acompanantes[${i}][sexo]" required>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                                <option value="otro">Otro</option>
                            </select>
                            <label>Menú:</label>
                            <select name="acompanantes[${i}][menu]" required>
                                <option value="Adulto">Adulto</option>
                                <option value="Infantil">Infantil</option>
                                <option value="Vegetariano">Vegetariano</option>
                                <option value="Dietetico">Dietético</option>
                            </select>
                        </div>`;
                }
            }

            function showModal() {
                document.getElementById('modal').style.display = "block";
                return true; // Permitir el envío del formulario
            }

            function closeModal() {
                document.getElementById('modal').style.display = "none";
            }
        </script>
    </div>
</body>
</html>

<!-- resources/views/admin/_form_invited.blade.php -->
<form id="formInvitado" method="POST" action="{{ route('invitados.store') }}">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" required>
            </div>
            <div class="mb-3">
                <label for="edad" class="form-label">Edad</label>
                <select class="form-select" id="edad" name="edad" required>
                    <option value="adulto">Adulto</option>
                    <option value="niño">Niño</option>
                    <option value="bebe">Bebé</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="sexo" class="form-label">Sexo</label>
                <select class="form-select" id="sexo" name="sexo" required>
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="menu" class="form-label">Menú</label>
                <select class="form-select" id="menu" name="menu" required>
                    <option value="Adulto">Adulto</option>
                    <option value="Infantil">Infantil</option>
                    <option value="Vegetariano">Vegetariano</option>
                    <option value="Dietetico">Dietético</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="cant_acompanantes" class="form-label">Cantidad de Acompañantes</label>
                <input type="number" class="form-control" id="cant_acompanantes" name="cant_acompanantes" min="0">
            </div>
            <div class="mb-3">
                <label for="confirmacion" class="form-label">Confirmación</label>
                <select class="form-select" id="confirmacion" name="confirmacion" required>
                    <option value="en espera">En espera</option>
                    <option value="aceptado">Aceptado</option>
                    <option value="rechazado">Rechazado</option>
                </select>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Agregar Invitado</button>
</form>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#formInvitado').submit(function(event) {
            event.preventDefault(); // Evitar el envío normal del formulario

            // Recolectar los datos del formulario
            var formData = $(this).serialize();

            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: formData,
                success: function(response) {
                    // Actualizar el contenido de la tabla en el modal
                    $('#listaInvitados').append(`
                        <tr>
                            <td>${$('#listaInvitados tr').length + 1}</td>
                            <td>${response.nombre} ${response.apellido}</td>
                            <td>${response.edad}</td>
                            <td>${response.sexo}</td>
                            <td>${response.menu}</td>
                            <td>
                                ${response.confirmacion == 'aceptado' ? 
                                    '<span class="badge bg-success">Aceptado</span>' : 
                                    response.confirmacion == 'rechazado' ? 
                                    '<span class="badge bg-danger">Rechazado</span>' : 
                                    '<span class="badge bg-warning">En espera</span>'
                                }
                            </td>
                            <td>${response.cant_acompanantes || 'N/A'}</td>
                            <td>${response.codigo}</td>
                        </tr>
                    `);

                    // Limpiar el formulario
                    $('#formInvitado')[0].reset();

                    // Opcional: mostrar un mensaje de éxito
                    alert('Invitado agregado con éxito');
                },
                error: function(xhr) {
                    // Manejo de errores
                    console.log(xhr.responseText);
                    alert('Hubo un error al agregar el invitado');
                }
            });
        });
    });
</script>

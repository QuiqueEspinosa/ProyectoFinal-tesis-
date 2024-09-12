<!-- resources/views/admin/invitado.blade.php -->
<form id="formInvitado" method="POST" action="{{ route('invitados.store') }}">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <!-- Contenedor para mensajes de error -->
            <div id="error-message" class="alert alert-danger d-none"></div>
        </div>
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
            <select class="form-select" id="mesa_id" name="mesa_id" @if($mesas->isEmpty()) disabled @endif>
                @if ($mesas->isEmpty())
                    <option value="">Aún no hay mesas creadas</option>
                @else
                    @foreach ($mesas as $mesa)
                        <option value="{{ $mesa->id }}">Mesa {{ $mesa->numero_mesa }}</option>
                    @endforeach
                @endif
            </select>
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
                <input type="number" class="form-control" id="cant_acompanantes" name="cant_acompanantes"
                    min="0">
            </div>

        </div>
    </div>
    <button type="submit" class="btn btn-primary">Agregar Invitado</button>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
 $(document).ready(function() {
    $('#formInvitado').submit(function(event) {
        event.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: formData,
            success: function(response) {
                // Limpiar el mensaje de error
                $('#error-message').addClass('d-none').text('');

                // Agregar el nuevo invitado a la tabla
                $('#listaInvitados').append(`
                    <tr>
                        <td>${$('#listaInvitados tr').length + 1}</td>
                        <td>${response.nombre} ${response.apellido}</td>
                        <td>${response.edad}</td>
                        <td>${response.sexo}</td>
                        <td>${response.mesa ? 'Mesa ' + (response.mesa.numero_mesa || 'Sin Número') : 'Sin Mesa'}</td>
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
            },
            error: function(xhr) {
                if (xhr.status === 400 && xhr.responseJSON && xhr.responseJSON.error) {
                    // Mostrar el mensaje de error de "mesa llena"
                    $('#error-message').removeClass('d-none').text(xhr.responseJSON.error);
                } else if (xhr.status === 422) {
                    // Mostrar errores de validación
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = '';
                    $.each(errors, function(key, value) {
                        errorMessages += value + '<br>';
                    });
                    $('#error-message').removeClass('d-none').html(errorMessages);
                } else {
                    // Otro error inesperado
                    $('#error-message').removeClass('d-none').text('Hubo un error al agregar el invitado.');
                }
            }
        });
    });
});

</script>

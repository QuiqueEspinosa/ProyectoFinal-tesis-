
<form id="formInvitadoEdit" method="POST" action="{{ route('invitados.update', $invitado->id) }}">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre"
                    value="{{ old('nombre', $invitado->nombre) }}" required>
            </div>
            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido"
                    value="{{ old('apellido', $invitado->apellido) }}" required>
            </div>
            <div class="mb-3">
                <label for="edad" class="form-label">Edad</label>
                <select class="form-select" id="edad" name="edad" required>
                    <option value="adulto" {{ old('edad', $invitado->edad) == 'adulto' ? 'selected' : '' }}>Adulto
                    </option>
                    <option value="niño" {{ old('edad', $invitado->edad) == 'niño' ? 'selected' : '' }}>Niño</option>
                    <option value="bebe" {{ old('edad', $invitado->edad) == 'bebe' ? 'selected' : '' }}>Bebé</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="mesa_id" class="form-label">Mesa</label>
                <select class="form-select" id="mesa_id" name="mesa_id"
                    @if ($mesas->isEmpty()) disabled @endif>
                    @if ($mesas->isEmpty())
                        <option value="">Aún no hay mesas creadas</option>
                    @else
                        @foreach ($mesas as $mesa)
                            <option value="{{ $mesa->id }}"
                                {{ old('mesa_id', $invitado->mesa_id) == $mesa->id ? 'selected' : '' }}>Mesa
                                {{ $mesa->numero_mesa }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="sexo" class="form-label">Sexo</label>
                <select class="form-select" id="sexo" name="sexo" required>
                    <option value="M" {{ old('sexo', $invitado->sexo) == 'M' ? 'selected' : '' }}>Masculino
                    </option>
                    <option value="F" {{ old('sexo', $invitado->sexo) == 'F' ? 'selected' : '' }}>Femenino
                    </option>
                    <option value="Otro" {{ old('sexo', $invitado->sexo) == 'Otro' ? 'selected' : '' }}>Otro</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="menu" class="form-label">Menú</label>
                <select class="form-select" id="menu" name="menu" required>
                    <option value="Adulto" {{ old('menu', $invitado->menu) == 'Adulto' ? 'selected' : '' }}>Adulto
                    </option>
                    <option value="Infantil" {{ old('menu', $invitado->menu) == 'Infantil' ? 'selected' : '' }}>
                        Infantil</option>
                    <option value="Vegetariano" {{ old('menu', $invitado->menu) == 'Vegetariano' ? 'selected' : '' }}>
                        Vegetariano</option>
                    <option value="Dietetico" {{ old('menu', $invitado->menu) == 'Dietetico' ? 'selected' : '' }}>
                        Dietético</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="cant_acompanantes" class="form-label">Cantidad de Acompañantes</label>
                <input type="number" class="form-control" id="cant_acompanantes" name="cant_acompanantes"
                    value="{{ old('cant_acompanantes', $invitado->cant_acompanantes) }}" min="0">
            </div>
            <div class="mb-3">
                <label for="confirmacion" class="form-label">Confirmación</label>
                <select class="form-select" id="confirmacion" name="confirmacion" required>
                    <option value="en espera"
                        {{ old('confirmacion', $invitado->confirmacion) == 'en espera' ? 'selected' : '' }}>En espera
                    </option>
                    <option value="aceptado"
                        {{ old('confirmacion', $invitado->confirmacion) == 'aceptado' ? 'selected' : '' }}>Aceptado
                    </option>
                    <option value="rechazado"
                        {{ old('confirmacion', $invitado->confirmacion) == 'rechazado' ? 'selected' : '' }}>Rechazado
                    </option>
                </select>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Actualizar Invitado</button>
</form>




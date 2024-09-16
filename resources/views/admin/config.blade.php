<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('config.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Fecha de evento -->
                        <div class="form-group">
                            <label for="fecha_evento">Fecha de Evento <small>(opcional)</small></label>
                            <input type="date" class="form-control" id="fecha_evento" name="fecha_evento"
                                value="{{ $config->fecha_evento ?? '' }}">
                        </div>

                        <!-- Horario -->
                        <div class="form-group">
                            <label for="horario">Horario <small>(opcional)</small></label>
                            <input type="time" class="form-control" id="horario" name="horario"
                                value="{{ $config->horario ?? '' }}">
                        </div>

                        <!-- Clase de Evento -->
                        <div class="form-group">
                            <label for="clase_evento">Clase de Evento</label>
                            <select name="clase_evento" id="clase_evento" class="form-control">
                                <option value="">Selecciona una clase de evento</option>
                                <option value="casamiento" {{ old('clase_evento', $config->clase_evento ?? '') == 'casamiento' ? 'selected' : '' }}>Casamiento</option>
                                <option value="fiesta_15" {{ old('clase_evento', $config->clase_evento ?? '') == 'fiesta_15' ? 'selected' : '' }}>Fiesta de 15</option>
                                <option value="fiesta_18" {{ old('clase_evento', $config->clase_evento ?? '') == 'fiesta_18' ? 'selected' : '' }}>Fiesta de 18</option>
                                <!-- Puedes agregar más opciones aquí -->
                            </select>
                        </div>



                        <!-- Salón -->
                        <div class="form-group">
                            <label for="salon">Salón <small>(opcional)</small></label>
                            <input type="text" class="form-control" id="salon" name="salon"
                                value="{{ $config->salon ?? '' }}">
                        </div>

                        <!-- Cantidad de Mesas -->
                        <div class="form-group">
                            <label for="cant_mesas">Cantidad de Mesas <small>(opcional)</small></label>
                            <input type="number" class="form-control" id="cant_mesas" name="cant_mesas"
                                value="{{ $config->cant_mesas ?? '' }}">
                        </div>

                        <!-- Cantidad de Sillas -->
                        <div class="form-group">
                            <label for="cant_sillas">Cantidad de Sillas <small>(opcional)</small></label>
                            <input type="number" class="form-control" id="cant_sillas" name="cant_sillas"
                                value="{{ $config->cant_sillas ?? '' }}">
                        </div>

                        <!-- Cantidad Total de Invitados -->
                        <div class="form-group">
                            <label for="cant_total_de_invitados">Cantidad Total de Invitados
                                <small>(opcional)</small></label>
                            <input type="number" class="form-control" id="cant_total_de_invitados"
                                name="cant_total_de_invitados" value="{{ $config->cant_total_de_invitados ?? '' }}">
                        </div>

                        <!-- Precio por Adulto -->
                        <div class="form-group">
                            <label for="precio_adulto">Precio por Adulto <small>(opcional)</small></label>
                            <input type="number" class="form-control" id="precio_adulto" name="precio_adulto"
                                value="{{ $config->precio_adulto ?? '' }}">
                        </div>

                        <!-- Precio por Menor -->
                        <div class="form-group">
                            <label for="precio_menor">Precio por Menor <small>(opcional)</small></label>
                            <input type="number" class="form-control" id="precio_menor" name="precio_menor"
                                value="{{ $config->precio_menor ?? '' }}">
                        </div>

                        <!-- Cantidad de Mesas Principales -->
                        <div class="form-group">
                            <label for="cant_mesa_principal">Cantidad de Mesas Principales
                                <small>(opcional)</small></label>
                            <input type="number" class="form-control" id="cant_mesa_principal"
                                name="cant_mesa_principal" value="{{ $config->cant_mesa_principal ?? '' }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Guardar Configuración</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

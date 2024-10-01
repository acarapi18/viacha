<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>




<div class="container mt-5">
    <h2>Registro de Equipos</h2>

    <!-- Select para elegir la unidad educativa (con Select2) -->
    <div class="form-group">
        <label for="unidad_educativa_select">Unidad Educativa:</label>
        <select id="unidad_educativa_select" class="form-control" style="width: 100%;">
            <option value="">Selecciona una unidad educativa</option>
        </select>
    </div>

    <!-- Botón para abrir el modal y agregar equipos -->
    <button type="button" class="btn btn-primary" id="addEquipoBtn">Añadir Equipo</button>

    <!-- Modal para agregar equipos -->
    <div class="modal fade" id="modalEquipos" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar Equipo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEquipos">
                        <input type="hidden" id="id_unidad" name="id_unidad">
                        <div class="form-group">
                            <label for="serie">Serie</label>
                            <input type="text" id="serie" name="serie" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="marca">Marca</label>
                            <input type="text" id="marca" name="marca" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="modelo">Modelo</label>
                            <input type="text" id="modelo" name="modelo" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="procesador">Procesador</label>
                            <input type="text" id="procesador" name="procesador" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="ram">RAM</label>
                            <input type="text" id="ram" name="ram" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="almacenamiento">Almacenamiento</label>
                            <input type="text" id="almacenamiento" name="almacenamiento" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="accesorios">Accesorios</label>
                            <input type="text" id="accesorios" name="accesorios" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="licencias">Licencias</label>
                            <input type="text" id="licencias" name="licencias" class="form-control">
                        </div>
                        <button type="button" class="btn btn-primary" id="addEquipo">Agregar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla temporal donde se listarán los equipos agregados -->
    <table id="equiposTable" class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Serie</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Procesador</th>
                <th>RAM</th>
                <th>Almacenamiento</th>
                <th>Accesorios</th>
                <th>Licencias</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <!-- Botón para registrar los equipos en la base de datos -->
    <button type="button" id="registrarEquipos" class="btn btn-success">Registrar</button>
</div>

<script>
    $(document).ready(function() {
        // Inicializar Select2
        $('#unidad_educativa_select').select2({
            ajax: {
                url: '/equipos/getUnidadesEducativas', // Asegúrate que esta URL sea correcta
                dataType: 'json',
                processResults: function(data) {
                    console.log(data); // Agrega un log para verificar que los datos llegan correctamente
                    return {
                        results: data.map(function(unidad) {
                            return {
                                id: unidad.id,
                                text: unidad.codigo_rue + ' - ' + unidad.nombre
                            };
                        })
                    };
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText); // Mostrar el error si hay uno
                }
            },
            placeholder: 'Buscar por nombre o código RUE',
            minimumInputLength: 1,
            theme: 'bootstrap4'
        });



        // Habilitar botón al seleccionar una unidad educativa
        $('#unidad_educativa_select').on('select2:select', function(e) {
            let idUnidad = e.params.data.id;
            $('#id_unidad').val(idUnidad);
            $('#addEquipoBtn').prop('disabled', false);
        });

        // Abrir modal para agregar equipo
        $('#addEquipoBtn').on('click', function() {
            $('#modalEquipos').modal('show');
        });

        // Agregar equipo a la tabla temporal
        $('#addEquipo').on('click', function() {
            let equipo = {
                serie: $('#serie').val(),
                marca: $('#marca').val(),
                modelo: $('#modelo').val(),
                procesador: $('#procesador').val(),
                ram: $('#ram').val(),
                almacenamiento: $('#almacenamiento').val(),
                accesorios: $('#accesorios').val(),
                licencias: $('#licencias').val(),
                id_unidad: $('#id_unidad').val()
            };

            let row = '<tr>' +
                '<td>' + equipo.serie + '</td>' +
                '<td>' + equipo.marca + '</td>' +
                '<td>' + equipo.modelo + '</td>' +
                '<td>' + equipo.procesador + '</td>' +
                '<td>' + equipo.ram + '</td>' +
                '<td>' + equipo.almacenamiento + '</td>' +
                '<td>' + equipo.accesorios + '</td>' +
                '<td>' + equipo.licencias + '</td>' +
                '<td><button class="btn btn-danger btn-sm deleteRow">Eliminar</button></td>' +
                '</tr>';

            $('#equiposTable tbody').append(row);
            $('#modalEquipos').modal('hide');
        });

        // Eliminar equipo de la tabla temporal
        $('#equiposTable').on('click', '.deleteRow', function() {
            $(this).closest('tr').remove();
        });

        // Guardar equipos en la base de datos
        $('#registrarEquipos').on('click', function() {
            let equipos = [];
            $('#equiposTable tbody tr').each(function() {
                let equipo = {
                    serie: $(this).find('td:eq(0)').text(),
                    marca: $(this).find('td:eq(1)').text(),
                    modelo: $(this).find('td:eq(2)').text(),
                    procesador: $(this).find('td:eq(3)').text(),
                    ram: $(this).find('td:eq(4)').text(),
                    almacenamiento: $(this).find('td:eq(5)').text(),
                    accesorios: $(this).find('td:eq(6)').text(),
                    licencias: $(this).find('td:eq(7)').text(),
                    id_unidad: $('#id_unidad').val()
                };
                equipos.push(equipo);
            });

            $.ajax({
                url: '/equipos/guardar',
                method: 'POST',
                data: {
                    equipos: equipos
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire('Éxito', 'Equipos registrados correctamente', 'success');
                        $('#equiposTable tbody').empty(); // Limpiar la tabla después del registro
                    }
                }
            });
        });
    });
</script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>


<?= $this->endSection() ?>
<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><b><?= $title; ?></b></h3>        
    </div>

    <div class="card-body">
        <div class="col-md-6">
            <div class="input-group mb-6 d-flex align-items-center">
                <div class="input-group-prepend">
                    <span class="input-group-text">Número de Serie:</span>
                </div>
                <input type="text" name="serie" id="buscarNumeroSerie" class="form-control me-3" required>
                <!-- Resultados de búsqueda al costado derecho -->
                <div id="resultadoBusqueda" class="ms-3"></div>
            </div>
        </div>

     <!-- Formulario de modificación de equipo -->
        <div id="formularioEquipo" class="container mt-4">
            <form id="formModificarEquipo">
                <input type="hidden" name="id_unidad_educativa" value="<?= session('id_unidad_educativa') ?>">
                <input type="hidden" name="id_usuario" value="<?= session()->get('user_id') ?>">

                <div class="row">
                    <!-- Columna 1 -->
                    <div class="col-md-3">
                        <label for="serie">Serie:</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                            </div>
                            <input type="text" name="serie" id="serie" class="form-control" readonly>
                        </div>

                        <label for="marca">Marca:</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                            </div>
                            <input type="text" name="marca" id="marca" class="form-control" readonly>
                        </div>

                        <div class="form-group">
                            <label>Accesorios</label><br>
                            <input type="checkbox" name="cargador" id="cargador" value="1"> Cargador<br>
                            <input type="checkbox" name="cable_poder" id="cable_poder" value="1"> C. de Poder<br>
                            <input type="checkbox" name="lupa" id="lupa" value="1"> Lupa<br>
                        </div>
                    </div>

                    <!-- Columna 2 -->
                    <div class="col-md-3">
                        <label for="modelo">Modelo:</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-laptop"></i></span>
                            </div>
                            <input type="text" name="modelo" id="modelo" class="form-control" readonly>
                        </div>

                        <label for="procesador">Procesador:</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-microchip"></i></span>
                            </div>
                            <input type="text" name="procesador" id="procesador" class="form-control" readonly>
                        </div>

                        <div class="form-group">
                            <label>Accesorios</label><br>
                            <input type="checkbox" name="termico" id="termico" value="1"> Térmico<br>
                            <input type="checkbox" name="lapiz_optico" id="lapiz_optico" value="1"> Lápiz Óptico<br>
                            <input type="checkbox" name="bateria" id="bateria" value="1"> Batería<br>
                        </div>
                    </div>

                    <!-- Columna 3 -->
                    <div class="col-md-3">
                        <label for="ram">Memoria RAM:</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-memory"></i></span>
                            </div>
                            <input type="text" name="ram" id="ram" class="form-control" required>
                        </div>

                        <label for="almacenamiento">Almacenamiento:</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-hdd"></i></span>
                            </div>
                            <input type="text" name="almacenamiento" id="almacenamiento" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Licencias</label><br>
                            <input type="checkbox" name="licencia_office" id="licencia_office" value="1"> Office<br>
                            <input type="checkbox" name="licencia_windows" id="licencia_windows" value="1"> Windows<br>
                        </div>
                    </div>

                    <!-- Columna 4 -->
                    <div class="col-md-3">
                        <label for="estado">Estado Actual:</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-toggle-on"></i></span>
                            <select name="estado" id="estado" class="form-control" required>
                                <option value="">Estado Actual</option>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                                <option value="En Reparacion">En Reparacion</option>
                            </select>
                        </div>

                        <label for="observacion">Observación:</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-chalkboard"></i></span>
                            </div>
                            <textarea class="form-control" name="observacion" id="observacion" placeholder="Observación"></textarea>
                        </div>
                    </div>
                </div>

                <button type="submit" id="guardarBtn" class="btn btn-primary" disabled>Guardar</button>
            </form>
        </div>
    </div>

    
</div>
<div class="card">
    <div class="card-header">
    <h3 class="card-title"><b>Inventariados</b></h3> 
     </div>

    <div class="card-body">
    <!-- DataTable para los equipos inventariados -->
            <div style="margin-top: 20px;">
                <table id="inventarioTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Accion</th>
                            <th>Estado</th>
                            <th>Serie</th>                            
                            <th>RAM</th>
                            <th>HDD</th>
                            <th>Accesorios</th>
                            <th>Licencias</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Se cargarán los datos vía Ajax -->
                    </tbody>
                </table>
            </div>

    </div>
     
</div>

<script>
$(document).ready(function () {
// Función debounce para limitar la frecuencia de llamadas
function debounce(func, wait) {
    let timeout;
    return function (...args) {
        const context = this;
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(context, args), wait);
    };
}


// Búsqueda exacta por número de serie con debounce
$('#buscarNumeroSerie').on('input', debounce(function () {
    const query = $(this).val().trim();

    // Si el campo está vacío, limpiar el formulario
    if (query.length === 0) {
        limpiarFormulario();
        return;
    }

    // Validar que el número de serie tenga entre 6 y 10 caracteres
    if (query.length < 6 || query.length > 10) {
        $('#resultadoBusqueda').html('<p>El número de serie debe tener entre 6 y 10 caracteres.</p>');
        $('#guardarBtn').prop('disabled', true); // Desactivar el botón de guardar
        return;
    }

    // Realizar la búsqueda solo si hay contenido válido en el campo
    $.getJSON('<?= site_url('inventario/buscarPorSerie') ?>', { serie: query })
        .done(function (response) {
            $('#resultadoBusqueda').empty();
            if (response.status === 'success' && response.data && response.data.length > 0) {
                const equipo = response.data[0]; // Tomar el primer resultado exacto

                // Actualizar los campos del formulario
                $('#equipoId').val(equipo.id);
                $('#serie').val(equipo.serie);
                $('#marca').val(equipo.marca);
                $('#modelo').val(equipo.modelo);
                $('#procesador').val(equipo.procesador);
                $('#ram').val(equipo.ram);
                $('#almacenamiento').val(equipo.almacenamiento);

                // Actualizar los checkboxes
                const checkboxes = [
                    'cargador', 'cable_poder', 'lupa', 'termico', 
                    'lapiz_optico', 'bateria', 'licencia_office', 'licencia_windows'
                ];
                checkboxes.forEach((checkbox) => {
                    const isChecked = equipo[checkbox] === '1' || equipo[checkbox] === 1 || equipo[checkbox] === true;
                    $(`#${checkbox}`).prop('checked', isChecked);
                });

                $('#guardarBtn').prop('disabled', false); // Activar el botón de guardar
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Sin coincidencias',
                    text: 'No se encontraron equipos con ese número de serie',
                    timer: 2000
                });
                limpiarFormulario();
            }
        })
        .fail(function () {
            $('#resultadoBusqueda').html('<p>Error en la búsqueda</p>');
        });
}, 300));

// Función para limpiar el formulario y desactivar el botón de guardar
function limpiarFormulario() {
    $('#buscarNumeroSerie').val(''); // Limpia el input
    $('#formModificarEquipo')[0].reset(); // Limpia el formulario
    $('#guardarBtn').prop('disabled', true); // Desactivar el botón de guardar
    $('#resultadoBusqueda').empty(); // Limpiar resultados previos
}

// Enviar el formulario para modificar el equipo
$('#formModificarEquipo').on('submit', function (e) {
    e.preventDefault();

    $.post('<?= site_url('inventario/modificarEquipo') ?>', $(this).serialize())
        .done(function (response) {
            if (response.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Inventario exitoso',
                    text: 'Equipo inventariado correctamente',
                    timer: 2000,
                    showConfirmButton: false
                });
                limpiarFormulario();
                table.ajax.reload(); // Recargar la tabla de equipos inventariados
                $('#formModificarEquipo')[0].reset(); // Limpiar el formulario
                $('#guardarBtn').prop('disabled', true); // Desactivar el botón
            } else if (response.status === 'duplicate') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Serie duplicada',
                    text: 'Este equipo ya ha sido inventariado hoy.',
                });
                limpiarFormulario();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'Error desconocido al modificar el equipo'
                });
            }
        })
        .fail(function () {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo conectar con el servidor. Inténtalo de nuevo más tarde.'
            });
        });
});

        // Inicializar DataTable para equipos inventariados
    const table = $('#inventarioTable').DataTable({
        ajax: '<?= site_url('inventario/listarEquiposInventariados') ?>',
        columns: [
            {
                data: null,
                render: data => `
                    <button class="btn btn-outline-info btn-sm btn-delete-serie" data-serie="${data.serie}">
                        <i class="fas fa-trash"></i>
                    </button>
                `
            },             
            { data: 'estado' },
            { data: 'serie' },
            { data: 'ram' },
            { data: 'almacenamiento' },
            { data: 'accesorios' },
            { data: 'licencias' }
        ],
        language: {
            url: '<?= base_url('dist/js/DatatablesSpanish.json'); ?>'
        }
    });

    // Escuchar clic en el botón eliminar
    $('#inventarioTable').on('click', '.btn-delete-serie', function () {
        const serie = $(this).data('serie');

        Swal.fire({
            title: '¿Estás seguro?',
            text: `Eliminarás el equipo con serie: ${serie}`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Enviar solicitud AJAX para eliminar
                $.ajax({
                    url: '<?= site_url('inventario/eliminarEquipo') ?>',
                    method: 'POST',
                    data: { serie: serie },
                    success: function (response) {
                        if (response.status === 'success') {
                            Swal.fire(
                                'Eliminado',
                                `El equipo con serie ${serie} fue eliminado correctamente.`,
                                'success'
                            );
                            table.ajax.reload(); // Recargar la tabla
                        } else {
                            Swal.fire(
                                'Error',
                                response.message || 'No se pudo eliminar el equipo.',
                                'error'
                            );
                        }
                    },
                    error: function () {
                        Swal.fire(
                            'Error',
                            'No se pudo conectar con el servidor. Inténtalo más tarde.',
                            'error'
                        );
                    }
                });
            }
        });
    });



});
</script>

<?= $this->endSection() ?>

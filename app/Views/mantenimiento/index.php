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
    
    <!-- Formulario de registro de mantenimiento -->
    <div id="formularioEquipo" class="container mt-4">
    <form id="formRegistrarMantenimiento">
        <input type="hidden" name="id_unidad_educativa" value="<?= session('id_unidad_educativa') ?>">
        <input type="hidden" name="id_usuario" value="<?= session()->get('user_id') ?>">
        <input type="hidden" name="id_equipo" id="id_equipo"> <!-- Asegúrate de llenar este campo -->

        <div class="row">
            <div class="col-md-3">
                <label for="serie">Serie:</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-tag"></i></span>
                    </div>
                    <input type="text" name="serie" id="serie" class="form-control" required readonly>
                </div>                          
            </div>

            <div class="col-md-3">
                <label for="marca">Marca:</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-tag"></i></span>
                    </div>
                    <input type="text" name="marca" id="marca" class="form-control" required readonly>
                </div>                  
            </div>

            <div class="col-md-3">
                <label for="modelo">Modelo:</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-laptop"></i></span>
                    </div>
                    <input type="text" name="modelo" id="modelo" class="form-control" required readonly>
                </div>
            </div>

            <div class="col-md-3">
                <label for="tipoMantenimiento">Tipo de Mantenimiento:</label>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-toggle-on"></i></span>
                    <select name="tipoMantenimiento" id="tipoMantenimiento" class="form-control" required>
                        <option value="" selected disabled>Seleccione</option>
                        <option value="Preventivo">Preventivo</option>
                        <option value="Correctivo">Correctivo</option>
                    </select>
                </div>
            </div>
        </div>

        <button type="submit" id="guardarBtn" class="btn btn-primary">Guardar</button>
    </form>
    </div>



    <!-- DataTable para los equipos inventariados -->
    <div style="margin-top: 20px;">
        <table id="equiposReportados" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Accion</th>
                    <th>Número de Serie</th>
                    <th>Marca</th>
                    <th>Modelo</th>                            
                    <th>Mantenimiento</th>
                </tr>
            </thead>
            <tbody>
                <!-- Se cargarán los datos vía Ajax -->
            </tbody>
        </table>
    </div>       
</div>

    <script>
$(document).ready(function () {
    // Debounce para controlar la frecuencia de llamadas AJAX
    let debounceTimer;
    const debounce = (callback, delay) => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(callback, delay);
    };

// Inicializar DataTable para equipos inventariados
const table = $('#equiposReportados').DataTable({
    ajax: '<?= site_url('mantenimiento/listarEquiposReportados') ?>', // URL del controlador para obtener los datos
    columns: [
        {
            data: 'id_equipo', // Mostrar el id_equipo directamente
            render: data => `
                <button class="btn btn-outline-info btn-sm btn-delete" data-id-equipo="${data}">
                    <i class="fas fa-trash"></i>
                </button>
            `
        },
        { data: 'serie' },          // Columna de la serie
        { data: 'marca' },          // Columna de la marca
        { data: 'modelo' },         // Columna del modelo
        { data: 'mantenimiento' }  // Columna del mantenimiento
    ],
    language: {
        url: '<?= base_url('dist/js/DatatablesSpanish.json'); ?>' // Archivo de traducción a español
    }
});

    // Búsqueda exacta por número de serie con debounce
    $('#buscarNumeroSerie').on('input', function () {
        const query = $(this).val().trim();

        // Si el campo está vacío, limpiar el formulario
        if (query.length === 0) {
            $('#formRegistrarMantenimiento')[0].reset();
            $('#guardarBtn').prop('disabled', true); // Desactivar el botón de guardar
            $('#resultadoBusqueda').empty(); // Limpiar resultados previos
            return;
        }

            // Validar que el número de serie tenga entre 6 y 10 caracteres
        if (query.length < 6 || query.length > 10) {
        $('#resultadoBusqueda').html('<p>El número de serie debe tener entre 6 y 10 caracteres.</p>');
        $('#guardarBtn').prop('disabled', true); // Desactivar el botón de guardar
        return;
        }


        // Realizar la búsqueda solo si hay contenido en el campo
        debounce(() => {
            $.getJSON('<?= site_url('mantenimiento/buscarPorSerie') ?>', { serie: query })
                .done(function (response) {
                    $('#resultadoBusqueda').empty();
                    if (response.status === 'success' && response.data.length > 0) {
                        const equipo = response.data[0]; // Tomar el primer resultado exacto
                        $('#id_equipo').val(equipo.id);
                        $('#serie').val(equipo.serie);
                        $('#marca').val(equipo.marca);
                        $('#modelo').val(equipo.modelo);
                        $('#guardarBtn').prop('disabled', false); // Activar el botón de guardar
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Sin coincidencias',
                            text: 'No se encontraron equipos con ese número de serie',
                            timer: 2000
                        });
                        $('#buscarNumeroSerie').val(''); // Limpia el input
                        $('#formRegistrarMantenimiento')[0].reset(); // Limpia el formulario
                        $('#guardarBtn').prop('disabled', true); // Desactivar el botón de guardar
                    }
                })
                .fail(function () {
                    $('#resultadoBusqueda').html('<p>Error en la búsqueda</p>');
                });
        }, 300); // Espera de 300 ms antes de ejecutar la búsqueda
    });

    // Enviar el formulario para registrar el mantenimiento del equipo
    $('#formRegistrarMantenimiento').on('submit', function (e) {
        e.preventDefault();
        $.post('<?= site_url('mantenimiento/registrarMantenimiento') ?>', $(this).serialize())
            .done(function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Mantenimiento registrado',
                        text: 'El mantenimiento del equipo ha sido registrado exitosamente',
                        timer: 2000
                    });
                    table.ajax.reload(); // Recargar la tabla de equipos inventariados
                    $('#formRegistrarMantenimiento')[0].reset(); // Limpiar el formulario
                    $('#guardarBtn').prop('disabled', true); // Desactivar el botón
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            })
            .fail(function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al registrar el mantenimiento'
                });
            });
    });

    $('#equiposReportados').on('click', '.btn-delete', function () {
        const idEquipo = $(this).data('id-equipo'); // Asegúrate de usar "data-id-equipo" correctamente
        console.log('ID del equipo para eliminar:', idEquipo); // Depuración

        if (!idEquipo) {
            Swal.fire('Error', 'ID del equipo no proporcionado.', 'error');
            return;
        }

        Swal.fire({
            title: '¿Estás seguro?',
            text: `Eliminarás el equipo con ID ${idEquipo}.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= site_url('mantenimiento/eliminarEquipo') ?>', // URL del controlador para eliminar
                    method: 'POST', // Método POST para enviar datos
                    data: { id_equipo: idEquipo }, // Enviar el ID del equipo
                    dataType: 'json', // Esperar respuesta en JSON
                    success: function (response) {
                        if (response.status === 'success') {
                            Swal.fire('Eliminado', 'El equipo fue eliminado correctamente.', 'success');
                            $('#equiposReportados').DataTable().ajax.reload(); // Recargar tabla
                        } else {
                            Swal.fire(
                                'Error',
                                response.message || 'No se pudo eliminar el equipo.',
                                'error'
                            );
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error AJAX:', error);
                        Swal.fire('Error', 'No se pudo conectar con el servidor. Inténtalo más tarde.', 'error');
                    },
                });
            }
        });
    });

});
</script>
   


<?= $this->endSection() ?>
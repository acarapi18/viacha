<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><b><?= $title; ?></b></h3>
        <div class="float-right d-flex">
            <button class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#modalAdd">
            <i class=" fas fa-plus"></i></button>
            <button class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#filterModal">
            <i class="fas fa-print"></i></button>        
        </div>

    </div>

    <div class="card-body">
        <!-- Aquí el contenido del CRUD de equipos -->
        <table id="equiposTable" class="table table-bordered datatable">
            <thead>
                <tr>
                    <th>Serie</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Procesador</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($equipos as $equipo): ?>
                    <tr>
                        <td><?= $equipo['serie'] ?></td>
                        <td><?= $equipo['marca'] ?></td>
                        <td><?= $equipo['modelo'] ?></td>
                        <td><?= $equipo['procesador'] ?></td>
                        <td><?= $equipo['estado'] ?></td>
                        <td>

                            <button class="btn btn-outline-primary btn-sm btn-edit" data-id="<?= $equipo['id'] ?>" data-toggle="modal" data-target="#modalEdit">
                                <i class=" fas fa-edit"></i>
                            </button>
                            <button class="btn btn-outline-info btn-sm btn-delete" data-id="<?= $equipo['id'] ?>">
                                <i class="fas fa-trash"></i>
                            </button>   
                                                        
                            <button class="btn btn-outline-secondary btn-sm btn-pdf" data-id="<?= $equipo['id'] ?>" onclick="generatePDF(<?= $equipo['id'] ?>)">
                            <i class="fas fa-file-pdf"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Agregar -->
<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddLabel">Agregar Equipo a la Unidad Educativa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAdd">
                <div class="modal-body">
                    <input type="hidden" name="id_unidad_educativa" value="<?= session('id_unidad_educativa') ?>">
                    <input type="hidden" name="id_usuario" value="<?= session()->get('user_id') ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                </div>
                                <input type="text" name="serie" placeholder="Número de Serie" class="form-control" required>
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                </div>
                                <input type="text" name="marca" placeholder="Marca" class="form-control" required>
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-laptop"></i></span>
                                </div>
                                <input type="text" name="modelo" placeholder="Modelo" class="form-control" required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-microchip"></i></span>
                                </div>
                                <input type="text" name="procesador" placeholder="Procesador" class="form-control" require>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-memory"></i></span>
                                </div>
                                <input type="text" name="ram" placeholder="Memoria RAM" class="form-control" require>
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-hdd"></i></span>
                                </div>
                                <input type="text" name="almacenamiento" placeholder="Almacenamiento" class="form-control" require>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group">
                                 <label class="input-group-text"><i class="fas fa-toggle-on"></i></label>
                                    <select name="estado" class="form-control" required>
                                        <option selected>Estado de Recepcion</option>
                                        <option value="Nuevo">Nuevo</option>
                                        <option value="Usado">Usado</option>
                                        <option value="Reparado">Reparado</option>
                                    </select>
                                </div>                            
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-chalkboard"></i></span>
                                </div>
                                <textarea class="form-control" name="observacion" placeholder="Obaservacion" aria-label="With textarea"></textarea>                    </div>
                            </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Accesorios</label><br>
                                <input type="checkbox" name="cargador" value="1"> Cargador<br>
                                <input type="checkbox" name="cable_poder" value="1"> Cable de Poder<br>
                                <input type="checkbox" name="lupa" value="1"> Lupa<br>
                                <input type="checkbox" name="termico" value="1"> Térmico<br>
                                <input type="checkbox" name="lapiz_optico" value="1"> Lápiz Óptico<br>
                                <input type="checkbox" name="bateria" value="1"> Batería<br>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Licencias</label><br>
                                <input type="checkbox" name="licencia_office" value="1"> Office<br>
                                <input type="checkbox" name="licencia_windows" value="1"> Windows<br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel">Editar Equipo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEdit">
                <div class="modal-body">
                    <input type="hidden" name="id">
                    <input type="hidden" name="id_unidad_educativa" value="<?= session()->get('id_unidad_educativa') ?>"> <!-- id_unidad_educativa -->
                    <input type="hidden" name="id_usuario" value="<?= session()->get('user_id') ?>">
                    <!-- Resto de los campos para editar equipo -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                </div>
                                <input type="text" name="serie" placeholder="Número de Serie" class="form-control" disabled>
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                </div>
                                <input type="text" name="marca" placeholder="Marca" class="form-control" disabled>
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-laptop"></i></span>
                                </div>
                                <input type="text" name="modelo" placeholder="Modelo" class="form-control" disabled>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-microchip"></i></span>
                                </div>
                                <input type="text" name="procesador" placeholder="Procesador" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-memory"></i></span>
                                </div>
                                <input type="text" name="ram" placeholder="Memoria RAM" class="form-control" require>
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-hdd"></i></span>
                                </div>
                                <input type="text" name="almacenamiento" placeholder="Almacenamiento" class="form-control" require>
                            </div>
                            
                            <div class="input-group mb-3">
                                <div class="input-group">
                                 <label class="input-group-text"><i class="fas fa-toggle-on"></i></label>
                                    <select name="estado" class="form-control" required>
                                        <option selected>Estado de Recepcion</option>
                                        <option value="Nuevo">Nuevo</option>
                                        <option value="Usado">Usado</option>
                                        <option value="Reparado">Reparado</option>
                                    </select>
                                </div>                            
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-chalkboard"></i></span>
                                </div>
                                <textarea class="form-control" name="observacion" placeholder="Observacion" aria-label="With textarea"></textarea>                    </div>
                            </div>
                            
                           
                        
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Accesorios</label><br>
                                <input type="checkbox" name="cargador" value="1"> Cargador<br>
                                <input type="checkbox" name="cable_poder" value="1"> Cable de Poder<br>
                                <input type="checkbox" name="lupa" value="1"> Lupa<br>
                                <input type="checkbox" name="termico" value="1"> Térmico<br>
                                <input type="checkbox" name="lapiz_optico" value="1"> Lápiz Óptico<br>
                                <input type="checkbox" name="bateria" value="1"> Batería<br>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Licencias</label><br>
                                <input type="checkbox" name="licencia_office" value="1"> Office<br>
                                <input type="checkbox" name="licencia_windows" value="1"> Windows<br>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        // Agregar Equipo
        $('#formAdd').submit(function(e) {
            e.preventDefault();
            $.post('<?= site_url('equipos/store') ?>', $(this).serialize(), function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        title: 'Éxito',
                        text: 'Equipo agregado correctamente',
                        icon: 'success',
                        //confirmButtonText: 'OK'
                        //position: "top-end",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                } else if (response.status === 'error') {
                    Swal.fire({
                        title: 'Error',
                        text: response.message,
                        icon: 'error',
                        confirmButtonText: 'Entendido'
                    });
                }
            }).fail(function() {
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al procesar la solicitud.',
                    icon: 'error',
                    confirmButtonText: 'Entendido'
                });
            });
        });

        // Editar Equipo - Llenar modal
        $('.btn-edit').click(function() {
            var id = $(this).data('id'); // Obtener el ID del equipo
            $.get('<?= site_url('equipos/getEquipos/') ?>' + id, function(data) {
                // Llenar los campos del formulario con los datos obtenidos
                $('#formEdit input[name="id"]').val(data.id);
                $('#formEdit input[name="serie"]').val(data.serie);
                $('#formEdit input[name="marca"]').val(data.marca);
                $('#formEdit input[name="modelo"]').val(data.modelo);
                $('#formEdit input[name="procesador"]').val(data.procesador);
                $('#formEdit input[name="ram"]').val(data.ram);
                $('#formEdit input[name="almacenamiento"]').val(data.almacenamiento);
                $('#formEdit select[name="estado"]').val(data.estado);
                $('#formEdit textarea[name="observacion"]').val(data.observacion);

                // Verificar los valores de los checkboxes y marcarlos si son 1
                $('#formEdit input[name="cargador"]').prop('checked', data.cargador == 1);
                $('#formEdit input[name="cable_poder"]').prop('checked', data.cable_poder == 1);
                $('#formEdit input[name="lupa"]').prop('checked', data.lupa == 1);
                $('#formEdit input[name="termico"]').prop('checked', data.termico == 1);
                $('#formEdit input[name="lapiz_optico"]').prop('checked', data.lapiz_optico == 1);
                $('#formEdit input[name="bateria"]').prop('checked', data.bateria == 1);
                $('#formEdit input[name="licencia_office"]').prop('checked', data.licencia_office == 1);
                $('#formEdit input[name="licencia_windows"]').prop('checked', data.licencia_windows == 1);

                // Mostrar el modal de edición
                $('#modalEdit').modal('show');
            }).fail(function() {
                alert('No se pudo obtener la información del equipo. Inténtelo de nuevo.');
            });
        });

        // Guardar cambios de edición
        $('#formEdit').submit(function(e) {
            e.preventDefault();
            var id = $('#formEdit input[name="id"]').val();
            $.post('<?= site_url('equipos/update/') ?>' + id, $(this).serialize(), function(response) {
                Swal.fire('Éxito', 'Equipo actualizado correctamente', 'success');
                location.reload();
            });
        });

        // Eliminar equipo
        $('.btn-delete').click(function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminarlo!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post('<?= site_url('equipos/delete/') ?>' + id, function(response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    title: 'Eliminado',
                                    text: 'El equipo ha sido eliminado.',
                                    icon: 'success',
                                    //confirmButtonText: 'OK'
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    // Recargar la página después de cerrar el SweetAlert
                                    location.reload();
                                });
                            } else if (response.status === 'error') {
                                Swal.fire({
                                    title: 'Error',
                                    text: response.message,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        }).fail(function() {
                            Swal.fire({
                                title: 'Error',
                                text: 'Ocurrió un problema al intentar eliminar el equipo.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        });
                    }
                });
        });

        //iniciar la tabla
        $('#equiposTable').DataTable({
        "language": {
            "url": "<?= base_url('dist/js/DatatablesSpanish.json'); ?>"
        }
        });

    });


</script>

<?= $this->endSection() ?>

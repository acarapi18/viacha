<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><b><?= $title; ?></b></h3>
    </div>
    <div class="card-body">
        <!-- Tabla de asignación de mantenimientos -->
        <table id="asignacionTable" class="table table-bordered datatable">
            <thead>
                <tr>
                    <th>RUE</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>D/F Solicitud</th>
                    <th>Num. Equipos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pendientes as $pendiente): ?>
                    <tr>
                        <td><?= esc($pendiente['codigo_rue']) ?></td>
                        <td><?= esc($pendiente['nombre']) ?></td>
                        <td><?= esc($pendiente['telefono']) ?></td>
                        <td><?= esc($pendiente['fecha_solicitud']) ?></td>
                        <td><?= esc($pendiente['cantidad_equipos']) ?></td>
                        <td>
                            <button class="btn btn-outline-primary btn-sm btn-assign" 
                                    data-id="<?= esc($pendiente['id_unidad']) ?>" 
                                    data-name="<?= esc($pendiente['nombre']) ?>" 
                                    data-toggle="modal" 
                                    data-target="#modalAssign">
                                <i class="fas fa-user-plus"></i> Técnico
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para asignar técnico -->
    <div class="modal fade" id="modalAssign" tabindex="-1" aria-labelledby="modalAssignLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAssignLabel">Asignar Técnico</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formAssign">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-school"></i></span>
                            </div>
                            <input type="text" id="unidadName" class="form-control" readonly placeholder="Unidad Educativa">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user-cog"></i></span>
                            </div>
                            <select id="tecnico" name="tecnico" class="form-control" required>
                                <option value="">Seleccione un técnico</option>
                                <?php foreach ($tecnicos as $tecnico): ?>
                                    <option value="<?= esc($tecnico['id']) ?>"><?= esc($tecnico['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <label class="input-group-text"><i class="fas fa-comment-dots"></i></label>
                            <textarea id="observacion" name="observacion" class="form-control" rows="3" placeholder="Observación"></textarea>
                        </div>
                        <div class="input-group mb-3">
                            <label class="input-group-text"><i class="fas fa-calendar-alt"></i></label>
                            <input type="date" id="fecha_asignacion" name="fecha_asignacion" class="form-control" required placeholder="Fecha de Asignación">
                        </div>
                        <input type="hidden" id="unidadId" name="unidad_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Asignar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de asignaciones realizadas -->
<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title"><b>Asignaciones Realizadas</b></h3>
    </div>
    <div class="card-body">
        <table id="asignacionesRealizadasTable" class="table table-bordered datatable">
            <thead>
                <tr>
                    <th>Unidad Educativa</th>
                    <th>Técnico Asignado</th>
                    <th>Fecha Asignación</th>
                    <th>Observación</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($asignaciones as $asignacion): ?>
                    <tr>
                        <td><?= esc($asignacion['nombre_unidad']) ?></td>
                        <td><?= esc($asignacion['nombre_tecnico']) ?></td>
                        <td><?= esc($asignacion['fecha_asignacion']) ?></td>
                        <td><?= esc($asignacion['observacion']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Scripts -->
<script>
    $(document).ready(function() {
        // Inicializar DataTable para asignaciones pendientes
        $('#asignacionTable').DataTable({
            "language": {
                "url": "<?= base_url('dist/js/DatatablesSpanish.json'); ?>"
            }
        });

        // Inicializar DataTable para asignaciones realizadas
        $('#asignacionesRealizadasTable').DataTable({
            "language": {
                "url": "<?= base_url('dist/js/DatatablesSpanish.json'); ?>"
            }
        });

        // Pasar datos al modal
        $('.btn-assign').on('click', function() {
            $('#unidadId').val($(this).data('id'));
            $('#unidadName').val($(this).data('name'));
        });

        // Manejo de la asignación de técnico
        $('#formAssign').submit(function(e) {
            e.preventDefault(); // Prevenir envío predeterminado del formulario
            $.post('<?= base_url('asignacion/asignarTecnico') ?>', $(this).serialize(), function(response) {
                if (response.success) {
                    Swal.fire('Éxito', response.message || 'Asignación realizada correctamente', 'success');
                    $('#modalAssign').modal('hide'); // Cerrar modal
                    location.reload(); // Recargar la página
                } else {
                    Swal.fire('Error', response.message || 'Ocurrió un error al asignar', 'error');
                }
            }).fail(function() {
                Swal.fire('Error', 'Algo salió mal. Intente nuevamente.', 'error');
            });
        });
    });
</script>

<?= $this->endSection() ?>

<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><b><?= esc($title); ?></b></h3>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Columna de Unidades Educativas -->
            <div class="col-md-4">
                <h5>Unidades Educativas</h5>
                <ul class="list-group" id="unidad-educativa-list">
                    <?php foreach ($unidades as $unidad): ?>
                        <li class="list-group-item unidad-item" data-id="<?= $unidad['id']; ?>">
                            <?= esc($unidad['nombre']); ?> (<?= esc($unidad['codigo_rue']); ?>)
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Columna de Equipos -->
            <div class="col-md-8">
                <h5>Equipos Asociados</h5>
                <table class="table table-bordered" id="equipos-table">
                    <thead>
                        <tr>
                            <th>Serie</th>
                            <th>Mantenimiento</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" class="text-center">Seleccione una unidad educativa</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar equipo -->
<div class="modal fade" id="editEquipoModal" tabindex="-1" role="dialog" aria-labelledby="editEquipoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="edit-equipo-form">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEquipoModalLabel">Editar Equipo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="equipo-id" name="equipo_id">
                    <div class="form-group">
                        <label for="serie">Serie</label>
                        <input type="text" class="form-control" id="serie" name="serie" required>
                    </div>
                    <div class="form-group">
                        <label for="tipo_mantenimiento">Tipo de mantenimiento</label>
                        <input type="text" class="form-control" id="tipo_mantenimiento" name="tipo_mantenimiento" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha_mantenimiento">Fecha</label>
                        <input type="text" class="form-control" id="fecha_mantenimiento" name="fecha_mantenimiento" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function () {
    // Cargar equipos al seleccionar una unidad educativa
    $('.unidad-item').on('click', function () {
        const unidadId = $(this).data('id');
        $('#equipos-table tbody').html('<tr><td colspan="4" class="text-center">Cargando...</td></tr>');
        $.ajax({
            url: '<?= base_url("soporte/getByUnidad") ?>/' + unidadId,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    let rows = '';
                    response.data.forEach(equipo => {
                        rows += `
                            <tr>
                                <td>${equipo.serie}</td>
                                <td>${equipo.tipo_mantenimiento}</td>
                                <td>${equipo.fecha_mantenimiento}</td>
                                <td>
                                    <button class="btn btn-outline-info btn-sm edit-equipo-btn" data-id="${equipo.id}">
                                    <i class="fas fa-cogs"></i> </button>
                                </td>
                            </tr>`;
                    });
                    $('#equipos-table tbody').html(rows);
                } else {
                    $('#equipos-table tbody').html('<tr><td colspan="4" class="text-center">No hay equipos asociados</td></tr>');
                    Swal.fire({
                        icon: 'info',
                        title: 'Información',
                        text: 'No hay equipos asociados a esta unidad educativa.',
                    });
                }
            }
        });
    });

    // Editar equipo
    $(document).on('click', '.edit-equipo-btn', function () {
        const equipoId = $(this).data('id');
        $.ajax({
            url: '<?= base_url("soporte/getById") ?>/' + equipoId,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    const equipo = response.data;
                    $('#equipo-id').val(equipo.id);
                    $('#serie').val(equipo.serie);
                    $('#tipo_mantenimiento').val(equipo.tipo_mantenimiento);
                    $('#fecha_mantenimiento').val(equipo.fecha_mantenimiento);
                    $('#editEquipoModal').modal('show');
                }
            }
        });
    });

    // Guardar cambios en el equipo
    $('#edit-equipo-form').on('submit', function (e) {
        e.preventDefault();
        const formData = $(this).serialize();
        $.ajax({
            url: '<?= base_url("soporte/update") ?>',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#editEquipoModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: 'Equipo actualizado correctamente.',
                    });
                    // Actualiza la lista de equipos
                    $('.unidad-item[data-id="' + response.unidad_id + '"]').trigger('click');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un error al actualizar el equipo.',
                    });
                }
            }
        });
    });
});
</script>

<?= $this->endSection() ?>

<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Gestión de Unidades Educativas</h3>
        <button class="btn btn-primary float-right" data-toggle="modal" data-target="#modalAdd">
            Agregar Unidad Educativa
        </button>
    </div>
    <div class="card-body">
        <!-- Aquí el contenido del CRUD de roles -->
        <!-- Tabla de roles -->
        <table class="table table-bordered datatable">
            <thead>
                <tr>
                    <th>Código RUE</th>
                    <th>Nombre</th>
                    <th>Direccion</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($unidades as $unidad): ?>
                    <tr>
                        <td><?= $unidad['codigo_rue'] ?></td>
                        <td><?= $unidad['nombre'] ?></td>
                        <td><?= $unidad['direccion'] ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm btn-edit" data-id="<?= $unidad['id'] ?>" data-toggle="modal" data-target="#modalEdit">
                                <i class=" fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm btn-delete" data-id="<?= $unidad['id'] ?>">
                                <i class="fas fa-trash"></i>
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
                <h5 class="modal-title" id="modalAddLabel">Agregar Unidad Educativa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAdd">
                <div class="modal-body">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="">Codigo RUE:</span>
                        </div>
                        <input type="text" name="codigo_rue" class="form-control" required>
                    </div>
                    <p>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="">Nombre:</span>
                        </div>
                        <input type="text" name="nombre" placeholder="Nombre" class="form-control" required>
                    </div>
                    </p>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="">Direccion:</span>
                        </div>
                        <input type="text" name="direccion" placeholder="Dirección" class="form-control">
                    </div>
                    <p>
                    <div class="input-group">
                        <label class="input-group-text" for="inputGroupSelect01">Dependencia:</label>
                        <select name="dependencia" class="form-control" id="">
                            <option selected>Seleccionar...</option>
                            <option value="Fiscal">Fiscal</option>
                            <option value="Convenio">Convenio</option>
                        </select>
                    </div>
                    <p>
                    <div class="input-group">
                        <label class="input-group-text" for="inputGroupSelect01">Area geografica:</label>
                        <select name="area_geografica" class="form-control" id="">
                            <option selected>Seleccionar...</option>
                            <option value="Rural">Rural</option>
                            <option value="Urbano">Urbano</option>
                        </select>
                    </div>
                    </p>
                    <div class="input-group">
                        <label class="input-group-text" for="usuario_id">Usuario:</label>
                        <select name="usuario_id" id="usuario_id" class="form-control" require>
                            <option value="">Seleccione un usuario</option>
                            <?php foreach ($usuarios as $usuario): ?>
                                <option value="<?= $usuario['id']; ?>">
                                    <?= $usuario['rol'] . ' - ' . $usuario['nombre']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <p>
                    <div class="input-group">
                        <label class="input-group-text" for="inputGroupSelect01">Estado:</label>
                        <select name="estado" class="form-control" id="">
                            <option selected>Seleccionar...</option>
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
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
                <h5 class="modal-title" id="modalEditLabel">Editar Unidad Educativa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEdit">
                <div class="modal-body">
                    <input type="hidden" name="id">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="">Codigo RUE:</span>
                        </div>
                        <input type="text" name="codigo_rue" class="form-control" required>
                    </div>
                    <p>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="">Nombre:</span>
                        </div>
                        <input type="text" name="nombre" placeholder="Nombre" class="form-control" required>
                    </div>
                    </p>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="">Direccion:</span>
                        </div>
                        <input type="text" name="direccion" placeholder="Dirección" class="form-control">
                    </div>
                    <p>
                    <div class="input-group">
                        <label class="input-group-text" for="inputGroupSelect01">Dependencia:</label>
                        <select name="dependencia" class="form-control" id="">
                            <option selected>Seleccionar...</option>
                            <option value="Fiscal">Fiscal</option>
                            <option value="Convenio">Convenio</option>
                        </select>
                    </div>
                    <p>
                    <div class="input-group">
                        <label class="input-group-text" for="inputGroupSelect01">Area geografica:</label>
                        <select name="area_geografica" class="form-control" id="">
                            <option selected>Seleccionar...</option>
                            <option value="Rural">Rural</option>
                            <option value="Urbano">Urbano</option>
                        </select>
                    </div>
                    <p>
                    <div class="input-group">
                        <label class="input-group-text" for="usuario_id">Usuario:</label>
                        <select name="usuario_id" id="usuario_id" class="form-control" require>
                            <option value="">Seleccione un usuario</option>
                            <?php foreach ($usuarios as $usuario): ?>
                                <option value="<?= $usuario['id']; ?>">
                                    <?= $usuario['rol'] . ' - ' . $usuario['nombre']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    </p>
                    <div class="input-group">
                        <label class="input-group-text" for="inputGroupSelect01">Estado:</label>
                        <select name="estado" class="form-control" id="">
                            <option selected>Seleccionar...</option>
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
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
        // Agregar Unidad
        $('#formAdd').submit(function(e) {
            e.preventDefault();
            $.post('<?= site_url('unidad_educativa/store') ?>', $(this).serialize(), function(response) {
                Swal.fire('Éxito', 'Unidad Educativa agregada correctamente', 'success');
                location.reload();
            });
        });

        // Editar Unidad - Llenar modal
        $('.btn-edit').click(function() {
            var id = $(this).data('id');
            $.get('<?= site_url('unidad_educativa/getUnidadEducativa/') ?>' + id, function(data) {
                $('#formEdit input[name="id"]').val(data.id);
                $('#formEdit input[name="codigo_rue"]').val(data.codigo_rue);
                $('#formEdit input[name="nombre"]').val(data.nombre);
                $('#formEdit input[name="direccion"]').val(data.direccion);
                $('#formEdit select[name="dependencia"]').val(data.dependencia);
                $('#formEdit select[name="area_geografica"]').val(data.area_geografica);
                $('#formEdit select[name="estado"]').val(data.estado);
                $('#formEdit select[name="usuario_id"]').val(data.usuario_id);
                $('#modalEdit').modal('show');
            });
        });

        // Guardar cambios de edición
        $('#formEdit').submit(function(e) {
            e.preventDefault();
            var id = $('#formEdit input[name="id"]').val();
            $.post('<?= site_url('unidad_educativa/update/') ?>' + id, $(this).serialize(), function(response) {
                Swal.fire('Éxito', 'Unidad Educativa actualizada correctamente', 'success');
                location.reload();
            });
        });

        // Eliminar Unidad
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
                    $.post('<?= site_url('unidad_educativa/delete/') ?>' + id, function(response) {
                        Swal.fire('Eliminado', 'La Unidad Educativa ha sido eliminada.', 'success');
                        location.reload();
                    });
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>
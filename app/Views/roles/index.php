<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Gestión de Roles</h3>
        <button class="btn btn-primary float-right" data-toggle="modal" data-target="#modalAddRol">Agregar Rol</button>
    </div>
    <div class="card-body">
        <!-- Aquí el contenido del CRUD de roles -->

        <!-- Tabla de roles -->
        <table class="table table-bordered datatable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($roles as $rol): ?>
                    <tr>
                        <td><?= $rol['id'] ?></td>
                        <td><?= $rol['nombre'] ?></td>
                        <td><?= $rol['descripcion'] ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm btn-edit" data-id="<?= $rol['id'] ?>" data-toggle="modal" data-target="#modalEdit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm btn-delete" data-id="<?= $rol['id'] ?>">
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
<div class="modal fade" id="modalAddRol" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddLabel">Agregar Rol</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAddRol">
                <div class="modal-body">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="">Nombre:</span>
                        </div>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <br>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Descripción:</span>
                        </div>
                        <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
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
                <h5 class="modal-title" id="modalEditLabel">Editar Rol</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEdit">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="">Nombre:</span>
                        </div>
                        <input type="text" class="form-control" id="nombre_edit" name="nombre" required>
                    </div>
                    <br>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Descripción:</span>
                        </div>
                        <textarea class="form-control" id="descripcion_edit" name="descripcion" required></textarea>
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

        // Agregar Rol
        $('#formAddRol').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: '<?= site_url('roles/store') ?>',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#modalAddRol').modal('hide');
                    if (response.status == 'success') {
                        Swal.fire('Agregado', 'El rol ha sido agregado correctamente.', 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', 'No se pudo agregar el rol.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Error en la solicitud.', 'error');
                }
            });
        });

        // Editar Rol - Abrir el modal con datos
        $('.btn-edit').click(function() {
            const id = $(this).data('id');

            $.ajax({
                url: '<?= site_url('roles/getRole') ?>/' + id,
                type: 'GET',
                success: function(data) {
                    $('#formEdit input[name="id"]').val(data.id);
                    $('#formEdit input[name="nombre"]').val(data.nombre);
                    $('#formEdit textarea[name="descripcion"]').val(data.descripcion);

                    $('#modalEdit').modal('show');
                },
                error: function() {
                    Swal.fire('Error', 'No se pudo obtener la información del rol.', 'error');
                }
            });
        });

        // Actualizar Rol
        $('#formEdit').submit(function(e) {
            e.preventDefault();
            const id = $('#formEdit input[name="id"]').val();

            $.ajax({
                url: '<?= site_url('roles/update') ?>/' + id,
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#modalEdit').modal('hide');
                    if (response.status == 'success') {
                        Swal.fire('Actualizado', 'El rol ha sido actualizado correctamente.', 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', 'No se pudo actualizar el rol.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Error en la solicitud.', 'error');
                }
            });
        });

        // Eliminar Rol
        $('.btn-delete').click(function() {
            const id = $(this).data('id');

            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esta acción.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= site_url('roles/delete') ?>/' + id,
                        type: 'POST',
                        success: function(response) {
                            if (response.status == 'success') {
                                Swal.fire('Eliminado', 'El rol ha sido eliminado.', 'success').then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error', 'No se pudo eliminar el rol.', 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error', 'Error en la solicitud.', 'error');
                        }
                    });
                }
            });
        });

    });
</script>
<?= $this->endSection() ?>
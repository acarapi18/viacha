<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Gestión de Usuarios</h3>
        <button class="btn btn-primary float-right" data-toggle="modal" data-target="#modalAdd">
            Agregar Usuario
        </button>
    </div>
    <div class="card-body">
        <!-- Aquí el contenido del CRUD de roles -->
        <table class="table table-bordered">
            <!-- Tabla de roles -->
            <table class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Usuario</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?= $usuario['nombre'] ?></td>
                            <td><?= $usuario['apellido'] ?></td>
                            <td><?= $usuario['usuario'] ?></td>
                            <td><?= $usuario['rol'] ?></td>
                            <td><?= $usuario['estado'] ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm btn-edit" data-id="<?= $usuario['id'] ?>" data-toggle="modal" data-target="#modalEdit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm btn-delete" data-id="<?= $usuario['id'] ?>">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <button class="btn btn-warning btn-sm btnCambiarPassword" data-id="<?= $usuario['id']; ?>">
                                    <i class="fas fa-key"></i>
                                </button>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </table>
    </div>
</div>


<!-- Modal Agregar -->
<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddLabel">Agregar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAdd">
                <div class="modal-body">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="">Nombre:</span>
                        </div>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <p>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="">Apellido:</span>
                        </div>
                        <input type="text" name="apellido" class="form-control" required>
                    </div>
                    </p>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="">Usuario:</span>
                        </div>
                        <input type="text" name="usuario" class="form-control" required>
                    </div>
                    <p>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="">Contraseña:</span>
                        </div>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <p>
                    <div class="input-group">
                        <label class="input-group-text" for="inputGroupSelect01">Rol:</label>
                        <select name="rol" class="form-control" id="">
                            <option selected>Seleccionar...</option>
                            <option value="Administrador">Administrador</option>
                            <option value="Tecnico">Tecnico</option>
                            <option value="Responsable">Responsable</option>
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
                <h5 class="modal-title" id="modalEditLabel">Editar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEdit">
                <div class="modal-body">
                    <input type="hidden" name="id">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="">Nombre:</span>
                        </div>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <p>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="">Apellido:</span>
                        </div>
                        <input type="text" name="apellido" class="form-control" required>
                    </div>
                    </p>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="">Usuario:</span>
                        </div>
                        <input type="text" name="usuario" class="form-control" required>
                    </div>
                    <p>
                    <div class="input-group">
                        <label class="input-group-text" for="inputGroupSelect01">Rol:</label>
                        <select name="rol" class="form-control" id="">
                            <option value="Administrador">Administrador</option>
                            <option value="Tecnico">Tecnico</option>
                            <option value="Responsable">Responsable</option>
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
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal para Cambiar Contraseña -->
<div class="modal fade" id="modalCambiarPassword" tabindex="-1" role="dialog" aria-labelledby="modalCambiarPasswordLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCambiarPasswordLabel">Cambiar Contraseña</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formCambiarPassword">
                    <input type="hidden" id="id_usuario_password">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="">Nueva Contraseña:</span>
                        </div>
                        <input type="password" name="nueva_password" id="nueva_password" class="form-control" required>
                    </div>
                    </p>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="">Confirmar Contraseña:</span>
                        </div>
                        <input type="text" name="confirmar_password" id="confirmar_password" class="form-control" required>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnCambiarPassword">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Similar functionality para agregar, editar y eliminar como el CRUD anterior.
    $(document).ready(function() {
        // Agregar Usuario
        $('#formAdd').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '<?= site_url('usuarios/store') ?>',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#modalAdd').modal('hide');
                    if (response.status == 'success') {
                        Swal.fire('Agregado', 'El usuario ha sido agregado correctamente.', 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', 'No se pudo agregar el usuario.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Error en la solicitud.', 'error');
                }
            });
        });
        // Editar Usuario - Abrir el modal con datos
        $('.btn-edit').click(function() {
            const id = $(this).data('id');
            $.ajax({
                url: '<?= site_url('usuarios/getUsuario') ?>/' + id,
                type: 'GET',
                success: function(data) {
                    $('#formEdit input[name="id"]').val(data.id);
                    $('#formEdit input[name="nombre"]').val(data.nombre);
                    $('#formEdit input[name="apellido"]').val(data.apellido);
                    $('#formEdit input[name="usuario"]').val(data.usuario);
                    $('#formEdit input[name="id_rol"]').val(data.id_rol);
                    $('#formEdit select[name="estado"]').val(data.estado);
                    $('#modalEdit').modal('show');
                },
                error: function() {
                    Swal.fire('Error', 'No se pudo obtener la información del usuario.', 'error');
                }
            });
        });
        // Actualizar Usuario
        $('#formEdit').submit(function(e) {
            e.preventDefault();
            const id = $('#formEdit input[name="id"]').val();
            $.ajax({
                url: '<?= site_url('usuarios/update') ?>/' + id,
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#modalEdit').modal('hide');
                    if (response.status == 'success') {
                        Swal.fire('Actualizado', 'El usuario ha sido actualizado correctamente.', 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', 'No se pudo actualizar el usuario.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Error en la solicitud.', 'error');
                }
            });
        });
        // Eliminar Usuario
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
                        url: '<?= site_url('usuarios/delete') ?>/' + id,
                        type: 'POST',
                        success: function(response) {
                            if (response.status == 'success') {
                                Swal.fire('Eliminado', 'El usuario ha sido eliminado.', 'success').then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error', 'No se pudo eliminar el usuario.', 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error', 'Error en la solicitud.', 'error');
                        }
                    });
                }
            });
        });



        // Abrir el modal para cambiar contraseña
        $('.btnCambiarPassword').click(function() {
            var id = $(this).data('id');
            $('#id_usuario_password').val(id);
            $('#modalCambiarPassword').modal('show');
        });

        // Manejar el evento de guardar nueva contraseña
        $('#btnCambiarPassword').click(function() {
            var id_usuario = $('#id_usuario_password').val();
            var nueva_password = $('#nueva_password').val();
            var confirmar_password = $('#confirmar_password').val();

            if (nueva_password !== confirmar_password) {
                Swal.fire('Error', 'Las contraseñas no coinciden', 'error');
                return;
            }

            $.ajax({
                url: '<?= base_url('usuarios/cambiarPassword'); ?>',
                method: 'POST',
                data: {
                    id: id_usuario,
                    password: nueva_password
                },
                success: function(response) {
                    $('#modalCambiarPassword').modal('hide');
                    if (response.success) {
                        Swal.fire('Éxito', 'Contraseña actualizada correctamente', 'success');
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Ocurrió un error en la solicitud', 'error');
                }
            });
        });



    });
</script>

<?= $this->endSection() ?>
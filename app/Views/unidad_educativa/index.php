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
        <!-- Tabla de roles -->
        <table id="unidadeseducativaTable" class="table table-bordered datatable">
            <thead>
                <tr>
                    <th>Código RUE</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Direccion</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($unidades as $unidad): ?>
                    <tr>
                        <td><?= $unidad['codigo_rue'] ?></td>
                        <td><?= $unidad['nombre'] ?></td>
                        <td><?= $unidad['telefono'] ?></td>
                        <td><?= $unidad['direccion'] ?></td>
                        <td>
                            <button class="btn btn-outline-primary btn-sm btn-edit" data-id="<?= $unidad['id'] ?>" data-toggle="modal" data-target="#modalEdit">
                                <i class=" fas fa-edit"></i>
                            </button>
                            <button class="btn btn-outline-info btn-sm btn-delete" data-id="<?= $unidad['id'] ?>">
                                <i class="fas fa-trash"></i>
                            </button>           
                            
                            <button class="btn btn-outline-secondary btn-sm btn-pdf" data-id="<?= $unidad['id'] ?>" onclick="generatePDF(<?= $unidad['id'] ?>)">
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
                <h5 class="modal-title" id="modalAddLabel">Agregar Unidad Educativa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAdd">
                <div class="modal-body">
                
                      <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id=""><i class="fas fa-code"></i></span>
                        </div>
                        <input type="text" name="codigo_rue" placeholder="Codigo Rue" class="form-control" required>
                    </div>
                    <p>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id=""><i class="fas fa-school"></i></span>
                        </div>
                        <input type="text" name="nombre" placeholder="Nombre" class="form-control" required>
                    </div>
                    </p>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id=""><i class="fas fa-phone"></i></span>
                        </div>
                        <input type="text" name="telefono" placeholder="Telefono" class="form-control">
                    </div>
                    <p>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id=""><i class="far fa-map"></i></span>
                        </div>
                        <input type="text" name="direccion" placeholder="Dirección" class="form-control">
                    </div>
                    <p>
                        
                    <div class="input-group">
                        <label class="input-group-text"><i class="fas fa-route"></i></label>
                        <select name="dependencia" class="form-control" id="">
                            <option selected>Dependencia</option>
                            <option value="Fiscal">Fiscal</option>
                            <option value="Convenio">Convenio</option>
                        </select>
                    </div>
                    <p>
                    <div class="input-group">
                        <label class="input-group-text"><i class="fas fa-map-signs"></i></label>
                        <select name="area_geografica" class="form-control" id="">
                            <option selected>Area Geografica</option>
                            <option value="Rural">Rural</option>
                            <option value="Urbano">Urbano</option>
                        </select>
                    </div>
                    </p>
                    
                    <div class="input-group">
                        <label class="input-group-text"><i class="fas fa-toggle-on"></i></label>
                        <select name="estado" class="form-control" id="">
                            <option selected>Estado</option>
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
                        <span class="input-group-text" id=""><i class="fas fa-code"></i></span>
                        </div>
                        <input type="text" name="codigo_rue" class="form-control" required>
                    </div>
                    <p>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text" id=""><i class="fas fa-school"></i></span>
                        </div>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    </p>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text" id=""><i class="fas fa-phone"></i></span>
                        </div>
                        <input type="text" name="telefono" class="form-control">
                    </div>
                    <p>

                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text" id=""><i class="far fa-map"></i></span>
                        </div>
                        <input type="text" name="direccion" class="form-control">
                    </div>
                    <p>
                    <div class="input-group">
                    <label class="input-group-text"><i class="fas fa-route"></i></label>
                        <select name="dependencia" class="form-control" id="">
                            <option selected>Dependencia</option>
                            <option value="Fiscal">Fiscal</option>
                            <option value="Convenio">Convenio</option>
                        </select>
                    </div>
                    <p>
                    <div class="input-group">
                    <label class="input-group-text"><i class="fas fa-map-signs"></i></label>
                        <select name="area_geografica" class="form-control" id="">
                            <option selected>Area Geografica</option>
                            <option value="Rural">Rural</option>
                            <option value="Urbano">Urbano</option>
                        </select>
                    </div>
                    
                    </p>
                    <div class="input-group">
                    <label class="input-group-text"><i class="fas fa-toggle-on"></i></label>
                        <select name="estado" class="form-control" id="">
                            <option selected>Estado</option>
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

<!-- Modal para filtrar e imprimir -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filtrar Unidades Educativas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="filterForm">
            <div class="modal-body">
                
                    <div class="mb-3">
                        <label for="dependencia" class="form-label">Dependencia</label>
                        <select id="dependencia" class="form-select">
                            <option value="">Seleccione</option>
                            <option value="Fiscal">Fiscal</option>
                            <option value="Convenio">Convenio</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="areaGeografica" class="form-label">Área Geográfica</label>
                        <select id="areaGeografica" class="form-select">
                            <option value="">Seleccione</option>
                            <option value="Urbano">Urbano</option>
                            <option value="Rural">Rural</option>
                        </select>
                    </div>
                
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" onclick="generatePDF()">Generar PDF</button>
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
                if (response.status === 'error') {
                    Swal.fire('Error', response.message, 'error');
                } else {
                    Swal.fire('Éxito', 'Unidad Educativa agregada correctamente', 'success');
                    location.reload();
                }
            });
            });

        // Editar Unidad - Llenar modal
        $('.btn-edit').click(function() {
            var id = $(this).data('id');
            $.get('<?= site_url('unidad_educativa/getUnidadEducativa/') ?>' + id, function(data) {
                $('#formEdit input[name="id"]').val(data.id);
                $('#formEdit input[name="codigo_rue"]').val(data.codigo_rue);
                $('#formEdit input[name="nombre"]').val(data.nombre);
                $('#formEdit input[name="telefono"]').val(data.telefono);
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
        // Exportar en pdf
        $('.btn-pdf').click(function() {
        var id = $(this).data('id');
        window.open('<?= site_url('unidad_educativa/pdf') ?>/' + id, '_blank');
        });
              

        $('#unidadeseducativaTable').DataTable({
        "language": {
            "url": "<?= base_url('dist/js/DatatablesSpanish.json'); ?>"
        }
        });


    });
    

</script>
<?= $this->endSection() ?>
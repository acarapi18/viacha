<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">
        <h1>Bienvenido, <?= session()->get('rol') ?> <?= session()->get('nombre') ?> al Dashboard</h1>
        <h2>Unidad Educativa: <?= $nombre_unidad_educativa ?> <?= $id_unidad_educativa ?></h2> <!-- Imprimir la unidad educativa asociada -->
        <!-- Aquí puedes incluir el contenido del dashboard -->
    </div>
</section>

<div class="row">
    <div class="col-lg-3 col-6">
        <!-- Small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>5</h3>
                <p>Equipos Registrados</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-shield"></i>
            </div>
            <a href="<?= site_url('roles') ?>" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <!-- Small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>10</h3>
                <p>Usuarios Registrados</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="<?= site_url('usuarios') ?>" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <!-- Small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>20</h3>
                <p>Unidades Educativas</p>
            </div>
            <div class="icon">
                <i class="fas fa-school"></i>
            </div>
            <a href="<?= site_url('unidad_educativa') ?>" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

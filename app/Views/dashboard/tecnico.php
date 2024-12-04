<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<section class="content">
    <div class="container-fluid">
        <h1>Bienvenido, <?= session()->get('rol') ?> <?= session()->get('nombre') ?> al Dashboard</h1>
    </div>
</section>

<div class="row">
    <div class="col-lg-3 col-6">
        <!-- Small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>5</h3>
                <p>Equipos Reparados</p>
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
                <p>Unidades Educativas Visitadas</p>
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
                <p>Trabajos Asignados</p>
            </div>
            <div class="icon">
                <i class="fas fa-school"></i>
            </div>
            <a href="<?= site_url('unidad_educativa') ?>" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

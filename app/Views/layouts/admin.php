<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : ''; ?></title>
    <!-- Bootstrap & AdminLTE CSS -->
    <link rel="stylesheet" href="<?= base_url('dist/css/adminlte.min.css') ?>">
    <!-- FontAwesome para los iconos -->
    <link rel="stylesheet" href="<?= base_url('plugins/fontawesome-free/css/all.min.css') ?>">
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="<?= base_url('plugins/sweetalert2/sweetalert2.min.css') ?>">
     <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') ?>">

<!-- jQuery -->
<script src="<?= base_url('plugins/jquery/jquery.min.js') ?>"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url('plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<!-- DataTables  & Plugins -->
<script src="<?= base_url('plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
<script src="<?= base_url('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('plugins/datatables-buttons/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('plugins/jszip/jszip.min.js') ?>"></script>
<script src="<?= base_url('plugins/pdfmake/pdfmake.min.js') ?>"></script>
<script src="<?= base_url('plugins/pdfmake/vfs_fonts.js') ?>"></script>
<script src="<?= base_url('plugins/datatables-buttons/js/buttons.html5.min.js') ?>"></script>
<script src="<?= base_url('plugins/datatables-buttons/js/buttons.print.min.js') ?>"></script>
<script src="<?= base_url('plugins/datatables-buttons/js/buttons.colVis.min.js') ?>"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('dist/js/adminlte.min.js') ?>"></script>
<!-- SweetAlert -->
<script src="<?= base_url('plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<!-- Select2 -->
<script src="<?= base_url('plugins/select2/js/select2.min.js') ?>"></script>
   
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= base_url('dashboard'); ?>" class="nav-link">Inicio</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
        <!-- User Profile -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                <i class="fas fa-user"></i> <?= session()->get('nombre'); ?> <?= session()->get('apellido'); ?>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="<?= base_url('logout'); ?>" class="dropdown-item dropdown-footer">Cerrar Sesión</a>
            </div>
        </li>
    </ul>
</nav>
        



        <!-- Main Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="<?= base_url() ?>" class="brand-link">
            <img src="<?= base_url('dist/img/AdminLTELogo.png'); ?>" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">TechViacha</span>
        </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
                

                        <?php 
                        $rol = session()->get('rol'); // Obtener el rol del usuario desde la sesión

                        // Mostrar el menú completo solo si el rol es administrador
                        if ($rol === 'Administrador'): ?>
                            
                            <li class="nav-item">
                            <a href="<?= site_url('dashboard/admin'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                            <!-- Gestión de Unidades Educativas -->
                            <li class="nav-item">
                                <a href="<?= site_url('unidad_educativa'); ?>" class="nav-link">
                                    <i class="nav-icon fas fa-school"></i>
                                    <p>Unidades Educativas</p>
                                </a>
                            </li>

                            <!-- Gestión de Usuarios -->
                            <li class="nav-item">
                                <a href="<?= site_url('usuarios'); ?>" class="nav-link">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>Usuarios</p>
                                </a>
                            </li>

                            <!-- Gestión de Equipos -->
                            <li class="nav-item">
                                <a href="<?= site_url('equipos'); ?>" class="nav-link">
                                    <i class="nav-icon fas fa-desktop"></i>
                                    <p>Equipos</p>
                                </a>
                            </li>

                            <!-- Gestión de asignacion -->
                            <li class="nav-item">
                                <a href="<?= site_url('asignacion'); ?>" class="nav-link">
                                    <i class="nav-icon fas fa-desktop"></i>
                                    <p>Asignacion</p>
                                </a>
                            </li>

                        <?php elseif ($rol === 'Técnico'): ?>
                            
                            <li class="nav-item">
                                <a href="<?= site_url('dashboard/tecnico'); ?>" class="nav-link">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Dashboard</p>
                                </a>
                            </li>

                             <!-- revisa asignaciones de mantenimiento (visible solo para técnicos) -->
                             <li class="nav-item">
                                <a href="<?= site_url('soporte'); ?>" class="nav-link">
                                    <i class="nav-icon fas fa-tools"></i>
                                    <p>Mantenimiento</p>
                                </a>
                            </li>

                            <!-- Registrar solución de los equipos (visible solo para técnicos) -->
                            <li class="nav-item">
                                <a href="<?= site_url('registrar_solucion'); ?>" class="nav-link">
                                    <i class="nav-icon fas fa-tools"></i>
                                    <p>Registrar Solución de Equipos</p>
                                </a>
                            </li>
                           

                        <?php elseif ($rol === 'Encargado'): ?>
                            <li class="nav-item">
                            <a href="<?= site_url('dashboard/encargado'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                            
                           <!-- Registrar equipos (visible solo para encargados) -->
                        <li class="nav-item">
                            <a href="<?= site_url('equipos'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-desktop"></i>
                                <p>Registrar Equipos</p>
                            </a>
                        </li>

                        <!-- Registrar Inventario (visible solo para encargados) -->
                        <li class="nav-item">
                            <a href="<?= site_url('inventario'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-clipboard-list"></i>
                                <p>Inventario de Equipos</p>
                            </a>
                        </li>

                        <!-- Reportar equipos con observaciones (visible solo para encargados) -->
                        <li class="nav-item">
                            <a href="<?= site_url('mantenimiento'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-tools"></i>
                                <p>Reporta Mantenimiento</p>
                            </a>
                        </li>


                        <?php endif; ?>
                        
                    </ul>
                </nav>
            </div>

        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <section class="content">
                <div class="container-fluid">
                    <?= $this->renderSection('content'); ?>
                </div>
            </section>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.0
            </div>
            <strong>&copy; 2024 TechViacha.</strong> Todos los derechos reservados.
        </footer>

    </div>


</body>

</html>
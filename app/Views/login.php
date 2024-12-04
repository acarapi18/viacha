<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- AdminLTE 3.2.0 -->
    <link rel="stylesheet" href="<?= base_url('plugins/fontawesome-free/css/all.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('dist/css/adminlte.min.css'); ?>">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <b>Iniciar Sesión</b>
    </div>

    <div class="card">
        <div class="card-body login-card-body">
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <form action="<?= base_url('authenticate') ?>" method="post">
                <div class="input-group mb-3">
                    <input type="text" name="usuario" class="form-control" placeholder="Usuario" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Contraseña" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                        <button type="button" class="btn btn-secondary" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- AdminLTE 3.2.0 -->
<script src="<?= base_url('plugins/jquery/jquery.min.js'); ?>"></script>
<script src="<?= base_url('plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?= base_url('dist/js/adminlte.min.js'); ?>"></script>

<!-- Mostrar/Ocultar Contraseña -->
<script>
    $('#togglePassword').on('click', function() {
        var passwordField = $('#password');
        var passwordFieldType = passwordField.attr('type');
        if (passwordFieldType == 'password') {
            passwordField.attr('type', 'text');
            $(this).find('i').toggleClass('fa-eye fa-eye-slash');
        } else {
            passwordField.attr('type', 'password');
            $(this).find('i').toggleClass('fa-eye fa-eye-slash');
        }
    });
</script>
</body>
</html>

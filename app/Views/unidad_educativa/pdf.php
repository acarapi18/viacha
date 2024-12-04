<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Unidad Educativa - <?= esc($unidad['nombre']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .table td {
            text-align: left;
        }
        .banner {
            width: 100%; /* Ajusta al 100% del ancho de la página */
            height: auto; /* Mantiene las proporciones de la imagen */
            margin-bottom: 20px; /* Espacio después del banner */
        }
    </style>
</head>
<body>

    <!-- Banner de la unidad educativa -->
    <img src="<?= base_url('assets/img/banner.jpg'); ?>" alt="Banner" class="banner">

    <div class="header">
        <h2>Unidad Educativa</h2>
        <p><b>Código RUE:</b> <?= esc($unidad['codigo_rue']); ?></p>
        <p><b>Nombre:</b> <?= esc($unidad['nombre']); ?></p>
    </div>

    <table class="table">
        <tr>
            <th>Teléfono</th>
            <td><?= esc($unidad['telefono']); ?></td>
        </tr>
        <tr>
            <th>Dirección</th>
            <td><?= esc($unidad['direccion']); ?></td>
        </tr>
        <tr>
            <th>Dependencia</th>
            <td><?= esc($unidad['dependencia']); ?></td>
        </tr>
        <tr>
            <th>Área Geográfica</th>
            <td><?= esc($unidad['area_geografica']); ?></td>
        </tr>
        <tr>
            <th>Estado</th>
            <td><?= esc($unidad['estado']); ?></td>
        </tr>
    </table>

</body>
</html>

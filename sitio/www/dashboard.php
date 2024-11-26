<?php
ini_set('display_errors', 1); // Habilitar la visualización de errores
ini_set('display_startup_errors', 1);
// Importaciones
require_once 'config/dashboard_require.php';
// Verificar si está logueado en session
session_start();
if ($_SESSION['usuario_id']===0) {
    // No logueado, redirigir a login
    header("Location: index.php");
    exit();
}
$facade = new ProyectoFacade();
$proyectos = $facade->listAllGrid();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Proyectos</title>
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="/static/css/lib/bootstrap.min.css">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="/static/css/lib/all.min.css">
    <style>
        body {
            background-color: #f4f6f9;
        }
        .toolbar {
            margin-bottom: 20px;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0,0,0,.05);
        }
        .btn-toolbar .btn {
            margin-right: 10px;
        }
    </style>
    <script src="/static/js/lib/jquery-3.7.1.min.js"></script>
    <script src="/static/js/login.js"></script>
</head>
<body>
    <div class="container-fluid">
        <!-- Barra de Herramientas -->
        <div class="row toolbar py-3">
            <div class="col-12">
                <div class="btn-toolbar" role="toolbar">
                    <div class="btn-group mr-2" role="group">
                        <button type="button" class="btn btn-success">
                            <i class="fas "></i> Agregar
                        </button>
                        <button type="button" class="btn btn-warning">
                            <i class="fas "></i> Modificar
                        </button>
                        <button type="button" class="btn btn-danger">
                            <i class="fas "></i> Eliminar
                        </button>
                        <button type="button" class="btn btn-secondary">
                            <i class="fas "></i> Salir
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grid de Datos -->
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>NOMBRE</th>
                            <th>PMO</th>
                            <th>DESCRIPCIÓN</th>
                            <th>DESARROLLADORES</th>
                        </tr>
                    </thead>
                    <tbody>
<?php foreach ($proyectos as $p): ?>
                        <tr>
                            <td><?= $p->getId() ?></td>
                            <td><?= $p->getNombre() ?></td>
                            <td><?= $p->getProjectManager()->getNombre()." ".$p->getProjectManager()->getApaterno()." ".$p->getProjectManager()->getAmaterno()  ?></td>
                            <td><?= $p->getDescripcion() ?></td> 
                            <td><?= $p->devs_names ?></td>
                        </tr>
<?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Scripts de Bootstrap -->
    <script src="/static/js/lib/popper.min.js"></script>
    <script src="/static/js/lib/bootstrap.min.js"></script>
</body>
</html>
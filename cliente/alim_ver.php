<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
include_once '../../../Aplicaciones/pjt_eatEasy/modelAdmin/ModelAdmin.php';
require_once '../../../Aplicaciones/pjt_eatEasy/modelAdmin/ModelAdmin.php';

if (!isset($_SESSION['sesionDTO'])) {
    header('Location: ../view/web/index.html');
    die();
}
$sesionDTO = unserialize($_SESSION['sesionDTO']);
if ($sesionDTO->getRol() != "2") {
    header('Location: ../view/web/index.html');
    die();
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="../estilos.css">
        <link rel="stylesheet" href="../tabla.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <title>PEDIR</title>
    </head>


    <script type="text/javascript">
        function ConfirmDelete() {
            var respuesta = confirm("Está seguro que desea eliminar este Alimento?");
            if (respuesta == true) {
                return true;
            } else
            {
                return false;
            }
        }
    </script>

    <header>
        <nav id="nav" class="nav1">
            <div class="contenedor-nav">
                <div class="logo">

                </div>
                <div class="enlaces" id="enlaces">
                    <a href='../controller/controllerAdmin.php?opcion=ver_aplimentop'> Pedir</a> 
                    <a href="alim_agregar.php"  class="btn-header">Vender</a> 
                    <a href='../controller/controllerAdmin.php?opcion=ver_aplimentop_per&correo=<?php echo $sesionDTO->getCorreo() ?>'> Mis Ventas</a>                     
                    <a href="../controller/controllerLogin.php?opcion=close" class="btn-header">Cerrar Sesión</a>
                </div>
                <div class="icono" id="open">
                    <span>&#9776;</span>
                </div>
            </div>
        </nav>
    </header>

    <body>

        <div class="main-panel" id="main-panel">
            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">PEDIR ALIMENTO PREPARADO</h4>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <form action="../controller/controllerAdmin.php">
                                        <input type="hidden" name="opcion" value="ver_aplimentop">
                                        <table class="table">
                                            <thead class=" text-primary">

                                            <th>Nombre</th>
                                            <th>Categoría</th>
                                            <th>Descripcion</th>
                                            <th>Precio</th>

                                            </thead>

                                            <tbody>
                                                <?php
                                                $model = new ModelAdmin();
                                                $listar = $model->obtenerCategorias();

                                                if (isset($_SESSION['listado_alimentop'])) {
                                                    $listado_alimentop = unserialize($_SESSION['listado_alimentop']);
                                                    foreach ($listado_alimentop as $alim) {
                                                        echo "<tr>";
                                                        echo "<td>" . $alim->getNombre_alimprep() . "</td>";
                                                        foreach ($listar as $prov) {
                                                            if ($alim->getId_cat() == $prov->getId_cat()) {
                                                                echo "<td>" . $prov->getDescripcion_cat() . "</td>";
                                                            }
                                                        }
                                                        echo "<td>" . $alim->getDescripción_alimprep() . "</td>";
                                                        echo "<td>" . $alim->getPrecio_alimprep() . "</td>";

                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "No se han cargado datos.";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="../administrador/now-ui-dashboard-master/now-ui-dashboard-master/assets/js/core/jquery.min.js"></script>
        <script src="../administrador/now-ui-dashboard-master/now-ui-dashboard-master/assets/js/core/popper.min.js"></script>
        <script src="../administrador/now-ui-dashboard-master/now-ui-dashboard-master/assets/js/core/bootstrap.min.js"></script>
        <script src="../administrador/now-ui-dashboard-master/now-ui-dashboard-master/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
        <script src="../administrador/now-ui-dashboard-master/now-ui-dashboard-master/assets/js/plugins/chartjs.min.js"></script>
        <script src="../administrador/now-ui-dashboard-master/now-ui-dashboard-master/assets/js/plugins/bootstrap-notify.js"></script>
        <script src="../administrador/now-ui-dashboard-master/now-ui-dashboard-master/assets/demo/demo.js"></script>
        <script src="../js/jquery.js"></script>
        <script src="../js/main.js"></script>
        <script src="../js/filtro.js"></script>
    </body>
</html>

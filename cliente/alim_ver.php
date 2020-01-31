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
$correo = $sesionDTO->getCorreo();
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
                    
                    
                    
                    
                     <?php
                                    // echo $correo;

                                    $pdo = Database::connect();
                                    $sql1 = "select curDate() as fecha";
                                    $sql = "SELECT P.ID_PERSONA AS C4,P.CEDULA_PERSONA AS C3,P.APELLIDOS_PERSONA as c1, P. NOMBRES_PERSONA as c2
                    FROM TAB_PERSONA P, TAB_PERSONA_ROL PR
                    WHERE P.ID_PERSONA = PR.ID_PERSONA
                    AND P.CORREO_PERSONA =  ?";
                                    $sql2 = "SELECT MAX(ID_ORDEN) as p1 FROM TAB_ORDEN";
                                    $consulta = $pdo->prepare($sql);
                                    $consulta1 = $pdo->prepare($sql1);
                                    $consulta2 = $pdo->prepare($sql2);

                                    $consulta->execute(array($correo));
                                    $consulta1->execute(array());
                                    $consulta2->execute(array());


                                    $dato = $consulta->fetch();
                                    $dato1 = $consulta1->fetch();
                                    $dato2 = $consulta2->fetch();
                                 
//                                    echo "<h4><b>CEDULA:</B> " . $dato['C3'] . " </h4></td><td>                 <h4><b>NOMBRES: </B> " . $dato ['c1'] . " " . $dato['c2'];
//                                    echo "</h4>";

                            
                                    ?>	
                    <a >  <?php echo $dato ['c1'] . " " . $dato['c2']?> </a>
                    <a href='../controller/controllerAdmin.php?opcion=ver_aplimentop'> <img src="img/carrito.png" title="PEDIR" width=80 height=80></a> 
                    <a href="alim_agregar.php"  class="btn-header"><img src="img/VENDER.png" title="VENDER" width=80 height=80></a> 
                    <a href='../controller/controllerAdmin.php?opcion=ver_aplimentop_per&correo=<?php echo $sesionDTO->getCorreo() ?>'> <img src="img/VENTAS.png" title="MIS VENTAS" width=80 height=80></a>                     
                    <a href="../controller/controllerLogin.php?opcion=close" class="btn-header"> <img src="img/CERRAR.png" title="CERRAR SESSION" width=80 height=80></a>
                </div>
                <div class="icono" id="open">
                    <span>&#9776;</span>
                    <?php echo $getCorreo ?>
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
                                    
                                    <form>
                                        <label>Buscar</label>
                                        <input type="text" id="parametro">
                                        <input type="submit" >
                                    </form>
                                    <form action="../controller/controllerAdmin.php">
                                        <input type="hidden" name="opcion" value="ver_aplimentop">
                                        <table class="table" style="color: chocolate"border="1">
                                            <thead style="background: chocolate">
                                           
                                            <th>Imagen</th>

                                            <th>Categoría</th>
                                            <th>Nombre - Descripcion</th>
                                            <th>Precio</th>

                                            <th>Cantidad</th>
                                            <th>Agregar</th>
                                            
                                            </thead>

                                            <tbody>
                                                <?php
                                                $model = new ModelAdmin();
                                                $listar = $model->obtenerCategorias();

                                                if (isset($_SESSION['listado_alimentop'])) {
                                                    $listado_alimentop = unserialize($_SESSION['listado_alimentop']);
                                                    foreach ($listado_alimentop as $alim) {
                                                        echo "<tr>";
                                                        echo "<td> <img src='../clientes/imagenAP/" . $alim->getNombre_img() . "'  width=80 height=80/></td>";


                                                        foreach ($listar as $prov) {
                                                            if ($alim->getId_cat() == $prov->getId_cat()) {
                                                                echo "<td>" . strtoupper($prov->getDescripcion_cat()) . "</td>";
                                                            }
                                                        }
                                                        echo "<td> <h5>" . strtoupper($alim->getNombre_alimprep()) . "</h5><br>" . $alim->getDescripción_alimprep() . "</td>";
                                                        echo "<td>" . $alim->getPrecio_alimprep() . "</td>";
                                                        echo "<td> <input type='number' id='cantidad' min='1' value=1  style='width : 40px; heigth : 10px'></td>";
                                                        echo " <td> <img src='img/agregar.png'> </td>";
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

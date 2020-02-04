<!DOCTYPE html>
<!--  #bf6726
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
include_once '../../../Aplicaciones/pjt_eatEasy/modelAdmin/ModelAdmin.php';
require_once '../../../Aplicaciones/pjt_eatEasy/modelAdmin/ModelAdmin.php';
$model = new ModelAdmin();

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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <link rel="stylesheet" href="../estilos.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
              crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <link href="../administrador/now-ui-dashboard-master/now-ui-dashboard-master/assets/css/switch.css" rel="stylesheet" />
        <link href="../administrador/now-ui-dashboard-master/now-ui-dashboard-master/assets/demo/demo.css" rel="stylesheet" />
        <title>VENDER</title>
    </head>

    <script type="text/javascript">
        function ConfirmEdit() {
            var respuesta = confirm("Está seguro que desea guardar la información!!");
            if (respuesta == true) {
                return true;
            } else
            {
                return false;
            }
        }

        function ConfirmarCancelar() {
            var respuesta = confirm("Está seguro que desea cancelar!!");
            if (respuesta == true) {
                return true;
            } else
            {
                return false;
            }
        }

        function filterFloat(evt, input) {
            // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
            var key = window.Event ? evt.which : evt.keyCode;
            var chark = String.fromCharCode(key)
                    ;
            var tempValue = input.value + chark;
            if (key >= 48 && key <= 57) {
                if (filter(tempValue) === false) {
                    return false;
                } else {
                    return true;
                }
            } else {
                if (key == 8 || key == 13 || key == 0) {
                    return true;
                } else if (key == 46) {
                    if (filter(tempValue) === false) {
                        return false;
                    } else {
                        return true;
                    }
                } else {
                    return false;
                }
            }
        }
        function filter(__val__) {
            var preg = /^([0-9]+\.?[0-9]{0,2})$/;
            if (preg.test(__val__) === true) {
                return true;
            } else {
                return false;
            }

        }
    </script>


    <body>
        <!--INICIO INDEX-->

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

        <!--INICIO FORMULARIO-->
        <section class="contact-box">
            <div class="row no-gutters bg-dark">
                <div class="col-xl-5 col-lg-12 register-bg2">
                    <div class="position-absolute testiomonial p-4">
                        <h3 class="font-weight-bold text-light">Los mejores en alimentos online.</h3>
                        <p class="lead text-light">La nueva etapa de la revolución digital se aproxima.</p>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-12 d-flex">
                    <div class="container align-self-center p-6">
                        <h1 class="font-weight-bold mb-3">VENDER ALIMENTO PREPARADO</h1>
                        <div class="form-group">
    <!--                        <button class="btn btn-outline-dark d-inline-block text-light mr-2 mb-3 width-100"><i class="icon ion-logo-google lead align-middle mr-2"></i> Google </button>
                            <button class="btn btn-outline-dark d-inline-block text-light mb-3 width-100"><i class="icon ion-logo-facebook lead align-middle mr-2"></i> Facebook</button>-->
                        </div>
                        <p class="text-muted mb-5">Ingrese la siguiente información.</p>

                        <form action="../controller/controllerAdmin.php" enctype="multipart/form-data" >
                            <div class="form-group mb-3">
                                <input type="hidden" name="opcion" value="guardar_aplimentop">
                            </div>

                            <div class="form-group mb-3">
                                <!--<label for='recipient-name' class='font-weight-bold'>Propietario:</label>-->
                                <input type="hidden" name="ID_PERSONA" value="<?php
                                $correo = $sesionDTO->getCorreo();
                                $lista = $model->obtenerPersonas();
                                foreach ($lista as $pro) {
                                    if ($pro->getCorreo_per() == $correo) {
                                        echo $pro->getId_per();
                                    }
                                }
                                ?>">                                 
                            </div>

                            <div class="form-group mb-3">
                                <label for='recipient-name' class="font-weight-bold">Categoría: </label>
                                <select name="ID_CATEGORIA">
                                    <?php
                                    $listad = $model->obtenerCategoriasActivos();
                                    foreach ($listad as $prov) {
                                        echo "<option value='" . $prov->getId_cat() . "'>" .
                                        $prov->getDescripcion_cat() . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="font-weight-bold">Nombre: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Nombre" name='NOMBRE_ALIMENTOPREPARADO' required>
                            </div>
                            <div class="form-group mb-3">
                                <label class="font-weight-bold">Descripción: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Descripcion" name='DESCRIPCION_ALIMENTOPREPARADO' required>
                            </div>
                            <div class="form-group mb-3">
                                <label class="font-weight-bold">Precio: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Precio" name='PRECIO_ALIMENTOPREPARADO' onkeypress="return filterFloat(event, this);" required="true">
                            </div>

                            <div class="form-group mb-3">
                                <label class="font-weight-bold">Imagen: <span class="text-danger">*</span></label>
                               <input id="imagen" name="IMAGEN_ALIMENTOPREPARADO" size="30" type="file"> <br>
                                
                            </div>
                            <input type='submit' value='Guardar' class="btn btn-primary width-100" onclick="return ConfirmEdit()"/>

                        </form>
                        <br>
                        <form action="../controller/controllerAdmin.php">
                            <input type="hidden" name="opcion" value="cancelar_alimentop">
                            <button class="btn btn-primary width-100" type="submit" onclick="return ConfirmarCancelar()">Cancelar</button>
                        </form>
                        <small class="d-inline-block text-muted mt-5">Todos los derechos reservados | © EatEasy</small>
                    </div>
                </div>
            </div>
        </section>
        <!--FIN FORMULARIO-->

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

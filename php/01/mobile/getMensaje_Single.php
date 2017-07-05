
<!DOCTYPE html>
<!--[if lt IE 7]> <html lang="en" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]> <html lang="en" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]> <html lang="en" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="en"><!--<![endif]-->
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="tecnointel.mx" name="author">

    <link href="<?= "http://".$_SERVER['SERVER_NAME'];?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= "http://".$_SERVER['SERVER_NAME'];?>/bootstrap_v4/css/bootstrap.min.css" rel="stylesheet">

<style type="text/css">

@media screen and (max-width: 980px){
    #contenedor{
        width: 96%;
    }
    #contenido{
        width: 60%;
    }
    #barra_lateral{
        width:30%;
    }
}


@media screen and (max-width: 480px){
    #encabezado{
        height: auto;
    }
    #contenido{
        width: auto;
    }
    #barra_lateral{
        display:none;
    }
}

body {
    width: 100%;
    max-width: 1024px;
    padding: 1%;
    margin-left: auto;
    margin-right: auto;    
}

html { 
    -webkit-background-size: cover;
    background-size: cover;
}

.superindice
{vertical-align:super} 

@media only screen 
    and (min-device-width : 375px) 
    and (max-device-width : 667px) 
    and (width : 667px) 
    and (height : 375px) 
    and (orientation : landscape) 
    and (color : 8)
    and (device-aspect-ratio : 375/667)
    and (aspect-ratio : 667/375)
    and (device-pixel-ratio : 2)
    and (-webkit-min-device-pixel-ratio : 2)
{ }

@media only screen 
    and (min-device-width : 375px) 
    and (max-device-width : 667px) 
    and (width : 375px) 
    and (height : 559px) 
    and (orientation : portrait) 
    and (color : 8)
    and (device-aspect-ratio : 375/667)
    and (aspect-ratio : 375/559)
    and (device-pixel-ratio : 2)
    and (-webkit-min-device-pixel-ratio : 2)
{ }


@media only screen 
    and (min-device-width : 414px) 
    and (max-device-width : 736px) 
    and (orientation : landscape) 
    and (-webkit-min-device-pixel-ratio : 3) 
{ }


@media only screen 
    and (min-device-width : 414px) 
    and (max-device-width : 736px)
    and (device-width : 414px)
    and (device-height : 736px)
    and (orientation : portrait) 
    and (-webkit-min-device-pixel-ratio : 3) 
    and (-webkit-device-pixel-ratio : 3)
{ }


@media only screen 
    and (max-device-width: 640px), 
    only screen and (max-device-width: 667px), 
    only screen and (max-width: 480px)
{ }

</style>

</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="well well-lg">
            <div class="card card-inverse center" style="border-color: #333; width: 100% !important;">
              <div class="card-block">
              <?php 

require_once("../oCenturaPDO.php");
$F = oCenturaPDO::getInstance();

$iduser         = $_GET['iduser'];
$idemp          = $_GET['idemp'];
$idmobilmensaje = $_GET['idmobilmensaje'];

$arg = "iduser=$iduser&idemp=$idemp&idmobilmensaje=$idmobilmensaje";

$r = $F->getQueryPDO(42,$arg);

                $titulo = "";
                $mensaje = "";
                if (count($r)>0){
                            $titulo = $r[0]->titulo;
                            $mensaje = $r[0]->mensaje;
                }else{
                            $titulo = "Error...";
                            $mensaje = "Ha ocurrido un error, ya estamos trabajando en repararlo.";
                }

               ?>
                <h3 class="text-left"><?= utf8_decode($titulo); ?></h3></br>
                <p class="text-left"><?= utf8_decode($mensaje); ?></p>
              </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

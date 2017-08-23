<?php
/*
ini_set('display_errors', '0');     
error_reporting(E_ALL | E_STRICT);  

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
*/

header('Access-Control-Allow-Origin: *')

?>

<!DOCTYPE html>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="tecnointel.mx" name>

    <link href="<?= "https://".$_SERVER['SERVER_NAME'];?>/css/style-t1.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= "https://".$_SERVER['SERVER_NAME'];?>/assets/css_/font-awesome.css" />

    <link rel="stylesheet" href="<?= "https://".$_SERVER['SERVER_NAME'];?>/assets/css/ace-fonts.css" />

    <!--
    ace styles
    -->

    <link rel="stylesheet" href="<?= "https://".$_SERVER['SERVER_NAME'];?>/assets/css/ace.css" />
    <link rel="stylesheet" href="<?= "https://".$_SERVER['SERVER_NAME'];?>/assets/css/ace-responsive.css" />

    <link href="<?= "https://".$_SERVER['SERVER_NAME'];?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= "https://".$_SERVER['SERVER_NAME'];?>/bootstrap_v4/css/bootstrap.min.css" rel="stylesheet">

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
    width: 96%;
    max-width: 1024px;
    padding: 1%;
}

html { 
    -webkit-background-size: cover;
    background-size: cover;
}

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
<div class="row-fluid">
<div class="span12">
<?php 
$colores = 
$colores = array("orange","blue","dark","yellow","purple","pink","red3","green","grey");

require_once("../oCenturaPDO.php");
$F = oCenturaPDO::getInstance();
$rs = $F->getQueryPDO(40);


foreach ($rs as $i => $value) {
    $y = rand(0,8);
?>
    <div class=" widget-box pricing-box">
        <div class="widget-header header-color-<?= $colores[$y]; ?>">
            <h5 class="bigger"><?= $rs[$i]->empresa; ?></h5>
        </div>

        <div class="widget-body">
            <div class="widget-main">

<div class="card">
    <p class="center"></br>
        <img class="card-img-top " 
                data-src="<?= $F->URL.$rs[$i]->imagen;?>" 
                src="<?= $F->URL.$rs[$i]->imagen;?>"
                alt="<?= $rs[$i]->empresa; ?>">
    </p>        
    <div class="card-block">
        <h4 class="card-title"><?= $rs[$i]->descuento; ?></h4>
        <address>
        <?php
        if ($rs[$i]->telefonos){
        ?>
        <i class="glyphicon glyphicon-phone red"> </i> 
        <?php
            $arTel = explode(",",$rs[$i]->telefonos);
            foreach ($arTel as $j => $value) {
        ?>
        <a href="tel:<?= $arTel[$j]; ?>" target="_blank"><?= $arTel[$j]; ?></a>
        <?php
                if ( ($j+1) < count($arTel) ) echo ", ";
            } 
        ?>
        </br>
        <?php
        } 
        if ($rs[$i]->emails){
        ?>
        <i class="glyphicon glyphicon-envelope purple"> </i> <a href="mailto:<?= $rs[$i]->emails; ?>" target="_blank"><?= $rs[$i]->emails; ?></a></br>
        <?php
        } 
        if ($rs[$i]->web){
        ?>
        <i class="glyphicon glyphicon-globe green"> </i> <a href="<?= $rs[$i]->web; ?>" target="_blank"><?= $rs[$i]->web; ?></a></br>
        <?php
        } 
        if ($rs[$i]->facebook){
        ?>
        <i class="middle icon-facebook-sign icon blue"> </i> <a href="<?= $rs[$i]->facebook; ?>" target="_blank"><?= $rs[$i]->facebook; ?></a></br>
        <?php
        } 
        if ($rs[$i]->twitter){
        ?>
        <i class="middle icon-twitter-sign icon light-blue"> </i> <a href="<?= $rs[$i]->twitter; ?>" target="_blank"><?= $rs[$i]->twitter; ?></a></br>
        <?php
        } 
        if ($rs[$i]->direccion1){
        ?>
        </br>
        <small class="text-muted">
        <i class="glyphicon glyphicon-chevron-right red"> </i> <?= $rs[$i]->direccion1; ?>
        </small></br></br>
        <?php
        } 
        if ($rs[$i]->direccion2){
        ?>
        <small class="text-muted">
        <i class="glyphicon glyphicon-chevron-right red"></i> <?= $rs[$i]->direccion2; ?>
        </small></br></br>
        <?php
        } 
        if ($rs[$i]->direccion3){
        ?>
        <small class="text-muted">
        <i class="glyphicon glyphicon-chevron-right red"> </i> <?= $rs[$i]->direccion3; ?>
        </small></br></br>
        <?php
        } 
        if ($rs[$i]->direccion4){
        ?>
        <small class="text-muted">
        <i class="glyphicon glyphicon-chevron-right red"> </i> <?= $rs[$i]->direccion4; ?>
        </small>
        <?php
        } 
        ?>
        
        </address>
        
    </div>
</div>

            </div>
        </div>
    </div>

<?php 
}
?>


</div>
</div>

</body>
</html>

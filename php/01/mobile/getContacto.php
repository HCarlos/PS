<!DOCTYPE html>
<!--[if lt IE 7]> <html lang="en" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]> <html lang="en" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]> <html lang="en" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="en"><!--<![endif]-->
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="tecnointel.mx" name="author">

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
            <div class="card card-inverse center" style="background-color: #333; border-color: #333; width: 100% !important;">
              <div class="card-block">
                <p class="text-center"><img src="<?= "https://".$_SERVER['SERVER_NAME'];?>/images/web/favicon-157-157.png" width="157" height="157" /> </p>
                <h3 class="card-title text-center">PlatSource<small class="superindice">&copy</small> <?= date('Y'); ?></h3>
                <p class="card-text text-center">Plataforma Educativa en Tiempo Real.</p>
                <p class="card-text left-center">

                    <table class="table table-bordered "> 
                        <tbody> 
                            <tr>
                                <td style="color:white">Desarrollado por: </td>
                                <td style="color:white"><strong>MSI Carlos Hidalgo</strong></td>
                            </tr>
                            <tr>
                                <td style="color:#51BFDD"><i class="middle icon-twitter-sign icon-2x light-blue"></i> Twitter: </td>
                                <td style="color:white"><strong><a href="https://twitter.com/DevCH" target="_blank">@DevCH</a></strong></td>
                            </tr>
                            <tr>
                                <td style="color:#4E5BB4"><i class="middle icon-facebook-sign icon-2x blue"></i>Facebook: </td>
                                <td style="color:white"><strong><a href="https://www.facebook.com/carlosmanuel.hidalgoruiz" target="_blank">Carlos Hidalgo</a></strong></td>
                            </tr>
                        </tbody> 
                    </table>                    

                </p></br>

                <a href="mailto:informes@platsource.mx" class="btn btn-primary"><i class="glyphicon glyphicon-envelope"></i> E-mail</a>
                <a href="tel:(993) 214 1032" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-phone"></i> Llamar</a>
              </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

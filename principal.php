<?php
    $IdEmpresa = $_GET["idempresa"];
    $ind0 =  intval($IdEmpresa) > 0 ? $IdEmpresa : '0';
    $ind1 =  intval($IdEmpresa) > 0 ? $IdEmpresa : '';
    // echo "Empresa: ".$_GET["idempresa"];
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html lang="en" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]> <html lang="en" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]> <html lang="en" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="en"><!--<![endif]-->
<head>
    <meta charset="utf-8">
    <title>PlatSource</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="PlatSource - Plataforma de Gestión en Educación" name="description">
    <meta name="keywords" content="PlatSource,Educación,Plataforma,Gestión,Educamos,Colegios,Escuelas,Universidades,Profesores,Alumnos,Directores,Primaria,Secundaria,Preparatoria">
    <meta content="tecnointel.mx" name="author">

    <link href="/images/web/favicon.png" rel="shortcut icon">
    <link href="/images/web/favicon.png" rel="apple-touch-icon">
    <link href="/images/web/favicon-72-72.png" rel="apple-touch-icon" sizes="72x72">
    <link href="/images/web/favicon-114-114.png" rel="apple-touch-icon" sizes="114x114">

    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/bootstrap/css/responsive.css" rel="stylesheet">

    <link href="/css/style-t1.css" rel="stylesheet">

    <link href="/css/tables.css" rel="stylesheet">
    <link href="/css/forms.css" rel="stylesheet">

    <link rel="stylesheet" href="/assets/css/jquery-ui-1.10.3.custom.min.css" />
    <link rel="stylesheet" href="/assets/css/jquery-ui-1.10.3.full.min.css" />

    <link rel="stylesheet" href="/assets/css/font-awesome.css" />
    
    
    <link rel="stylesheet" href="/assets/css_/font-awesome.css" />
    

    <!--[if IE 7]>
        <link rel="stylesheet" href="/assets/css/font-awesome-ie7.css" />
    <![endif]-->

    <link rel="stylesheet" href="/assets/css/ace-fonts.css" />

    <!--ace styles-->

    <link rel="stylesheet" href="/assets/css/ace<?= $ind1; ?>.css" />
    <link rel="stylesheet" href="/assets/css/ace-responsive.css" />
    <link rel="stylesheet" href="/assets/css/ace-skins.css" />
    <link rel="stylesheet" href="/assets/css/bootstrap-timepicker.css" />    
    <link rel="stylesheet" href="/assets/css/datepicker.css" />
    <link rel="stylesheet" href="/assets/css/colorpicker.css" />
    <link rel="stylesheet" href="/assets/css/jquery.gritter.css" />

    <!-- <link rel="stylesheet" href="/assets/css/jquery.dataTables.css" /> -->
    
    <!--[if lte IE 8]>
        <link rel="stylesheet" href="/assets/css/ace-ie.css" />
    <![endif]-->


    <link href="/css/docs.css" rel="stylesheet">
    <link href="/css/sg-01.css" rel="stylesheet">

    <script src="/assets/js/ace-extra.min.js"></script>
    

<style type="text/css">

body{background: transparent url("/img/blueprint.png") top left; }

</style>

<script type="text/javascript">


    
</script>

</head>
<body>

  <script type="text/javascript">

      try {

            var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
            document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));

            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-69719226-1', 'auto');
            ga('send', 'pageview');

            var trackOutboundLink = function(url,titulo) {
               ga('send', 'event', titulo, 'click', url, {'hitCallback':
                 function () {}
               });
            }

      } catch(err) { alert(err.message); }

  </script>

    <?php include("php/01/templates/navbar-top.php"); ?>
    
    <section class="section-portfolio" id="section-portfolio" >
 
        <div class="main-container container-fluid" style="background-color: transparent;">
            <a class="menu-toggler" id="menu-toggler" href="#">
                <span class="menu-text"></span>
            </a>

            <?php include("php/01/templates/sidebar-left.php"); ?>

            <div class="main-content">

                <div class="breadcrumbs transparent" id="breadcrumbs">
                    <ul class="breadcrumb" id="breadcrumb">
                        <li>
                            <i class="icon-home home-icon"></i>
                            <a id="href0" href="/dashboard/<?= $ind0; ?>/">Inicio</a>
                        </li>
                    </ul><!--.breadcrumb--> 
                    <span id="barInfoL0" class=""></span>                   
                    <span id="barInfoR0" class="pull-right"></span>                   

                </div>

                <div class="page-content">
                    <div class="row-fluid">
                        <div class="span12">
                            <!--PAGE CONTENT BEGINS-->
                            <div class="container inw100p " id="contentMain" ></div>
                            <div class="container inw100p " id="contentProfile"></div>
                            <div class="container inw100p " id="contentLevel3"></div>
                            <div class="container inw100p " id="contentLevel4"></div>
                            <div class="container inw100p " id="contentLevel5"></div>

                            <!--PAGE CONTENT ENDS-->
                        </div><!--/.span-->
                    </div><!--/.row-fluid-->
                </div><!--/.page-content-->

            </div><!--/.main-content-->
        </div><!--/.main-container-->

    </section>

    <!-- .................................... $post-footer .................................... -->
    <?php include("php/01/templates/footer.php"); ?>


    <div class="modal fade bs-example-modal-lg" tabindex="-1" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="contentModal1">
                <img src="/img/loading.gif" width="32" height="32" alt=""/> Cargando...
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->  

    <div id="divUploadImage" class="modal fade " style = "height:600px !important; width: 600px !important;">
    </div><!-- /.modal -->

    <script type="text/javascript" src="/js/01/accounting.js"></script>

    <!-- .................................... $scripts .................................... -->
    <script src="/js/libs/jquery.min.js"></script>


    <script src="/bootstrap/js/bootstrap.min.js"></script>

    <!--basic scripts-->

    <!--[if !IE]>-->

    <script type="text/javascript">
        window.jQuery || document.write("<script src='/assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
    </script>

    <!--<![endif]-->

    <!--
    [if IE]>
    <script type="text/javascript">
    window.jQuery || document.write("<script src='/assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
    </script>
    <![endif]
    -->

    <script type="text/javascript">
        if("ontouchend" in document) document.write("<script src='/assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
    </script>

    <script src="/assets/js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="/assets/js/jquery-ui-1.10.3.full.min.js"></script>
    <script src="/assets/js/jquery.gritter.min.js"></script>
    <script src="/assets/js/jquery.dataTables.min.js"> </script>
    <script src="/assets/js/jquery.dataTables.bootstrap.js"> </script>
    <script src="/assets/js/date-time/bootstrap-datepicker.min.js"></script>
    <script src="/assets/js/date-time/bootstrap-timepicker.min.js"></script>

    <script src="/assets/js/jquery.ui.touch-punch.min.js"></script>
    <script src="/assets/js/bootbox.min.js"></script>
    <script src="/assets/js/jquery.easy-pie-chart.min.js"></script>
    <script src="/assets/js/jquery.gritter.min.js"></script>
    <script src="/assets/js/spin.min.js"></script>
    
    <script src="/assets/js/ace-elements.min.js"></script>
    <script src="/assets/js/ace.min.js"></script>
    
    <script src="/assets/js/fuelux/fuelux.wizard.min.js"></script>
    <script src="/assets/js/jquery.validate.min.js"></script>
    <script src="/assets/js/additional-methods.min.js"></script>
    
    <script src="/assets/js/bootstrap-colorpicker.min.js"></script>
    <script src="/assets/js/jquery.maskedinput.min.js"></script>
    <!-- <script src="/js/01/custom_map_tooltip.js"></script> -->

    <!-- <script src="/assets/js/jquery.nestable.min.js"></script> -->

    <script  src="/js/01/base.js"> </script>
    
    <script typy="text/javascript">
        document.write("<script src='"+obj.getValue(4)+"/socket.io/socket.io.js'>"+"<"+"/script>");
        if ( localStorage.IdEmpresaHome ){

        }
    </script>    


    <script  src="/js/init.js"> </script>

<script>

$(".dropdown-toggle").click(function () {
    $(".nav-collapse").css('height', 'auto')
});

</script>

<!-- Start of StatCounter Code for Default Guide -->
<script type="text/javascript">
    var sc_project=10092802; 
    var sc_invisible=0; 
    var sc_security="ca3e0c27"; 
    var scJsHost = (("https:" == document.location.protocol) ?
    "https://secure." : "http://www.");
    document.write("<sc"+"ript type='text/javascript' src='" +
    scJsHost+
    "statcounter.com/counter/counter.js'></"+"script>");


    $('[data-rel=tooltip]').tooltip();
    
/*
    $(".rsPrincipal0").hide();
    var IDTCve = parseInt(localStorage.ClaveNivelAcceso, 0);
    if (IDTCve != 5 && IDTCve != 7){
        $(".rsPrincipal0").show();
        console.log("Clave: "+IDTCve);
    }
*/

</script>
<!-- End of StatCounter Code for Default Guide -->




</body>
</html>
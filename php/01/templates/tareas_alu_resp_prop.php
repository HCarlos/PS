<?php

include("includes/metas.php");

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idtareadestinatario = $_POST['idtareadestinatario'];
$idtareadestinatariorespuesta = $_POST['idtareadestinatariorespuesta'];


?>
<div class="widget-box">
    <div class="widget-header widget-header-blue widget-header-flat">

        <h4 class="smaller lighter blue">
            <i class="icon-flag"></i>
            <span id="tPResp0">---</span>
        </h4>                
        
        <div class="widget-toolbar no-border">
            <button  type="button" class="btn btn-minier btn-primary arrowed-in-right arrowed closeFormUpload " style="margin: 0 1em !important;" >
                <i class="icon-angle-left icon-on-right"></i>
                Regresar
            </button>
        </div>

    </div>


    <div class="widget-body">
        <div class="widget-main">
            
            <div class="row-fluid">


            <form class="form-inline" id="frmRespuestaTareaDestinatario" role="form">
                <div class="row-fluid">
                    <div class="wd70prc span10" >                
                        <textarea cols="40" rows="8" name="respuesta" id="respuesta" class="wd100prc" autofocus></textarea>
                    </div>
                    <div class="span1">
                        <br/>
                        <br/>
                        <button class="btn btn-primary btn-small">
                            <i class="icon-ok bigger-110"></i>
                            Guardar
                        </button>
                    </div>
                </div>
                <input type="hidden" id="idtareadestinatario" name="idtareadestinatario" value="<?php echo $idtareadestinatario; ?>" />
                <input type="hidden" id="idtareadestinatariorespuesta" name="idtareadestinatariorespuesta" value="<?php echo $idtareadestinatariorespuesta; ?>" />
                <input type="hidden" id="user" name="user" value="<?php echo $user; ?>" />
            </form>     



            </div> <!-- row-fluid Redactar Tarea-->

        </div><!--/widget-main-->
    </div><!--/widget-body-->

</div>

<!--PAGE CONTENT ENDS-->
<script typy="text/javascript">        

jQuery(function($) {


	$("#preloaderPrincipal").hide();

    var idtareadestinatario = <?php echo $idtareadestinatario ?>;
    var idtareadestinatariorespuesta = <?php echo $idtareadestinatariorespuesta ?>;

    if (idtareadestinatariorespuesta<=0){ // Nuevo Registro
        $("#tPResp0").html("Nuevo registro");

    }else{ // Editar Registro
        $("#tPResp0").html("Editando el registro: "+idtareadestinatariorespuesta);
        getRespuestaTareaDestinatario(idtareadestinatariorespuesta);
    }

    function getRespuestaTareaDestinatario(IdTareaDestinatarioRespuesta){
        $.post(obj.getValue(0) + "data/", {o:40, t:20006, c:IdTareaDestinatarioRespuesta, p:10, from:0, cantidad:0,s:''},
            function(json){
                if (json.length>0){
                    $("#respuesta").val( json[0].respuesta );

/*
*/

                }
        },'json');
    }

    $("#frmRespuestaTareaDestinatario").unbind("submit");
    $("#frmRespuestaTareaDestinatario").on("submit",function(event){
        event.preventDefault();

        $("#preloaderPrincipal").show();

        var queryString = $(this).serialize();  
        
        // alert(queryString)
        // return false;

        var data = new FormData();

        if (validForm()){
            var IdTareaDestinatarioRespuesta = (idtareadestinatariorespuesta==0?6:7)
            $.post(obj.getValue(0) + "data/", {o:40, t:IdTareaDestinatarioRespuesta, c:queryString, p:2, from:0, cantidad:0, s:''},
            function(json) {

                    alert(json[0].msg); 

                    if (json[0].msg=="OK"){
                        // stream.emit("cliente", {mensaje: "PLATSOURCE-RESPUESTA_TAREA-PROP-"+IdTareaDestinatarioRespuesta});
                    }

                    $("#preloaderPrincipal").hide();
                    $("#contentLevel3").hide(function(){
                        $("#contentLevel3").empty();
                        $("#contentProfile").show();
                    });

            }, "json");
        }else{
            $("#preloaderPrincipal").hide();
        }

    });

    function validForm(){

        if ($("#respuesta").val().length <= 0){
            alert("Faltan la Respuesta");
            $("#respuesta").focus();
            return false;
        }

        return true;

    }

    // close Form
    $(".closeFormUpload").on("click",function(event){
        event.preventDefault();
        $("#preloaderPrincipal").hide();
        $("#contentLevel3").hide(function(){
            $("#contentLevel3").empty();
            $("#contentProfile").show();
        });        
        resizeScreen();
        return false;
    });

    // var stream = io.connect(obj.getValue(4));

    $("#respuesta").focus();

});

</script>
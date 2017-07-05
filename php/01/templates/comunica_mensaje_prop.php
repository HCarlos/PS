<?php

include("includes/metas.php");

require_once("../oFunctions.php");

$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idcommensaje = $_POST['idcommensaje'];

?>
<form id="frmComMensaje" role="form">

<div class="widget-box">
    <div class="widget-header widget-header-flat">

        <h4 id="tituloPanel"></h4>
        
        <div class="widget-toolbar no-border">
                <button  type="button" class="btn btn-minier btn-primary arrowed-in-right arrowed closeFormUpload " style="margin: 0 2em !important;" >
                        <i class="icon-angle-left icon-on-right"></i>
                        Regresar
                </button>

        </div>

    </div>

    <div class="widget-body">
        <div class="widget-main">
            

                                <table class="wd95prc ">
                                    
                                    <tr>
                                        <td>
                                            <label for="titulo">Título:</label>
                                        </td>
                                        <td colspan="3">
                                            <input class="marginLeft1em altoMoz wd100prc" type="text" name="titulo" id="titulo" value="" autofocus/>
                                        </td>

                                    </tr>

                                    <tr>
                                        <td>
                                            <label for="fecha">Fecha:</label>
                                        </td>
                                        <td>
                                            
                                            <input class="marginLeft1em date-picker altoMoz" id="fecha" name="fecha" data-date-format="dd-mm-yyyy" type="text" >
                                            <span class="add-on">
                                                    <i class="icon-calendar"></i>
                                            </span>



                                        </td>
                                        <td>
                                            <label for="fecha_fin"></label>
                                        </td>
                                        <td>

                                            

                                        </td>

                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="mensaje" >Mensaje:</label>
                                        </td>
                                        <td colspan="3">
                                            <textarea cols="40" rows="8" name="mensaje" id="mensaje" class="marginLeft1em wd100prc"></textarea>
                                        </td>

                                    </tr>

                                </table>



        </div><!--/widget-main-->
    </div><!--/widget-body-->

</div>

            <input type="hidden" name="idcommensaje" id="idcommensaje" value="<?php echo $idcommensaje; ?>">
            <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
            <div class="form-group w96" style='margin-right: 3em; margin-top: 1em;'>
                <button type="button" class="btn btn-default pull-right closeFormUpload" data-dismiss="modal" ><i class="icon-signout "></i>Cerrar</button>
                <span class="muted"></span>
                <button type="submit" class="btn btn-primary pull-right" style='margin-right: 4em;'><i class="icon-save"></i>Guardar</button>
            </div>

        </form>

<!--PAGE CONTENT ENDS-->
<script typy="text/javascript">        

jQuery(function($) {


	$("#preloaderPrincipal").hide();

	var idcommensaje = <?php echo $idcommensaje ?>;

    $("#frmComMensaje").unbind("submit");
    $("#frmComMensaje").on("submit",function(event){
        event.preventDefault();

        $("#preloaderPrincipal").show();

        var queryString = $(this).serialize();  
        
        var IdComMensaje = idcommensaje <= 0 ? 0 : 1;

        $.post(obj.getValue(0) + "data/", {o:42, t:IdComMensaje, c:queryString, p:2, from:0, cantidad:0, s:''},
        function(json) {
                if (json[0].msg=="OK"){
                    alert("Datos guardados con éxito");
                    stream.emit("cliente", {mensaje: "PLATSOURCE-MENSAJE_EDIT-PROP-"+IdComMensaje});
                    $("#preloaderPrincipal").hide();
                    // if (is_fotos){
                        $("#contentProfile").hide(function(){
                            $("#contentProfile").html("");
                            $("#contentMain").show();
                        });
                    // }
                    
                }else{
                    $("#preloaderPrincipal").hide();
                    alert(json.msg);    
                }

        }, "json");

    });

    // ============================================================================================================
    // 
    // TAREA NUEVA ( INICIO )
    // 
    // ============================================================================================================


    function getComMensaje(IdComMensaje){
        
        $("#row0").hide();

        $("#preloaderPrincipal").show();
        var nc = "u="+localStorage.nc+"&idcommensaje="+IdComMensaje;
        $.post(obj.getValue(0)+"data/", { o:41, t:31001, p:10,c:nc,from:0,cantidad:0, s:"" },
            function(json){
                
                $("#titulo").val ( json[0].titulo_mensaje );
                $("#mensaje").val ( json[0].mensaje );

                $("#fecha").val ( json[0].cfecha );

                $('#fecha').mask('99-99-9999');

                $("#preloaderPrincipal").hide();
                
            }, "json"
        ); 
    }


    // ============================================================================================================
    // 
    // EDITAR TAREA ( FIN )
    // 
    // ============================================================================================================
 
	// close Form
	$(".closeFormUpload").on("click",function(event){
		event.preventDefault();
		$("#preloaderPrincipal").hide();
		$("#contentProfile").hide(function(){
			$("#contentProfile").html("");
			$("#contentMain").show();
		});
		resizeScreen();
		return false;
	});

    $('.date-picker').datepicker().next().on(ace.click_event, function(){
                    $(this).prev().focus();
    });

    $('#fecha').mask('99-99-9999');
    $('#fecha').val(obj.getDateToday());


    if ( idcommensaje > 0 ) {
        $("#tituloPanel").html("Editando la Mensaje: "+idcommensaje);
        getComMensaje(idcommensaje);
    }else{
        $("#tituloPanel").html("Mensaje Nuevo");
    }

   $("#titulo").focus();

    var stream = io.connect(obj.getValue(4));


});

</script>
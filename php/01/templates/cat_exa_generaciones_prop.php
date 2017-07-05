<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idgeneracion  = $_POST['idgeneracion'];

?>
<div class="row-fluid">
<div class="span12" style="padding-left: 1em; padding-right: 1em;">
<div class="tabbable">

	<h3 class="header smaller lighter blue" id="title"></h3>
	<form id="frmData" role="form">

		<ul class="nav nav-tabs" id="myTab">

			<li class="active">
				<a data-toggle="tab" href="#general">
					<i class="red icon-home bigger-110"></i>
					Generales
				</a>
			</li>

		</ul>

		<div class="tab-content">

			<div id="general" class="tab-pane active">

				<div class="form-group ">
			    	<label for="generacion" class="col-lg-3 control-label">Generación</label>
			    	<div class="col-lg-9">
				    	<input type="text" class="form-control altoMoz" id="generacion" name="generacion"  >
		      		</div>
			    </div>


				<div class="form-group frmPred ">
			    	<label for="status_generacion" class="col-lg-3 control-label">Predeterminado</label>
			    	<div class="col-lg-1">
                        <label>
                            <input name="predeterminado" id="predeterminado" class="ace ace-switch ace-switch-6" type="checkbox">
                            <span class="lbl"></span>
                        </label>
			    	</div>
                </div>                    

		    	<div class="col-lg-12">
		    	</div>

				<div class="form-group ">
			    	<label for="status_generacion" class="col-lg-3 control-label">Activo</label>
			    	<div class="col-lg-1">
                        <label>
                            <input name="status_generacion" id="status_generacion" class="ace ace-switch ace-switch-4" type="checkbox" checked="checked">
                            <span class="lbl"></span>
                        </label>
			    	</div>
                </div>                    

		    	<div class="col-lg-12">
		    	</div>

			</div>

		</div>

	    <input type="hidden" name="idgeneracion" id="idgeneracion" value="<?php echo $idgeneracion; ?>">
	    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
	    <div class="form-group w96" style='margin-right: 3em; margin-top: 1em;'>
	    	<button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="exitfrmGen01">
				<i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
	    		Cerrar
	    	</button>
	    	<span class="muted"></span>
	    	<button type="submit" class="btn btn-primary pull-right" style='margin-right: 4em;'><i class="icon-save"></i>Guardar</button>
		</div>

	</form>

</div>




</div>
</div>
<!--PAGE CONTENT ENDS-->

<script typy="text/javascript">        

jQuery(function($) {

	$("#preloaderPrincipal").hide();
	$(".frmPred").hide();

	var idgeneracion = <?php echo $idgeneracion; ?>;

	function getGeneracion(IdGeneracion){
		$.post(obj.getValue(0) + "data/", {o:61, t:50, c:IdGeneracion, p:55, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					
					$("#generacion").val(json[0].generacion);
					$("#status_generacion").prop("checked",json[0].status_generacion==1?true:false);	
					$("#predeterminado").prop("checked",json[0].predeterminado==1?true:false);	
					$("#generacion").focus();
					
				}
		},'json');
	}

    $("#frmData").unbind("submit");
	$("#frmData").on("submit",function(event){
		event.preventDefault();

		$("#preloaderPrincipal").show();

		if (validForm()){

			var queryString = $(this).serialize();	

			// alert(queryString);

			var IdTipoAtencion = (idgeneracion==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:61, t:IdTipoAtencion, c:queryString, p:52, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						stream.emit("cliente", {mensaje: "PLATSOURCE-GENERACION-PROP-"+idgeneracion});
						$("#preloaderPrincipal").hide();
						$("#contentProfile").hide(function(){
							$("#contentProfile").empty();
							$("#contentMain").show();
						});
        			}else{
						$("#preloaderPrincipal").hide();
        				alert(json[0].msg);	
        				return false;
        			}
        	}, "json");
		}else{
			$("#preloaderPrincipal").hide();
		}

	});

	$("#exitfrmGen01").on("click",function(event){
		event.preventDefault();
		$("#preloaderPrincipal").hide();
		$("#contentProfile").hide(function(){
			$("#contentProfile").empty();
			$("#contentMain").show();
		});
		resizeScreen();
		return false;
	});


	function validForm(){

		if ($("#generacion").val().length <= 0){
			alert("Faltan la Generación");
			$("#generacion").focus();
			return false;
		}

		return true;

	}

	if (idgeneracion<=0){
		$("#title").html("Nuevo registro");
		$("#generacion").focus();
	}else{
		$("#title").html("Editando el registro: "+idgeneracion);
		$(".frmPred").show();
		getGeneracion(idgeneracion);
	}


	var stream = io.connect(obj.getValue(4));
    stream.on("servidor", jsNewConcepto);

    function jsNewConcepto(datosServer) {

    }



});

</script>
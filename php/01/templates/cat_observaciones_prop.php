<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idobservacion  = $_POST['idobservacion'];

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
					Observación
				</a>
			</li>

		</ul>

		<div class="tab-content">

			<div id="general" class="tab-pane active">
			
				<div class="form-group ">
			    	<label for="observacion" class="col-lg-3 control-label">Observación</label>
			    	<div class="col-lg-9">
				    	<input type="text" class="form-control altoMoz" id="observacion" name="observacion" required >
		      		</div>
			    </div>

				<div class="form-group ">
					<label class="col-lg-3 control-label green" for="idioma"><b>Es Español</b></label>
			    	<div class="col-lg-9">
						<input name="idioma" id="idioma" class="ace ace-switch ace-switch-6" type="checkbox"  checked>
						<span class="lbl"></span>
		      		</div>
			    </div>
			    <div class="clearfix"></div>

				<div class="form-group ">
			    	<label for="status_observacion" class="col-lg-3 control-label">Status</label>
			    	<div class="col-lg-5">
						<select class="form-control input-lg"  name="status_observacion" id="status_observacion" size="1">
							<option value="0">Inactivo</option>
							<option value="1" selected >Activo</option>
						</select>
		      		</div>
			    </div>

			</div>

		</div>

	    <input type="hidden" name="idobservacion" id="idobservacion" value="<?php echo $idobservacion; ?>">
	    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
	    <div class="form-group w96" style='margin-right: 3em; margin-top: 1em;'>
	    	<button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="closeFormUpload"><i class="icon-signout"></i>Cerrar</button>
	    	<span class="muted"></span>
	    	<button type="submit" class="btn btn-primary pull-right" style='margin-right: 4em;'><i class="icon-save"></i>Guardar</button>
		</div>

	</form>

</div>




</div>
</div>
<!--PAGE CONTENT ENDS-->

<script type="text/javascript">        

jQuery(function($) {

	// var stream = io.connect(obj.getValue(4));


	$("#preloaderPrincipal").hide();

	$("#clave").focus();

	var idobservacion = <?php echo $idobservacion; ?>;

	if (idobservacion<=0){ // Nuevo Registro
		$("#title").html("Nuevo registro");
	}else{ // Editar Registro
		$("#title").html("Editando el registro: "+idobservacion);
		getobservacion(idobservacion);
	}

	function getobservacion(IdObservacion){
		$.post(obj.getValue(0) + "data/", {o:20, t:10001, c:IdObservacion, p:10, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#observacion").val(json[0].observacion);
					$("#status_observacion").val(json[0].status_observacion);
					$("#idioma").prop("checked",json[0].idioma==0?true:false);						
				}
		},'json');
	}

    $("#frmData").unbind("submit");
	$("#frmData").on("submit",function(event){
		event.preventDefault();

		$("#preloaderPrincipal").show();

	    var queryString = $(this).serialize();	
	    
	    // alert(queryString)
	    // return false;

		var data = new FormData();

		if (validForm()){
			var IdObservacion = (idobservacion==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:20, t:IdObservacion, c:queryString, p:2, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						// stream.emit("cliente", {mensaje: "PLATSOURCE-OBSERVACIONES-PROP-"+idobservacion});
						$("#preloaderPrincipal").hide();
						$("#divUploadImage").modal('hide');
        			}else{
						$("#preloaderPrincipal").hide();
        				alert(json[0].msg);	
        			}
        	}, "json");
		}else{
			$("#preloaderPrincipal").hide();
		}

	});

	$("#closeProp").on("click",function(event){
		$("#preloaderPrincipal").hide();
		$("#divUploadImage").modal('hide');
	});

	function validForm(){

		if($("#observacion").val().length <= 0){
			alert("Faltan el observacion");
			$("#observacion").focus();
			return false;
		}

		return true;

	}




});

</script>
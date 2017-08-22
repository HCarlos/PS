<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idalutipoactividad  = $_POST['idalutipoactividad'];

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
					Tipo de Actividad del Alumnos
				</a>
			</li>

		</ul>

		<div class="tab-content">

			<div id="general" class="tab-pane active">
			
				<div class="form-group ">
			    	<label for="tipo_actividad" class="col-lg-2 control-label">Tipo de Actividad del Alumno</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="tipo_actividad" name="tipo_actividad" required >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="status_tipo_actividad" class="col-lg-2 control-label">Status</label>
			    	<div class="col-lg-10">
						<select class="form-control input-lg"  name="status_tipo_actividad" id="status_tipo_actividad" size="1">
							<option value="0">Inactivo</option>
							<option value="1" selected >Activo</option>
						</select>
		      		</div>
			    </div>

			</div>

		</div>

	    <input type="hidden" name="idalutipoactividad" id="idalutipoactividad" value="<?php echo $idalutipoactividad; ?>">
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

<script typy="text/javascript">        

jQuery(function($) {

	// var stream = io.connect(obj.getValue(4));


	$("#preloaderPrincipal").hide();

	$("#clave").focus();

	var idalutipoactividad = <?php echo $idalutipoactividad ?>;

	if (idalutipoactividad<=0){ // Nuevo Registro
		$("#title").html("Nuevo registro");
	}else{ // Editar Registro
		$("#title").html("Editando el registro: "+idalutipoactividad);
		getTipoActividadAlumno(idalutipoactividad);
	}

	function getTipoActividadAlumno(IdAluTipoActividad){
		$.post(obj.getValue(0) + "data/", {o:1, t:103, c:IdAluTipoActividad, p:10, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#clave").val(json[0].clave);
					$("#tipo_actividad").val(json[0].tipo_actividad);
					$("#status_tipo_actividad").val(json[0].status_tipo_actividad);
				}
		},'json');
	}

    $("#frmData").unbind("submit");
	$("#frmData").on("submit",function(event){
		event.preventDefault();

		$("#preloaderPrincipal").show();

	    var queryString = $(this).serialize();	
	    
	    //alert(queryString)
	    // return false;

		var data = new FormData();

		if (validForm()){
			var IdAluTipoActividad = (idalutipoactividad==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:44, t:IdAluTipoActividad, c:queryString, p:2, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						// stream.emit("cliente", {mensaje: "PLATSOURCE-TIPO_ACTIVIDAD_ALUMNO-PROP-"+IdAluTipoActividad});
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

		if($("#tipo_actividad").val().length <= 0){
			alert("Faltan el Tipo de Actividad del Alumno");
			$("#tipo_actividad").focus();
			return false;
		}

		return true;

	}




});

</script>
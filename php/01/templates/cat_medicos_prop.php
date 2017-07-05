<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idmedico  = $_POST['idmedico'];

?>
<div class="row-fluid">
<div class="span12" style="padding-left: 1em; padding-right: 1em;">
<div class="tabbable">

	<h3 class="header smaller lighter blue" id="title"></h3>
	<form id="frmDataCatMed0" role="form">

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
			    	<label for="app_medico" class="col-lg-2 control-label">Ap. Paterno</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="app_medico" name="app_medico" autofocus >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="apm_medico" class="col-lg-2 control-label">Ap. Materno</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="apm_medico" name="apm_medico"  >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="nombre_medico" class="col-lg-2 control-label">Nombre</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="nombre_medico" name="nombre_medico"  >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="especialidad" class="col-lg-2 control-label">Especialidad</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="especialidad" name="especialidad"  >
		      		</div>
			    </div>

				<div class="form-group ">
					<label for="tel1" class="col-lg-2">Teléfono 1</label>
			    	<div class="col-lg-10">
						<input class="col-lg-2 altoMoz" id="tel1" name="tel1" type="text" >
			      	</div>
			    </div>

				<div class="form-group ">
					<label for="tel2" class="col-lg-2">Teléfono 2</label>
			    	<div class="col-lg-10">
						<input class="col-lg-2 altoMoz" id="tel2" name="tel2" type="text" >
			      	</div>
			    </div>

				<div class="form-group ">
			    	<label for="email1" class="col-lg-2 control-label">E-Mail 1</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="email1" name="email1" >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="email2" class="col-lg-2 control-label">E-Mail 2</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="email2" name="email2" >
		      		</div>
			    </div>
				<div class="form-group ">
			    	<label for="email2" class="col-lg-2 control-label">Status</label>
					<div class="col-lg-10">
						<label>
							<input name="status_medico" id="status_medico" class="ace ace-switch ace-switch-6" type="checkbox" checked>
							<span class="lbl"></span>
						</label>
					</div>						
			    </div>

			</div>
	
		</div>

	    <input type="hidden" name="idmedico" id="idmedico" value="<?php echo $idmedico; ?>">
	    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
	    <div class="form-group w96" style='margin-right: 3em; margin-top: 1em;'>
	    	<button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="closeFrmCatMedicos0">
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

	// var stream = io.connect(obj.getValue(4));


	$("#preloaderPrincipal").hide();

	$("#app_medico").focus();

	var idmedico = <?php echo $idmedico ?>;


	function getMedico(IdMedico){
		$.post(obj.getValue(0) + "data/", {o:48, t:110, c:IdMedico, p:10, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					
					$("#app_medico").val(json[0].app_medico);
					$("#apm_medico").val(json[0].apm_medico);
					$("#nombre_medico").val(json[0].nombre_medico);
					$("#especialidad").val(json[0].especialidad);
					$("#email1").val(json[0].email1);
					$("#email2").val(json[0].email2);

					$("#tel1").val(json[0].tel1);
					$("#tel2").val(json[0].tel2);

					$("#status_medico").prop("checked",json[0].status_medico==1?true:false);	
					
					$("#app_medico").focus();
					
				}
		},'json');
	}

    $("#frmDataCatMed0").unbind("submit");
	$("#frmDataCatMed0").on("submit",function(event){
		event.preventDefault();

		$("#preloaderPrincipal").show();

		if (validForm()){

			var queryString = $(this).serialize();	

			var IdPersona = (idmedico==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:48, t:IdPersona, c:queryString, p:2, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						// stream.emit("cliente", {mensaje: "PLATSOURCE-MEDICOS-PROP-"+idmedico});
						$("#preloaderPrincipal").hide();
						$("#contentProfile").hide(function(){
							$("#contentProfile").html("");
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

	$("#closeFrmCatMedicos0").on("click",function(event){
		event.preventDefault();
		$("#preloaderPrincipal").hide();
		$("#contentProfile").hide(function(){
			$("#contentProfile").html("");
			$("#contentMain").show();
		});
		resizeScreen();
		return false;
	});


	function validForm(){

		if ($("#app_medico").val().length <= 0){
			alert("Faltan el Apellido Paterno");
			$("#app_medico").focus();
			return false;
		}

		if ($("#apm_medico").val().length <= 0){
			alert("Faltan el Apellido Materno");
			$("#apm_medico").focus();
			return false;
		}

		if ($("#nombre_medico").val().length <= 0){
			alert("Faltan el Nombre");
			$("#nombre_medico").focus();
			return false;
		}

		return true;

	}

	if (idmedico<=0){ // Nuevo Registro
		$("#title").html("Nuevo registro");
	}else{ // Editar Registro
		$("#title").html("Editando el registro: "+idmedico);
		getMedico(idmedico);
	}



});

</script>
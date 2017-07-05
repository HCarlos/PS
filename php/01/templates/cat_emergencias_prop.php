<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idemergencia  = $_POST['idemergencia'];

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
					Telefonos
				</a>
			</li>

		</ul>

		<div class="tab-content">

			<div id="general" class="tab-pane active">
			
				<div class="form-group ">
			    	<label for="nombre" class="col-lg-2 control-label">Nombre</label>
			    	<div class="col-lg-10 ">
				    	<input type="text" class="form-control altoMoz" id="nombre" name="nombre" required autofocus >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="tel1" class="col-lg-2 control-label">Teléfono</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="tel1" name="tel1" required >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="parentezco" class="col-lg-2 control-label">Parentesco</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="parentezco" name="parentezco"  maxlength="50" required >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="status_emergencia" class="col-lg-2 control-label">Status</label>
			    	<div class="col-lg-10">
						<select class="form-control input-lg"  name="status_emergencia" id="status_emergencia" size="1">
							<option value="0">Inactivo</option>
							<option value="1" selected >Activo</option>
						</select>
		      		</div>
			    </div>

			</div>

		</div>

	    <input type="hidden" name="idemergencia" id="idemergencia" value="<?php echo $idemergencia; ?>">
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

	var stream = io.connect(obj.getValue(4));


	$("#preloaderPrincipal").hide();

	$("#nombre").focus();

	var idemergencia = <?php echo $idemergencia ?>;

	if (idemergencia<=0){ // Nuevo Registro
		$("#title").html("Nuevo registro");
	}else{ // Editar Registro
		$("#title").html("Editando el registro: "+idemergencia);
		getTelefono(idemergencia);
	}

	function getTelefono(IdEmergencia){
		$.post(obj.getValue(0) + "data/", {o:13, t:2, c:IdEmergencia, p:51, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#nombre").val(json[0].nombre);
					$("#tel1").val(json[0].tel1);
					$("#parentezco").val(json[0].parentezco);
					$("#status_emergencia").val(json[0].status_emergencia);
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
			var IdEmergencia = (idemergencia==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:53, t:IdEmergencia, c:queryString, p:52, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						stream.emit("cliente", {mensaje: "PLATSOURCE-EMERGENCIA-PROP-"+IdEmergencia});
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

		if($("#nombre").val().length <= 0){
			alert("Faltan la Nombre");
			$("#nombre").focus();
			return false;
		}

		if($("#tel1").val().length <= 0){
			alert("Faltan el Telefono");
			$("#tel1").focus();
			return false;
		}

		if($("#parentezco").val().length <= 0){
			alert("Faltan el Parentezco");
			$("#tel1").focus();
			return false;
		}

		return true;

	}




});

</script>
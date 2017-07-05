<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idestado  = $_POST['idestado'];

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
					Estados
				</a>
			</li>

		</ul>

		<div class="tab-content">

			<div id="general" class="tab-pane active">
			
				<div class="form-group ">
			    	<label for="clave" class="col-lg-2 control-label">Clave</label>
			    	<div class="col-lg-10 ">
				    	<input type="text" class="form-control altoMoz" maxlength="20" id="clave" name="clave" required autofocus >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="estado" class="col-lg-2 control-label">Estado</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="estado" name="estado" required >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="status_estado" class="col-lg-2 control-label">Status</label>
			    	<div class="col-lg-10">
						<select class="form-control input-lg"  name="status_estado" id="status_estado" size="1">
							<option value="0">Inactivo</option>
							<option value="1" selected >Activo</option>
						</select>
		      		</div>
			    </div>

			</div>

		</div>

	    <input type="hidden" name="idestado" id="idestado" value="<?php echo $idestado; ?>">
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

	$("#clave").focus();

	var idestado = <?php echo $idestado ?>;

	if (idestado<=0){ // Nuevo Registro
		$("#title").html("Nuevo registro");
	}else{ // Editar Registro
		$("#title").html("Editando el registro: "+idestado);
		getEstado(idestado);
	}

	function getEstado(IdEstado){
		$.post(obj.getValue(0) + "data/", {o:1, t:2, c:IdEstado, p:10, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#clave").val(json[0].clave);
					$("#estado").val(json[0].estado);
					$("#status_estado").val(json[0].status_estado);
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
			var IdEstado = (idestado==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:1, t:IdEstado, c:queryString, p:2, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						stream.emit("cliente", {mensaje: "PLATSOURCE-ESTADO-PROP-"+IdEstado});
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

		if($("#clave").val().length <= 0){
			alert("Faltan la Clave");
			$("#clave").focus();
			return false;
		}

		if($("#estado").val().length <= 0){
			alert("Faltan el Estado");
			$("#estado").focus();
			return false;
		}

		return true;

	}




});

</script>
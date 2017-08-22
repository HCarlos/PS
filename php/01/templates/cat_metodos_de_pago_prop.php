<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idmetododepago  = $_POST['idmetododepago'];

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
					Métodos de Pago
				</a>
			</li>

		</ul>

		<div class="tab-content">

			<div id="general" class="tab-pane active">
			
				<div class="form-group ">
			    	<label for="metodo_de_pago" class="col-lg-4 control-label">Métodos de Pago</label>
			    	<div class="col-lg-8">
				    	<input type="text" class="form-control altoMoz" id="metodo_de_pago" name="metodo_de_pago" required >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="status_metodo_de_pago" class="col-lg-4 control-label">Status</label>
			    	<div class="col-lg-8">
						<select class="form-control input-lg"  name="status_metodo_de_pago" id="status_metodo_de_pago" size="1">
							<option value="0">Inactivo</option>
							<option value="1" selected >Activo</option>
						</select>
		      		</div>
			    </div>

			</div>

		</div>

	    <input type="hidden" name="idmetododepago" id="idmetododepago" value="<?php echo $idmetododepago; ?>">
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

	var idmetododepago = <?php echo $idmetododepago ?>;

	if (idmetododepago<=0){ // Nuevo Registro
		$("#title").html("Nuevo registro");
	}else{ // Editar Registro
		$("#title").html("Editando el registro: "+idmetododepago);
		getMetodoPago(idmetododepago);
	}

	function getMetodoPago(IdMetododePago){
		$.post(obj.getValue(0) + "data/", {o:29, t:75, c:IdMetododePago, p:10, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#metodo_de_pago").val(json[0].metodo_de_pago);
					$("#status_metodo_de_pago").val(json[0].status_metodo_de_pago);
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
			var IdMetododePago = (idmetododepago==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:29, t:IdMetododePago, c:queryString, p:2, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						// stream.emit("cliente", {mensaje: "PLATSOURCE-METODOS_DE_PAGO-PROP-"+IdMetododePago});
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

		if ($("#metodo_de_pago").val().length <= 0) {
			alert("Faltan el Nivel");
			$("#metodo_de_pago").focus();
			return false;
		}

		return true;

	}




});

</script>
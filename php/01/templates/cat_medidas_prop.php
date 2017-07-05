<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idmedida  = $_POST['idmedida'];

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
					Medida
				</a>
			</li>

		</ul>

		<div class="tab-content">

			<div id="general" class="tab-pane active">
			
				<div class="form-group ">
			    	<label for="medida1" class="col-lg-4 control-label">Abreviatura</label>
			    	<div class="col-lg-8">
				    	<input type="text" class="form-control altoMoz" id="medida1" name="medida1" required >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="medida2" class="col-lg-4 control-label">Medida</label>
			    	<div class="col-lg-8">
				    	<input type="text" class="form-control altoMoz" id="medida2" name="medida2" required >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="clave" class="col-lg-4 control-label">Clave</label>
			    	<div class="col-lg-8">
				    	<input type="text" class="form-control altoMoz" id="clave" name="clave" required >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="status_medida" class="col-lg-4 control-label">Status</label>
			    	<div class="col-lg-8">
						<select class="form-control input-lg"  name="status_medida" id="status_medida" size="1">
							<option value="0">Inactivo</option>
							<option value="1" selected >Activo</option>
						</select>
		      		</div>
			    </div>

			</div>

		</div>

	    <input type="hidden" name="idmedida" id="idmedida" value="<?php echo $idmedida; ?>">
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

	var idmedida = <?php echo $idmedida ?>;

	if (idmedida<=0){ // Nuevo Registro
		$("#title").html("Nuevo registro");
	}else{ // Editar Registro
		$("#title").html("Editando el registro: "+idmedida);
		getMedida(idmedida);
	}

	function getMedida(IdMedida){
		$.post(obj.getValue(0) + "data/", {o:32, t:81, c:IdMedida, p:10, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#medida1").val(json[0].medida1);
					$("#medida2").val(json[0].medida2);
					$("#clave").val(json[0].clave);
					$("#status_medida").val(json[0].status_medida);
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
			var IdMedida = (idmedida==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:32, t:IdMedida, c:queryString, p:2, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						stream.emit("cliente", {mensaje: "PLATSOURCE-MEDIDAS-PROP-"+IdMedida});
						$("#preloaderPrincipal").hide();
						$("#contentProfile").hide(function(){
							$("#contentProfile").html("");
							$("#contentMain").show();
						});
        			}else{
						$("#preloaderPrincipal").hide();
        				alert(json[0].msg);	
        			}
        	}, "json");
		}else{
			$("#preloaderPrincipal").hide();
		}

	});

	$("#closeFormUpload").on("click",function(event){
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

		if ($("#medida1").val().length <= 0) {
			alert("Faltan la Abreviatura");
			$("#medida1").focus();
			return false;
		}

		if ($("#medida2").val().length <= 0) {
			alert("Faltan la Medida");
			$("#medida2").focus();
			return false;
		}

		return true;

	}


});

</script>
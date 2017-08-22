<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idnivel  = $_POST['idnivel'];

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
					Nivel
				</a>
			</li>

		</ul>

		<div class="tab-content">

			<div id="general" class="tab-pane active">
			
				<div class="form-group ">
			    	<label for="nivel" class="col-lg-4 control-label">Nivel</label>
			    	<div class="col-lg-8">
				    	<input type="text" class="form-control altoMoz" id="nivel" name="nivel" required >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="clave_nivel" class="col-lg-4 control-label">Cve Niv Interno</label>
			    	<div class="col-lg-8">
				    	<input type="text" class="form-control altoMoz" id="clave_nivel" name="clave_nivel" required >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="clave_registro_nivel" class="col-lg-4 control-label">Clave</label>
			    	<div class="col-lg-8">
				    	<input type="text" class="form-control altoMoz" id="clave_registro_nivel" name="clave_registro_nivel" required >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="nivel_oficial" class="col-lg-4 control-label">Nivel Oficial</label>
			    	<div class="col-lg-8">
				    	<input type="text" class="form-control altoMoz" id="nivel_oficial" name="nivel_oficial" required >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="nivel_fiscal" class="col-lg-4 control-label">Nivel Fiscal</label>
			    	<div class="col-lg-8">
				    	<input type="text" class="form-control altoMoz" id="nivel_fiscal" name="nivel_fiscal" required >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="fecha_actas" class="col-lg-4 control-label">Fecha Actas</label>
			    	<div class="col-lg-8">
				    	<input type="text" class="form-control altoMoz" id="fecha_actas" name="fecha_actas" required >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="status_nivel" class="col-lg-4 control-label">Status</label>
			    	<div class="col-lg-8">
						<select class="form-control input-lg"  name="status_nivel" id="status_nivel" size="1">
							<option value="0">Inactivo</option>
							<option value="1" selected >Activo</option>
						</select>
		      		</div>
			    </div>

			</div>

		</div>

	    <input type="hidden" name="idnivel" id="idnivel" value="<?php echo $idnivel; ?>">
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

	var idnivel = <?php echo $idnivel ?>;

	if (idnivel<=0){ // Nuevo Registro
		$("#title").html("Nuevo registro");
	}else{ // Editar Registro
		$("#title").html("Editando el registro: "+idnivel);
		getNivel(idnivel);
	}

	function getNivel(IdNivel){
		$.post(obj.getValue(0) + "data/", {o:3, t:6, c:IdNivel, p:10, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#nivel").val(json[0].nivel);
					$("#clave_nivel").val(json[0].clave_nivel);
					$("#nivel_oficial").val(json[0].nivel_oficial);
					$("#nivel_fiscal").val(json[0].nivel_fiscal);
					$("#fecha_actas").val(json[0].fecha_actas);
					$("#clave_registro_nivel").val(json[0].clave_registro_nivel);
					$("#status_nivel").val(json[0].status_nivel);
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
			var IdNivel = (idnivel==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:3, t:IdNivel, c:queryString, p:2, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						// stream.emit("cliente", {mensaje: "PLATSOURCE-NIVELES-PROP-"+IdNivel});
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

		if ($("#nivel").val().length <= 0) {
			alert("Faltan el Nivel");
			$("#nivel").focus();
			return false;
		}

		if ( parseInt($("#clave_nivel").val()) <= 0) {
			alert("Faltan la Clave Nivel Inerno");
			$("#clave_nivel").focus();
			return false;
		}

		if ($("#clave_registro_nivel").val().length <= 0) {
			alert("Faltan la Clave de Registro del Nivel");
			$("#clave_registro_nivel").focus();
			return false;
		}

		if ($("#nivel_oficial").val().length <= 0) {
			alert("Faltan el Nivel Oficial");
			$("#nivel_oficial").focus();
			return false;
		}

		if ($("#nivel_fiscal").val().length <= 0) {
			alert("Faltan el Nivel Fiscal");
			$("#nivel_fiscal").focus();
			return false;
		}


		return true;

	}




});

</script>
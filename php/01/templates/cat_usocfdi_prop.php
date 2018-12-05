<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idusocfdi  = $_POST['idusocfdi'];

?>
<div class="row-fluid">
<div class="span12" style="padding-left: 1em; padding-right: 1em;">
<div class="tabbable">

	<h3 class="header smaller lighter blue" id="title"></h3>
	<form id="frmUsoCFDi" role="form">

		<ul class="nav nav-tabs" id="myTab">

			<li class="active">
				<a data-toggle="tab" href="#general">
					<i class="red icon-home bigger-110"></i>
					UsoCFDi
				</a>
			</li>

		</ul>

		<div class="tab-content">

			<div id="general" class="tab-pane active">
			
				<div class="form-group ">
			    	<label for="usocfdi" class="col-lg-2 control-label">Clave</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="usocfdi" name="usocfdi" required >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="descripcion" class="col-lg-2 control-label">Descripción</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="descripcion" name="descripcion" required >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="status_usocfdi" class="col-lg-2 control-label">Status</label>
			    	<div class="col-lg-10">
						<select class="form-control input-lg"  name="status_usocfdi" id="status_usocfdi" size="1">
							<option value="0">Inactivo</option>
							<option value="1" selected >Activo</option>
						</select>
		      		</div>
			    </div>

			</div>

		</div>

	    <input type="hidden" name="idusocfdi" id="idusocfdi" value="<?php echo $idusocfdi; ?>">
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

	$("#usocfdi").focus();

	var idusocfdi = <?php echo $idusocfdi ?>;

	if (idusocfdi<=0){ // Nuevo Registro
		$("#title").html("Nuevo registro");
	}else{ // Editar Registro
		$("#title").html("Editando el registro: "+idusocfdi);
		getusocfdi(idusocfdi);
	}

	function getusocfdi(idusocfdi){
		$.post(obj.getValue(0) + "data/", {o:70, t:86, c:idusocfdi, p:54, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#usocfdi").val(json[0].usocfdi);
					$("#descripcion").val(json[0].descripcion);
					$("#status_usocfdi").val(json[0].status_usocfdi);
				}
		},'json');
	}

    $("#frmUsoCFDi").unbind("submit");
	$("#frmUsoCFDi").on("submit",function(event){
		event.preventDefault();

		$("#preloaderPrincipal").show();

	    var queryString = $(this).serialize();	
	    

		var data = new FormData();

		if (validForm()){
			var IdUsoCDFi = (idusocfdi==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:70, t:IdUsoCDFi, c:queryString, p:52, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
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

		if($("#usocfdi").val().length <= 0){
			alert("Faltan el usocfdi");
			$("#usocfdi").focus();
			return false;
		}

		return true;

	}




});

</script>
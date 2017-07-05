<?php

include("includes/metas.php");

$user = $_POST['user'];
$idgirobeneficio  = $_POST['idgirobeneficio'];

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
					Giro Afiliados
				</a>
			</li>

		</ul>

		<div class="tab-content">

			<div id="general" class="tab-pane active">
			
				<div class="form-group ">
			    	<label for="girobeneficio" class="col-lg-3 control-label">Giro Afiliados</label>
			    	<div class="col-lg-9">
				    	<input type="text" class="form-control altoMoz" id="girobeneficio" name="girobeneficio" required >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="status_giro_beneficio" class="col-lg-3 control-label">Status</label>
			    	<div class="col-lg-9">
						<select class="form-control input-lg"  name="status_giro_beneficio" id="status_giro_beneficio" size="1">
							<option value="0">Inactivo</option>
							<option value="1" selected >Activo</option>
						</select>
		      		</div>
			    </div>

			</div>

		</div>

	    <input type="hidden" name="idgirobeneficio" id="idgirobeneficio" value="<?php echo $idgirobeneficio; ?>">
	    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
	    <div class="form-group w96" style='margin-right: 3em; margin-top: 1em;'>
	    	<button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="closeFormUpload">
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

	var stream = io.connect(obj.getValue(4));


	$("#preloaderPrincipal").hide();

	$("#girobeneficio").focus();

	var idgirobeneficio = <?php echo $idgirobeneficio ?>;

	if (idgirobeneficio<=0){ // Nuevo Registro
		$("#title").html("Nuevo registro");
	}else{ // Editar Registro
		$("#title").html("Editando el registro: "+idgirobeneficio);
		getGiroAfiliados(idgirobeneficio);
	}

	function getGiroAfiliados(IdGiroAfiliado){
		$.post(obj.getValue(0) + "data/", {o:37, t:37, c:IdGiroAfiliado, p:54, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#girobeneficio").val(json[0].girobeneficio);
					$("#status_giro_beneficio").val(json[0].status_giro_beneficio);
				}
		},'json');
	}

    $("#frmData").unbind("submit");
	$("#frmData").on("submit",function(event){
		event.preventDefault();

		$("#preloaderPrincipal").show();

	    var queryString = $(this).serialize();	
	    
		if (validForm()){
			var IdGiroAfiliado = (idgirobeneficio==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:58, t:IdGiroAfiliado, c:queryString, p:52, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						stream.emit("cliente", {mensaje: "PLATSOURCE-GIRO_BENEFICIO-PROP-"+IdGiroAfiliado});
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

		if($("#girobeneficio").val().length <= 0){
			alert("Faltan el Giro del Afiliado");
			$("#girobeneficio").focus();
			return false;
		}

		return true;

	}




});

</script>
<?php

include("includes/metas.php");

$user = $_POST['user'];
$idgrumatcon  = $_POST['idgrumatcon'];
$idgrumatconmkb  = $_POST['idgrumatconmkb'];
$descripcion_mkb  = $_POST['descripcion_mkb'];
$num_eval = $_POST['num_eval'];

?>

<div class="tabbable" style="margin:1em;">

	<form id="frmDataPartesConfigMKB0" role="form">

		<ul class="nav nav-tabs" id="myTab">

			<li class="active">
				<a data-toggle="tab" href="#general">
					<i class="red icon-home bigger-110"></i>
					<span><?php echo $descripcion_mkb; ?></span>
				</a>
			</li>

		</ul>

		<div class="tab-content">

			<div id="general" class="tab-pane active">
			
				<div class="form-group ">
			    	<label for="descripcion_breve" class="col-lg-4 control-label">Descripcion Breve</label>
			    	<div class="col-lg-8">
				    	<input type="text" class="form-control altoMoz" id="descripcion_breve" name="descripcion_breve" required >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="descripcion_avanzada" class="col-lg-4 control-label">Descripcion Avanzada</label>
			    	<div class="col-lg-8">
				    	<textarea class="form-control " id="descripcion_avanzada" name="descripcion_avanzada" required rows="4"></textarea>		      		
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="status_grumatconmkb" class="col-lg-4 control-label">Status</label>
			    	<div class="col-lg-8">
						<select class="form-control input-lg"  name="status_grumatconmkb" id="status_grumatconmkb" size="1">
							<option value="0">Inactivo</option>
							<option value="1" selected >Activo</option>
						</select>
		      		</div>
			    </div>


			</div>

		</div>

	    <input type="hidden" name="idgrumatconmkb" id="idgrumatconmkb" value="<?php echo $idgrumatconmkb; ?>">
	    <input type="hidden" name="idgrumatcon" id="idgrumatcon" value="<?php echo $idgrumatcon; ?>">
	    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
	    <div class="form-group w96" style='margin-right: 3em; margin-top: 1em;'>
	    	<button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="closeFormUpload"><i class="icon-signout"></i>Cerrar</button>
	    	<span class="muted"></span>
	    	<button type="submit" class="btn btn-primary pull-right" style='margin-right: 4em;'><i class="icon-save"></i>Guardar</button>
		</div>

	</form>

</div>

<script typy="text/javascript">        

jQuery(function($) {

	// var stream = io.connect(obj.getValue(4));

	//alert($("#num_eval_matcon").val());

	$("#preloaderPrincipal").hide();

	$("#descripcion").focus();

	var idgrumatconmkb = <?php echo $idgrumatconmkb ?>;
	var Num_Eval = <?php echo $num_eval ?>;
	$("#num_eval_matcon").val(Num_Eval);

	function getGruMatConMKB0(IdGruMatConMKB0){
		$.post(obj.getValue(0) + "data/", {o:45, t:105, c:IdGruMatConMKB0, p:11, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#descripcion_breve").val(json[0].descripcion_breve);
					$("#descripcion_avanzada").val(json[0].descripcion_avanzada);
					$("#status_grumatconmkb").val(json[0].status_grumatconmkb);
				}
		},'json');
	}

    $("#frmDataPartesConfigMKB0").unbind("submit");
	$("#frmDataPartesConfigMKB0").on("submit",function(event){
		event.preventDefault();

		$("#preloaderPrincipal").show();

	    var queryString = $(this).serialize();	
	    
	    // alert(queryString)
	    //return false;

		var data = new FormData();

		if (validForm()){
			var IdGruMatConMKB0 = (idgrumatconmkb==0?0:1)
			// alert(IdGruMatConMKB0);
            $.post(obj.getValue(0) + "data/", {o:45, t:IdGruMatConMKB0, c:queryString, p:2, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						// stream.emit("cliente", {mensaje: "PLATSOURCE-GRUMATCONMKB-PROP-"+IdGruMatConMKB0});
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

		if($("#descripcion_breve").val().length <= 0){
			alert("Faltan el Descripcion Breve");
			$("#descripcion_breve").focus();
			return false;
		}

		if($("#descripcion_avanzada").val().length <= 0){
			alert("Faltan el Descripcion Avanzada");
			$("#descripcion_avanzada").focus();
			return false;
		}

	return true;

	}


	if (idgrumatconmkb<=0){ // Nuevo Registro
		$("#title").html("Nuevo registro");
	}else{ // Editar Registro
		getGruMatConMKB0(idgrumatconmkb);
	}

	$("#descripcion_breve").focus();


});

</script>
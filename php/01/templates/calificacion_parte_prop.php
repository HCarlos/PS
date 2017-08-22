<?php

include("includes/metas.php");

$user = $_POST['user'];
$idgrumat  = $_POST['idgrumat'];
$idgrumatcon  = $_POST['idgrumatcon'];
$materia  = $_POST['materia'];
$num_eval = $_POST['num_eval'];
?>

<div class="row-fluid">
<div class="span12" style="padding-left: 1em; padding-right: 1em;">
<div class="tabbable">

	<h3 class="header smaller lighter blue" id="title"><?php echo $materia; ?></h3>
	<form id="frmDataPartesConfig" role="form">

		<ul class="nav nav-tabs" id="myTab">

			<li class="active">
				<a data-toggle="tab" href="#general">
					<i class="red icon-home bigger-110"></i>
					<h4>Porcentaje</h4>
				</a>
			</li>

		</ul>

		<div class="tab-content">

			<div id="general" class="tab-pane active">
			
				<div class="form-group ">
			    	<label for="descripcion" class="col-lg-2 control-label">Descripcion</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="descripcion" name="descripcion" required >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="porcentaje" class="col-lg-2 control-label">Porcentaje</label>
			    	<div class="col-lg-10">
						<input maxlength="3" class="input-mini spinner-input form-control inPorc altoMoz" name="porcentaje" id="porcentaje" type="number" max="100" min="0">
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="idalutipoactividad" class="col-lg-2 control-label">Categoría:</label>
			    	<div class="col-lg-10">
						<select class="form-control input-lg"  name="idalutipoactividad" id="idalutipoactividad" size="1" autofocus>
						</select>
		      		</div>
			    </div>

			</div>

		</div>

	    <input type="hidden" name="idgrumatcon" id="idgrumatcon" value="<?php echo $idgrumatcon; ?>">
	    <input type="hidden" name="idgrumat" id="idgrumat" value="<?php echo $idgrumat; ?>">
	    <input type="hidden" name="num_eval_matcon" id="num_eval_matcon" value="0">
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

	//alert($("#num_eval_matcon").val());

	$("#preloaderPrincipal").hide();

	$("#descripcion").focus();

	var idgrumatcon = <?php echo $idgrumatcon ?>;
	var Num_Eval = <?php echo $num_eval ?>;

	$("#num_eval_matcon").val(Num_Eval);
	
	function getGruMatCon(IdGruMatCon){
		$.post(obj.getValue(0) + "data/", {o:18, t:39, c:IdGruMatCon, p:11, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#descripcion").val(json[0].descripcion);
					$("#porcentaje").val(json[0].porcentaje);
					$("#idalutipoactividad").val(json[0].idalutipoactividad);
				}
		},'json');
	}

    $("#frmDataPartesConfig").unbind("submit");
	$("#frmDataPartesConfig").on("submit",function(event){
		event.preventDefault();

		$("#preloaderPrincipal").show();

	    var queryString = $(this).serialize();	
	    
	    // alert(queryString)
	    //return false;

		var data = new FormData();

		if (validForm()){
			var IdGruMatCon = (idgrumatcon==0?0:1)
			//alert(IdGruMatCon);
            $.post(obj.getValue(0) + "data/", {o:18, t:IdGruMatCon, c:queryString, p:2, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						// stream.emit("cliente", {mensaje: "PLATSOURCE-GRUMATCON-PROP-"+IdGruMatCon});
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

		if($("#descripcion").val().length <= 0){
			alert("Faltan el Descripcion");
			$("#descripcion").focus();
			return false;
		}

		if($("#porcentaje").val().length <= 0){
			alert("Faltan el Porcentaje");
			$("#porcentaje").focus();
			return false;
		}

		if($("#num_eval_matcon").val() == '0'){
			alert("No existe el Número de Evaluación");
			$("#descripcion").focus();
			return false;
		}

	return true;

	}


	function getTipoActividad(){
	    var nc = "u="+localStorage.nc;
	    $.post(obj.getValue(0)+"data/", { o:44, t:102, p:10,c:nc,from:0,cantidad:0, s:" order by tipo_actividad asc " },
	        function(json){
	           $.each(json, function(i, item) {
	                $("#idalutipoactividad").append('<option value="'+item.idalutipoactividad+'" > '+item.tipo_actividad+'</option>');
	            });
	            
				if (idgrumatcon<=0){ // Nuevo Registro
					$("#title").html("Nuevo registro");
				}else{ // Editar Registro
					getGruMatCon(idgrumatcon);
				}

				$("#idalutipoactividad").focus();


	        }, "json"
	    );  
	}

	getTipoActividad();


});

</script>
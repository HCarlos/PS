<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idmatclas  = $_POST['idmatclas'];

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
					Clasificación de Materias
				</a>
			</li>

		</ul>

		<div class="tab-content">

			<div id="general" class="tab-pane active">
			
				<div class="form-group ">
			    	<label for="clasificacion" class="col-lg-2 control-label">Clasificación</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="clasificacion" name="clasificacion" required >
		      		</div>
			    </div>

					<table class="table span12" >
						<tr><td>
							<label class="" for="status_materia_clasificacion">
									<b>Estatus</b>
							</label>
							</td>
							<td>
								<input name="status_materia_clasificacion" id="status_materia_clasificacion" class="ace ace-switch ace-switch-6" type="checkbox" checked>
								<span class="lbl"></span>
							</td>
						</tr>
					</table>

			</div>

		</div>

	    <input type="hidden" name="idmatclas" id="idmatclas" value="<?php echo $idmatclas; ?>">
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

	// var stream = io.connect(obj.getValue(4));


	$("#preloaderPrincipal").hide();

	$("#clasificacion").focus();

	var idmatclas = <?php echo $idmatclas ?>;

	if (idmatclas<=0){ // Nuevo Registro
		$("#title").html("Nuevo registro");
	}else{ // Editar Registro
		$("#title").html("Editando el registro: "+idmatclas);
		getMatClas(idmatclas);
	}

	function getMatClas(IdMatClas){
		$.post(obj.getValue(0) + "data/",{o:8, t:16, c:IdMatClas, p:10, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#clasificacion").val(json[0].clasificacion);
					$("#status_materia_clasificacion").prop("checked",json[0].status_materia_clasificacion==1?true:false);	
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
			var IdMatClas = (idmatclas==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:8, t:IdMatClas, c:queryString, p:2, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						// stream.emit("cliente", {mensaje: "PLATSOURCE-MATCLAS-PROP-"+idmatclas});
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

		if($("#clasificacion").val().length <= 0){
			alert("Faltan la Clasificación");
			$("#clasificacion").focus();
			return false;
		}

		return true;

	}




});

</script>
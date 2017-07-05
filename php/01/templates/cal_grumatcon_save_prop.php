<?php

include("includes/metas.php");


$user = $_POST['user'];
$idgrumat  = $_POST['idgrumat'];
$num_eval  = $_POST['num_eval'];

if ( isset($_POST['idmatconsave']) ){
	$idmatconsave  = $_POST['idmatconsave'];
}else{
	$idmatconsave  = 0;
}

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
					Guardar configuración actual de esta materia
				</a>
			</li>

		</ul>

		<div class="tab-content">

			<div id="general" class="tab-pane active">
			

				<div class="form-group ">
			    	<label for="titulo" class="col-lg-3 control-label">Título</label>
			    	<div class="col-lg-9">
				    	<input type="text" class="form-control altoMoz" id="titulo" name="titulo" required alt="autofocus" >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="isitem" class="col-lg-3 control-label">Incluir Items</label>
					<div class="col-lg-9">
						<label>
							<input name="isitem" id="isitem" class="ace ace-switch ace-switch-6" type="checkbox" checked>
							<span class="lbl"></span>
						</label>
					</div>						
			    </div>
			</div>

		</div>

	    <input type="hidden" name="idmatconsave" id="idmatconsave" value="<?= $idmatconsave; ?>">
	    <input type="hidden" name="idgrumat" id="idgrumat" value="<?php echo $idgrumat; ?>">
	    <input type="hidden" name="num_eval" id="num_eval" value="<?php echo $num_eval; ?>">
	    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
	    <div class="form-group w96" style='margin-right: 3em; margin-top: 1em;'>
	    	<button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="closeFormUpload"><i class="icon-signout"></i>Cerrar</button>
	    	<span class="muted"></span>
	    	<button type="submit" class="btn btn-primary pull-right" style='margin-right: 4em;'><i class="icon icon-save"></i>Guardar</button>
		</div>

	</form>

</div>




</div>
</div>
<!--PAGE CONTENT ENDS-->

<script typy="text/javascript">        

jQuery(function($) {

	$("#preloaderPrincipal").hide();

	var stream = io.connect(obj.getValue(4));


	var idmatconsave = <?php echo $idmatconsave ?>;
	var idgrumat = <?php echo $idgrumat ?>;

	if (idmatconsave<=0){ // Nuevo Registro
		$("#title").html("Nuevo registro");
	}else{ // Editar Registro
		$("#title").html("Editando el registro: "+idgrumat);
		getMatConSave(idmatconsave);
	}

	function getMatConSave(IdMatConSave){
		$.post(obj.getValue(0) + "data/", {o:55, t:2, c:IdMatConSave, p:52, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#titulo").val(json[0].titulo);
					$("#isitem").prop("checked",json[0].isitem==1?true:false);	

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
			var IdMatConSave = (idmatconsave==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:55, t:IdMatConSave, c:queryString, p:52, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						stream.emit("cliente", {mensaje: "PLATSOURCE-MATCONSAVE-PROP-"+idmatconsave});
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

		if($("#titulo").val().length <= 0){
			alert("Faltan el Estado");
			$("#titulo").focus();
			return false;
		}

		return true;

	}

	$("#titulo").focus();




});

</script>
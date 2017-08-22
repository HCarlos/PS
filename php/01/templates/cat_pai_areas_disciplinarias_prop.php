<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user 			= $_POST['user'];
$idpaiareadisciplinaria  = $_POST['idpaiareadisciplinaria'];

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
					Áreas Disciplinarias PAI
				</a>
			</li>

		</ul>

		<div class="tab-content">

			<div id="general" class="tab-pane active">
			
				<div class="form-group ">
			    	<label for="area_disciplinaria" class="col-lg-4 control-label">Descripción</label>
			    	<div class="col-lg-8 ">
				    	<input type="text" class="form-control altoMoz" id="area_disciplinaria" name="area_disciplinaria" required >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="orden_impresion" class="col-lg-4 control-label">Orden</label>
			    	<div class="col-lg-8">

								<input class="input-mini spinner-input form-control altoMoz" id="orden_impresion" name="orden_impresion" value="1" minlength="1" maxlength="8" type="number">

		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="status_area_disciplinaria" class="col-lg-4 control-label">Status</label>
			    	<div class="col-lg-8">
                        <!-- <span class="add-on"><i class="icon-asterisk red"></i></span> -->
                        <input name="status_area_disciplinaria" id="status_area_disciplinaria" class="ace ace-switch ace-switch-6" type="checkbox" checked>
                        <span class="lbl"></span>
		      		</div>
			    </div>

			</div>

		</div>

	    <input type="hidden" name="idpaiareadisciplinaria" id="idpaiareadisciplinaria" value="<?php echo $idpaiareadisciplinaria; ?>">
	    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
	    <div class="form-group w96" style='margin-right: 3em; margin-top: 1em;'>
	    	<button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="exitADProp0"><i class="icon-signout"></i>Cerrar</button>
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

	var idpaiareadisciplinaria = <?php echo $idpaiareadisciplinaria ?>;

	if (idpaiareadisciplinaria<=0){ // Nuevo Registro
		$("#title").html("Nuevo registro");
	}else{ // Editar Registro
		$("#title").html("Editando el registro: "+idpaiareadisciplinaria);
		getCriterio(idpaiareadisciplinaria);
	}

	function getCriterio(IdPAIAD1){
		$.post(obj.getValue(0) + "data/", {o:63, t:54, c:IdPAIAD1, p:54, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#area_disciplinaria").val(json[0].area_disciplinaria);					
					$("#orden_impresion").val(json[0].orden_impresion);
                    $("#status_area_disciplinaria").prop("checked",json[0].status_area_disciplinaria==1?true:false);
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
			var IdPAIAD1 = (idpaiareadisciplinaria==0?0:1)
			// alert(queryString);
            $.post(obj.getValue(0) + "data/", {o:63, t:IdPAIAD1, c:queryString, p:52, from:0, cantidad:0, s:''},
            function(json) {
            		
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						// stream.emit("cliente", {mensaje: "PLATSOURCE-AD_PAI-PROP-"+IdPAIAD1});
						$("#preloaderPrincipal").hide();
						$("#contentProfile").hide(function(){
							$("#contentProfile").empty();
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

	$("#exitADProp0").on("click",function(event){
		event.preventDefault();
		$("#preloaderPrincipal").hide();
		$("#contentProfile").hide(function(){
			$("#contentProfile").empty();
			$("#contentMain").show();
		});
		resizeScreen();
		return false;
	});

	function validForm(){

		if ($("#area_disciplinaria").val().length <= 0) {
			alert("Faltan la Descripción del Área Disciplinaria");
			$("#area_disciplinaria").focus();
			return false;
		}

		return true;

	}

	//$('#orden_impresion').ace_spinner({value:1,min:1,max:8,step:1, icon_up:'icon-plus', icon_down:'icon-minus', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});
			

	$('#area_disciplinaria').focus();

});

</script>
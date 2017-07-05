<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user 			= $_POST['user'];
$idpaicriterio  = $_POST['idpaicriterio'];

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
					Criterio PAI
				</a>
			</li>

		</ul>

		<div class="tab-content">

			<div id="general" class="tab-pane active">
			
				<div class="form-group ">
			    	<label for="criterio" class="col-lg-4 control-label">Criterio PAI</label>
			    	<div class="col-lg-8">
						<select class="form-control input-lg"  name="criterio" id="criterio" size="1">
							<option value="">Empty</option>
							<option value="A">Criterio A</option>
							<option value="B">Criterio B</option>
							<option value="C">Criterio C</option>
							<option value="D">Criterio D</option>
						</select>
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="descripcion_criterio" class="col-lg-4 control-label">Descripción</label>
			    	<div class="col-lg-8 bootstrap-criteriopicker">
				    	<input type="text" class="form-control altoMoz" id="descripcion_criterio" name="descripcion_criterio" required >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="status_pai_criterio" class="col-lg-4 control-label">Status</label>
			    	<div class="col-lg-8">
                        <!-- <span class="add-on"><i class="icon-asterisk red"></i></span> -->
                        <input name="status_pai_criterio" id="status_pai_criterio" class="ace ace-switch ace-switch-6" type="checkbox" checked>
                        <span class="lbl"></span>
		      		</div>
			    </div>

			</div>

		</div>

	    <input type="hidden" name="idpaicriterio" id="idpaicriterio" value="<?php echo $idpaicriterio; ?>">
	    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
	    <div class="form-group w96" style='margin-right: 3em; margin-top: 1em;'>
	    	<button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="exitCritList"><i class="icon-signout"></i>Cerrar</button>
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

	var idpaicriterio = <?php echo $idpaicriterio ?>;

	if (idpaicriterio<=0){ // Nuevo Registro
		$("#title").html("Nuevo registro");
	}else{ // Editar Registro
		$("#title").html("Editando el registro: "+idpaicriterio);
		getCriterio(idpaicriterio);
	}

	function getCriterio(IdPAICriterio){
		$.post(obj.getValue(0) + "data/", {o:62, t:52, c:IdPAICriterio, p:54, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#criterio").val(json[0].criterio);
					$("#descripcion_criterio").val(json[0].descripcion_criterio);
                    $("#status_pai_criterio").prop("checked",json[0].status_pai_criterio==1?true:false);
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
			var IdPAICriterio = (idpaicriterio==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:62, t:IdPAICriterio, c:queryString, p:52, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						stream.emit("cliente", {mensaje: "PLATSOURCE-CRITERIOS-PROP-"+IdPAICriterio});
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

	$("#exitCritList").on("click",function(event){
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

		if ($("#criterio").val() == "") {
			alert("Faltan el Criterio");
			$("#criterio").focus();
			return false;
		}

		if ($("#descripcion_criterio").val().length <= 0) {
			alert("Faltan la Descripción del Criterio");
			$("#descripcion_criterio").focus();
			return false;
		}

		return true;

	}


	$('#criterio').focus();


});

</script>
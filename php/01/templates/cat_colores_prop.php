<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idcolor  = $_POST['idcolor'];

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
					Color
				</a>
			</li>

		</ul>

		<div class="tab-content">

			<div id="general" class="tab-pane active">
			
				<div class="form-group ">
			    	<label for="color" class="col-lg-4 control-label">Color</label>
			    	<div class="col-lg-8">
				    	<input type="text" class="form-control altoMoz" id="color" name="color" required >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="codigo_color_hex" class="col-lg-4 control-label">Código</label>
			    	<div class="col-lg-8 bootstrap-colorpicker">
				    	<input type="text" class="form-control altoMoz" id="codigo_color_hex" name="codigo_color_hex" required >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="status_color" class="col-lg-4 control-label">Status</label>
			    	<div class="col-lg-8">
						<select class="form-control input-lg"  name="status_color" id="status_color" size="1">
							<option value="0">Inactivo</option>
							<option value="1" selected >Activo</option>
						</select>
		      		</div>
			    </div>

			</div>

		</div>

	    <input type="hidden" name="idcolor" id="idcolor" value="<?php echo $idcolor; ?>">
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

	var idcolor = <?php echo $idcolor ?>;

	if (idcolor<=0){ // Nuevo Registro
		$("#title").html("Nuevo registro");
	}else{ // Editar Registro
		$("#title").html("Editando el registro: "+idcolor);
		getColor(idcolor);
	}

	function getColor(IdNivel){
		$.post(obj.getValue(0) + "data/", {o:30, t:77, c:IdNivel, p:10, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#color").val(json[0].color);
					$("#codigo_color_hex").val(json[0].codigo_color_hex);
					$("#status_color").val(json[0].status_color);
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
			var IdNivel = (idcolor==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:30, t:IdNivel, c:queryString, p:2, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						stream.emit("cliente", {mensaje: "PLATSOURCE-COLORES-PROP-"+IdNivel});
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

		if ($("#color").val().length <= 0) {
			alert("Faltan el Color");
			$("#color").focus();
			return false;
		}

		if ($("#codigo_color_hex").val().length <= 0) {
			alert("Faltan el Código en Hexagésimal");
			$("#codigo_color_hex").focus();
			return false;
		}

		return true;

	}


	$('#codigo_color_hex').colorpicker();


});

</script>
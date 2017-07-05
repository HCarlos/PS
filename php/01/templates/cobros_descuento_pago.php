<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idedocta  = $_POST['idedocta'];
$idfamilia  = $_POST['idfamilia'];

?>
<div class="row-fluid">
<div class="span12" style="padding-left: 1em; padding-right: 1em;">
<div class="tabbable">

	<h3 class="header smaller lighter blue" id="title">Aplicar Descuento: <?php echo $idedocta; ?></h3>
	<form id="frmData" role="form">

		<ul class="nav nav-tabs" id="myTab">

			<li class="active">
				<a data-toggle="tab" href="#general">
					<i class="red icon-percent bigger-110"></i>
					Descuento
				</a>
			</li>

		</ul>

		<div class="tab-content">

			<div id="general" class="tab-pane active">
			
				<div class="form-group ">
			    	<label for="porcentaje" class="col-lg-3 control-label">Porcentaje: </label>
			    	<div class="col-lg-9">
				    	<input type="text" class="form-control altoMoz" id="porcentaje" name="porcentaje" required autofocus>
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="omitir_descto_beca" class="col-lg-3 control-label">Omitir Becas: </label>
						<div class="span3">
							<label>
								<input name="omitir_descto_beca" id="omitir_descto_beca" class="ace ace-switch ace-switch-6" type="checkbox">
								<span class="lbl"></span>
							</label>
						</div>
			    </div>

			</div>

		</div>

	    <input type="hidden" name="idedocta" id="idedocta" value="<?php echo $idedocta; ?>">
	    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
	    <input type="hidden" name="idfamilia" id="idfamilia" value="<?php echo $idfamilia; ?>">
	    <div class="form-group w96" style='margin-right: 3em; margin-top: 1em;'>
	    	<button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="closeFormUpload"><i class="icon-signout"></i>Regresar</button>
	    	<span class="muted"></span>
	    	<button type="submit" class="btn btn-primary pull-right" style='margin-right: 4em;'><i class="icon-ok"></i>Aplicar</button>
		</div>

	</form>

</div>




</div>
</div>
<!--PAGE CONTENT ENDS-->

<script typy="text/javascript">        

jQuery(function($) {

	var stream = io.connect(obj.getValue(4));
	var idedocta = <?php echo $idedocta; ?>;

	$("#preloaderPrincipal").hide();

    $("#frmData").unbind("submit");
	$("#frmData").on("submit",function(event){
		event.preventDefault();

		$("#preloaderPrincipal").show();

	    var queryString = $(this).serialize();	
	    
	    // alert(queryString)
	    // return false;

		var data = new FormData();

		if (validForm()){
            $.post(obj.getValue(0) + "data/", {o:28, t:5, c:queryString, p:2, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Descuento aplicado con éxito.");
						stream.emit("cliente", {mensaje: "PLATSOURCE-APLYDESCTO-PROP-"+idedocta});
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

		if( parseFloat( $("#edocta").val() ) <= 0){
			alert("Faltan el Porcentaje");
			$("#edocta").focus();
			return false;
		}

		return true;

	}

	$("#descuento").focus();


});

</script>
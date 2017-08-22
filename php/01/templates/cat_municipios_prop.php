<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idmunicipio  = $_POST['idmunicipio'];

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
					Municipios
				</a>
			</li>

		</ul>

		<div class="tab-content">

			<div id="general" class="tab-pane active">

				<div class="form-group ">
			    	<label for="idestado" class="col-lg-2 control-label">Estado</label>
			    	<div class="col-lg-10">
						<select class="form-control input-lg"  name="idestado" id="idestado" size="1">
						</select>
		      		</div>
			    </div>
			
				<div class="form-group ">
			    	<label for="clave" class="col-lg-2 control-label">Clave</label>
			    	<div class="col-lg-10 ">
				    	<input type="text" class="form-control altoMoz" maxlength="20" id="clave" name="clave" required autofocus >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="municipio" class="col-lg-2 control-label">Municipio</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="municipio" name="municipio" required >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="status_municipio" class="col-lg-2 control-label">Status</label>
			    	<div class="col-lg-10">
						<select class="form-control input-lg"  name="status_municipio" id="status_municipio" size="1">
							<option value="0">Inactivo</option>
							<option value="1" selected >Activo</option>
						</select>
		      		</div>
			    </div>

			</div>

		</div>

	    <input type="hidden" name="idmunicipio" id="idmunicipio" value="<?php echo $idmunicipio; ?>">
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

	$("#clave").focus();

	var idmunicipio = <?php echo $idmunicipio ?>;


	function getMunicipio(IdMunicipio){
		$.post(obj.getValue(0) + "data/", {o:2, t:4, c:IdMunicipio, p:10, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#clave").val(json[0].clave);
					$("#idestado").val(json[0].idestado);
					$("#municipio").val(json[0].municipio);
					$("#status_municipio").val(json[0].status_municipio);
				}
		},'json');
	}

    $("#frmData").unbind("submit");
	$("#frmData").on("submit",function(event){
		event.preventDefault();

		$("#preloaderPrincipal").show();

	    var queryString = $(this).serialize();	
	    
		var data = new FormData();

		if (validForm()){
			var IdMunicipio = (idmunicipio==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:2, t:IdMunicipio, c:queryString, p:2, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						// stream.emit("cliente", {mensaje: "PLATSOURCE-MUNICIPIO-PROP-"+IdMunicipio});
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

		if($("#clave").val().length <= 0){
			alert("Faltan la Clave");
			$("#clave").focus();
			return false;
		}

		if($("#municipio").val().length <= 0){
			alert("Faltan el Municipio");
			$("#municipio").focus();
			return false;
		}

		return true;

	}

function getEstados(){
    var nc = "u="+localStorage.nc;
    $.post(obj.getValue(0)+"data/", { o:1, t:1, p:0,c:nc,from:0,cantidad:0, s:"" },
        function(json){
            var nc;
           $.each(json, function(i, item) {
                //alert(item.label);
                nc = item.label.split("@");
                $("#idestado").append('<option value="'+item.data+'"> '+item.label+'</option>');
            });
            
			if (idmunicipio<=0){ // Nuevo Registro
				$("#title").html("Nuevo registro");
			}else{ // Editar Registro
				$("#title").html("Editando el registro: "+idmunicipio);
				getMunicipio(idmunicipio);
			}



        }, "json"
    );  
}

getEstados();

});

</script>
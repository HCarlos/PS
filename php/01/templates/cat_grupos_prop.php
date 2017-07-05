<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idgrupo  = $_POST['idgrupo'];

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
					Generales
				</a>
			</li>

			<li >
				<a data-toggle="tab" href="#especifico">
					<i class="red icon-home bigger-110"></i>
					Específicos
				</a>
			</li>

		</ul>

		<div class="tab-content">

			<div id="general" class="tab-pane active">
			
				<div class="form-group ">
			    	<label for="clave" class="col-lg-4 control-label">Clave</label>
			    	<div class="col-lg-8">
				    	<input type="text" class="form-control altoMoz" id="clave" name="clave" required >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="grupo" class="col-lg-4 control-label">Grupo</label>
			    	<div class="col-lg-8">
				    	<input type="text" class="form-control altoMoz" id="grupo" name="grupo" required >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="grupo_periodo" class="col-lg-4 control-label">Periodo</label>
			    	<div class="col-lg-8">
				    	<input type="text" class="form-control altoMoz" id="grupo_periodo" name="grupo_periodo"  >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="grupo_oficial" class="col-lg-4 control-label">Nombre Oficial</label>
			    	<div class="col-lg-8">
				    	<input type="text" class="form-control altoMoz" id="grupo_oficial" name="grupo_oficial"  >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="grupo_periodo_ciclo" class="col-lg-4 control-label">Semestre</label>
			    	<div class="col-lg-8">
				    	<input type="text" class="form-control altoMoz" id="grupo_periodo_ciclo" name="grupo_periodo_ciclo"  >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="grado" class="col-lg-4 control-label">Grado</label>
			    	<div class="col-lg-8">
						<select class="form-control input-lg"  name="grado" id="grado" size="1">
							<option value="0" selected>Ninguno</option>
							<option value="1">Primero</option>
							<option value="2">Segundo</option>
							<option value="3">Tercero</option>
							<option value="4">Cuarto</option>
							<option value="5">Quinto</option>
							<option value="6">Sexto</option>
							<option value="7">Septimo</option>
							<option value="8">Octavo</option>
							<option value="9">Noveno</option>
							<option value="10">Décimo</option>
							<option value="11">Décimo Primero</option>
							<option value="12">Décimo Segundo</option>
						</select>
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="status_grupo" class="col-lg-4 control-label">Status</label>
			    	<div class="col-lg-8">
						<select class="form-control input-lg"  name="status_grupo" id="status_grupo" size="1">
							<option value="0">Inactivo</option>
							<option value="1" selected >Activo</option>
						</select>
		      		</div>
			    </div>

			</div>


			<div id="especifico" class="tab-pane">
			
				<div class="form-group ">
			    	<label for="bloqueado" class="col-lg-4 control-label">Bloqueado</label>
			    	<div class="col-lg-8">
						<label>
							<input name="bloqueado" id="bloqueado" class="ace ace-switch ace-switch-6" type="checkbox">
							<span class="lbl"></span>
						</label>
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="activo_en_caja" class="col-lg-4 control-label">Activo en Caja</label>
			    	<div class="col-lg-8">
						<label>
							<input name="activo_en_caja" id="activo_en_caja" class="ace ace-switch ace-switch-6" type="checkbox">
							<span class="lbl"></span>
						</label>
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="ver_boleta_interna" class="col-lg-4 control-label">Ver Boleta Interna</label>
			    	<div class="col-lg-8">
						<label>
							<input name="ver_boleta_interna" id="ver_boleta_interna" class="ace ace-switch ace-switch-6" type="checkbox">
							<span class="lbl"></span>
						</label>
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="ver_boleta_oficial" class="col-lg-4 control-label">Ver Boleta Oficial</label>
			    	<div class="col-lg-8">
						<label>
							<input name="ver_boleta_oficial" id="ver_boleta_oficial" class="ace ace-switch ace-switch-6" type="checkbox">
							<span class="lbl"></span>
						</label>
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="ispai_grupo" class="col-lg-4 control-label">Es Grupo PAI</label>
			    	<div class="col-lg-8">
						<label>
							<input name="ispai_grupo" id="ispai_grupo" class="ace ace-switch ace-switch-6" type="checkbox">
							<span class="lbl"></span>
						</label>
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="grado_pai" class="col-lg-4 control-label">Grado PAI</label>
			    	<div class="col-lg-8">
	                    <select name="grado_pai" id="grado_pai" size="1" style="width:100% !important;" > 
	                    	<option value="0" selected>Seleccione un Grado PAI</option>
	                    	<option value="1">Primero</option>
	                    	<option value="2">Segundo</option>
	                    	<option value="3">Tercero</option>
	                    	<option value="4">Cuarto</option>
	                    	<option value="5">Quinto</option>
	                    </select>
		      		</div>
			    </div>

			</div>


		</div>

	    <input type="hidden" name="idgrupo" id="idgrupo" value="<?php echo $idgrupo; ?>">
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
	var User = "<?= $user; ?>";


	$("#preloaderPrincipal").hide();

	$("#clave").focus();

	var idgrupo = <?php echo $idgrupo ?>;

	if (idgrupo<=0){ // Nuevo Registro
		$("#title").html("Nuevo registro");
	}else{ // Editar Registro
		$("#title").html("Editando el registro: "+idgrupo);
		getGrupo(idgrupo);
	}

	function getGrupo(IdGrupo){
		$.post(obj.getValue(0) + "data/", {o:4, t:8, c:IdGrupo, p:10, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){

					$("#clave").val(json[0].clave);
					$("#grupo").val(json[0].grupo);
					$("#grado").val(json[0].grado);
					$("#grado_pai").val(json[0].grado_pai);
					$("#grupo_periodo").val(json[0].grupo_periodo);
					$("#grupo_periodo_ciclo").val(json[0].grupo_periodo_ciclo);
					$("#grupo_oficial").val(json[0].grupo_oficial);
					// $("#visible").prop("checked",json[0].visible==1?true:false);						
					$("#bloqueado").prop("checked",json[0].bloqueado==1?true:false);
					$("#activo_en_caja").prop("checked",json[0].activo_en_caja==1?true:false);
					$("#ver_boleta_interna").prop("checked",json[0].ver_boleta_interna==1?true:false);
					$("#ver_boleta_oficial").prop("checked",json[0].ver_boleta_oficial==1?true:false);
					$("#ispai_grupo").prop("checked",json[0].ispai_grupo==1?true:false);
					$("#status_grupo").val(json[0].status_grupo);

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
			var IdGrupo = (idgrupo==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:4, t:IdGrupo, c:queryString, p:2, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						stream.emit("cliente", {mensaje: "PLATSOURCE-GRUPOS-PROP-"+idgrupo+"-"+User});
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

		if($("#grupo").val().length <= 0){
			alert("Faltan el Grupo");
			$("#grupo").focus();
			return false;
		}

		return true;

	}




});

</script>
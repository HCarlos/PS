<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idprofesor  = $_POST['idprofesor'];

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
				<a data-toggle="tab" href="#especificos">
					<i class="blue icon-cog bigger-110"></i>
					Específicos
				</a>
			</li>

		</ul>

		<div class="tab-content">

			<div id="general" class="tab-pane active">
			
				<div class="form-group">
			    	<label for="username" class="col-lg-3 control-label">Username</label>
			    	<div class="col-lg-8">
				    	<input type="text" class="form-control altoMoz" id="username" name="username" >
		      		</div>
			    	<div class="col-lg-1">
				    	<button class="btn btn-link " id="btnGenUser">Generar</button>
		      		</div>
			    </div>

				<div class="form-group">
			    	<label for="ap_paterno" class="col-lg-3 control-label">Ap. Paterno</label>
			    	<div class="col-lg-9">
				    	<input type="text" class="form-control altoMoz" id="ap_paterno" name="ap_paterno"  >
		      		</div>
			    </div>

				<div class="form-group">
			    	<label for="ap_materno" class="col-lg-3 control-label">Ap. Materno</label>
			    	<div class="col-lg-9">
				    	<input type="text" class="form-control altoMoz" id="ap_materno" name="ap_materno"  >
		      		</div>
			    </div>

				<div class="form-group">
			    	<label for="nombre" class="col-lg-3 control-label">Nombre</label>
			    	<div class="col-lg-9">
				    	<input type="text" class="form-control altoMoz" id="nombre" name="nombre"  >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="email" class="col-lg-3 control-label">E-Mail</label>
			    	<div class="col-lg-9">
				    	<input type="text" class="form-control altoMoz" id="email" name="email" >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="status_profesor" class="col-lg-3 control-label">Status</label>
			    	<div class="col-lg-9">
						<select class="form-control input-lg"  name="status_profesor" id="status_profesor" size="1">
							<option value="0">Inactivo</option>
							<option value="1" selected >Activo</option>
						</select>
		      		</div>
			    </div>

			</div>
			
			<div id="especificos" class="tab-pane">


				<div class="form-group ">
					<label for="fecha_nacimiento" class="col-lg-3">Fecha Nacimiento</label>
			    	<div class="col-lg-8">
						<input class="col-lg-3 date-picker altoMoz" id="fecha_nacimiento" name="fecha_nacimiento" data-date-format="dd-mm-yyyy" type="text" >
			      	</div>
			    </div>

				<div class="form-group ">
					<label for="fecha_ingreso" class="col-lg-3">Fecha Ingreso</label>
			    	<div class="col-lg-8">
						<input class="col-lg-3 date-picker altoMoz" id="fecha_ingreso" name="fecha_ingreso" data-date-format="dd-mm-yyyy" type="text" >
			      	</div>
			    </div>

				<div class="form-group ">
			    	<label for="cel1" class="col-lg-3 control-label">Celular 1</label>
			    	<div class="col-lg-9">
				    	<input type="tel" class="form-control altoMoz" id="cel1" name="cel1" >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="cel2" class="col-lg-3 control-label">Celular 2</label>
			    	<div class="col-lg-9">
				    	<input type="tel" class="form-control altoMoz" id="cel2" name="cel2" >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="direccion" class="col-lg-3 control-label">Dirección donde vive</label>
			    	<div class="col-lg-9">
				    	<textarea class="form-control" rows="3" id="direccion" name="direccion"></textarea>
		      		</div>
			    </div>


			</div>
		</div>

	    <input type="hidden" name="idprofesor" id="idprofesor" value="<?php echo $idprofesor; ?>">
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

	$("#username").focus();
	$("#btnGenUser").hide();

	var idprofesor = <?php echo $idprofesor ?>;


	function getpersona(idprofesor){
		$.post(obj.getValue(0) + "data/", {o:6, t:12, c:idprofesor, p:10, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#username").val(json[0].username);
					
					$("#ap_paterno").val(json[0].ap_paterno);
					$("#ap_materno").val(json[0].ap_materno);
					$("#nombre").val(json[0].nombre);
					$("#email").val(json[0].email);
					$("#cel1").val(json[0].cel1);
					$("#cel2").val(json[0].cel2);
					$("#direccion").val(json[0].direccion);

					$("#fecha_ingreso").val(json[0].cfecha_ingreso);
					$("#fecha_nacimiento").val(json[0].cfecha_nacimiento);

					$("#status_profesor").val(json[0].status_profesor);

					
					if ( $("#username").val() == "" ){
							
						$("#btnGenUser").show();
					} 
					
					$("#username").focus();
				}
		},'json');
	}

    $("#frmData").unbind("submit");
	$("#frmData").on("submit",function(event){
		event.preventDefault();

		$("#preloaderPrincipal").show();

	    var queryString = $(this).serialize();	
	    
	    // alert(queryString)
	    // return false;

		var data = new FormData();

		if (validForm()){
			var IdProfesor = (idprofesor==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:6, t:IdProfesor, c:queryString, p:2, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						stream.emit("cliente", {mensaje: "PLATSOURCE-personaES-PROP-"+idprofesor});
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

	$("#btnGenUser").on("click",function(event){
		event.preventDefault();
		$("#iconSaveCommentResp").show();
		var resp =  confirm("Esto creará un USERNAME a este Profesor?");
		if (resp){
			obj.setIsTimeLine(false);
            $.post(obj.getValue(0) + "data/", {o:6, t:2, c:idprofesor, p:3, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
						stream.emit("cliente", {mensaje: "PLATSOURCE-PROFESORES-PROP-"+idprofesor});
						$("#preloaderPrincipal").hide();
						$("#contentProfile").hide(function(){
							$("#contentProfile").html("");
							$("#contentMain").show();
						});
						resizeScreen();
						return false;
        			}else{
        				alert(json[0].msg);	
        			}
        	}, "json");
    	}
	});


	function validForm(){

		if ($("#ap_paterno").val().length <= 0){
			alert("Faltan el Apellido Paterno");
			$("#ap_paterno").focus();
			return false;
		}

		if ($("#ap_materno").val().length <= 0){
			alert("Faltan el Apellido Materno");
			$("#ap_materno").focus();
			return false;
		}

		if ($("#nombre").val().length <= 0){
			alert("Faltan el Nombre");
			$("#nombre").focus();
			return false;
		}

		if ($("#email").val().length <= 0){
			alert("Faltan el E-Mail");
			$("#email").focus();
			return false;
		}
		return true;

	}

	$('.date-picker').datepicker().next().on(ace.click_event, function(){
					$(this).prev().focus();
	});

	$('#fecha_nacimiento').mask('99-99-9999');
	$('#fecha_nacimiento').val(obj.getDateToday());

	$('#fecha_ingreso').mask('99-99-9999');
	$('#fecha_ingreso').val(obj.getDateToday());

	if (idprofesor<=0){ // Nuevo Registro
		$("#title").html("Nuevo registro");
	}else{ // Editar Registro
		$("#title").html("Editando el registro: "+idprofesor);
		getpersona(idprofesor);
	}



});

</script>
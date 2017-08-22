<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idpersona  = $_POST['idpersona'];

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

			<li >
				<a data-toggle="tab" href="#domicilio">
					<i class="green fa fa-envelope bigger-110"></i>
					Domicilio
				</a>
			</li>

		</ul>

		<div class="tab-content">

			<div id="general" class="tab-pane active">

				<div class="form-group ">
			    	<label for="username" class="col-lg-3 control-label">Username</label>
			    	<div class="col-lg-8">
				    	<input type="text" class="form-control altoMoz" id="username" name="username" >
		      		</div>
			    	<div class="col-lg-1">
				    	<button class="btn btn-link " id="btnGenPerUser">Generar</button>
		      		</div>
			    </div>
			
				<div class="form-group ">
			    	<label for="ap_paterno" class="col-lg-3 control-label">Ap. Paterno</label>
			    	<div class="col-lg-9">
				    	<input type="text" class="form-control altoMoz" id="ap_paterno" name="ap_paterno"  >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="ap_materno" class="col-lg-3 control-label">Ap. Materno</label>
			    	<div class="col-lg-9">
				    	<input type="text" class="form-control altoMoz" id="ap_materno" name="ap_materno"  >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="nombre" class="col-lg-3 control-label">Nombre</label>
			    	<div class="col-lg-9">
				    	<input type="text" class="form-control altoMoz" id="nombre" name="nombre"  >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="curp" class="col-lg-3 control-label">CURP</label>
			    	<div class="col-lg-9">
				    	<input type="text" class="form-control altoMoz" id="curp" name="curp"  >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="email1" class="col-lg-3 control-label">E-Mail 1</label>
			    	<div class="col-lg-9">
				    	<input type="text" class="form-control altoMoz" id="email1" name="email1" >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="email2" class="col-lg-3 control-label">E-Mail 2</label>
			    	<div class="col-lg-9">
				    	<input type="text" class="form-control altoMoz" id="email2" name="email2" >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="status_persona" class="col-lg-3 control-label">Status</label>
			    	<div class="col-lg-9">
						<select class="form-control input-lg"  name="status_persona" id="status_persona" size="1">
							<option value="0">Inactivo</option>
							<option value="1" selected >Activo</option>
						</select>
		      		</div>
			    </div>

			</div>

			<div id="especificos" class="tab-pane">

				<div class="form-group ">
					<label for="tel1" class="col-lg-2">Teléfono 1</label>
			    	<div class="col-lg-10">
						<input class="form-control altoMoz" id="tel1" name="tel1" type="text" >
			      	</div>
			    </div>

				<div class="form-group ">
					<label for="tel2" class="col-lg-2">Teléfono 2</label>
			    	<div class="col-lg-10">
						<input class="form-control altoMoz" id="tel2" name="tel2" type="text" >
			      	</div>
			    </div>


				<div class="form-group ">
					<label for="cel1" class="col-lg-2">Celular 1</label>
			    	<div class="col-lg-10">
						<input class="form-control altoMoz" id="cel1" name="cel1" type="text" >
			      	</div>
			    </div>

				<div class="form-group ">
					<label for="cel2" class="col-lg-2">Celular 2</label>
			    	<div class="col-lg-10">
						<input class="form-control altoMoz" id="cel2" name="cel2" type="text" >
			      	</div>
			    </div>

				<div class="form-group ">
					<label for="fecha_nacimiento" class="col-lg-2">Fecha Nacimiento</label>
			    	<div class="col-lg-10">
						<input class="col-lg-3 date-picker altoMoz" id="fecha_nacimiento" name="fecha_nacimiento" data-date-format="dd-mm-yyyy" type="text" >
			      	</div>
			    </div>

				<div class="form-group ">
					<label for="lugar_nacimiento" class="col-lg-2">Lugar Nacimiento</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="lugar_nacimiento" name="lugar_nacimiento"  >
			      	</div>
			    </div>

				<div class="form-group ">
			    	<label for="genero" class="col-lg-2 control-label">Género</label>
			    	<div class="col-lg-10">
						<select class="form-control input-lg"  name="genero" id="genero" size="1">
							<option value="0">Mujer</option>
							<option value="1">Hombre</option>
						</select>
		      		</div>
			    </div>

				<div class="form-group ">
					<label for="ocupacion" class="col-lg-2">Ocupación</label>
			    	<div class="col-lg-10">
						<input class="form-control altoMoz" id="ocupacion" name="ocupacion" type="text" >
			      	</div>
			    </div>

			</div>

			<div id="domicilio" class="tab-pane">

				<div class="form-group ">
					<label for="domicilio_generico" class="col-lg-2">Domicilio Genérico</label>
			    	<div class="col-lg-12">
						<textarea  class="col-lg-10" id="domicilio_generico" name="domicilio_generico" cols="4" ></textarea>
			      	</div>
			    </div>


				<div class="form-group ">

	                <table>

	                    <tr>
	                        <td><label for="calle" class="textRight">Calle</label></td>
	                        <td>
	                            <span class="add-on"><i class="icon-asterisk red"></i></span>
	                            <input class="altoMoz" name="calle" id="calle" type="text" required>
	                        </td>
	                        <td><label for="num_ext" class="marginLeft2em textRight">Num Ext</label></td>
	                        <td>
	                            <span class="add-on"><i class="icon-asterisk red"></i></span>
	                            <input class="altoMoz" name="num_ext" id="num_ext" type="text" required>
	                        </td>
	                        <td><label for="num_int" class="marginLeft2em textRight">Num Int</label></td>
	                        <td>
	                            <input class="altoMoz" name="num_int" id="num_int" type="text" >
	                        </td>
	                    </tr>

	                    <tr>
	                        <td><label for="colonia" class="textRight">Colonia</label></td>
	                        <td>
	                            <span class="add-on"><i class="icon-asterisk red"></i></span>
	                            <input class="altoMoz" name="colonia" id="colonia" type="text" required>
	                        </td>
	                        <td><label for="localidad" class="marginLeft2em textRight">Localidad</label></td>
	                        <td>
	                            <span class="add-on"><i class="icon-asterisk red"></i></span>
	                            <input class="altoMoz" name="localidad" id="localidad" type="text" required>
	                        </td>
	                        <td></td>
	                        <td></td>
	                    </tr>

	                    <tr>
	                        <td><label for="estado" class="textRight">Estado</label></td>
	                        <td>
	                            <span class="add-on"><i class="icon-asterisk red"></i></span>
	                            <input class="altoMoz" name="estado" id="estado" type="text" required>
	                        </td>
	                        <td><label for="municipio" class="marginLeft2em textRight">Municipio</label></td>
	                        <td>
	                            <span class="add-on"><i class="icon-asterisk red"></i></span>
	                            <input class="altoMoz" name="municipio" id="municipio" value="CENTRO" type="text" required>
	                        </td>
	                        <td></td>
	                        <td></td>
	                    </tr>

	                    <tr>
	                        <td><label for="pais" class="marginLeft2em textRight">Pais</label></td>
	                        <td>
	                            <span class="add-on"><i class="icon-asterisk red"></i></span>
	                            <input class="altoMoz" name="pais" id="pais" value="México" type="text" required>
	                        </td>
	                        <td><label for="cp" class="marginLeft2em textRight">CP</label></td>
	                        <td>
	                            <input class="altoMoz" name="cp" id="cp" type="text" >
	                        </td>
	                        <td></td>
	                        <td></td>
	                    </tr>

	                </table>

                </div>

				<div class="form-group ">
			    	<label for="lugar_trabajo" class="col-lg-2 control-label">Lugar de Trabajo</label>
			    	<div class="col-lg-12">
				    	<input type="text" class="form-control altoMoz" id="lugar_trabajo" name="lugar_trabajo"  >
		      		</div>
			    </div>



			</div>


		</div>

	    <input type="hidden" name="idpersona" id="idpersona" value="<?php echo $idpersona; ?>">
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

	$("#username").focus();
	$("#btnGenPerUser").hide();

	var idpersona = <?php echo $idpersona ?>;

	function getpersona(Idpersona){
		$.post(obj.getValue(0) + "data/", {o:10, t:20, c:Idpersona, p:10, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#username").val(json[0].username);
					
					$("#ap_paterno").val(json[0].ap_paterno);
					$("#ap_materno").val(json[0].ap_materno);
					$("#nombre").val(json[0].nombre);
					$("#email1").val(json[0].email1);
					$("#email2").val(json[0].email2);

					$("#cel1").val(json[0].cel1);
					$("#cel2").val(json[0].cel2);

					$("#tel1").val(json[0].tel1);
					$("#tel2").val(json[0].tel2);

					$("#domicilio_generico").html(json[0].domicilio_generico);

					$("#calle").val(json[0].calle);
					$("#num_ext").val(json[0].num_ext);
					$("#num_int").val(json[0].num_int);
					$("#colonia").val(json[0].colonia);
					$("#localidad").val(json[0].localidad);
					$("#estado").val(json[0].estado);
					$("#municipio").val(json[0].municipio);
					$("#pais").val(json[0].pais);
					$("#cp").val(json[0].cp);

					$("#lugar_nacimiento").val(json[0].lugar_nacimiento);
					$("#curp").val(json[0].curp);
					$("#fecha_nacimiento").val(json[0].cfecha_nacimiento);
					$("#lugar_trabajo").val(json[0].lugar_trabajo);

					$("#genero").val(json[0].genero);
					$("#ocupacion").val(json[0].ocupacion);

					$("#status_persona").val(json[0].status_persona);
					
					if ( $("#username").val() == "" ){
						$("#btnGenPerUser").show();
					} 
					
					$("#username").focus();
					
				}
		},'json');
	}

    $("#frmData").unbind("submit");
	$("#frmData").on("submit",function(event){
		event.preventDefault();

		$("#preloaderPrincipal").show();

		if (validForm()){

			var queryString = $(this).serialize();	

			// alert(queryString);

			var IdPersona = (idpersona==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:10, t:IdPersona, c:queryString, p:2, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						// stream.emit("cliente", {mensaje: "PLATSOURCE-PERSONAS-PROP-"+idpersona});
						$("#preloaderPrincipal").hide();
						$("#contentProfile").hide(function(){
							$("#contentProfile").html("");
							$("#contentMain").show();
						});
        			}else{
						$("#preloaderPrincipal").hide();
        				alert(json[0].msg);	
        				return false;
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

	$("#btnGenPerUser").on("click",function(event){
		event.preventDefault();
		$("#iconSaveCommentResp").show();
		var resp =  confirm("Esto creará un USERNAME a esta Persona?");
		if (resp){
			obj.setIsTimeLine(false);
			//alert(idpersona);
	        $.post(obj.getValue(0) + "data/", {o:10, t:2, c:idpersona, p:3, from:0, cantidad:0, s:''},
	        function(json) {
	        		if (json[0].msg=="OK"){
						// stream.emit("cliente", {mensaje: "PLATSOURCE-PERSONAS-PROP-"+idpersona});
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
		return true;

	}



	function getEmpresa(){
		var nc = "u="+localStorage.nc;
		$.post(obj.getValue(0) + "data/", {o:10, t:-1, c:nc, p:55, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#estado").val(json[0].estado);
					$("#municipio").val(json[0].municipio);
					$("#title").html("Nuevo registro");
				}
		},'json');
	}

	$('.date-picker').datepicker().next().on(ace.click_event, function(){
					$(this).prev().focus();
	});

	$('#fecha_nacimiento').mask('99-99-9999');
	$('#fecha_nacimiento').val(obj.getDateToday());

	if (idpersona<=0){ 
		getEmpresa();
	}else{ 
		$("#title").html("Editando el registro: "+idpersona);
		getpersona(idpersona);
	}



});

</script>
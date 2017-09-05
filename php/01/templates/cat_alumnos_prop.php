<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idalumno  = $_POST['idalumno'];

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
				<a data-toggle="tab" href="#becas">
					<i class="orange fa fa-life-ring bigger-110"></i>
					Becas
				</a>
			</li>

			<li >
				<a data-toggle="tab" href="#config">
					<i class="green icon-leaf bigger-110"></i>
					Configuraciones
				</a>
			</li>

		</ul>

		<div class="tab-content">

			<div id="general" class="tab-pane active">
			
				<div class="form-group ">
			    	<label for="username" class="col-lg-2 control-label">Username</label>
			    	<div class="col-lg-9">
				    	<input type="text" class="form-control altoMoz" id="username" name="username" readonly disabled>
		      		</div>
			    	<div class="col-lg-1">
				    	<button class="btn btn-link " id="btnGenUser">Generar</button>
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="ap_paterno" class="col-lg-2 control-label">Ap. Paterno</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="ap_paterno" name="ap_paterno"  >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="ap_materno" class="col-lg-2 control-label">Ap. Materno</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="ap_materno" name="ap_materno"  >
		      		</div>
			    </div>


				<div class="form-group ">
			    	<label for="nombre" class="col-lg-2 control-label">Nombre</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="nombre" name="nombre"  >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="curp" class="col-lg-2 control-label">CURP</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="curp" name="curp"  >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="rfc" class="col-lg-2 control-label">RFC</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="rfc" name="rfc"  >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="email" class="col-lg-2 control-label">E-Mail</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="email" name="email" >
		      		</div>
			    </div>

			</div>

			<div id="especificos" class="tab-pane">


				<div class="form-group ">
					<label for="fecha_nacimiento" class="col-lg-2">Fecha Nacimiento</label>
			    	<div class="col-lg-10">
						<input class="col-lg-3 date-picker altoMoz" id="fecha_nacimiento" name="fecha_nacimiento" data-date-format="dd-mm-yyyy" type="text" value="<?= date('d-m-Y'); ?>" >
			      	</div>
			    </div>

				<div class="form-group ">
					<label for="lugar_nacimiento" class="col-lg-2">Lugar Nacimiento</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="lugar_nacimiento" name="lugar_nacimiento"  >
			      	</div>
			    </div>

				<div class="form-group ">
					<label for="fecha_ingreso" class="col-lg-2">Fecha Ingreso</label>
			    	<div class="col-lg-10">
						<input class="col-lg-3 date-picker altoMoz" id="fecha_ingreso" name="fecha_ingreso" data-date-format="dd-mm-yyyy" type="text" value="<?= date('d-m-Y'); ?>" >
			      	</div>
			    </div>

				<div class="form-group ">
			    	<label for="matricula_interna" class="col-lg-2 control-label">Matrícula Interna</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="matricula_interna" name="matricula_interna"  >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="matricula_oficial" class="col-lg-2 control-label">Matrícula Oficial</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="matricula_oficial" name="matricula_oficial"  >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="genero" class="col-lg-2 control-label">Género</label>
			    	<div class="col-lg-10">
						<select class="form-control input-lg"  name="genero" id="genero" size="1">
							<option value="0" selected >Mujer</option>
							<option value="1">Hombre</option>
						</select>
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="tipo_sangre" class="col-lg-2 control-label">Tipo de Sangre</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="tipo_sangre" name="tipo_sangre"  >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="enfermedades" class="col-lg-2 control-label">Enfermedades</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="enfermedades" name="enfermedades"  >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="reacciones_alergicas" class="col-lg-2 control-label">Reacciones Alérgicas</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="reacciones_alergicas" name="reacciones_alergicas"  >
		      		</div>
			    </div>

			</div>


			<div id="becas" class="tab-pane">

				<div class="form-group ">
			    	<label for="beca_sep" class="col-lg-2 control-label">Beca SEP</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="beca_sep" name="beca_sep" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="Beca otorgada por la SEP" value="0.00" >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="beca_arji" class="col-lg-2 control-label">Beca Colegio</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="beca_arji" name="beca_arji" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="Beca otorgada por el Colegio"  value="0.00" >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="beca_sp" class="col-lg-2 control-label">Beca S.P.F.</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="beca_sp" name="beca_sp" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="Beca otorgada por la Sociedad de Padres de Familia"  value="0.00" >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="beca_bach" class="col-lg-2 control-label">Beca Bachilleres</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="beca_bach" name="beca_bach" pattern="[-+]?[0-9]*[.,]?[0-9]+" title="Beca otorgada por Colegio de Bachilleres"  value="0.00" >
		      		</div>
			    </div>

			</div>

			<div id="config" class="tab-pane">

				<table class="table span6" >

					<tr><td>
						<label class="green" for="activo_en_ciclo">
								<b>Activo en este Ciclo</b>
						</label>
						</td>
						<td>
							<input name="activo_en_ciclo" id="activo_en_ciclo" class="ace ace-switch ace-switch-6" type="checkbox" checked>
							<span class="lbl"></span>
						</td>
					</tr>

					<tr>
						<td>
							<label class="green" for="valid_for_admin">
									<b>Validado por el Administrador</b>
							</label>
						</td>
						<td>
							<input name="valid_for_admin" id="valid_for_admin" class="ace ace-switch ace-switch-6" type="checkbox">
							<span class="lbl"></span>
						</td>
					</tr>

					<tr>
						<td>
							<label class="green" for="status_alumno">
									<b>Status</b>
							</label>
						</td>
						<td>
							<input name="status_alumno" id="status_alumno" class="ace ace-switch ace-switch-6" type="checkbox">
							<span class="lbl"></span>
						</td>
					</tr>

					<tr>
						<td>
							<label class="green" for="is_baja">
									<b>Es Baja</b>
							</label>
						</td>
						<td>
							<input name="is_baja" id="is_baja" class="ace ace-switch ace-switch-6" type="checkbox">
							<span class="lbl"></span>
						</td>
					</tr>

					<tr>
						<td>
							<label class="green" for="idalumotivobaja">
							</label>
						</td>
						<td>
							<select class="form-control"  name="idalumotivobaja" id="idalumotivobaja" size="1">
							</select>
						</td>
					</tr>

					<tr>
						<td>
							<label class="green" for="tipo_baja">
									<b>Tipo Baja</b>
							</label>
						</td>
						<td>
    		                <select name="tipo_baja" id="tipo_baja" size="1" > 
    		                	<option value="0">Ninguno</option>
    		                	<option value="1">Temporal</option>
    		                	<option value="2">Definitiva</option>
	                    	</select>
						</td>
					</tr>

					<tr>
						<td>
							<label class="green" for="fecha_baja">
									<b>Fecha Baja</b>
							</label>
						</td>
						<td>
							<input class="col-lg-6 date-picker altoMoz" id="fecha_baja" name="fecha_baja" data-date-format="dd-mm-yyyy" type="text" value="<?= date('d-m-Y'); ?>" >
						</td>
					</tr>

				
				</table>
			</div>




		</div>

	    <input type="hidden" name="idalumno" id="idalumno" value="<?php echo $idalumno; ?>">
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

	var lc = parseInt(localStorage.IdUserNivelAcceso,0);

	// var stream = io.connect(obj.getValue(4));

	$("#preloaderPrincipal").hide();

	$("#username").focus();
	$("#btnGenUser").hide();

	var idalumno = <?php echo $idalumno ?>;


	function getAlumno(IdAlumno){
		$.post(obj.getValue(0) + "data/", {o:5, t:10, c:IdAlumno, p:10, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#username").val(json[0].username);
					
					$("#ap_paterno").val(json[0].ap_paterno);
					$("#ap_materno").val(json[0].ap_materno);
					$("#nombre").val(json[0].nombre);
					$("#curp").val(json[0].curp);
					$("#rfc").val(json[0].rfc);
					$("#email").val(json[0].email);

					$("#fecha_ingreso").val(json[0].cfecha_ingreso);
					$("#fecha_nacimiento").val(json[0].cfecha_nacimiento);
					$("#lugar_nacimiento").val(json[0].lugar_nacimiento);

					$("#tipo_sangre").val(json[0].tipo_sangre);
					$("#enfermedades").val(json[0].enfermedades);
					$("#reacciones_alergicas").val(json[0].reacciones_alergicas);

					$("#matricula_interna").val(json[0].matricula_interna);
					$("#matricula_oficial").val(json[0].matricula_oficial);

					$("#genero").val(json[0].genero);

					$("#beca_sep").val(json[0].beca_sep);
					$("#beca_arji").val(json[0].beca_arji);
					$("#beca_sp").val(json[0].beca_sp);
					$("#beca_bach").val(json[0].beca_bach);

					$("#valid_for_admin").prop("checked",json[0].valid_for_admin==1?true:false);	
					$("#activo_en_ciclo").prop("checked",json[0].activo_en_ciclo==1?true:false);	
					$("#status_alumno").prop("checked",json[0].status_alumno==1?true:false);	

					$("#is_baja").prop("checked",json[0].is_baja==1?true:false);	
					$("#idalumotivobaja").val(json[0].idalumotivobaja);
					$("#tipo_baja").val(json[0].tipo_baja);
					$("#fecha_baja").val(json[0].cfecha_baja);

					
					if ( $("#username").val() == "" ){
							
						$("#btnGenUser").show();
					} 

					validPermissionsDisabled(lc);
					
					$("#username").focus();
				}
		},'json');
	}

    $("#frmData").unbind("submit");
	$("#frmData").on("submit",function(event){
		event.preventDefault();

		$("#preloaderPrincipal").show();

		validPermissionsEnabled(lc);

	    var queryString = $(this).serialize();	

	    
	    // alert(queryString)
	    // return false;

		var data = new FormData();

		if (validForm()){
			var IdAlumno = (idalumno==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:5, t:IdAlumno, c:queryString, p:2, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						// stream.emit("cliente", {mensaje: "PLATSOURCE-ALUMNOS-PROP-"+IdAlumno});
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

/*
	$("#closeProp").on("click",function(event){
		$("#preloaderPrincipal").hide();
		$("#divUploadImage").modal('hide');
	});
*/

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
		var resp =  confirm("Esto creará un USERNAME a este alumno?");
		if (resp){
			obj.setIsTimeLine(false);
            $.post(obj.getValue(0) + "data/", {o:5, t:2, c:idalumno, p:3, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
						// stream.emit("cliente", {mensaje: "PLATSOURCE-ALUMNOS-PROP-"+idalumno});
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

		// if ($("#email").val().length <= 0){
		// 	alert("Faltan el E-Mail");
		// 	$("#email").focus();
		// 	return false;
		// }

		return true;

	}

	// $('.date-picker').datepicker().next().on(ace.click_event, function(){
	// 				$(this).prev().focus();
	// });

	$('.date-picker').datepicker({
    	format: 'dd-mm-yyyy',
		autoclose: true
	});

	$('.date-picker').on('changeDate', function(event){
	    $(this).datepicker('hide');
	    // validDate();
	});

	$('#fecha_nacimiento').mask('99-99-9999');
	$('#fecha_nacimiento').val(obj.getDateToday());

	$('#fecha_ingreso').mask('99-99-9999');
	$('#fecha_ingreso').val(obj.getDateToday());

	$('#fecha_baja').mask('99-99-9999');
	$('#fecha_baja').val(obj.getDateToday());

	if (idalumno<=0){ // Nuevo Registro
		getMotivosBaja (0);		
		validPermissionsDisabled(lc);
		$("#title").html("Nuevo registro");
	}else{ // Editar Registro
		$("#title").html("Editando el registro: "+idalumno);
		getMotivosBaja(idalumno);
	}


	function getMotivosBaja(idalumno){
	    var nc = "u="+localStorage.nc;
	    $("#idalumotivobaja").empty();
	    $("#idalumotivobaja").append('<option value="0" >Seleccione un motivo de baja</option>');
	    $.post(obj.getValue(0)+"data/", { o:1, t:71, p:0,c:nc,from:0,cantidad:0, s:"" },
	        function(json){
	           $.each(json, function(i, item) {
	                $("#idalumotivobaja").append('<option value="'+item.data+'" > '+item.label+'</option>');
	            });

	            getAlumno(idalumno); 

	        }, "json"
	    );  
	}

	function validPermissionsDisabled(lc){
		switch(lc){
			case 11:
			case 12:
			case 13:
			case 14:
			case 15:
			case 16:
			case 17:
			case 18:
			case 19:
			case 20:
			case 21:
			case 22:
			case 23:
			case 24:
			case 25:
				$("#valid_for_admin").prop("disabled",true);
				$("#activo_en_ciclo").prop("disabled",true);
				$("#beca_arji").prop("disabled",true);
				$("#beca_sep").prop("disabled",true);
				$("#beca_sp").prop("disabled",true);
				$("#beca_bach").prop("disabled",true);
				$("#btnGenUser").prop("disabled",true);
		}
	}

	function validPermissionsEnabled(lc){
		$("#activo_en_ciclo").prop("disabled",false);
		$("#beca_arji").prop("disabled",false);
		$("#beca_sep").prop("disabled",false);
		$("#beca_sp").prop("disabled",false);
		$("#beca_bach").prop("disabled",false);
	}

});

</script>
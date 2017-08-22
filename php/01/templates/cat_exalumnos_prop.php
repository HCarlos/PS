<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idexalumno  = $_POST['idexalumno'];
$objOrigen         = $_POST['objOrigen'];
$objDestino        = $_POST['objDestino'];

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
				<a data-toggle="tab" href="#redessociales">
					<i class="fa fa-share-alt bigger-110" aria-hidden="true"></i>
					Redes Sociales
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
				    	<button class="btn btn-link " id="btnGenUserExa">Generar</button>
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
					<label for="fecha_nacimiento" class="col-lg-2">Fecha Nacimiento</label>
			    	<div class="col-lg-10">
						<input class="date-picker altoMoz" id="fecha_nacimiento" name="fecha_nacimiento" data-date-format="dd-mm-yyyy" type="text" >
                        <span class="add-on">
                                <i class="icon-calendar"></i>
                        </span>			      	
			      	</div>

			    </div>


				<div class="form-group ">
			    	<label for="telefono" class="col-lg-2 control-label">Teléfono</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="telefono" name="telefono"  >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="extension" class="col-lg-2 control-label">Extensión</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="extension" name="extension"  >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="celular" class="col-lg-2 control-label">Celular</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="celular" name="celular"  >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="email" class="col-lg-2 control-label">E-Mail</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="email" name="email" >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="idgeneracion" class="col-lg-2 control-label">Generación</label>
			    	<div class="col-lg-10">
				    	<select name="idgeneracion" id="idgeneracion" size="1" > 
                        </select>
		      		</div>
			    </div>


				<div class="form-group ">
			    	<label for="status_exalumno" class="col-lg-2 control-label">Status</label>
			    	<div class="col-lg-1">
                        <label>
                            <input name="status_exalumno" id="status_exalumno" class="ace ace-switch ace-switch-4" type="checkbox" checked="checked">
                            <span class="lbl"></span>
                        </label>
		      		</div>
			    </div>

			</div>

			<div id="especificos" class="tab-pane">


				<div class="form-group ">
					<label for="direccion" class="col-lg-2">Dirección</label>
			    	<div class="col-lg-10">
						<textarea class="form-control" rows="3" id="direccion" name="direccion"></textarea>
			      	</div>
			    </div>

				<div class="form-group ">
			    	<label for="profesion" class="col-lg-2 control-label">Profesión</label>
			    	<div class="col-lg-10">
						<textarea class="form-control" rows="3" id="profesion" name="profesion"></textarea>
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="ocupacion" class="col-lg-2 control-label">Ocupación</label>
			    	<div class="col-lg-10">
						<textarea class="form-control" rows="3" id="ocupacion" name="ocupacion"></textarea>
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
			    	<label for="isfam" class="col-lg-2 control-label">Es Familiar</label>
			    	<div class="col-lg-1">
                        <label>
                            <input name="isfam" id="isfam" class="ace ace-switch ace-switch-6" type="checkbox" checked="checked">
                            <span class="lbl"></span>
                        </label>
		      		</div>
			    </div>

		    	<div class="col-lg-12"></div>

				<div class="form-group ">
			    	<label for="num_hijos" class="col-lg-2 control-label">Núm. Hijos</label>
			    	<div class="col-lg-9">
				    	<input type="text" class="form-control altoMoz" id="num_hijos" name="num_hijos" value="" >
		      		</div>
			    </div>

			</div>


			<div id="redessociales" class="tab-pane">


				<div class="form-group ">
					<label for="facebook" class="col-lg-2">Facebook</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="facebook" name="facebook"  >
			      	</div>
			    </div>

				<div class="form-group ">
			    	<label for="twitter" class="col-lg-2 control-label">Twitter</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="twitter" name="twitter"  >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="instagram" class="col-lg-2 control-label">Instagram</label>
			    	<div class="col-lg-10">
				    	<input type="text" class="form-control altoMoz" id="instagram" name="instagram"  >
		      		</div>
			    </div>

			</div>

		</div>

	    <input type="hidden" name="idexalumno" id="idexalumno" value="<?php echo $idexalumno; ?>">
	    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
	    <div class="form-group w96" style='margin-right: 3em; margin-top: 1em;'>
	    	<button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="exitFormExa">
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

	var lc = parseInt(localStorage.IdUserNivelAcceso,0);

	// var stream = io.connect(obj.getValue(4));

	$("#preloaderPrincipal").hide();

	$("#username").focus();
	$("#btnGenUserExa").hide();

	var idexalumno = <?php echo $idexalumno ?>;
	var objOrigen  = "<?= $objOrigen; ?>";
	var objDestino = "<?= $objDestino; ?>";


	function getExAlumno(IdExAlumno){
		$.post(obj.getValue(0) + "data/", {o:60, t:48, c:IdExAlumno, p:55, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#username").val(json[0].username);
					
					$("#ap_paterno").val(json[0].ap_paterno);
					$("#ap_materno").val(json[0].ap_materno);
					$("#nombre").val(json[0].nombre);
					$("#telefono").val(json[0].telefono);
					$("#extension").val(json[0].extension);
					$("#celular").val(json[0].celular);
					$("#email").val(json[0].email);

					$("#fecha_nacimiento").val(json[0].fecha_nacimiento);
					if ( json[0].fecha_nacimiento == "00-00-0000"  ){
					    $('#fecha_nacimiento').val(obj.getDateToday());
					}

					$("#num_hijos").val(json[0].num_hijos);

					$("#direccion").val(json[0].direccion);
					$("#profesion").val(json[0].profesion);
					$("#ocupacion").val(json[0].ocupacion);

					$("#isfam").prop("checked",json[0].isfam==1?true:false);	
					$("#status_exalumno").prop("checked",json[0].status_exalumno==1?true:false);	

					$("#genero").val(json[0].genero);

					$("#facebook").val(json[0].facebook);
					$("#twitter").val(json[0].twitter);
					$("#instagram").val(json[0].instagram);

					$("#idgeneracion").val(json[0].idgeneracion);
					
					if ( $("#username").val() == "" ){
							
						$("#btnGenUserExa").show();
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

		var data = new FormData();

		if (validForm()){
			var IdExAlumno = (idexalumno==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:60, t:IdExAlumno, c:queryString, p:52, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						// stream.emit("cliente", {mensaje: "PLATSOURCE-EXALUMNOS-PROP-"+IdExAlumno});
						$("#preloaderPrincipal").hide();
						$("#"+objOrigen).hide(function(){
							$("#"+objOrigen).empty();
							$("#"+objDestino).show();
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

	$("#exitFormExa").on("click",function(event){
		event.preventDefault();
		$("#preloaderPrincipal").hide();
		$("#"+objOrigen).hide(function(){
			$("#"+objOrigen).empty();
			$("#"+objDestino).show();
		});
		resizeScreen();
		return false;
	});

	$("#btnGenUserExa").on("click",function(event){
		event.preventDefault();
		$("#iconSaveCommentResp").show();
		var resp =  confirm("Esto creará un USERNAME a este exalumno?");
		if (resp){
			obj.setIsTimeLine(false);
            $.post(obj.getValue(0) + "data/", {o:60, t:2, c:idexalumno, p:3, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
						// stream.emit("cliente", {mensaje: "PLATSOURCE-EXALUMNOS-PROP-"+idexalumno});
						$("#preloaderPrincipal").hide();
						$("#"+objOrigen).hide(function(){
							$("#"+objOrigen).empty();
							$("#"+objDestino).show();
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

    function getGeneraciones(){
        var nc = "u="+localStorage.nc;
        $("#idgeneracion").empty();
        $.post(obj.getValue(0)+"data/", { o:60, t:60, p:51,c:nc,from:0,cantidad:0, s:"" },
            function(json){
               $.each(json, function(i, item) {
               		var pred = parseInt(item.predeterminado,0) == 1 ? 'selected' : '';
                    $("#idgeneracion").append('<option value="'+item.idgeneracion+'" '+pred+' > '+item.generacion+'</option>');
                });
		  		if (idexalumno<=0){ // Nuevo Registro
					$("#title").html("Nuevo registro");
				}else{ // Editar Registro
					$("#title").html("Editando el registro: "+idexalumno);
	                getExAlumno(idexalumno);
				}
             
            }, "json"
        );  
    }


	getGeneraciones(idexalumno);


});

</script>
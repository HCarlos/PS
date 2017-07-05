<?php

include("includes/metas.php");

$user = $_POST['user'];
$idgrumat  = $_POST['idgrumat'];
$idgrupo  = $_POST['idgrupo'];
$idciclo =  $_POST['idciclo'];

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

			<li>
				<a data-toggle="tab" href="#especificos">
					<i class="blue icon-bolt bigger-110"></i>
					Específicos
				</a>
			</li>

		</ul>

		<div class="tab-content">

			<div id="general" class="tab-pane active">
			
				<div class="form-group ">
			    	<label for="idmateria" class="col-lg-3 control-label">Materias</label>
			    	<div class="col-lg-9">
						<select class="form-control input-lg"  name="idmateria" id="idmateria" size="1">
						</select>
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="idprofesor" class="col-lg-3 control-label">Profesor</label>
			    	<div class="col-lg-9">
						<select class="form-control input-lg"  name="idprofesor" id="idprofesor" size="1">
						</select>
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="isagrupadora0" class="col-lg-3 control-label">Es Agrupadora</label>
			    	<div class="col-lg-9">
						<select class="form-control input-lg"  name="isagrupadora0" id="isagrupadora0" size="1">
							<option value="0" selected>No</option>
							<option value="1">Si</option>
						</select>
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="ispai_materia" class="col-lg-3 control-label">Es Materia PAI</label>
			    	<div class="col-lg-9">
						<select class="form-control input-lg"  name="ispai_materia" id="ispai_materia" size="1" readonly="readonly" >
							<option value="0" selected>No</option>
							<option value="1">Si</option>
						</select>
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="orden_impresion" class="col-lg-3 control-label">Ord. Impresión</label>
			    	<div class="col-lg-9">
				    	<input type="number" class="form-control altoMoz" id="orden_impresion" name="orden_impresion" min="0" max="999" value='0'>
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="orden_historial" class="col-lg-3 control-label">Ord. Historial</label>
			    	<div class="col-lg-9">
				    	<input type="number" class="form-control altoMoz" id="orden_historial" name="orden_historial" min="0" max="999" value='0'>
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="orden_oficial" class="col-lg-3 control-label">Ord. Oficial</label>
			    	<div class="col-lg-9">
				    	<input type="number" class="form-control altoMoz" id="orden_oficial" name="orden_oficial" min="0" max="999" value='0'>
		      		</div>
			    </div>

			</div>

			<div id="especificos" class="tab-pane">

				<div class="form-group ">
			    	<label for="materia_oficial" class="col-lg-3 control-label">Materia Oficial</label>
			    	<div class="col-lg-9">
				    	<input type="text" class="form-control altoMoz" id="materia_oficial" name="materia_oficial"   >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="abreviatura_oficial" class="col-lg-3 control-label">Abrev Oficial</label>
			    	<div class="col-lg-9">
				    	<input type="text" class="form-control altoMoz" id="abreviatura_oficial" name="abreviatura_oficial"  >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="clave" class="col-lg-3 control-label">Folio</label>
			    	<div class="col-lg-9">
				    	<input type="text" class="form-control altoMoz" id="clave" name="clave"  >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="creditos" class="col-lg-3 control-label">Créditos</label>
			    	<div class="col-lg-9">
				    	<input type="number" class="form-control altoMoz" id="creditos" name="creditos" value='0' >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="isoficial" class="col-lg-3 control-label">Es Oficial</label>
			    	<div class="col-lg-9">
						<label>
							<input name="isoficial" id="isoficial" class="ace ace-switch ace-switch-6" type="checkbox">
							<span class="lbl"></span>
						</label>
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="status_grumat" class="col-lg-3 control-label">Status</label>
			    	<div class="col-lg-9">
						<label>
							<input name="status_grumat" id="status_grumat" class="ace ace-switch ace-switch-6" type="checkbox">
							<span class="lbl"></span>
						</label>
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="bloqueado" class="col-lg-3 control-label">Bloqueado</label>
			    	<div class="col-lg-9">
						<label>
							<input name="bloqueado" id="bloqueado" class="ace ace-switch ace-switch-6" type="checkbox">
							<span class="lbl"></span>
						</label>
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="eval_default" class="col-lg-3 control-label">Eval Pred.</label>
			    	<div class="col-lg-9">
				    	<input type="number" class="form-control altoMoz" id="eval_default" name="eval_default" value='1' min="1" max="8" step="1" >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="eval_mod" class="col-lg-3 control-label">Eval Mod.</label>
			    	<div class="col-lg-9">
				    	<input type="number" class="form-control altoMoz" id="eval_mod" name="eval_mod" value='1' min="1" max="8" step="1" >
		      		</div>
			    </div>

			</div>


		</div>

	    <input type="hidden" name="idgrupo" id="idgrupo" value="<?php echo $idgrupo; ?>">
	    <input type="hidden" name="idciclo" id="idciclo" value="<?php echo $idciclo; ?>">
	    <input type="hidden" name="idgrumat" id="idgrumat" value="<?php echo $idgrumat; ?>">
	    <input type="hidden" name="ispai_grupo" id="ispai_grupo" value="0">
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


	$("#preloaderPrincipal").hide();

	$("#clave").focus();

	var idgrumat = <?php echo $idgrumat ?>;
	var IdCiclo = <?php echo $idciclo ?>;

	if (idgrumat<=0){ // Nuevo Registro
		$("#title").html("Nuevo registro");
	}else{ // Editar Registro
		$("#title").html("Editando el registro: "+idgrumat);
		getGruMat(idgrumat);
	}

	function getGruMat(IdGruMat){
		$.post(obj.getValue(0) + "data/", {o:16, t:32, c:IdGruMat, p:10, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#idmateria").val(json[0].idmateria); // 0
					$("#idprofesor").val(json[0].idprofesor); // 0
					$("#isagrupadora0").val(json[0].isagrupadora);
					// $("#ispai_materia").val(json[0].ispai_materia);
					
					changeMateria(json[0].idmateria);
					
					getGrupo(json[0].idgrupo);

					$("#orden_impresion").val(json[0].orden_impresion);
					$("#ispai_grupo").val(json[0].ispai_grupo);
					$("#orden_historial").val(json[0].orden_historial);
					$("#orden_oficial").val(json[0].orden_oficial);
					$("#materia_oficial").val(json[0].materia_oficial);
					$("#abreviatura_oficial").val(json[0].abreviatura_oficial);

					$("#clave").val(json[0].clave);
					$("#creditos").val(json[0].creditos);

					$("#bloqueado").prop("checked",json[0].materia_bloqueada==1?true:false);						

					$("#eval_default").val(json[0].eval_default);
					$("#eval_mod").val(json[0].eval_mod);


					// $("#status_grumat").val(json[0].status_grumat);
					$("#status_grumat").prop("checked",json[0].status_grumat==1?true:false);	

					$("#isoficial").prop("checked",json[0].isoficial==1?true:false);	

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
			var IdGruMat = (idgrumat==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:16, t:IdGruMat, c:queryString, p:2, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						stream.emit("cliente", {mensaje: "PLATSOURCE-GRUMATS-PROP-"+IdGruMat});
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

		if( parseInt($("#idmateria").val(),0) <= 0){
			alert("Seleccione una Materia");
			$("#idmateria").focus();
			return false;
		}

		return true;

	}

function getMaterias(){
    var nc = "u="+localStorage.nc;
    $("#idmateria").append('<option value="0" >Seleccione una Materia</option>');
    $.post(obj.getValue(0)+"data/", { o:1, t:13, p:0,c:nc,from:0,cantidad:0, s:" order by materia asc " },
        function(json){
           $.each(json, function(i, item) {
                $("#idmateria").append('<option value="'+item.data+'" > '+item.label+'</option>');
            });
			getProfesores();
        }, "json"
    );  
}

$("#idmateria").on("change",function(event){
	event.preventDefault();
	var idmat = $(this).val();
	changeMateria(idmat);
});

function changeMateria(idmateria){
	$("#preloaderPrincipal").show();
    var nc = "u="+localStorage.nc+"&idmateria="+idmateria;
    // alert(nc);
    $.post(obj.getValue(0)+"data/", { o:1, t:63, p:0,c:nc,from:0,cantidad:0, s:"" },
        function(json){
			if (json.length>0){
				$("#ispai_materia").val(json[0].ispai_materia);
			}	
			$("#preloaderPrincipal").hide();
        }, "json"
    );  	
}

function getGrupo(idgrupo){
	$("#preloaderPrincipal").show();
    var nc = "u="+localStorage.nc+"&idgrupo="+idgrupo;
    // alert(nc);
    $.post(obj.getValue(0)+"data/", { o:1, t:64, p:0,c:nc,from:0,cantidad:0, s:"" },
        function(json){
			if (json.length>0){
				$("#ispai_grupo").val(json[0].ispai_grupo);
				var tit = $("#title").html();
				$("#title").html(tit + "PAI");
			}	
			$("#preloaderPrincipal").hide();
        }, "json"
    );  	
}

function getProfesores(){
    var nc = "u="+localStorage.nc;
    $.post(obj.getValue(0)+"data/", { o:1, t:12, p:0,c:nc,from:0,cantidad:0, s:" order by nombre_profesor asc " },
        function(json){
           $.each(json, function(i, item) {
                $("#idprofesor").append('<option value="'+item.data+'" > '+item.label+'</option>');
            });
            
			if (idgrumat<=0){ // Nuevo Registro
				$("#title").html("Nuevo registro");
			}else{ // Editar Registro
				$("#title").html("Editando el registro: "+idgrumat);
				getGruMat(idgrumat);
			}

        }, "json"
    );  
}

getMaterias();



});

</script>
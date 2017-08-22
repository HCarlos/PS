<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idmateria  = $_POST['idmateria'];

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
				<a data-toggle="tab" href="#oficial">
					<i class="grey icon-circle-blank bigger-110"></i>
					Oficial
				</a>
			</li>

		</ul>

		<div class="tab-content">

			<div id="general" class="tab-pane active">
			
				<div class="form-group ">
			    	<label for="materia" class="col-lg-3 control-label">Materia</label>
			    	<div class="col-lg-9">
				    	<input type="text" class="form-control altoMoz" id="materia" name="materia" required >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="abreviatura" class="col-lg-3 control-label">Abreviatura</label>
			    	<div class="col-lg-9">
				    	<input type="text" class="form-control altoMoz" id="abreviatura" name="abreviatura" required >
		      		</div>
			    </div>


				<div class="form-group ">
			    	<label for="clave" class="col-lg-3 control-label">Clave</label>
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
			    	<label for="idmatclas" class="col-lg-3 control-label">Clasificación</label>
			    	<div class="col-lg-9">
						<select class="form-control input-lg"  name="idmatclas" id="idmatclas" size="1"></select>
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="ord_imp" class="col-lg-3 control-label">Ord. Impresión</label>
			    	<div class="col-lg-9">
				    	<input type="number" class="form-control altoMoz" id="ord_imp" name="ord_imp" min="0" max="999" value='0' >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="ord_hist" class="col-lg-3 control-label">Ord. Historial</label>
			    	<div class="col-lg-9">
				    	<input type="number" class="form-control altoMoz" id="ord_hist" name="ord_hist" min="0" max="999" value='0' >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="ord_oficial" class="col-lg-3 control-label">Ord. Oficial</label>
			    	<div class="col-lg-9">
				    	<input type="number" class="form-control altoMoz" id="ord_oficial" name="ord_oficial" min="0" max="999" value='0' >
		      		</div>
			    </div>


			</div>
			<div id="especificos" class="tab-pane">


<!-- 				<div class="form-group ">
					<label for="isoficial" class="col-lg-4">Es Oficial</label>
			    	<div class="col-lg-8">
						<input id="isoficial" name="isoficial" class="ace ace-switch ace-switch-6" type="checkbox" >
			      	</div>
			    </div>
 -->

				<table class="table span12 w96" >

					<tr><td class="wd30prc">
						<label class="green" for="isoficial">
								<b>Es Oficial</b>
						</label>
						</td>
						<td class="wd60prc">
							<input name="isoficial" id="isoficial" class="ace ace-switch ace-switch-6" type="checkbox" checked>
							<span class="lbl"></span>
						</td>
					</tr>

					<tr><td>
						<label class="green" for="idioma">
								<b>Es Español</b>
						</label>
						</td>
						<td>
							<input name="idioma" id="idioma" class="ace ace-switch ace-switch-6" type="checkbox"  checked>
							<span class="lbl"></span>
						</td>
					</tr>
				
					<tr><td>
						<label class="green" for="isedutec">
								<b>Es Educación Tecnológica</b>
						</label>
						</td>
						<td>
							<input name="isedutec" id="isedutec" class="ace ace-switch ace-switch-6" type="checkbox">
							<span class="lbl"></span>
						</td>
					</tr>
				
					<tr>
						<td>
							<label class="green" for="ispai_materia">
								<b>Es Materia PAI</b>
							</label>
						</td>
						<td>
							<input name="ispai_materia" id="ispai_materia" class="ace ace-switch ace-switch-6" type="checkbox">
							<span class="lbl"></span>
						</td>
					</tr>

					<tr>
						<td>
							<label class="green" for="idpaiareadisciplinaria">
								<b>Área Disciplinaria PAI</b>
							</label>
						</td>
						<td class="tbl150W">
							<select class="w96"  name="idpaiareadisciplinaria" id="idpaiareadisciplinaria" size="1"></select>
						</td>
					</tr>
				
					<tr><td>
						<label class="green" for="isagrupadora">
								<b>Es Agrupadora</b>
						</label>
						</td>
						<td>
							<input name="isagrupadora" id="isagrupadora" class="ace ace-switch ace-switch-6" type="checkbox">
							<span class="lbl"></span>
						</td>
					</tr>
				
					<tr><td>
						<label class="green" for="status_materia">
								<b>Estatus</b>
						</label>
						</td>
						<td>
							<input name="status_materia" id="status_materia" class="ace ace-switch ace-switch-6" type="checkbox" checked>
							<span class="lbl"></span>
						</td>
					</tr>
				

				</table>

			</div>

			<div id="oficial" class="tab-pane">
			
				<div class="form-group ">
			    	<label for="materia_oficial" class="col-lg-3 control-label">Materia Oficial</label>
			    	<div class="col-lg-9">
				    	<input type="text" class="form-control altoMoz" id="materia_oficial" name="materia_oficial"   >
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="abreviatura_oficial" class="col-lg-3 control-label">Abreviatura Oficial</label>
			    	<div class="col-lg-9">
				    	<input type="text" class="form-control altoMoz" id="abreviatura_oficial" name="abreviatura_oficial"  >
		      		</div>
			    </div>

			</div>


		</div>

	    <input type="hidden" name="idmateria" id="idmateria" value="<?php echo $idmateria; ?>">
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

	// var stream = io.connect(obj.getValue(4));


	$("#preloaderPrincipal").hide();

	$("#materia").focus();
	$("#btnGenUser").hide();

	var idmateria = <?php echo $idmateria ?>;


	function getMateria(IdMateria){
		$.post(obj.getValue(0) + "data/", {o:7, t:14, c:IdMateria, p:10, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#username").val(json[0].username);
					
					$("#materia").val(json[0].materia);
					$("#abreviatura").val(json[0].abreviatura);
					$("#materia_oficial").val(json[0].materia_oficial);
					$("#abreviatura_oficial").val(json[0].abreviatura_oficial);
					$("#clave").val(json[0].clave);
					$("#creditos").val(json[0].creditos);
					$("#idmatclas").val(json[0].idmatclas);
					$("#ord_imp").val(json[0].ord_imp);
					$("#ord_hist").val(json[0].ord_hist);
					$("#ord_oficial").val(json[0].ord_oficial);
					$("#idpaiareadisciplinaria").val(json[0].idpaiareadisciplinaria);

					$("#idioma").prop("checked",json[0].idioma==0?true:false);	
					$("#isoficial").prop("checked",json[0].isoficial==1?true:false);	
					$("#isedutec").prop("checked",json[0].isedutec==1?true:false);	
					$("#ispai_materia").prop("checked",json[0].ispai_materia==1?true:false);	
					$("#isagrupadora").prop("checked",json[0].isagrupadora==1?true:false);	
					$("#status_materia").prop("checked",json[0].status_materia==1?true:false);	

					//$("#status_materia").val(json[0].status_materia);

					
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
			var IdMateria = (idmateria==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:7, t:IdMateria, c:queryString, p:2, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						// stream.emit("cliente", {mensaje: "PLATSOURCE-MATERIAS-PROP-"+idmateria});
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

	$("#closeFormUpload").on("click",function(event){
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

		if ($("#materia").val().length <= 0){
			alert("Faltan la Materia");
			$("#materia").focus();
			return false;
		}

		if ($("#abreviatura").val().length <= 0){
			alert("Faltan la Abreviatura");
			$("#abreviatura").focus();
			return false;
		}
/*
		if ($("#materia_oficial").val().length <= 0){
			alert("Faltan el nombre de la Materia Oficial");
			$("#materia_oficial").focus();
			return false;
		}

		if ($("#abreviatura_oficial").val().length <= 0){
			alert("Faltan la Abreviatura Oficial");
			$("#abreviatura_oficial").focus();
			return false;
		}
*/
		return true;

	}


function getMatClas(){
    var nc = "u="+localStorage.nc;
    var cls = "";
    $("#idmatclas").empty();
    $.post(obj.getValue(0)+"data/", { o:1, t:7, p:0,c:nc,from:0,cantidad:0, s:"" },
        function(json){
            var nc;
           $.each(json, function(i, item) {
                //alert(item.label);
                nc = item.label.split("@");
                cls = i==0?"selected":'';
                $("#idmatclas").append('<option value="'+item.data+'" '+cls+'> '+item.label+'</option>');
            });
            
			getAreasDisciplnariasPAI();

        }, "json"
    );  
}

function getAreasDisciplnariasPAI(){
    var nc = "u="+localStorage.nc;
    var cls = "";
    $("#idpaiareadisciplinaria").empty();
    $("#idpaiareadisciplinaria").append('<option value="0" selected>Seleccione un elemento</option>');
    $.post(obj.getValue(0)+"data/", { o:1, t:65, p:0,c:nc,from:0,cantidad:0, s:"" },
        function(json){
            var nc;
           $.each(json, function(i, item) {
                //alert(item.label);
                $("#idpaiareadisciplinaria").append('<option value="'+item.data+'"> '+item.label+'</option>');
            });
            
			if (idmateria<=0){
				$("#title").html("Nuevo registro");
			}else{ 
				$("#title").html("Editando el registro: "+idmateria);
				getMateria(idmateria);
			}

        }, "json"
    );  
}


getMatClas();

});

</script>
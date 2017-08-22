<?php

include("includes/metas.php");

$user = $_POST['user'];
$idpaiobjetivo  = $_POST['idpaiobjetivo'];

?>
<div class="row-fluid">
<div class="span12" style="padding-left: 1em; padding-right: 1em;">

	<form id="frmPAIC0" role="form">

		<ul class="nav nav-tabs" id="myTab">

			<li class="active">
				<a data-toggle="tab" href="#general">
					<i class="red icon-home bigger-110"></i>
					Objetivo PAI :: <span class="header smaller lighter blue" id="title"></span>
				</a>
			</li>

		</ul>

		<div class="tabbable">

				<div class="tab-content">

					<div id="general" class="tab-pane active">
						<table class="wd100prc">
							<tr>
								<td class="wd25prc">
		                    		<label for="idpaiareadisciplinaria" class="lblH2cmb">Área Disciplinaria </label>
		                    	</td>	
								<td class="wd100prc">
				                    <select name="idpaiareadisciplinaria" id="idpaiareadisciplinaria" size="1" style="width:100% !important;" > 
				                    </select>
		                    	</td>	
							</tr>

							<tr>
								<td class="wd25prc">
		                    		<label for="idpaicriterio" class="lblH2cmb">Criterios de Evaluación </label>
		                    	</td>	
								<td class="wd100prc">
				                    <select name="idpaicriterio" id="idpaicriterio" size="1" style="width:100% !important;" > 
				                    </select>
		                    	</td>	
							</tr>

							<tr>
								<td>
					    			<label for="grado_pai" class="control-label">Grado</label>
		                    	</td>	
								<td>
				                    <select name="grado_pai" id="grado_pai" size="1" style="width:100% !important;" > 
				                    	<option value="1">Primero</option>
				                    	<option value="2" selected>Segundo</option>
				                    	<option value="3">Tercero</option>
				                    	<option value="4">Cuarto</option>
				                    	<option value="5">Quinto</option>
				                    </select>
				      			</td>
							</tr>

							<tr>
								<td>
					    			<label for="objetivo" class="control-label">Descriptor</label>
		                    	</td>	
								<td>
									<textarea class="form-control" rows="6" id="objetivo" name="objetivo"></textarea>
								</td>
							</tr>

							<tr>
								<td>
									<label for="status_pai_objetivo" class="control-label">
											Activo
									</label>
								</td>
								<td>
									<input name="status_pai_objetivo" id="status_pai_objetivo" class="ace ace-switch ace-switch-6" type="checkbox" checked>
									<span class="lbl"></span>
								</td>
							</tr>

						</table>			

					</div>

				</div>

			    <input type="hidden" name="idpaiobjetivo" id="idpaiobjetivo" value="<?= $idpaiobjetivo; ?>">
			    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
			    <div class="form-group w96" style='margin-right: 3em; margin-top: 1em;'>
			    	<button type="button" class="btn btn-default pull-right exitPAICO0" data-dismiss="modal" ><i class="icon-signout"></i>Cerrar</button>
			    	<span class="muted"></span>
			    	<button type="submit" class="btn btn-primary pull-right" style='margin-right: 4em;'><i class="icon-save"></i>Guardar</button>
				</div>


		</div>

	</form>

</div>
</div>
<!--PAGE CONTENT ENDS-->

<script typy="text/javascript">        

jQuery(function($) {

	// var stream = io.connect(obj.getValue(4));

	$("#preloaderPrincipal").hide();

	var idpaiobjetivo = <?= $idpaiobjetivo ?>;

	function getConceptosPAI(IdObjetivo){
		$.post(obj.getValue(0) + "data/", {o:65, t:58, c:IdObjetivo, p:54, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#idpaiobjetivo").val(json[0].idpaiobjetivo);
					$("#idpaiareadisciplinaria").val(json[0].idpaiareadisciplinaria);
					$("#idpaicriterio").val(json[0].idpaicriterio);
					$("#objetivo").val(json[0].objetivo);
					$("#grado_pai").val(json[0].grado_pai);
					$("#status_pai_objetivo").prop("checked",json[0].status_pai_objetivo==1?true:false);	
				}
		},'json');
	}

    $("#frmPAIC0").unbind("submit");
    $("#frmPAIC0").on("submit",function(event){
        event.preventDefault();

        if ( validForm() ) {

            $("#preloaderPrincipal").show();
            var queryString = $(this).serialize();  
            var IdObjetivo = (idpaiobjetivo==0?0:1);
            $.post(obj.getValue(0) + "data/", {o:65, t:IdObjetivo, c:queryString, p:52, from:0, cantidad:0, s:''},
            function(json) {
        		if (json[0].msg=="OK"){
        			alert("Datos guardados con éxito.");
					// stream.emit("cliente", {mensaje: "PLATSOURCE-PAI_OBJETIVOS_-PROP-"+IdObjetivo});
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


	function getAreasDisciplnariasPAI(){
	    var nc = "u="+localStorage.nc;
	    var cls = "";
	    $("#idpaiareadisciplinaria").empty();
	    $("#idpaiareadisciplinaria").append('<option value="0" selected>Seleccione un elemento</option>');
	    $.post(obj.getValue(0)+"data/", { o:1, t:65, p:0,c:nc,from:0,cantidad:0, s:"" },
	        function(json){
	            var nc;
	           $.each(json, function(i, item) {
	                $("#idpaiareadisciplinaria").append('<option value="'+item.data+'"> '+item.label+'</option>');
	            });
	            
				getCriteriosPAI();

	        }, "json"
	    );  
	}


	function getCriteriosPAI(){
	    var nc = "u="+localStorage.nc;
	    $("#idpaicriterio").empty();
	    $("#idpaicriterio").append('<option value="0" selected>Seleccione un elemento</option>');
	    $.post(obj.getValue(0)+"data/", { o:64, t:51, p:54,c:nc,from:0,cantidad:0, s:"" },
	        function(json){
	            var nc;
	           $.each(json, function(i, item) {
	                //alert(item.label);
	                $("#idpaicriterio").append('<option value="'+item.idpaicriterio+'"> Criterio '+item.criterio+' - '+item.descripcion_criterio+'</option>');
	            });
	            
				if (idpaiobjetivo<=0){
					$("#title").html("Nuevo registro");
				}else{ 
					$("#title").html("Editando el registro: "+idpaiobjetivo);
					getConceptosPAI(idpaiobjetivo);
				}

	        }, "json"
	    );  
	}

	$(".exitPAICO0").on("click",function(event){
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

		if(parseInt($("#idpaiareadisciplinaria").val(),0) < 0){
			alert("Faltan el Área Disciplinaria");
			$("#idpaiareadisciplinaria").focus();
			return false;
		}

		if(parseInt($("#idpaicriterio").val(),0) < 0){
			alert("Faltan el Criterio");
			$("#idpaicriterio").focus();
			return false;
		}

		if($("#objetivo").val().length <= 0){
			alert("Faltan el Objetivo");
			$("#objetivo").focus();
			return false;
		}

		return true;

	}

	getAreasDisciplnariasPAI();

	$("#idpaiareadisciplinaria").focus();




});

</script>
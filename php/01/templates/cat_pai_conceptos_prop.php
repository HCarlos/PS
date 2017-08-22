<?php

include("includes/metas.php");

$user = $_POST['user'];
$idpaiconcepto  = $_POST['idpaiconcepto'];

?>
<div class="row-fluid">
<div class="span12" style="padding-left: 1em; padding-right: 1em;">

	<form id="frmPAIC0" role="form">

		<ul class="nav nav-tabs" id="myTab">

			<li class="active">
				<a data-toggle="tab" href="#general">
					<i class="red icon-home bigger-110"></i>
					Descriptor PAI :: <span class="header smaller lighter blue" id="title"></span>
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
					    			<label for="rango_califica" class="control-label">Nivel de Logro</label>
		                    	</td>	
								<td>
				                    <select name="rango_califica" id="rango_califica" size="1" style="width:100% !important;" > 
				                    	<option value="0">0</option>
				                    	<option value="2">1-2</option>
				                    	<option value="4">3-4</option>
				                    	<option value="6">5-6</option>
				                    	<option value="8">7-8</option>
				                    </select>
				      			</td>
							</tr>

							<tr>
								<td>
					    			<label for="concepto" class="control-label">Descriptor</label>
		                    	</td>	
								<td>
									<textarea class="form-control" rows="6" id="concepto" name="concepto"></textarea>
								</td>
							</tr>

							<tr>
								<td>
									<label for="status_pai_concepto" class="control-label">
											Activo
									</label>
								</td>
								<td>
									<input name="status_pai_concepto" id="status_pai_concepto" class="ace ace-switch ace-switch-6" type="checkbox" checked>
									<span class="lbl"></span>
								</td>
							</tr>

						</table>			

					</div>

				</div>

			    <input type="hidden" name="idpaiconcepto" id="idpaiconcepto" value="<?= $idpaiconcepto; ?>">
			    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
			    <div class="form-group w96" style='margin-right: 3em; margin-top: 1em;'>
			    	<button type="button" class="btn btn-default pull-right exitPAICC0" data-dismiss="modal" ><i class="icon-signout"></i>Cerrar</button>
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

	var idpaiconcepto = <?= $idpaiconcepto ?>;

	function getConceptosPAI(IdConcepto){
		$.post(obj.getValue(0) + "data/", {o:64, t:56, c:IdConcepto, p:54, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){
					$("#idpaiconcepto").val(json[0].idpaiconcepto);
					$("#idpaiareadisciplinaria").val(json[0].idpaiareadisciplinaria);
					$("#idpaicriterio").val(json[0].idpaicriterio);
					$("#rango_califica").val(json[0].rango_califica);
					$("#concepto").val(json[0].concepto);
					$("#grado_pai").val(json[0].grado_pai);
					$("#status_pai_concepto").prop("checked",json[0].status_pai_concepto==1?true:false);	
				}
		},'json');
	}

    $("#frmPAIC0").unbind("submit");
    $("#frmPAIC0").on("submit",function(event){
        event.preventDefault();

        if ( validForm() ) {

            $("#preloaderPrincipal").show();
            var queryString = $(this).serialize();  
            var IdConcepto = (idpaiconcepto==0?0:1);
            $.post(obj.getValue(0) + "data/", {o:64, t:IdConcepto, c:queryString, p:52, from:0, cantidad:0, s:''},
            function(json) {
        		if (json[0].msg=="OK"){
        			alert("Datos guardados con éxito.");
					// stream.emit("cliente", {mensaje: "PLATSOURCE-PAI_CONCEPTOS_-PROP-"+IdConcepto});
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
	            
				if (idpaiconcepto<=0){
					$("#title").html("Nuevo registro");
				}else{ 
					$("#title").html("Editando el registro: "+idpaiconcepto);
					getConceptosPAI(idpaiconcepto);
				}

	        }, "json"
	    );  
	}

	$(".exitPAICC0").on("click",function(event){
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

		if($("#concepto").val().length <= 0){
			alert("Faltan el Concepto");
			$("#concepto").focus();
			return false;
		}

		return true;

	}

	getAreasDisciplnariasPAI();

	$("#idpaiareadisciplinaria").focus();




});

</script>
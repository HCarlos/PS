<?php

include("includes/metas.php");

$user = $_POST["user"];
$idgrupo = $_POST["idgrupo"];
$grupo = $_POST["grupo"];
$grado_pai = $_POST["grado_pai"];
?>


<div  class="row-fluid">
<!-- 	<div class="span12 widget-container-span ui-sortable"> -->
<div class="widget-box span12">

		<div  class="widget-header header-color-green2 widget-header-flat padtop05em">
			
			<div class="widget-toolbar white pull-left no-border " >

				<h4 class="smaller">
					<i class="icon-leaf lemon"></i>
					Configuración: <strong color="white"><?= $grupo; ?></strong>   Grado PAI: <strong color="white"><?= $grado_pai; ?></strong>
				</h4>

			</div>

			<div class="widget-toolbar white pull-right no-border mute">

<!-- 				
			<a class="white tooltip-info" href="#"  id="btnPrintListCal02" data-original-title="Ver Calificaciones" data-rel="tooltip" data-placement="left" title="Ver Calificaciones">
				<i class="fa fa-list bigger-130"></i>
			</a>

 -->

 			</div>

		</div>

		<div class="widget-body">
			<div class="widget-main padding-4">
				<div class="content">

				<form class="form" role="form" id="frmCapCalPAI01">

					<div class="col-lg-12 input-group">

						<div class="col-lg-6 ">

							<div class="input-group">
								<span class="input-group-addon">
									<label class="clear-lbl-addon lbl0" for="cmbMatPAI200">Materias :</label>
								</span>
								<select id="cmbMatPAI200" name="cmbMatPAI200" class="form-control">
									<option value="0" selected>Seleccione una Materia</option>
								</select>
							</div>

						</div>
						
					</div>

					<div role="separator" class="divider"></div>

					<div class="col-lg-12">

						<div class="form-actions center">
							<button class="btn btn-success" type="submit" id="cmdCapCalPAI01">
								Capturar Calificaciones
								<i class="icon-arrow-right icon-on-right bigger-130"></i>
							</button>
						</div>

					</div>

					<input type="hidden" name="idgrupo" id="idgrupo" value="<?= $idgrupo; ?>">
					<input type="hidden" name="grado_pai" id="grado_pai" value="<?= $grado_pai; ?>">
					<input type="hidden" name="num_eval_capcal_fmt_1" id="num_eval_capcal_fmt_1" value="0">

				</form>

				</div>
			</div>
		</div>	
	</div>
</div>


<script typy="text/javascript">        

jQuery(function($) {

	$("#preloaderPrincipal").hide();
	var IdUNA = localStorage.IdUserNivelAcceso;
	var evalDef = 0;
	var evalMod = 0;
	var IdGrupo = <?= $idgrupo; ?>;
	var Grado_PAI = <?= $grado_pai; ?>;
	var Grupo = "<?= $grupo; ?>";
	var IdPAIAreaDisciplinaria = 0;
	var arrMPAI01 = [];

    evalDef = parseInt( obj.getConfig(6,0), 0);
   	sayNumEval(evalDef);


	$(".lbl0").width(86);

	$("#cmdCapCalPAI01").on("click",function(event){
		event.preventDefault();
        $("#contentProfile").empty();
        $("#contentMain").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
	        $.post(obj.getValue(0) + "captura-cal-pai-1/", {
	        	user: nc,
				idgrumat: $("#cmbMatPAI200").val(),
				materia: $("#cmbMatPAI200 :selected").text(),
				configmat: 0,
				configmkb: 0,
				idgrupo: IdGrupo,
				grado_pai: Grado_PAI, 
				num_eval: evalDef, 
				grupo: Grupo, 
				idpaiareadisciplinaria: IdPAIAreaDisciplinaria
	            },
	            function(html) {	                
	                $("#contentProfile").html(html).show('slow',function(){
		                $('#breadcrumb').html(getBar('Inicio, Captura de Calificaciones del Markbook' ));
	                });
	            }, "html");
        });

        return false;

	});


/* ***************************** METERIAS ***************************** */

    function getMatPAI(IdGrupo){
	    $("#preloaderPrincipal").show();
		$("#cmdCapCalPAI01").attr('Disabled', true);
	    var nc = "u="+localStorage.nc+"&idgrupo="+IdGrupo;

	    $("#cmbMatPAI200").html("<option value='0' selected>Seleccione una Materia</option>");
	    $.post(obj.getValue(0)+"data/", { o:1, t:17, p:0, c:nc, from:0, cantidad:0, s:"" },
	        function(json){
	            if (json.length>0){
	            	arrMPAI01 = [];
	            	var j = 0;
	                $.each(json, function(i, item) {
	               	var vad = parseInt(item.idpaiareadisciplinaria, 0); 
	               	if (vad > 0){
	                    $("#cmbMatPAI200").append('<option value="'+item.data+'-'+j+'"> '+item.label+'</option>');
	                    arrMPAI01[j] = {
                    				idgrumat: 				item.data, 
                    				eval_default: 			item.eval_default, 
                    				eval_mod: 				item.eval_mod,
                    				bloqueada: 				item.materia_bloqueada,
                    				idpaiareadisciplinaria: item.idpaiareadisciplinaria
                    			}
                    			j++;
	               	}

	                });	               
	           	}

			    $("#preloaderPrincipal").hide();

	        }, "json"
	    );
	}

	$("#cmbMatPAI200").on("change",function(event){
		event.preventDefault();
		var Ids = $(this).val().split('-');
    	var IdGruMat = parseInt(Ids[0],0);
    	var K = parseInt(Ids[1],0);
		var val0 =  obj.searchInArray( arrMPAI01, IdGruMat, "idgrumat" );
		if (val0 > -1 ){
			if ( arrMPAI01[val0].bloqueada == 1 ){
				alert("Materia Bloqueda");
				return false;
			}
			IdPAIAreaDisciplinaria = -1;
			$("#cmdCapCalPAI01").attr('Disabled', true);

		}else{
			IdPAIAreaDisciplinaria = arrMPAI01[K].idpaiareadisciplinaria;
			$("#cmdCapCalPAI01").attr('Disabled', false);
			return false;
		}	

	});

	function sayNumEval(evalDef){
       	$("#barInfoR0").html(sayNoEval(evalDef));
       	$("#num_eval_capcal_fmt_1").val(evalDef);		
	}

	getMatPAI(IdGrupo);

	/* ************************************************************************************************************** */	

});

function resizeScreen() {
	
    $("#contentMain").css("min-height", obj.getMinHeight());
    $("#contentProfile").css("min-height", obj.getMinHeight());

}

</script>
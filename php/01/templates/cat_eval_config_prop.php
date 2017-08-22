<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idevalconfig  = $_POST['idevalconfig'];

?>
<style type="text/css">
/*	
	tr{border-bottom: 1px #C0BBBB solid; padding-top: 0.5em;}
	tr:hover{background-color: #ECE780; border: 1px #C0BBBB solid; }
	td{padding-left: 1em;
		padding-right: 1em;
	}
*/
	label{color: green; font-weight: bold; }
	.lbl{margin-left: 2em; }
</style>
<div class="row-fluid">

	<h3 class="header smaller lighter blue" id="title"></h3>
	<form id="frmEvalConfig" role="form">


			    <table>
			    	<tr>
			    		<td>
					    	<label for="idnivel" class=" tbl50W">Nivel</label>
			    		</td>
			    		<td>
		                    <select name="idnivel" id="idnivel" size="1" class=" tbl150W" > 
		                    </select>
			    		</td>
			    		<td>
			    			<label for="idciclo" class="tbl50W lbl">Ciclo</label>
			    		</td>
			    		<td>
	                    	<select name="idciclo" id="idciclo" size="1"  class=" tbl150W" > 
		                    </select>
			    		</td>
			    		<td>
			    			<label for="periodo" class="tbl70W lbl">Periodos</label>
			    		</td>
			    		<td>
							<select  name="periodo" id="periodo" size="1" class=" tbl150W">
								<option value="1" selected>1er Periodo | Único</option>
								<option value="2" >2do Periodo</option>
							</select>
			    		</td>
			    	</tr>
			    </table>	
			    <table class="bordered">
			    	<thead>
			    		<tr>
			    			<th>Eval</th>
			    			<th>Descripción</th>
			    			<th>Fecha Inicial</th>
			    			<th>Fecha Final</th>
			    		</tr>
			    	</thead>
			    	<tbody>
			    	<tr>
			    		<td>1</td>	
			    		<td>
			    			<input type="text" class="altoMoz tbl150W" maxlength="20" id="eval_1" name="eval_1" required autofocus >
			    		</td>
			    		<td>
							<input class="date-picker altoMoz tbl150W" id="fecha_inicio_eval_1" name="fecha_inicio_eval_1" data-date-format="yyyy-mm-dd" type="text" value="<?= date('Y-m-d'); ?>" >
			    		</td>
			    		<td>
							<input class="date-picker altoMoz tbl150W" id="fecha_fin_eval_1" name="fecha_fin_eval_1" data-date-format="yyyy-mm-dd" type="text" value="<?= date('Y-m-d'); ?>">
			    		</td>
			    	</tr>
			    	<tr>
			    		<td>2</td>	
			    		<td>
			    			<input type="text" class="altoMoz tbl150W" maxlength="20" id="eval_2" name="eval_2" required  >
			    		</td>
			    		<td>
							<input class="date-picker altoMoz tbl150W" id="fecha_inicio_eval_2" name="fecha_inicio_eval_2" data-date-format="yyyy-mm-dd" type="text" value="<?= date('Y-m-d'); ?>">
			    		</td>
			    		<td>
							<input class="date-picker altoMoz tbl150W" id="fecha_fin_eval_2" name="fecha_fin_eval_2" data-date-format="yyyy-mm-dd" type="text" value="<?= date('Y-m-d'); ?>">
			    		</td>
			    	</tr>
			    	<tr>
			    		<td>3</td>	
			    		<td>
			    			<input type="text" class="altoMoz tbl150W" maxlength="20" id="eval_3" name="eval_3" required  >
			    		</td>
			    		<td>
							<input class="date-picker altoMoz tbl150W" id="fecha_inicio_eval_3" name="fecha_inicio_eval_3" data-date-format="yyyy-mm-dd" type="text" value="<?= date('Y-m-d'); ?>">
			    		</td>
			    		<td>
							<input class="date-picker altoMoz tbl150W" id="fecha_fin_eval_3" name="fecha_fin_eval_3" data-date-format="yyyy-mm-dd" type="text" value="<?= date('Y-m-d'); ?>">
			    		</td>
			    	</tr>
			    	<tr>
			    		<td>4</td>	
			    		<td>
			    			<input type="text" class="altoMoz tbl150W" maxlength="20" id="eval_4" name="eval_4" required  >
			    		</td>
			    		<td>
							<input class="date-picker altoMoz tbl150W" id="fecha_inicio_eval_4" name="fecha_inicio_eval_4" data-date-format="yyyy-mm-dd" type="text" value="<?= date('Y-m-d'); ?>">
			    		</td>
			    		<td>
							<input class="date-picker altoMoz tbl150W" id="fecha_fin_eval_4" name="fecha_fin_eval_4" data-date-format="yyyy-mm-dd" type="text" value="<?= date('Y-m-d'); ?>">
			    		</td>
			    	</tr>
			    	<tr>
			    		<td>5</td>	
			    		<td>
			    			<input type="text" class="altoMoz tbl150W" maxlength="20" id="eval_5" name="eval_5" required  >
			    		</td>
			    		<td>
							<input class="date-picker altoMoz tbl150W" id="fecha_inicio_eval_5" name="fecha_inicio_eval_5" data-date-format="yyyy-mm-dd" type="text" value="<?= date('Y-m-d'); ?>">
			    		</td>
			    		<td>
							<input class="date-picker altoMoz tbl150W" id="fecha_fin_eval_5" name="fecha_fin_eval_5" data-date-format="yyyy-mm-dd" type="text" value="<?= date('Y-m-d'); ?>">
			    		</td>
			    	</tr>
			    	<tr>
			    		<td>6</td>	
			    		<td>
			    			<input type="text" class="altoMoz tbl150W" maxlength="20" id="eval_6" name="eval_6" required  >
			    		</td>
			    		<td>
							<input class="date-picker altoMoz tbl150W" id="fecha_inicio_eval_6" name="fecha_inicio_eval_6" data-date-format="yyyy-mm-dd" type="text" value="<?= date('Y-m-d'); ?>">
			    		</td>
			    		<td>
							<input class="date-picker altoMoz tbl150W" id="fecha_fin_eval_6" name="fecha_fin_eval_6" data-date-format="yyyy-mm-dd" type="text" value="<?= date('Y-m-d'); ?>">
			    		</td>
			    	</tr>
			    	<tr>
			    		<td>7</td>	
			    		<td>
			    			<input type="text" class="altoMoz tbl150W" maxlength="20" id="eval_7" name="eval_7" required  >
			    		</td>
			    		<td>
							<input class="date-picker altoMoz tbl150W" id="fecha_inicio_eval_7" name="fecha_inicio_eval_7" data-date-format="yyyy-mm-dd" type="text" value="<?= date('Y-m-d'); ?>">
			    		</td>
			    		<td>
							<input class="date-picker altoMoz tbl150W" id="fecha_fin_eval_7" name="fecha_fin_eval_7" data-date-format="yyyy-mm-dd" type="text" value="<?= date('Y-m-d'); ?>">
			    		</td>
			    	</tr>
			    	<tr>
			    		<td>8</td>	
			    		<td>
			    			<input type="text" class="altoMoz tbl150W" maxlength="20" id="eval_8" name="eval_8" required  >
			    		</td>
			    		<td>
							<input class="date-picker altoMoz tbl150W" id="fecha_inicio_eval_8" name="fecha_inicio_eval_8" data-date-format="yyyy-mm-dd" type="text" value="<?= date('Y-m-d'); ?>">
			    		</td>
			    		<td>
							<input class="date-picker altoMoz tbl150W" id="fecha_fin_eval_8" name="fecha_fin_eval_8" data-date-format="yyyy-mm-dd" type="text" value="<?= date('Y-m-d'); ?>">
			    		</td>
			    	</tr>
				</tbody>

			    </table>

	    <input type="hidden" name="idevalconfig" id="idevalconfig" value="<?php echo $idevalconfig; ?>">
	    <input type="hidden" name="u" id="u" value="<?php echo $user; ?>">
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
<!--PAGE CONTENT ENDS-->

<script typy="text/javascript">        

jQuery(function($) {

	// var stream = io.connect(obj.getValue(4));


	$("#preloaderPrincipal").hide();

	$("#idnivel").focus();

	var idevalconfig = <?php echo $idevalconfig ?>;


	function getEvalConfig(IdEvalConfig){
		$.post(obj.getValue(0) + "data/", {o:50, t:6, c:IdEvalConfig, p:54, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){

					$("#idnivel").val(json[0].idnivel);
					$("#idciclo").val(json[0].idciclo);
					$("#periodo").val(json[0].periodo);

					$("#eval_1").val(json[0].eval_1);
					$("#fecha_inicio_eval_1").val(json[0].fecha_inicio_eval_1);
					$("#fecha_fin_eval_1").val(json[0].fecha_fin_eval_1);

					$("#eval_2").val(json[0].eval_2);
					$("#fecha_inicio_eval_2").val(json[0].fecha_inicio_eval_2);
					$("#fecha_fin_eval_2").val(json[0].fecha_fin_eval_2);

					$("#eval_3").val(json[0].eval_3);
					$("#fecha_inicio_eval_3").val(json[0].fecha_inicio_eval_3);
					$("#fecha_fin_eval_3").val(json[0].fecha_fin_eval_3);

					$("#eval_4").val(json[0].eval_4);
					$("#fecha_inicio_eval_4").val(json[0].fecha_inicio_eval_4);
					$("#fecha_fin_eval_4").val(json[0].fecha_fin_eval_4);

					$("#eval_5").val(json[0].eval_5);
					$("#fecha_inicio_eval_5").val(json[0].fecha_inicio_eval_5);
					$("#fecha_fin_eval_5").val(json[0].fecha_fin_eval_5);

					$("#eval_6").val(json[0].eval_6);
					$("#fecha_inicio_eval_6").val(json[0].fecha_inicio_eval_6);
					$("#fecha_fin_eval_6").val(json[0].fecha_fin_eval_6);

					$("#eval_7").val(json[0].eval_7);
					$("#fecha_inicio_eval_7").val(json[0].fecha_inicio_eval_7);
					$("#fecha_fin_eval_7").val(json[0].fecha_fin_eval_7);

					$("#eval_8").val(json[0].eval_8);
					$("#fecha_inicio_eval_8").val(json[0].fecha_inicio_eval_8);
					$("#fecha_fin_eval_8").val(json[0].fecha_fin_eval_8);



				}
		},'json');
	}

    // $("#frmEvalConfig").unbind("submit");
	$("#frmEvalConfig").on("submit",function(event){
		event.preventDefault();

		$("#preloaderPrincipal").show();

		// alert("Hola Mundo");

	    var queryString = $(this).serialize();	
	    
	    // alert(queryString);

		var data = new FormData();

			var IdEvalConfig = (idevalconfig==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:50, t:IdEvalConfig, c:queryString, p:52, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						// stream.emit("cliente", {mensaje: "PLATSOURCE-EVALCONFIG-PROP-"+IdEvalConfig});
						$("#preloaderPrincipal").hide();
						$("#contentProfile").hide(function(){
							$("#contentProfile").empty();
							$("#contentMain").show();
						});
						resizeScreen();
        			}else{
						$("#preloaderPrincipal").hide();
        				alert(json[0].msg);	
        			}
        	}, "json")
			.fail(function(error) { 
				alert(error.responseText) ;
				$("#preloaderPrincipal").hide();
			});

	});


	function getCiclos(){
	    var nc = "u="+localStorage.nc;
	    $("#idciclo").html('');
	    $.post(obj.getValue(0)+"data/", { o:1, t:2, p:0,c:nc,from:0,cantidad:0, s:"" },
	        function(json){
	            var pred = "";
	           $.each(json, function(i, item) {
	                pred = item.predeterminado == 1 ? ' selected ': ' ';
	                $("#idciclo").append('<option value="'+item.data+'" ' + pred + '> '+item.label+'</option>');
	            });

	            getNiveles(); 

	        }, "json"
	    );  
	}


	function getNiveles(){
	    var nc = "u="+localStorage.nc;
	    $("#idnivel").html('');
	    $.post(obj.getValue(0)+"data/", { o:1, t:3, p:0,c:nc,from:0,cantidad:0, s:"" },
	        function(json){
	           $.each(json, function(i, item) {
	                $("#idnivel").append('<option value="'+item.data+'"> '+item.label+'</option>');
	            });
	            
				if (idevalconfig<=0){
					$("#title").html("Nuevo registro");
				}else{
					$("#title").html("Editando el registro: "+idevalconfig);
					getEvalConfig(idevalconfig);
				}
	        }, "json"
	    );  
	}

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

	$('.date-picker').datepicker({
		autoclose: true
	});

	$('.date-picker').on('changeDate', function(event){
	    $(this).datepicker('hide');
	    //validDate();
	});

	getCiclos();

});

</script>
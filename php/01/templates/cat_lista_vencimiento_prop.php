<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idlistavencimiento  = $_POST['idlistavencimiento'];

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


			    <table class="wd100prc">
			    	<tr>
			    		<td class="wd10prc">
					    	<label for="descripcion" class="wd100prc">Descripción</label>
			    		</td>
			    		<td class="wd80prc">
			    			<input type="text" class="altoMoz wd100prc" id="descripcion" name="descripcion" required autofocus >
			    		</td>
			    	</tr>
			    </table>	
			    <table class="bordered">
			    	<thead>
			    		<tr>
			    			<th>#</th>
			    			<th>Descripción</th>
			    		</tr>
			    	</thead>
			    	<tbody>
				    	<tr>
				    		<td>1</td>	
				    		<td>
				    			<input type="text" class="altoMoz tbl150W" maxlength="10" id="v1" name="v1" required autofocus placeholder="YYYY-mm-dd" >
				    		</td>
				    	</tr>
				    	<tr>
				    		<td>2</td>	
				    		<td>
				    			<input type="text" class="altoMoz tbl150W" maxlength="10" id="v2" name="v2" placeholder="YYYY-mm-dd"  >
				    		</td>
				    	</tr>
				    	<tr>
				    		<td>3</td>	
				    		<td>
				    			<input type="text" class="altoMoz tbl150W" maxlength="10" id="v3" name="v3" placeholder="YYYY-mm-dd"  >
				    		</td>
				    	</tr>
				    	<tr>
				    		<td>4</td>	
				    		<td>
				    			<input type="text" class="altoMoz tbl150W" maxlength="10" id="v4" name="v4" placeholder="YYYY-mm-dd"  >
				    		</td>
				    	</tr>
				    	<tr>
				    		<td>5</td>	
				    		<td>
				    			<input type="text" class="altoMoz tbl150W" maxlength="10" id="v5" name="v5" placeholder="YYYY-mm-dd"  >
				    		</td>
				    	</tr>
				    	<tr>
				    		<td>6</td>	
				    		<td>
				    			<input type="text" class="altoMoz tbl150W" maxlength="10" id="v6" name="v6" placeholder="YYYY-mm-dd"  >
				    		</td>
				    	</tr>
				    	<tr>
				    		<td>7</td>	
				    		<td>
				    			<input type="text" class="altoMoz tbl150W" maxlength="10" id="v7" name="v7" placeholder="YYYY-mm-dd"  >
				    		</td>
				    	</tr>
				    	<tr>
				    		<td>8</td>	
				    		<td>
				    			<input type="text" class="altoMoz tbl150W" maxlength="10" id="v8" name="v8" placeholder="YYYY-mm-dd"  >
				    		</td>
				    	</tr>
				    	<tr>
				    		<td>9</td>	
				    		<td>
				    			<input type="text" class="altoMoz tbl150W" maxlength="10" id="v9" name="v9" placeholder="YYYY-mm-dd"  >
				    		</td>
				    	</tr>
				    	<tr>
				    		<td>10</td>	
				    		<td>
				    			<input type="text" class="altoMoz tbl150W" maxlength="10" id="v10" name="v10" placeholder="YYYY-mm-dd"  >
				    		</td>
				    	</tr>
				    	<tr>
				    		<td>11</td>	
				    		<td>
				    			<input type="text" class="altoMoz tbl150W" maxlength="10" id="v11" name="v11" placeholder="YYYY-mm-dd"  >
				    		</td>
				    	</tr>
				    	<tr>
				    		<td>12</td>	
				    		<td>
				    			<input type="text" class="altoMoz tbl150W" maxlength="10" id="v12" name="v12" placeholder="YYYY-mm-dd"  >
				    		</td>
				    	</tr>
					</tbody>

			    </table>

			    <div class="separete borderTopContainer"></div>

			    <table class="wd100prc">
			    	<tr>
			    		<td class="wd10prc">
					    	<label for="status_fecha_vencimiento" class=" tbl50W">Estatus</label>
			    		</td>
			    		<td class="wd80prc">
                            <input name="status_fecha_vencimiento" id="status_fecha_vencimiento" class="ace ace-switch ace-switch-6" type="checkbox" checked>
                            <span class="lbl"></span>
			    		</td>
			    	</tr>
			    </table>	

	    <input type="hidden" name="idlistavencimiento" id="idlistavencimiento" value="<?php echo $idlistavencimiento; ?>">
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

	var stream = io.connect(obj.getValue(4));


	$("#preloaderPrincipal").hide();

	$("#descripcion").focus();

	var idlistavencimiento = <?php echo $idlistavencimiento ?>;


	function getEvalConfig(IdListaVencimiento){
		$.post(obj.getValue(0) + "data/", {o:66, t:62, c:IdListaVencimiento, p:54, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){

					$("#descripcion").val(json[0].descripcion);

					$("#v1").val(json[0].v1);
					$("#v2").val(json[0].v2);
					$("#v3").val(json[0].v3);
					$("#v4").val(json[0].v4);
					$("#v5").val(json[0].v5);
					$("#v6").val(json[0].v6);
					$("#v7").val(json[0].v7);
					$("#v8").val(json[0].v8);
					$("#v9").val(json[0].v9);
					$("#v10").val(json[0].v10);
					$("#v11").val(json[0].v11);
					$("#v12").val(json[0].v12);

                    $("#status_fecha_vencimiento").prop("checked",json[0].status_fecha_vencimiento==1?true:false);

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

			var IdListaVencimiento = (idlistavencimiento==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:66, t:IdListaVencimiento, c:queryString, p:52, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						stream.emit("cliente", {mensaje: "PLATSOURCE-LV-PROP-"+IdListaVencimiento});
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

	if (idlistavencimiento<=0){
		$("#title").html("Nuevo registro");
	}else{
		$("#title").html("Editando el registro: "+idlistavencimiento);
		getEvalConfig(idlistavencimiento);
	}

});

</script>
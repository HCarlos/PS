<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idalumno  = $_POST['idalumno'];
$grupo = $_POST['grupo'];
$idnivel  = $_POST['idnivel'];
$idemp  = $_POST['idemp'];
$alumno  = $_POST['alumno'];
$idciclo  = $_POST['idciclo'];

?>

<h3 class="header smaller lighter blue" >
    <span id="title1"></span>
    <a class="label label-info arrowed-in-right arrowed closeFormDatAdicOfRep0 pull-right">Regresar</a>	
</h3>


<div class="row-fluid">
	<div class="span12" style="padding-left: 1em; padding-right: 1em;">

		<form id="frmDatAdicOfRep0"  class="form">

			<div class="widget-box" id="wdMemberFam">
				
				<div class="widget-header">
					<h4 class="pull-left">A) <span>RESULTADOS DE <strong>EXÁMENRES DE RECUPEACIÓN</strong></span> </h4>

				</div>

				<div class="widget-body">
					<div class="widget-main">
						<div class="row-fluid">

							<table role="table">
								<tbody>
									
									<tr>
										<td> <input type="text" id="asigrep0" name="asigrep0" value="" placeholder="Asignatura 1" class="altoMoz" /> </td>
										<td> <input type="text" id="evalrep00" name="evalrep00" value="" placeholder="Resultado" class="altoMoz marginLeft1em" /> </td>
										<td> <input type="text" id="evalrep01" name="evalrep01" value="" placeholder="Resultado" class="altoMoz marginLeft1em" /> </td>
										<td> <input type="text" id="evalrep02" name="evalrep02" value="" placeholder="Resultado" class="altoMoz marginLeft1em" /> </td>
										<td> <input type="text" id="evalrep03" name="evalrep03" value="" placeholder="Resultado" class="altoMoz marginLeft1em" /> </td>
									</tr>

									<tr>
										<td> <input type="text" id="asigrep1" name="asigrep1" value="" placeholder="Asignatura 2" class="altoMoz" /> </td>
										<td> <input type="text" id="evalrep10" name="evalrep10" value="" placeholder="Resultado" class="altoMoz marginLeft1em" /> </td>
										<td> <input type="text" id="evalrep11" name="evalrep11" value="" placeholder="Resultado" class="altoMoz marginLeft1em" /> </td>
										<td> <input type="text" id="evalrep12" name="evalrep12" value="" placeholder="Resultado" class="altoMoz marginLeft1em" /> </td>
										<td> <input type="text" id="evalrep13" name="evalrep13" value="" placeholder="Resultado" class="altoMoz marginLeft1em" /> </td>
									</tr>

									<tr>
										<td> <input type="text" id="asigrep2" name="asigrep2" value="" placeholder="Asignatura 3" class="altoMoz" /> </td>
										<td> <input type="text" id="evalrep20" name="evalrep20" value="" placeholder="Resultado" class="altoMoz marginLeft1em" /> </td>
										<td> <input type="text" id="evalrep21" name="evalrep21" value="" placeholder="Resultado" class="altoMoz marginLeft1em" /> </td>
										<td> <input type="text" id="evalrep22" name="evalrep22" value="" placeholder="Resultado" class="altoMoz marginLeft1em" /> </td>
										<td> <input type="text" id="evalrep23" name="evalrep23" value="" placeholder="Resultado" class="altoMoz marginLeft1em" /> </td>
									</tr>

									<tr>
										<td> <input type="text" id="asigrep3" name="asigrep3" value="" placeholder="Asignatura 4" class="altoMoz" /> </td>
										<td> <input type="text" id="evalrep30" name="evalrep30" value="" placeholder="Resultado" class="altoMoz marginLeft1em" /> </td>
										<td> <input type="text" id="evalrep31" name="evalrep31" value="" placeholder="Resultado" class="altoMoz marginLeft1em" /> </td>
										<td> <input type="text" id="evalrep32" name="evalrep32" value="" placeholder="Resultado" class="altoMoz marginLeft1em" /> </td>
										<td> <input type="text" id="evalrep33" name="evalrep33" value="" placeholder="Resultado" class="altoMoz marginLeft1em" /> </td>
									</tr>

									<tr>
										<td> <input type="text" id="asigrep4" name="asigrep4" value="" placeholder="Asignatura 5" class="altoMoz" /> </td>
										<td> <input type="text" id="evalrep40" name="evalrep40" value="" placeholder="Resultado" class="altoMoz marginLeft1em" /> </td>
										<td> <input type="text" id="evalrep41" name="evalrep41" value="" placeholder="Resultado" class="altoMoz marginLeft1em" /> </td>
										<td> <input type="text" id="evalrep42" name="evalrep42" value="" placeholder="Resultado" class="altoMoz marginLeft1em" /> </td>
										<td> <input type="text" id="evalrep43" name="evalrep43" value="" placeholder="Resultado" class="altoMoz marginLeft1em" /> </td>
									</tr>


								</tbody>
							</table>

						</div>
					</div>
				</div>
			</div>			


		    <input type="hidden" name="idalumno" id="idalumno" value="<?php echo $idalumno; ?>">
		    <input type="hidden" name="idnivel" id="idnivel" value="<?php echo $idnivel; ?>">
		    <input type="hidden" name="idemp" id="idemp" value="<?php echo $idemp; ?>">
		    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">

			<div class="row-fluid">
			    <div class="span12">

				    <div class="form-group w96" style='margin-right: 3em; margin-top: 1em;'>
				    	<span class="muted"></span>
				    	<button type="submit" class="btn btn-primary " style='margin-right: 4em;'><i class="glyphicon glyphicon-download-alt"></i>Guardar</button>
					</div>
				</div>
			</div>

		</form>

	</div>
</div>


<!--PAGE CONTENT ENDS-->

<script typy="text/javascript">        

jQuery(function($) {

	$("#preloaderPrincipal").hide();

	var IdAlumno = <?php echo $idalumno ?>;
	var IdNivel = <?php echo $idnivel ?>;
	var Grupo = '<?php echo $grupo; ?>';
	var IdEmp = <?php echo $idemp ?>;
	var Alumno = '<?php echo $alumno; ?>';
	var IdCiclo = <?php echo $idciclo; ?>;

	getDatAdicOfRep0(IdAlumno, IdNivel, IdEmp);

	$("#title1").html("Editando ID: ("+IdAlumno+" : "+Grupo+") <strong style='color:orange;'>"+Alumno+"</strong>"  );

	// close Form
	$(".closeFormDatAdicOfRep0").on("click",function(event){
		event.preventDefault();
		$("#preloaderPrincipal").hide();
		$("#contentLevel4").hide(function(){
			$("#contentLevel4").html("");
			$("#contentLevel3").show();
		});
		resizeScreen();
		return false;
	});

	function getDatAdicOfRep0(IdAlumno, IdNivel, IdEmp){

		$("#preloaderPrincipal").show();

		nc = "idemp="+IdEmp+"&idalumno="+IdAlumno+"&idnivel="+IdNivel;
		$.post(obj.getValue(0) + "data/", {o:43, t:91, c:nc, p:11, from:0, cantidad:0, s:' limit 1 '},
			function(json){
				if (json.length > 0 ) {
				
					$("#asigrep0").val(json[0].asigrep0);
					$("#evalrep00").val(json[0].evalrep00);
					$("#evalrep01").val(json[0].evalrep01);
					$("#evalrep02").val(json[0].evalrep02);
					$("#evalrep03").val(json[0].evalrep03);

					$("#asigrep1").val(json[0].asigrep1);
					$("#evalrep10").val(json[0].evalrep10);
					$("#evalrep11").val(json[0].evalrep11);
					$("#evalrep12").val(json[0].evalrep12);
					$("#evalrep13").val(json[0].evalrep13);

					$("#asigrep2").val(json[0].asigrep2);
					$("#evalrep20").val(json[0].evalrep20);
					$("#evalrep21").val(json[0].evalrep21);
					$("#evalrep22").val(json[0].evalrep22);
					$("#evalrep23").val(json[0].evalrep23);

					$("#asigrep3").val(json[0].asigrep3);
					$("#evalrep30").val(json[0].evalrep30);
					$("#evalrep31").val(json[0].evalrep31);
					$("#evalrep32").val(json[0].evalrep32);
					$("#evalrep33").val(json[0].evalrep33);

					$("#asigrep4").val(json[0].asigrep4);
					$("#evalrep40").val(json[0].evalrep40);
					$("#evalrep41").val(json[0].evalrep41);
					$("#evalrep42").val(json[0].evalrep42);
					$("#evalrep43").val(json[0].evalrep43);
				
				}

				$("#preloaderPrincipal").hide();

		},'json');

	}



    $("#frmDatAdicOfRep0").unbind("submit");
	$("#frmDatAdicOfRep0").on("submit",function(event){
		event.preventDefault();

		$("#preloaderPrincipal").show();

		$("#user").val(localStorage.nc);

		var queryString = $(this).serialize();

		// alert(queryString);

        $.post(obj.getValue(0) + "data/", {o:43, t:5, c:queryString, p:2, from:0, cantidad:0, s:''},
        function(json) {
        		if (json[0].msg=="OK"){

        			alert("Datos guardados con éxito.");
					// stream.emit("cliente", {mensaje: "PLATSOURCE-DATOS_ADICIONALES_OFICIALES-IDGPO-"+IdAlumno});

					$("#preloaderPrincipal").hide();
					$("#contentLevel4").hide(function(){
						$("#contentLevel4").html("");
						$("#contentLevel3").show();
					});

    			}else{
    				alert(json[0].msg);	
					$("#preloaderPrincipal").hide();
    			}
    	}, "json");		


	});

	

});

</script>
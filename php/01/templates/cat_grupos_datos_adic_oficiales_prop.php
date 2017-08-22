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
    <a class="label label-info arrowed-in-right arrowed closeFormDatAdicOf0 pull-right">Regresar</a>	
</h3>


<div class="row-fluid">
	<div class="span12" style="padding-left: 1em; padding-right: 1em;">

		<form id="frmDatAdicOf1"  class="form">

			<div class="widget-box" id="wdMemberFam">
				
				<div class="widget-header">
					<h4 class="pull-left">A) <span>EVALUACIÓN DE HERRAMIENTAS FUNDAMENTALES PARA EL APRENDIZAJE</span> </h4>

					<div class="widget-toolbar pull-right ">
						<select name="ispromovido" id="ispromovido" size="1" class="altoMoz marginTop1em" >
							<option value="0">No Promovido</option>
							<option value="1" selected>Promovido</option>
							<option value="2">Promovido con Reservas</option>
						</select>
					</div>

				</div>

				<div class="widget-body">
					<div class="widget-main">
						<div class="row-fluid">

							<table role="table">
								<tbody>
									<tr>
										<td class="wd75prc">
											<label for="escritura">ESCRITURA</label><br/>
											<textarea name="escritura" id="escritura" rows="2" class="wd100prc" ></textarea>
										</td>
										<td >
											<div class="wd20prc marginLeft1em">
												<label for="escritura_eval">Bimestre que Necesita Reforzar</label><br/>
												<select name="escritura_eval" id="escritura_eval" size="1" >
													<option value="0" selected>Ninguno</option>
													<option value="1">I</option>
													<option value="2">II</option>
													<option value="3">III</option>
													<option value="4">IV</option>
													<option value="5">V</option>
												</select>
											</div>
										</td>
										<td></td>
										<td></td>
									</tr>
									<tr>
										<td class="wd75prc">
											<label for="lectura">LECTURA</label><br/>
											<textarea name="lectura" id="lectura" rows="2" class="wd100prc" ></textarea>
										</td>
										<td >
											<div class="wd20prc marginLeft1em">
												<label for="lectura_eval">Bimestre que Necesita Reforzar</label><br/>
												<select name="lectura_eval" id="lectura_eval" size="1" >
													<option value="0" selected>Ninguno</option>
													<option value="1">I</option>
													<option value="2">II</option>
													<option value="3">III</option>
													<option value="4">IV</option>
													<option value="5">V</option>
												</select>
											</div>
										</td>
										<td></td>
										<td></td>
									</tr>
									<tr>
										<td class="wd75prc">
											<label for="matematica">MATEMÁTICAS</label><br/>
											<textarea name="matematica" id="matematica" rows="2" class="wd100prc" ></textarea>
										</td>
										<td >
											<div class="wd20prc marginLeft1em">
												<label for="matematica_eval">Bimestre que Necesita Reforzar</label><br/>
												<select name="matematica_eval" id="matematica_eval" size="1" >
													<option value="0" selected>Ninguno</option>
													<option value="1">I</option>
													<option value="2">II</option>
													<option value="3">III</option>
													<option value="4">IV</option>
													<option value="5">V</option>
												</select>
											</div>
										</td>
										<td></td>
										<td></td>
									</tr>
								</tbody>
							</table>

						</div>
					</div>
				</div>
			</div>			



			<div class="widget-box" id="wdMemberFam1">
				
				<div class="widget-header">
					<h4 class="pull-left">B) <span>OBSERVACIONES Y/O RECOMENDACIONES POR BIMESTRE Y ASIGNATURA</span> </h4>				
				</div>

				<div class="widget-body">
					<div class="widget-main">
						<div class="row-fluid">

							<table role="table" class="wd98prc">
								<tbody>

									<tr>
										<td class="tbl50W">
											<div class="wd100prc">
												<label for="bim0">BIM:</label>
												<input name="bim0" id="bim0" value="" class=" tbl80W altoMoz" />											
											</div>
										</td>

										<td class="tbl150W">
											<div class="wd96prc">
												<label for="asignatura0">ASIGNATURA:</label>
												<input name="asignatura0" id="asignatura0" value="" class=" wd100prc altoMoz" />
											</div>
										</td>

										<td class="tbl350W">
											<div class="wd96prc ">
												<label for="observaciones_especificas0">OBSERVACIONES:</label>
												<input name="observaciones_especificas0" id="observaciones_especificas0" value="" class="altoMoz  wd96prc" />
											</div>
										</td>

										<td class="tbl350W">
											<div class="wd96prc ">
												<label for="recomendaciones0">RECOMENDACIONES:</label>
												<input name="recomendaciones0" id="recomendaciones0" value="" class="altoMoz wd96prc" />
											</div>
										</td>

									</tr>

									<tr>
										<td class="tbl50W">
											<div class="wd100prc">
												<label for="bim1">BIM:</label>
												<input name="bim1" id="bim1" value="" class=" tbl80W altoMoz" />											
											</div>
										</td>

										<td class="tbl150W">
											<div class="wd96prc">
												<label for="asignatura1">ASIGNATURA:</label>
												<input name="asignatura1" id="asignatura1" value="" class=" wd100prc altoMoz" />
											</div>
										</td>

										<td class="tbl350W">
											<div class="wd96prc ">
												<label for="observaciones_especificas1">OBSERVACIONES:</label>
												<input name="observaciones_especificas1" id="observaciones_especificas1" value="" class="altoMoz  wd96prc" />
											</div>
										</td>

										<td class="tbl350W">
											<div class="wd96prc ">
												<label for="recomendaciones1">RECOMENDACIONES:</label>
												<input name="recomendaciones1" id="recomendaciones1" value="" class="altoMoz wd96prc" />
											</div>
										</td>

									</tr>

									<tr>
										<td class="tbl50W">
											<div class="wd100prc">
												<label for="bim2">BIM:</label>
												<input name="bim2" id="bim2" value="" class=" tbl80W altoMoz" />											
											</div>
										</td>

										<td class="tbl150W">
											<div class="wd96prc">
												<label for="asignatura2">ASIGNATURA:</label>
												<input name="asignatura2" id="asignatura2" value="" class=" wd100prc altoMoz" />
											</div>
										</td>

										<td class="tbl350W">
											<div class="wd96prc ">
												<label for="observaciones_especificas2">OBSERVACIONES:</label>
												<input name="observaciones_especificas2" id="observaciones_especificas2" value="" class="altoMoz  wd96prc" />
											</div>
										</td>

										<td class="tbl350W">
											<div class="wd96prc ">
												<label for="recomendaciones2">RECOMENDACIONES:</label>
												<input name="recomendaciones2" id="recomendaciones2" value="" class="altoMoz wd96prc" />
											</div>
										</td>

									</tr>

									<tr>
										<td class="tbl50W">
											<div class="wd100prc">
												<label for="bim3">BIM:</label>
												<input name="bim3" id="bim3" value="" class=" tbl80W altoMoz" />											
											</div>
										</td>

										<td class="tbl150W">
											<div class="wd96prc">
												<label for="asignatura3">ASIGNATURA:</label>
												<input name="asignatura3" id="asignatura3" value="" class=" wd100prc altoMoz" />
											</div>
										</td>

										<td class="tbl350W">
											<div class="wd96prc ">
												<label for="observaciones_especificas3">OBSERVACIONES:</label>
												<input name="observaciones_especificas3" id="observaciones_especificas3" value="" class="altoMoz  wd96prc" />
											</div>
										</td>

										<td class="tbl350W">
											<div class="wd96prc ">
												<label for="recomendaciones3">RECOMENDACIONES:</label>
												<input name="recomendaciones3" id="recomendaciones3" value="" class="altoMoz wd96prc" />
											</div>
										</td>

									</tr>

									<tr>
										<td class="tbl50W">
											<div class="wd100prc">
												<label for="bim4">BIM:</label>
												<input name="bim4" id="bim4" value="" class=" tbl80W altoMoz" />											
											</div>
										</td>

										<td class="tbl150W">
											<div class="wd96prc">
												<label for="asignatura4">ASIGNATURA:</label>
												<input name="asignatura4" id="asignatura4" value="" class=" wd100prc altoMoz" />
											</div>
										</td>

										<td class="tbl350W">
											<div class="wd96prc ">
												<label for="observaciones_especificas4">OBSERVACIONES:</label>
												<input name="observaciones_especificas4" id="observaciones_especificas4" value="" class="altoMoz  wd96prc" />
											</div>
										</td>

										<td class="tbl350W">
											<div class="wd96prc ">
												<label for="recomendaciones4">RECOMENDACIONES:</label>
												<input name="recomendaciones4" id="recomendaciones4" value="" class="altoMoz wd96prc" />
											</div>
										</td>

									</tr>



								</tbody>
							</table>

						</div>
					</div>
				</div>
			</div>			


			<div class="widget-box" id="wdMemberFam2">
				
				<div class="widget-header">
					<h4 class="pull-left">C) <span>OBSERVACIONES GENERALES</span> </h4>				
				</div>

				<div class="widget-body">
					<div class="widget-main">
						<div class="row-fluid">

							<table role="table" class="wd100prc">
								<tbody>

									<tr>

										<td class="wd100prc">
											<div class="wd90prc">
												<label for="observaciones_generales">OBSERVACIONES GENERALES:</label>
												<input name="observaciones_generales" id="observaciones_generales" value="" class="altoMoz wd100prc" />
											</div>
										</td>

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

	getDatAdicOf0(IdAlumno, IdNivel, IdEmp);

	$("#title1").html("Editando ID: ("+IdAlumno+" : "+Grupo+") <strong style='color:orange;'>"+Alumno+"</strong>"  );

	// close Form
	$(".closeFormDatAdicOf0").on("click",function(event){
		event.preventDefault();
		$("#preloaderPrincipal").hide();
		$("#contentLevel4").hide(function(){
			$("#contentLevel4").html("");
			$("#contentLevel3").show();
		});
		resizeScreen();
		return false;
	});

	function getDatAdicOf0(IdAlumno, IdNivel, IdEmp){

		$("#preloaderPrincipal").show();

		nc = "idemp="+IdEmp+"&idalumno="+IdAlumno+"&idnivel="+IdNivel;
		$.post(obj.getValue(0) + "data/", {o:43, t:91, c:nc, p:11, from:0, cantidad:0, s:' limit 1 '},
			function(json){

				$("#escritura").html(json[0].escritura);
				$("#escritura_eval").val(json[0].escritura_eval);

				$("#lectura").html(json[0].lectura);
				$("#lectura_eval").val(json[0].lectura_eval);

				$("#matematica").html(json[0].matematica);
				$("#matematica_eval").val(json[0].matematica_eval);


				$("#ispromovido").val(json[0].ispromovido);

				$("#bim0").val(json[0].bim0);
				$("#asignatura0").val(json[0].asignatura0);
				$("#observaciones_especificas0").val(json[0].observaciones_especificas0);
				$("#recomendaciones0").val(json[0].recomendaciones0);

				$("#bim1").val(json[0].bim1);
				$("#asignatura1").val(json[0].asignatura1);
				$("#observaciones_especificas1").val(json[0].observaciones_especificas1);
				$("#recomendaciones1").val(json[0].recomendaciones1);

				$("#bim2").val(json[0].bim2);
				$("#asignatura2").val(json[0].asignatura2);
				$("#observaciones_especificas2").val(json[0].observaciones_especificas2);
				$("#recomendaciones2").val(json[0].recomendaciones2);

				$("#bim3").val(json[0].bim3);
				$("#asignatura3").val(json[0].asignatura3);
				$("#observaciones_especificas3").val(json[0].observaciones_especificas3);
				$("#recomendaciones3").val(json[0].recomendaciones3);

				$("#bim4").val(json[0].bim4);
				$("#asignatura4").val(json[0].asignatura4);
				$("#observaciones_especificas4").val(json[0].observaciones_especificas4);
				$("#recomendaciones4").val(json[0].recomendaciones4);
				
				$("#observaciones_generales").val(json[0].observaciones_generales);

				$("#preloaderPrincipal").hide();

		},'json');

	}



    $("#frmDatAdicOf1").unbind("submit");
	$("#frmDatAdicOf1").on("submit",function(event){
		event.preventDefault();

		$("#preloaderPrincipal").show();

		$("#user").val(localStorage.nc);

		var queryString = $(this).serialize();

        $.post(obj.getValue(0) + "data/", {o:43, t:2, c:queryString, p:2, from:0, cantidad:0, s:''},
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
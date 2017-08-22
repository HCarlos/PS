<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$grupo = $_POST['grupo'];
$grado = $_POST['grado'];
$idnivel  = $_POST['idnivel'];
$idemp  = $_POST['idemp'];
$idciclo  = $_POST['idciclo'];

?>

<h3 class="header smaller lighter blue" >
    <span id="title1"></span>
    <a class="label label-info arrowed-in-right arrowed closeFormDatAdicOf1 pull-right">Regresar</a>	
</h3>


<div class="row-fluid">
	<div class="span12" style="padding-left: 1em; padding-right: 1em;">

		<form id="frmDatAdicOf1"  class="form">


			<div class="widget-box" id="wdMemberFam0">
				
				<div class="widget-header">
					<h4 class="pull-left">POSICIÓN <strong>PROMEDIOS</strong></span> </h4>
				</div>

				<div class="widget-body">
					<div class="widget-main">
						<div class="row-fluid">

							<table>
								<tbody>
									<tr>
										<td >
											<div >
												<label for="initcal_x">Inicia Caida de Calificaciones:</label>
												<input name="initcal_x" id="initcal_x" value="" class="  altoMoz" />
											</div>
										</td>
										<td >
											<div class=" marginLeft1em">
												<label for="altofilacal">Alto de la Fila de Califiaciones:</label>
												<input name="altofilacal" id="altofilacal" value="" class="  altoMoz" />
											</div>
										</td>
										<td >
											<div class="marginLeft1em">
												<label for="promovido_si">Promovido (SI):</label>
												<input name="promovido_si" id="promovido_si" value="" class="  altoMoz" />
											</div>
										</td>
										<td >
											<div class=" marginLeft2em">
												<label for="promovido_no">Promovido (NO):</label>
												<input name="promovido_no" id="promovido_no" value="" class="  altoMoz" />
											</div>
										</td>
										<td >
											<div class=" marginLeft2em">
												<label for="promovido_condiciones">Promovido (COND.):</label>
												<input name="promovido_condiciones" id="promovido_condiciones" value="" class="  altoMoz" />
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
					<h4 class="pull-left">POSICIÓN DE LAS CAIDAS OFICIALES PARA <strong>MATERIAS REPROBADAS</strong> SECUNDARIA</span> </h4>
				</div>

				<div class="widget-body">
					<div class="widget-main">
						<div class="row-fluid">

							<table role="table">
								<tbody>

									<tr>
										<td><input type="text" id="mr0" name="mr0" value="" placeholder="Asignatura 1" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="er00" name="er00" value="" placeholder="0,0" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="er01" name="er01" value="" placeholder="0,1" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="er02" name="er02" value="" placeholder="0,2" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="er03" name="er03" value="" placeholder="0,3" class="altoMoz tbl100W"/></td>
									</tr>

									<tr>
										<td><input type="text" id="mr1" name="mr1" value="" placeholder="Asignatura 2" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="er10" name="er10" value="" placeholder="1,0" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="er11" name="er11" value="" placeholder="1,1" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="er12" name="er12" value="" placeholder="1,2" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="er13" name="er13" value="" placeholder="1,3" class="altoMoz tbl100W"/></td>
									</tr>

									<tr>
										<td><input type="text" id="mr2" name="mr2" value="" placeholder="Asignatura 3" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="er20" name="er20" value="" placeholder="2,0" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="er21" name="er21" value="" placeholder="2,1" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="er22" name="er22" value="" placeholder="2,2" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="er23" name="er23" value="" placeholder="2,3" class="altoMoz tbl100W"/></td>
									</tr>

									<tr>
										<td><input type="text" id="mr3" name="mr3" value="" placeholder="Asignatura 4" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="er30" name="er30" value="" placeholder="3,0" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="er31" name="er31" value="" placeholder="3,1" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="er32" name="er32" value="" placeholder="3,2" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="er33" name="er33" value="" placeholder="3,3" class="altoMoz tbl100W"/></td>
									</tr>

								</tbody>
							</table>

						</div>
					</div>
				</div>
			</div>		

			<div class="widget-box" id="wdMemberFam4">
				
				<div class="widget-header">
					<h4 class="pull-left">POSICIÓN DE LAS HERRAMIENTAS FUNDAMENTALES PARA EL <strong>APRENDIZAJE</strong> </span> </h4>
				</div>

				<div class="widget-body">
					<div class="widget-main">
						<div class="row-fluid">

							<table role="table">
								<tbody>

									<tr>
										<td><input type="text" id="escritura" name="escritura" value="" placeholder="Escritura" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="esc0" name="esc0" value="" placeholder="0,0" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="esc1" name="esc1" value="" placeholder="0,1" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="esc2" name="esc2" value="" placeholder="0,2" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="esc3" name="esc3" value="" placeholder="0,3" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="esc4" name="esc4" value="" placeholder="0,4" class="altoMoz tbl100W"/></td>
									</tr>

									<tr>
										<td><input type="text" id="lectura" name="lectura" value="" placeholder="Lectura" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="lec0" name="lec0" value="" placeholder="1,0" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="lec1" name="lec1" value="" placeholder="1,1" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="lec2" name="lec2" value="" placeholder="1,2" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="lec3" name="lec3" value="" placeholder="1,3" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="lec4" name="lec4" value="" placeholder="1,4" class="altoMoz tbl100W"/></td>
									</tr>

									<tr>
										<td><input type="text" id="matematicas" name="matematicas" value="" placeholder="Matemáticas" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="mate0" name="mate0" value="" placeholder="2,0" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="mate1" name="mate1" value="" placeholder="2,1" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="mate2" name="mate2" value="" placeholder="2,2" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="mate3" name="mate3" value="" placeholder="2,3" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="mate4" name="mate4" value="" placeholder="2,4" class="altoMoz tbl100W"/></td>
									</tr>

								</tbody>
							</table>

						</div>
					</div>
				</div>
			</div>		
			
			

			<div class="widget-box" id="wdMemberFam3">
				
				<div class="widget-header">
					<h4 class="pull-left">POSICIÓN DE LOS <strong>PROMEDIOS</strong></span> </h4>
				</div>

				<div class="widget-body">
					<div class="widget-main">
						<div class="row-fluid">

							<table>
								<tbody>
									<tr>

										<td >
											<div class="wd96prc">
												<label for="promedio_grado">Promedio Grado:</label>
												<input name="promedio_grado" id="promedio_grado" value="" class="  altoMoz" />
											</div>
										</td>
										
										<td >
											<div class="wd96prc marginLeft1em">
												<label for="promedio_nivel">Promedio Nivel:</label>
												<input name="promedio_nivel" id="promedio_nivel" value="" class="  altoMoz" />
											</div>
										</td>
										
										<td>
											<div class="wd96prc marginLeft1em">
												<label for="clave_tecnologia_pos">Clave de Tecnología:</label>
												<input name="clave_tecnologia_pos" id="clave_tecnologia_pos" value="" class="  altoMoz" />
											</div>
										</td>
										
										<td>
											<div class="wd96prc marginLeft1em">
												<label for="tecnologia_pos">Tecnología:</label>
												<input name="tecnologia_pos" id="tecnologia_pos" value="" class="  altoMoz" />
											</div>
										</td>

										<td>
											<div class="wd96prc marginLeft1em">
												<label for="area_diciplinaria_pos">Area Disciplinaria:</label>
												<input name="area_diciplinaria_pos" id="area_diciplinaria_pos" value="" class="  altoMoz" />
											</div>
										</td>

										<td >
											<div class="wd96prc marginLeft1em">
												<label for="asesoria_si_pos">Asistió Asesoria (SI):</label>
												<input name="asesoria_si_pos" id="asesoria_si_pos" value="" class="  altoMoz" />
											</div>
										</td>

										<td >
											<div class="wd96prc marginLeft1em">
												<label for="asignatura_sec_pos">Asignatura:</label>
												<input name="asignatura_sec_pos" id="asignatura_sec_pos" value="" class="  altoMoz" />
											</div>
										</td>


									</tr>
								</tbody>
							</table>


						</div>
					</div>
				</div>
			</div>			

			<div class="widget-box" id="wdMemberFam6">
				
				<div class="widget-header">
					<h4 class="pull-left">POSICIÓN DE LAS <strong>OBSERVACIONES</strong> Y/O <strong>RECOMENDACIONES</strong> POR <strong>BIMESTRE</strong> Y <strong>ASIGNATURA</strong> </span> </h4>
				</div>

				<div class="widget-body">
					<div class="widget-main">
						<div class="row-fluid">

							<table role="table">
								<tbody>

									<tr>
										<td><input type="text" id="bim0" name="bim0" value="" placeholder="0;0" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="asig0" name="asig0" value="" placeholder="0;1" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="obsesp0" name="obsesp0" value="" placeholder="0;2" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="rec0" name="rec0" value="" placeholder="0;3" class="altoMoz tbl100W"/></td>
									</tr>

									<tr>
										<td><input type="text" id="bim1" name="bim1" value="" placeholder="1;0" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="asig1" name="asig1" value="" placeholder="1;1" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="obsesp1" name="obsesp1" value="" placeholder="1;2" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="rec1" name="rec1" value="" placeholder="1;3" class="altoMoz tbl100W"/></td>
									</tr>

									<tr>
										<td><input type="text" id="bim2" name="bim2" value="" placeholder="2;0" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="asig2" name="asig2" value="" placeholder="2;1" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="obsesp2" name="obsesp2" value="" placeholder="2;2" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="rec2" name="rec2" value="" placeholder="2;3" class="altoMoz tbl100W"/></td>
									</tr>

									<tr>
										<td><input type="text" id="bim3" name="bim3" value="" placeholder="3;0" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="asig3" name="asig3" value="" placeholder="3;1" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="obsesp3" name="obsesp3" value="" placeholder="3;2" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="rec3" name="rec3" value="" placeholder="3;3" class="altoMoz tbl100W"/></td>
									</tr>

									<tr>
										<td><input type="text" id="bim4" name="bim4" value="" placeholder="4;0" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="asig4" name="asig4" value="" placeholder="4;1" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="obsesp4" name="obsesp4" value="" placeholder="4;2" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="rec4" name="rec4" value="" placeholder="4;3" class="altoMoz tbl100W"/></td>
									</tr>

									<tr>
										<td colspan="4">
											<div class="wd96prc marginLeft1em">
												<label for="observaciones_generales">Observaciones Generales:</label>
												<input name="observaciones_generales" id="observaciones_generales" value="" class="  altoMoz" />
											</div>
										</td>
									</tr>

								</tbody>
							</table>

						</div>
					</div>
				</div>
			</div>		

			<div class="widget-box" id="wdMemberFam1">
				
				<div class="widget-header">
					<h4 class="pull-left">POSICIÓN DE LAS CAIDAS OFICIALES PARA <strong>LECTURA SEP</strong></span> </h4>
				</div>

				<div class="widget-body">
					<div class="widget-main">
						<div class="row-fluid">

							<table role="table">
								<tbody>

									<tr>
										<td><input type="text" id="x0x0" name="x0x0" value="" placeholder="0,0" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x0x1" name="x0x1" value="" placeholder="0,1" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x0x2" name="x0x2" value="" placeholder="0,2" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x0x3" name="x0x3" value="" placeholder="0,3" class="altoMoz tbl100W"/></td>
									</tr>

									<tr>
										<td><input type="text" id="x1x0" name="x1x0" value="" placeholder="1,0" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x1x1" name="x1x1" value="" placeholder="1,1" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x1x2" name="x1x2" value="" placeholder="1,2" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x1x3" name="x1x3" value="" placeholder="1,3" class="altoMoz tbl100W"/></td>
									</tr>

									<tr>
										<td><input type="text" id="x2x0" name="x2x0" value="" placeholder="2,0" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x2x1" name="x2x1" value="" placeholder="2,1" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x2x2" name="x2x2" value="" placeholder="2,2" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x2x3" name="x2x3" value="" placeholder="2,3" class="altoMoz tbl100W"/></td>
									</tr>

									<tr>
										<td><input type="text" id="x3x0" name="x3x0" value="" placeholder="3,0" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x3x1" name="x3x1" value="" placeholder="3,1" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x3x2" name="x3x2" value="" placeholder="3,2" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x3x3" name="x3x3" value="" placeholder="3,3" class="altoMoz tbl100W"/></td>
									</tr>

									<tr>
										<td><input type="text" id="x4x0" name="x4x0" value="" placeholder="4,0" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x4x1" name="x4x1" value="" placeholder="4,1" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x4x2" name="x4x2" value="" placeholder="4,2" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x4x3" name="x4x3" value="" placeholder="4,3" class="altoMoz tbl100W"/></td>
									</tr>

									<tr>
										<td><input type="text" id="x5x0" name="x5x0" value="" placeholder="5,0" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x5x1" name="x5x1" value="" placeholder="5,1" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x5x2" name="x5x2" value="" placeholder="5,2" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x5x3" name="x5x3" value="" placeholder="5,3" class="altoMoz tbl100W"/></td>
									</tr>

									<tr>
										<td><input type="text" id="x6x0" name="x6x0" value="" placeholder="6,0" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x6x1" name="x6x1" value="" placeholder="6,1" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x6x2" name="x6x2" value="" placeholder="6,2" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x6x3" name="x6x3" value="" placeholder="6,3" class="altoMoz tbl100W"/></td>
									</tr>

									<tr>
										<td><input type="text" id="x7x0" name="x7x0" value="" placeholder="7,0" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x7x1" name="x7x1" value="" placeholder="7,1" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x7x2" name="x7x2" value="" placeholder="7,2" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x7x3" name="x7x3" value="" placeholder="7,3" class="altoMoz tbl100W"/></td>
									</tr>

									<tr>
										<td><input type="text" id="x8x0" name="x8x0" value="" placeholder="8,0" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x8x1" name="x8x1" value="" placeholder="8,1" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x8x2" name="x8x2" value="" placeholder="8,2" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x8x3" name="x8x3" value="" placeholder="8,3" class="altoMoz tbl100W"/></td>
									</tr>

									<tr>
										<td><input type="text" id="x9x0" name="x9x0" value="" placeholder="9,0" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x9x1" name="x9x1" value="" placeholder="9,1" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x9x2" name="x9x2" value="" placeholder="9,2" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x9x3" name="x9x3" value="" placeholder="9,3" class="altoMoz tbl100W"/></td>
									</tr>

									<tr>
										<td><input type="text" id="x10x0" name="x10x0" value="" placeholder="10,0" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x10x1" name="x10x1" value="" placeholder="10,1" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x10x2" name="x10x2" value="" placeholder="10,2" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x10x3" name="x10x3" value="" placeholder="10,3" class="altoMoz tbl100W"/></td>
									</tr>

									<tr>
										<td><input type="text" id="x11x0" name="x11x0" value="" placeholder="11,0" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x11x1" name="x11x1" value="" placeholder="11,1" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x11x2" name="x11x2" value="" placeholder="11,2" class="altoMoz tbl100W"/></td>
										<td><input type="text" id="x11x3" name="x11x3" value="" placeholder="11,3" class="altoMoz tbl100W"/></td>
									</tr>


								</tbody>
							</table>

						</div>
					</div>
				</div>
			</div>			


			<div class="widget-box" id="wdMemberFam5">
				
				<div class="widget-header">
					<h4 class="pull-left">POSICIÓN <strong>FECHA</strong> Y <strong>LUGAR</strong></span> </h4>
				</div>

				<div class="widget-body">
					<div class="widget-main">
						<div class="row-fluid">

							<table>
								<tbody>

									<tr>
										<td >
											<div >
												<label for="maestro">Maestro:</label>
												<input name="maestro" id="maestro" value="" class="  altoMoz" />
											</div>
										</td>
										<td >
											<div class=" marginLeft1em">
												<label for="director">Director:</label>
												<input name="director" id="director" value="" class="  altoMoz" />
											</div>
										</td>
										<td >
											<div class="marginLeft1em">
												<label for="lugar_pos">Lugar:</label>
												<input name="lugar_pos" id="lugar_pos" value="" class="  altoMoz" />
											</div>
										</td>
										<td >
											<div class=" marginLeft2em">
												<label for="dia">Dia:</label>
												<input name="dia" id="dia" value="" class="  altoMoz" />
											</div>
										</td>
										<td >
											<div class=" marginLeft2em">
												<label for="mes">Mes:</label>
												<input name="mes" id="mes" value="" class="  altoMoz" />
											</div>
										</td>
										<td >
											<div class=" marginLeft2em">
												<label for="anno">Año:</label>
												<input name="anno" id="anno" value="" class="  altoMoz" />
											</div>
										</td>

									</tr>


									<tr>
										<td >
											<div class=" marginLeft1em">
												<label for="iduserdirector">ID Director:</label>
												<select name="iduserdirector" id="iduserdirector" size="1" class="altoMoz marginTop1em" >
													<option value="0" selected>Seleccione un(a) Director(a)</option>
												</select>
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
					<h4 class="pull-left">OTROS <strong>DATOS</strong></span> </h4>
				</div>

				<div class="widget-body">
					<div class="widget-main">
						<div class="row-fluid">

							<table>
								<tbody>
									<tr>
										<td class="tbl250W">
											<div class="wd96prc">
												<label for="lugar">LUGAR:</label>
												<input name="lugar" id="lugar" value="" class=" wd100prc altoMoz" />
											</div>
										</td>
										<td class="tbl150W">
											<div class="wd96prc marginLeft2em">
												<label for="fecha">FECHA:</label>
												<input class="date-picker altoMoz wd100prc" id="fecha" name="fecha" data-date-format="dd-mm-yyyy" type="text" value="<?php echo date(); ?>" />
											</div>
										</td>
										<td>
											<div class="wd96prc marginLeft1em">
												<label for="clave_tecnologia">Clave de Tecnología:</label>
												<input name="clave_tecnologia" id="clave_tecnologia" value="" class="  altoMoz" />
											</div>
										</td>
										
										<td>
											<div class="wd96prc marginLeft1em">
												<label for="tecnologia">Tecnología:</label>
												<input name="tecnologia" id="tecnologia" value="" class="  altoMoz" />
											</div>
										</td>

										<td>
											<div class="wd96prc marginLeft1em">
												<label for="area_diciplinaria">Area Disciplinaria:</label>
												<input name="area_diciplinaria" id="area_diciplinaria" value="" class="  altoMoz" />
											</div>
										</td>

										<td >
											<div class="wd96prc marginLeft1em">
												<label for="asignatura_sec">Asignatura:</label>
												<input name="asignatura_sec" id="asignatura_sec" value="" class="  altoMoz" />
											</div>
										</td>


									</tr>
								</tbody>
							</table>


						</div>
					</div>
				</div>
			</div>			



		    <input type="hidden" name="grado" id="grado" value="<?php echo $grado; ?>">
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

	accounting.settings = {
		currency: {
			symbol : " ", 
			format: "%s%v",
			decimal : ".",
			thousand: ",",  
			precision : 2   
		},
		number: {
			precision : 0,  
			thousand: ",",
			decimal : "."
		}
	}

	var IdNivel = <?php echo $idnivel ?>;
	var Grupo = '<?php echo $grupo; ?>';
	var IdEmp = <?php echo $idemp ?>;
	var Grado = <?php echo $grado; ?>;
	var IdCiclo = <?php echo $idciclo; ?>;

	$("#title1").html("Editando ID: ("+Grupo+") <strong style='color:orange;'></strong>"  );

	// close Form
	$(".closeFormDatAdicOf1").on("click",function(event){
		event.preventDefault();
		$("#preloaderPrincipal").hide();
		$("#contentLevel4").hide(function(){
			$("#contentLevel4").html("");
			$("#contentLevel3").show();
		});
		resizeScreen();
		return false;
	});

	function getDatAdicOf0(IdNivel, IdEmp){

		$("#preloaderPrincipal").show();

		nc = "idemp="+IdEmp+"&grado="+Grado+"&idnivel="+IdNivel;
		$.post(obj.getValue(0) + "data/", {o:43, t:96, c:nc, p:11, from:0, cantidad:0, s:' limit 1 '},
			function(json){
				if (json.length > 0 ){

					$("#promovido_si").val(json[0].promovido_si);
					$("#promovido_no").val(json[0].promovido_no);
					$("#promovido_condiciones").val(json[0].promovido_condiciones);

					$("#mr0").val(json[0].mr0);
					$("#er00").val(json[0].er00);
					$("#er01").val(json[0].er01);
					$("#er02").val(json[0].er02);
					$("#er03").val(json[0].er03);

					$("#mr1").val(json[0].mr1);
					$("#er10").val(json[0].er10);
					$("#er11").val(json[0].er11);
					$("#er12").val(json[0].er12);
					$("#er13").val(json[0].er13);

					$("#mr2").val(json[0].mr2);
					$("#er20").val(json[0].er20);
					$("#er21").val(json[0].er21);
					$("#er22").val(json[0].er22);
					$("#er23").val(json[0].er23);

					$("#mr3").val(json[0].mr3);
					$("#er30").val(json[0].er30);
					$("#er31").val(json[0].er31);
					$("#er32").val(json[0].er32);
					$("#er33").val(json[0].er33);

					$("#escritura").val(json[0].escritura);
					$("#esc0").val(json[0].esc0);
					$("#esc1").val(json[0].esc1);
					$("#esc2").val(json[0].esc2);
					$("#esc3").val(json[0].esc3);
					$("#esc4").val(json[0].esc4);

					$("#lectura").val(json[0].lectura);
					$("#lec0").val(json[0].lec0);
					$("#lec1").val(json[0].lec1);
					$("#lec2").val(json[0].lec2);
					$("#lec3").val(json[0].lec3);
					$("#lec4").val(json[0].lec4);

					$("#matematicas").val(json[0].matematicas);
					$("#mate0").val(json[0].mate0);
					$("#mate1").val(json[0].mate1);
					$("#mate2").val(json[0].mate2);
					$("#mate3").val(json[0].mate3);
					$("#mate4").val(json[0].mate4);

					$("#bim0").val(json[0].bim0);
					$("#asig0").val(json[0].asig0);
					$("#obsesp0").val(json[0].obsesp0);
					$("#rec0").val(json[0].rec0);

					$("#bim1").val(json[0].bim1);
					$("#asig1").val(json[0].asig1);
					$("#obsesp1").val(json[0].obsesp1);
					$("#rec1").val(json[0].rec1);

					$("#bim2").val(json[0].bim2);
					$("#asig2").val(json[0].asig2);
					$("#obsesp2").val(json[0].obsesp2);
					$("#rec2").val(json[0].rec2);

					$("#bim3").val(json[0].bim3);
					$("#asig3").val(json[0].asig3);
					$("#obsesp3").val(json[0].obsesp3);
					$("#rec3").val(json[0].rec3);

					$("#bim4").val(json[0].bim4);
					$("#asig4").val(json[0].asig4);
					$("#obsesp4").val(json[0].obsesp4);
					$("#rec4").val(json[0].rec4);

					$("#x0x0").val(json[0].x0x0);
					$("#x0x1").val(json[0].x0x1);
					$("#x0x2").val(json[0].x0x2);
					$("#x0x3").val(json[0].x0x3);

					$("#x1x0").val(json[0].x1x0);
					$("#x1x1").val(json[0].x1x1);
					$("#x1x2").val(json[0].x1x2);
					$("#x1x3").val(json[0].x1x3);

					$("#x2x0").val(json[0].x2x0);
					$("#x2x1").val(json[0].x2x1);
					$("#x2x2").val(json[0].x2x2);
					$("#x2x3").val(json[0].x2x3);

					$("#x3x0").val(json[0].x3x0);
					$("#x3x1").val(json[0].x3x1);
					$("#x3x2").val(json[0].x3x2);
					$("#x3x3").val(json[0].x3x3);

					$("#x4x0").val(json[0].x4x0);
					$("#x4x1").val(json[0].x4x1);
					$("#x4x2").val(json[0].x4x2);
					$("#x4x3").val(json[0].x4x3);

					$("#x5x0").val(json[0].x5x0);
					$("#x5x1").val(json[0].x5x1);
					$("#x5x2").val(json[0].x5x2);
					$("#x5x3").val(json[0].x5x3);

					$("#x6x0").val(json[0].x6x0);
					$("#x6x1").val(json[0].x6x1);
					$("#x6x2").val(json[0].x6x2);
					$("#x6x3").val(json[0].x6x3);

					$("#x7x0").val(json[0].x7x0);
					$("#x7x1").val(json[0].x7x1);
					$("#x7x2").val(json[0].x7x2);
					$("#x7x3").val(json[0].x7x3);

					$("#x8x0").val(json[0].x8x0);
					$("#x8x1").val(json[0].x8x1);
					$("#x8x2").val(json[0].x8x2);
					$("#x8x3").val(json[0].x8x3);

					$("#x9x0").val(json[0].x9x0);
					$("#x9x1").val(json[0].x9x1);
					$("#x9x2").val(json[0].x9x2);
					$("#x9x3").val(json[0].x9x3);

					$("#x10x0").val(json[0].x10x0);
					$("#x10x1").val(json[0].x10x1);
					$("#x10x2").val(json[0].x10x2);
					$("#x10x3").val(json[0].x10x3);

					$("#x11x0").val(json[0].x11x0);
					$("#x11x1").val(json[0].x11x1);
					$("#x11x2").val(json[0].x11x2);
					$("#x11x3").val(json[0].x11x3);

					$("#observaciones_generales").val(json[0].observaciones_generales);

					$("#promedio_grado").val(json[0].promedio_grado);
					$("#promedio_nivel").val(json[0].promedio_nivel);

					$("#clave_tecnologia_pos").val(json[0].clave_tecnologia_pos);
					$("#tecnologia_pos").val(json[0].tecnologia_pos);
					$("#area_diciplinaria_pos").val(json[0].area_diciplinaria_pos);
					$("#asesoria_si_pos").val(json[0].asesoria_si_pos);

					$("#asignatura_sec").val(json[0].asignatura_sec);
					$("#asignatura_sec_pos").val(json[0].asignatura_sec_pos);

					$("#maestro").val(json[0].maestro);
					$("#director").val(json[0].director);
					$("#lugar_pos").val(json[0].lugar_pos);
					$("#dia").val(json[0].dia);
					$("#mes").val(json[0].mes);
					$("#anno").val(json[0].anno);

					$("#iduserdirector").val(json[0].iduserdirector);

					$("#lugar").val(json[0].lugar);
					
					$("#clave_tecnologia").val(json[0].clave_tecnologia);
					$("#tecnologia").val(json[0].tecnologia);
					$("#area_diciplinaria").val(json[0].area_diciplinaria);

					$("#initcal_x").val(json[0].initcal_x);
					$("#altofilacal").val(json[0].altofilacal);

					$('.date-picker').datepicker().next().on(ace.click_event, function(){
						$(this).prev().focus();
					});
					$('.date-picker').mask('99-99-9999');
					$(".date-picker").val( json[0].cfecha_boleta );

				}

				$("#preloaderPrincipal").hide();

		},'json');

	}



    $("#frmDatAdicOf1").unbind("submit");
	$("#frmDatAdicOf1").on("submit",function(event){
		event.preventDefault();

		$("#preloaderPrincipal").show();

		$("#user").val(localStorage.nc);

		var queryString = $(this).serialize();

		//alert(queryString);

        $.post(obj.getValue(0) + "data/", {o:43, t:3, c:queryString, p:2, from:0, cantidad:0, s:''},
        function(json) {
        		if (json[0].msg=="OK"){

        			alert("Datos guardados con éxito.");
					// stream.emit("cliente", {mensaje: "PLATSOURCE-DATOS_ADICIONALES_OFICIALES_POS_LEC_SEP-IDGPO-"+Grado});

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

	function getDirectores(IdNivel){
		// var nc = "u="+localStorage.nc+"&idgrupo="+IdGrupo;
		var	nc = "u="+localStorage.nc+"&clavenivel="+IdNivel;

		$.post(obj.getValue(0) + "data/", {o:43, t:97, c:nc, p:11, from:0, cantidad:0,s:''},
			function(json){
				$.each(json, function(i, item) {
					$("#iduserdirector").append('<option value="'+item.idusuariodirector+'">'+item.director+'</option>');
				});		
				
				getDatAdicOf0(IdNivel, IdEmp);

		},'json');
	}

	getDirectores(IdNivel);


	$('.date-picker').datepicker().next().on(ace.click_event, function(){
		$(this).prev().focus();
	});
	$('.date-picker').mask('99-99-9999');
	$('.date-picker').val(obj.getDateToday());
	

});

</script>
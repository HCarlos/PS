<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idpreinscripcion  = $_POST['idpreinscripcion'];

?>
<div class="row-fluid">
<div class="span12" style="padding-left: 1em; padding-right: 1em;">
<div class="tabbable">

	<h3 class="header smaller lighter blue" id="title"></h3>
	<form id="frmDataPreinscripcion" role="form">

	<div class="row-fluid">
		<div class="span10">
			<div class="widget-box pricing-box">
				<div class="widget-header header-color-dark">
					<h5 class="bigger lighter">DATOS PERSONALES DEL ALUMNO(A)</h5>
				</div>

				<div class="widget-body">
					<div class="widget-main">
					 
					 <table>
					 	<tr>
					 		<td class="span3"><label for="ap_paterno_alumno">Apellido Paterno</label> </td>
					 		<td class="span6">
					 			<input class="w96 altoMoz" type="text" id="ap_paterno_alumno" name="ap_paterno_alumno"/>
					 			<!-- <p class="text-danger">Error</p> -->
					 		</td>
					 	</tr>
					 	<tr>
					 		<td><label for="ap_materno_alumno">Apellido Materno</label> </td>
					 		<td><input class="w96 altoMoz" type="text" id="ap_materno_alumno" name="ap_materno_alumno"/></td>
					 	</tr>
					 	<tr>
					 		<td><label for="nombre_alumno">Nombre</label> </td>
					 		<td><input class="w96 altoMoz" type="text" id="nombre_alumno" name="nombre_alumno"/></td>
					 	</tr>
					 	<tr>
					 		<td><label for="curp_alumno">CURP</label> </td>
					 		<td><input class="w96 altoMoz" type="text" id="curp_alumno" name="curp_alumno"/></td>
					 	</tr>
					 	<tr>
					 		<td><label for="grado_cursara">Grado que cursará</label> </td>
					 		<td><input class="w96 altoMoz" type="text" id="grado_cursara" name="grado_cursara"/></td>
					 	</tr>
					 	<tr>
					 		<td><label for="ciclo_escolar">Ciclo Escolar</label> </td>
					 		<td><input class="w96 altoMoz" type="text" id="ciclo_escolar" name="ciclo_escolar"/></td>
					 	</tr>
					 	<tr>
					 		<td><label for="genero_alumno">Es Hombre?</label> </td>
					 		<td>
								<label>
									<input id="genero_alumno" name="genero_alumno" class="ace ace-switch ace-switch-2" type="checkbox">
									<span class="lbl"></span>
								</label>
							</td>
					 	</tr>
					 	<tr>
					 		<td><label for="fecha_ingreso">Fecha Ingreso</label> </td>
					 		<td><input id="fecha_ingreso" name="fecha_ingreso"  class="w96 altoMoz" type="text" /></td>
					 	</tr>
					 	<tr>
					 		<td><label for="edad_septiembre">Edad al 1ro de Sept.</label> </td>
					 		<td><input id="edad_septiembre" name="edad_septiembre"  class="w96 altoMoz" type="text" /></td>
					 	</tr>
					 	<tr>
					 		<td><label for="lugar_nacimiento_alumno">Lugar de Nacimiento</label> </td>
					 		<td><input id="lugar_nacimiento_alumno" name="lugar_nacimiento_alumno"  class="w96 altoMoz" type="text" /></td>
					 	</tr>
					 	<tr>
					 		<td><label for="fecha_nacimiento_alumno">Fecha Nacimiento</label> </td>
					 		<td><input id="fecha_nacimiento_alumno" name="fecha_nacimiento_alumno"  class="w96 altoMoz" type="text" /></td>
					 	</tr>
					 	<tr>
					 		<td><label for="enfermedades">Enfermedad</label> </td>
					 		<td><input id="enfermedades" name="enfermedades"  class="w96 altoMoz" type="text" /></td>
					 	</tr>
					 	<tr>
					 		<td><label for="reacciones_alergicas">Reaciones Alérgicas</label> </td>
					 		<td><input id="reacciones_alergicas" name="reacciones_alergicas"  class="w96 altoMoz" type="text" /></td>
					 	</tr>
					 	<tr>
					 		<td><label for="tipo_sangre">Tipo de Sangre</label> </td>
					 		<td><input id="tipo_sangre" name="tipo_sangre"  class="w96 altoMoz" type="text" /></td>
					 	</tr>
					 	<tr>
					 		<td><label for="app_medico">Ap. Paterno Médico</label> </td>
					 		<td><input id="app_medico" name="app_medico"  class="w96 altoMoz" type="text" /></td>
					 	</tr>
					 	<tr>
					 		<td><label for="apm_medico">Ap. Materno Médico</label> </td>
					 		<td><input id="apm_medico" name="apm_medico"  class="w96 altoMoz" type="text" /></td>
					 	</tr>
					 	<tr>
					 		<td><label for="nombre_medico">Nombre Médico</label> </td>
					 		<td><input id="nombre_medico" name="nombre_medico"  class="w96 altoMoz" type="text" /></td>
					 	</tr>
					 	<tr>
					 		<td><label for="telefono_medico">Teléfono Médico</label> </td>
					 		<td><input id="telefono_medico" name="telefono_medico"  class="w96 altoMoz" type="text" /></td>
					 	</tr>
					 	<tr>
					 		<td><label for="especialidad_medico">Especialidad Médico</label> </td>
					 		<td><input id="especialidad_medico" name="especialidad_medico"  class="w96 altoMoz" type="text" /></td>
					 	</tr>

					 </table>

					</div>
				</div>
			</div>
		</div>	
	</div>	

	<div class="row-fluid">
		<div class="span10">
			<div class="widget-box pricing-box">
				<div class="widget-header header-color-dark">
					<h5 class="bigger lighter">TELEFONOS DE EMERGENCIA</h5>
				</div>

				<div class="widget-body">
					<div class="widget-main">
					 <table>
					 	<tr>
					 		<td class="span1"><label for="nombre_emergencia">Nombre</label> </td>
					 		<td><input id="nombre_emergencia" name="nombre_emergencia" class="w96 altoMoz" type="text"/></td>
					 		<td class="span1"><label for="tel_emergencia">Teléfono</label> </td>
					 		<td><input id="tel_emergencia" name="tel_emergencia" class="w96 altoMoz" type="text"/></td>
					 		<td class="span1"><label for="parentezco_emergencia">Parentesco</label> </td>
					 		<td><input id="parentezco_emergencia" name="parentezco_emergencia" class="w96 altoMoz" type="text"/></td>
					 	</tr>
					 	<tr>
					 		<td><label for="nombre_emergencia1">Nombre</label> </td>
					 		<td><input id="nombre_emergencia1" name="nombre_emergencia1" class="w96 altoMoz" type="text"/></td>
					 		<td><label for="tel_emergencia1">Teléfono</label> </td>
					 		<td><input id="tel_emergencia1" name="tel_emergencia1" class="w96 altoMoz" type="text"/></td>
					 		<td><label for="parentezco_emergencia1">Parentesco</label> </td>
					 		<td><input id="parentezco_emergencia1" name="parentezco_emergencia1" class="w96 altoMoz" type="text"/></td>
					 	</tr>
					 </table>
					</div>
				</div>
			</div>
		</div>	
	</div>	

	<div class="row-fluid">
		<div class="span10">
			<div class="widget-box pricing-box">
				<div class="widget-header header-color-pink">
					<h5 class="bigger lighter">DATOS DE LA MADRE O TUTORA</h5>
				</div>

				<div class="widget-body">
					<div class="widget-main">
						 <table>
						 	<tr>
						 		<td class="span3"><label for="ap_paterno_madre">Apellido Paterno</label> </td>
						 		<td class="span6"><input id="ap_paterno_madre" name="ap_paterno_madre"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="ap_materno_madre">Apellido Materno</label> </td>
						 		<td><input id="ap_materno_madre" name="ap_materno_madre"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="nombre_madre">Nombre</label> </td>
						 		<td><input id="nombre_madre" name="nombre_madre"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="curp_madre">CURP</label> </td>
						 		<td><input id="curp_madre" name="curp_madre"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="fecha_nacimiento_madre">Fecha Nacimiento</label> </td>
						 		<td><input id="fecha_nacimiento_madre" name="fecha_nacimiento_madre"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="lugar_nacimiento_madre">Lugar de Nacimiento</label> </td>
						 		<td><input id="lugar_nacimiento_madre" name="lugar_nacimiento_madre"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="ocupacion_madre">Ocupación</label> </td>
						 		<td><input id="ocupacion_madre" name="ocupacion_madre"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="lugar_trabajo_madre">Lugar de Trabajo</label> </td>
						 		<td><input id="lugar_trabajo_madre" name="lugar_trabajo_madre"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="domicilio_madre">Domicilio Particular</label> </td>
						 		<td><input id="domicilio_madre" name="domicilio_madre"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="telefono_casa_madre">Teléfono Casa</label> </td>
						 		<td><input id="telefono_casa_madre" name="telefono_casa_madre"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="telefono_celular_madre">Teléfono Celular</label> </td>
						 		<td><input id="telefono_celular_madre" name="telefono_celular_madre"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="telefono_oficina_madre">Teléfono Oficina</label> </td>
						 		<td><input id="telefono_oficina_madre" name="telefono_oficina_madre"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="email_madre">Email</label> </td>
						 		<td><input id="email_madre" name="email_madre"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="genero_madre">Es Mujer?</label> </td>
						 		<td>
									<label>
										<input id="genero_madre" name="genero_madre" class="ace ace-switch ace-switch-2" type="checkbox" checked>
										<span class="lbl"></span>
									</label>
								</td>
						 	</tr>
						 </table>
					</div>
				</div>
			</div>
		</div>	
	</div>	

	<div class="row-fluid">
		<div class="span10">
			<div class="widget-box pricing-box">
				<div class="widget-header header-color-blue">
					<h5 class="bigger lighter">DATOS DEL PADRE O TUTOR</h5>
				</div>

				<div class="widget-body">
					<div class="widget-main">
						 <table>
						 	<tr>
						 		<td class="span3"><label for="ap_paterno_padre">Apellido Paterno</label> </td>
						 		<td class="span6"><input id="ap_paterno_padre" name="ap_paterno_padre"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="ap_materno_padre">Apellido Materno</label> </td>
						 		<td><input id="ap_materno_padre" name="ap_materno_padre"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="nombre_padre">Nombre</label> </td>
						 		<td><input id="nombre_padre" name="nombre_padre"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="curp_padre">CURP</label> </td>
						 		<td><input id="curp_padre" name="curp_padre"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="fecha_nacimiento_padre">Fecha Nacimiento</label> </td>
						 		<td><input id="fecha_nacimiento_padre" name="fecha_nacimiento_padre"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="lugar_nacimiento_padre">Lugar de Nacimiento</label> </td>
						 		<td><input id="lugar_nacimiento_padre" name="lugar_nacimiento_padre"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="ocupacion_padre">Ocupación</label> </td>
						 		<td><input id="ocupacion_padre" name="ocupacion_padre"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="lugar_trabajo_padre">Lugar de Trabajo</label> </td>
						 		<td><input id="lugar_trabajo_padre" name="lugar_trabajo_padre"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="domicilio_padre">Domicilio Particular</label> </td>
						 		<td><input id="domicilio_padre" name="domicilio_padre"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="telefono_casa_padre">Teléfono Casa</label> </td>
						 		<td><input id="telefono_casa_padre" name="telefono_casa_padre" class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="telefono_celular_padre">Teléfono Celular</label> </td>
						 		<td><input id="telefono_celular_padre" name="telefono_celular_padre"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="telefono_oficina_padre">Teléfono Oficina</label> </td>
						 		<td><input id="telefono_oficina_padre" name="telefono_oficina_padre"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="email_padre">Email</label> </td>
						 		<td><input id="email_padre" name="email_padre"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="genero_padre">Es Hombre?</label> </td>
						 		<td>
									<label>
										<input id="genero_padre" name="genero_padre" class="ace ace-switch ace-switch-2" type="checkbox" checked>
										<span class="lbl"></span>
									</label>
								</td>
						 	</tr>
						 </table>					
					</div>
				</div>
			</div>
		</div>	
	</div>	

	<div class="row-fluid">
		<div class="span10">
			<div class="widget-box pricing-box">
				<div class="widget-header header-color-dark">
					<h5 class="bigger lighter">QUIEN ES EL TUTOR</h5>
				</div>
				<div class="widget-body">
					<div class="widget-main">
					 <table>
					 	<tr>
					 		<td class="span3"><label for="quien_es_tutor">Quién es el Tutor?</label></td>
					 		<td class="span6">
					 			<select id="quien_es_tutor" name="quien_es_tutor" size="1" class="w96 altoMoz">
					 				<option value="0" selected>La Madre</option>
					 				<option value="1">El Padre</option>
					 				<option value="2">Otro</option>
					 			</select>
					 		</td>
					 	</tr>
					 </table>
					 <table>
					 	<tr>
					 		<td class="span2"><label for="nombre_otro_tutor">Nombre otro Tutor</label> </td>
					 		<td><input id="nombre_otro_tutor" name="nombre_otro_tutor" class="w96 altoMoz" type="text"/></td>
					 		<td class="span3"><label for="parentezco_otro_tutor">Parentesco otro Tutor</label> </td>
					 		<td><input id="parentezco_otro_tutor" name="parentezco_otro_tutor" class="w96 altoMoz" type="text"/></td>
					 		<td class="span2"><label for="telefono_otro_tutor">Teléfono otro Tutor</label> </td>
					 		<td><input id="telefono_otro_tutor" name="telefono_otro_tutor" class="w96 altoMoz" type="text"/></td>
					 	</tr>
					 </table>
					</div>
				</div>
			</div>
		</div>	
	</div>

	<div class="row-fluid">
		<div class="span10">
			<div class="widget-box pricing-box">
				<div class="widget-header header-color-default">
					<h5 class="bigger lighter dark">DATOS DE INTERES</h5>
				</div>

				<div class="widget-body">
					<div class="widget-main">
						<table>
						 	<tr>
						 		<td class="span4"><label for="colegio_procede">Colegio del que Procede</label> </td>
						 		<td class="span5"><input id="colegio_procede" name="colegio_procede"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="bilingue">Bilingüe?</label> </td>
						 		<td>
									<label>
										<input id="bilingue" name="bilingue" class="ace ace-switch ace-switch-2" type="checkbox">
										<span class="lbl"></span>
									</label>
								</td>
						 	</tr>
						 	<tr>
						 		<td><label for="idioma_2">Segundo Idioma</label> </td>
						 		<td><input id="idioma_2" name="idioma_2"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="tiene_hermanos">Tiene hermanos en esta escuela?</label> </td>
						 		<td>
									<label>
										<input id="tiene_hermanos" name="tiene_hermanos" class="ace ace-switch ace-switch-2" type="checkbox">
										<span class="lbl"></span>
									</label>
								</td>
						 	</tr>
						 	<tr>
						 		<td><label for="grado_hermanos">Grado de sus hermanos</label> </td>
						 		<td><input id="grado_hermanos" name="grado_hermanos"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="tuvo_hermanos">Tuvo hermanos en años anteriores?</label> </td>
						 		<td>
									<label>
										<input id="tuvo_hermanos" name="tuvo_hermanos" class="ace ace-switch ace-switch-2" type="checkbox">
										<span class="lbl"></span>
									</label>
								</td>
						 	</tr>
						 	<tr>
						 		<td><label for="ciclo_hermanos">Ciclo escolar de sus hermanos</label> </td>
						 		<td><input id="ciclo_hermanos" name="ciclo_hermanos"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="hijo_exalumno">Es hijo de Exalumno?</label> </td>
						 		<td>
									<label>
										<input id="hijo_exalumno" name="hijo_exalumno" class="ace ace-switch ace-switch-2" type="checkbox">
										<span class="lbl"></span>
									</label>
								</td>
						 	</tr>
						 	<tr>
						 		<td><label for="quien_recomienda">Quién lo recomienda?</label> </td>
						 		<td><input id="quien_recomienda" name="quien_recomienda"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="recomienda_hijos">Persona que recomienda, tiene hijos en el colegio?</label> </td>
						 		<td>
									<label>
										<input id="recomienda_hijos" name="recomienda_hijos" class="ace ace-switch ace-switch-2" type="checkbox">
										<span class="lbl"></span>
									</label>
								</td>
						 	</tr>
						 	<tr>
						 		<td><label for="porque_eligio">Por qué eligió este colegio?</label> </td>
						 		<td><input id="porque_eligio" name="porque_eligio"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						</table>					
					</div>
				</div>
			</div>
		</div>	
	</div>	

	<div class="row-fluid">
		<div class="span10">
			<div class="widget-box pricing-box">
				<div class="widget-header header-color-red">
					<h5 class="bigger lighter">DATOS FISCALES</h5>
				</div>

				<div class="widget-body">
					<div class="widget-main">
						<table>
						 	<tr>
						 		<td class="span4"><label for="razon_social_fiscal">Razón Social</label> </td>
						 		<td class="span5"><input id="razon_social_fiscal" name="razon_social_fiscal"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="rfc_fiscal">R.F.C.</label> </td>
						 		<td><input id="rfc_fiscal" name="rfc_fiscal"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="curp_fiscal">CURP</label> </td>
						 		<td><input id="curp_fiscal" name="curp_fiscal"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="calle_fiscal">Calle</label> </td>
						 		<td><input id="calle_fiscal" name="calle_fiscal"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="num_ext_fiscal">Número Exterior</label> </td>
						 		<td><input id="num_ext_fiscal" name="num_ext_fiscal"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="num_int_fiscal">Número Interior</label> </td>
						 		<td><input id="num_int_fiscal" name="num_int_fiscal"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="colonia_fiscal">Colonia</label> </td>
						 		<td><input id="colonia_fiscal" name="colonia_fiscal"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="localidad_fiscal">Localidad</label> </td>
						 		<td><input id="localidad_fiscal" name="localidad_fiscal"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="estado_fiscal">Estado</label> </td>
						 		<td><input id="estado_fiscal" name="estado_fiscal"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="pais_fiscal">País</label> </td>
						 		<td><input id="pais_fiscal" name="pais_fiscal"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="cp_fiscal">Código Postal</label> </td>
						 		<td><input id="cp_fiscal" name="cp_fiscal"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="tel1_fiscal">Teléfono</label> </td>
						 		<td><input id="tel1_fiscal" name="tel1_fiscal"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						 	<tr>
						 		<td><label for="email1_fiscal">E-Mail</label> </td>
						 		<td><input id="email1_fiscal" name="email1_fiscal"  class="w96 altoMoz" type="text" /></td>
						 	</tr>
						</table>					
					</div>
				</div>
			</div>
		</div>	
	</div>	


	<div class="row-fluid">
		<div class="span10">		
		    <input type="hidden" name="idpreinscripcion" id="idpreinscripcion" value="<?php echo $idpreinscripcion; ?>">
		    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
		    <div class="form-group">
		    	<button type="button" class="btn btn-large btn-danger pull-right" id="closeFormUpload"><i class="icon-ban-circle bigger-110"></i>Cerrar</button>
		    	<span class="muted"></span>
		    	<button type="submit" class="btn btn-large btn-success pull-right" style='margin-right: 4em;'><i class="icon-ok bigger-110"></i>Guardar</button>
	
		    	<button type="button" class="btn btn-large btn-primary left-right" id="cmdPrint"><i class="icon-print  bigger-110"></i>Imprimir</button>
			</div>
		</div>	
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

	$("#clave").focus();

	var idpreinscripcion = <?= $idpreinscripcion ?>;

	if (idpreinscripcion<=0){ // Nuevo Registro
		$("#title").html("Nuevo registro");
	}else{ // Editar Registro
		$("#title").html("Editando el registro: "+idpreinscripcion);
		getPreinscripcion(idpreinscripcion);
	}

	$("#ap_paterno_alumno").focus();

	function getPreinscripcion(IdPreinscripcion){
		var nc = "u="+localStorage.nc+"&idpreinscripcion="+IdPreinscripcion;
		$.post(obj.getValue(0) + "data/", {o:54, t:29, c:nc, p:54, from:0, cantidad:0,s:''},
			function(json){
				if (json.length>0){

					$("#ap_paterno_alumno").val( json[0].ap_paterno_alumno );
					$("#ap_materno_alumno").val( json[0].ap_materno_alumno );
					$("#nombre_alumno").val( json[0].nombre_alumno );
					$("#grado_cursara").val( json[0].grado_cursara );
					$("#ciclo_escolar").val( json[0].ciclo_escolar );
					$("#edad_septiembre").val( json[0].edad_septiembre );
					$("#fecha_nacimiento_alumno").val( json[0].fecha_nacimiento_alumno );
					$("#fecha_ingreso").val( json[0].fecha_ingreso );
					$("#lugar_nacimiento_alumno").val( json[0].lugar_nacimiento_alumno );
					$("#curp_alumno").val( json[0].curp_alumno ); 
					$("#enfermedades").val( json[0].enfermedades );
					$("#reacciones_alergicas").val( json[0].reacciones_alergicas );
					$("#tipo_sangre").val( json[0].tipo_sangre );
					$("#app_medico").val( json[0].app_medico );
					$("#apm_medico").val( json[0].apm_medico );
					$("#nombre_medico").val( json[0].nombre_medico );
					$("#especialidad_medico").val( json[0].especialidad_medico );
					$("#telefono_medico").val( json[0].telefono_medico );
					$("#ap_paterno_padre").val( json[0].ap_paterno_padre );
					$("#ap_materno_padre").val( json[0].ap_materno_padre );
					$("#nombre_padre").val( json[0].nombre_padre );
					$("#curp_padre").val( json[0].curp_padre );
					$("#fecha_nacimiento_padre").val( json[0].fecha_nacimiento_padre );
					$("#lugar_nacimiento_padre").val( json[0].lugar_nacimiento_padre );
					$("#ocupacion_padre").val( json[0].ocupacion_padre );
					$("#lugar_trabajo_padre").val( json[0].lugar_trabajo_padre );
					$("#domicilio_padre").val( json[0].domicilio_padre );
					$("#telefono_casa_padre").val( json[0].telefono_casa_padre );
					$("#telefono_celular_padre").val( json[0].telefono_celular_padre );
					$("#telefono_oficina_padre").val( json[0].telefono_oficina_padre );
					$("#email_padre").val( json[0].email_padre );
					$("#ap_paterno_madre").val( json[0].ap_paterno_madre );
					$("#ap_materno_madre").val( json[0].ap_materno_madre );
					$("#nombre_madre").val( json[0].nombre_madre );
					$("#curp_madre").val( json[0].curp_madre );
					$("#fecha_nacimiento_madre").val( json[0].fecha_nacimiento_madre );
					$("#lugar_nacimiento_madre").val( json[0].lugar_nacimiento_madre );
					$("#ocupacion_madre").val( json[0].ocupacion_madre );
					$("#lugar_trabajo_madre").val( json[0].lugar_trabajo_madre );
					$("#domicilio_madre").val( json[0].domicilio_madre );
					$("#telefono_casa_madre").val( json[0].telefono_casa_madre );
					$("#telefono_celular_madre").val( json[0].telefono_celular_madre );
					$("#telefono_oficina_madre").val( json[0].telefono_oficina_madre );
					$("#email_madre").val( json[0].email_madre );
					$("#nombre_emergencia").val( json[0].nombre_emergencia );
					$("#tel_emergencia").val( json[0].tel_emergencia );
					$("#parentezco_emergencia").val( json[0].parentezco_emergencia );
					$("#nombre_emergencia1").val( json[0].nombre_emergencia1 );
					$("#tel_emergencia1").val( json[0].tel_emergencia1 );
					$("#parentezco_emergencia1").val( json[0].parentezco_emergencia1 );
					$("#colegio_procede").val( json[0].colegio_procede );
					$("#idioma_2").val( json[0].idioma_2 );
					$("#grado_hermanos").val( json[0].grado_hermanos );
					$("#ciclo_hermanos").val( json[0].ciclo_hermanos );
					$("#quien_recomienda").val( json[0].quien_recomienda );
					$("#porque_eligio").val( json[0].porque_eligio );
					$("#rfc_fiscal").val( json[0].rfc_fiscal );
					$("#curp_fiscal").val( json[0].curp_fiscal );
					$("#razon_social_fiscal").val( json[0].razon_social_fiscal );
					$("#calle_fiscal").val( json[0].calle_fiscal );
					$("#num_ext_fiscal").val( json[0].num_ext_fiscal );
					$("#num_int_fiscal").val( json[0].num_int_fiscal );
					$("#colonia_fiscal").val( json[0].colonia_fiscal );
					$("#localidad_fiscal").val( json[0].localidad_fiscal );
					$("#estado_fiscal").val( json[0].estado_fiscal );
					$("#pais_fiscal").val( json[0].pais_fiscal );
					$("#cp_fiscal").val( json[0].cp_fiscal );
					$("#email1_fiscal").val( json[0].email1_fiscal );
					$("#tel1_fiscal").val( json[0].tel1_fiscal );
					$("#quien_es_tutor").val( json[0].quien_es_tutor );
					$("#nombre_otro_tutor").val( json[0].nombre_otro_tutor );
					$("#parentezco_otro_tutor").val( json[0].parentezco_otro_tutor );
					$("#telefono_otro_tutor").val( json[0].telefono_otro_tutor );

					$("#genero_alumno").prop("checked",json[0].genero_alumno==1?true:false); 
					$("#genero_padre").prop("checked",json[0].genero_padre==1?true:false);
					$("#genero_madre").prop("checked",json[0].genero_madre==1?true:false);
//					$("#quien_es_tutor").prop("checked",json[0].quien_es_tutor==1?true:false);
					$("#bilingue").prop("checked",json[0].bilingue==1?true:false);
					$("#tiene_hermanos").prop("checked",json[0].tiene_hermanos==1?true:false);
					$("#tuvo_hermanos").prop("checked",json[0].tuvo_hermanos==1?true:false);
					$("#hijo_exalumno").prop("checked",json[0].hijo_exalumno==1?true:false);
					$("#recomienda_hijos").prop("checked",json[0].recomienda_hijos==1?true:false);


				}
		},'json');
	}

    $("#frmDataPreinscripcion").unbind("submit");
	$("#frmDataPreinscripcion").on("submit",function(event){
		event.preventDefault();

		$("#preloaderPrincipal").show();

	    var queryString = $("#frmDataPreinscripcion").serialize();	
	    
	    //alert(queryString)
	    // return false;

		var data = new FormData();

		if (validForm()){
			var IdPreinscripcion = (idpreinscripcion==0?0:1)
            $.post(obj.getValue(0) + "data/", {o:54, t:IdPreinscripcion, c:queryString, p:57, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Datos guardados con éxito.");
						// stream.emit("cliente", {mensaje: "PLATSOURCE-PREINSCRIPCIONES-PROP-"+IdPreinscripcion});
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
		
/*
		if ($("#color").val().length <= 0) {
			alert("Faltan el Color");
			$("#color").focus();
			return false;
		}

		if ($("#codigo_color_hex").val().length <= 0) {
			alert("Faltan el Código en Hexagésimal");
			$("#codigo_color_hex").focus();
			return false;
		}
*/

		return true;

	}

	$("#cmdPrint").on("click",function(event){
		event.preventDefault();

		var logoPreinscripcion = obj.getConfig(103,0); 
        var url;

		var nc = "u="+localStorage.nc+
				"&idpreinscripcion="+idpreinscripcion+
				"&logoPreinscripcion="+logoPreinscripcion;

        var PARAMS = {o:54, t:29, c:nc, p:54, from:0, cantidad:0, s:''};

    	url = obj.getValue(0)+"preinscripcion-pdf/";

        var temp=document.createElement("form");
        temp.action=url;
        temp.method="POST";
        temp.target="_blank";
        temp.style.display="none";
        for(var x in PARAMS) {
            var opt=document.createElement("textarea");
            opt.name=x;
            opt.value=PARAMS[x];
            temp.appendChild(opt);
        }
        document.body.appendChild(temp);
        temp.submit();
        return temp;

	});

});

</script>
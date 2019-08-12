<?php

include("includes/metas.php");

$user = $_POST['user'];
$idgrupo  = $_POST['idgrupo'];
$grupo = $_POST['grupo'];
$gradox = $_POST['gradox'];
$idciclo = $_POST['idciclo'];
?>

<div class="widget-box span10" id="wgtPrinc0">

	<div class="widget-header widget-header-flat">
		<h3 class="grey lighter  pull-left position-relative wd100prc">
			<i class="icon-leaf green"></i>
			Qué desea hacer?
			<a class="label label-info arrowed-in-right arrowed btnClose closeFormGenListaGruAlu0 pull-right" >Regresar</a>
		</h3>
	</div>

	<div class="widget-body">
		<div class="widget-main">
			<div class="row-fluid">

			<p>
				<br/>
 				<a href="#" class="link link-info"  id="printBolCalGruAlu0">
					<i class="icon-print  bigger-125 icon-on-left"></i>
					Imprimir Boletas Internas<br/>
					<small >
						<a href="#" class="link  lighter grey marginLeft2em" id="prepareCal">Preparar calificaciones a imprimir</a>
						<i id="spnwork0" class="lighter grey marginLeft2em">Preparando las Boletas, por favor, espere...</i>
					</small>
				</a>
				<br/>				
				<div id="boling0">
	 				<a href="#" class="link link-info"  id="boling00">
						<i class="icon-print  bigger-125 icon-on-left"></i>
						Imprimir Boletas Internas Inglés<br/>
					</a>
					<br/>										
				</div>
				<div id="listadosKinderArji0">

					<div class="well">
						
						<select id="numeval-1" name="numeval-1" size="1">
							<option value="0" selected>Todas las Evaluaciones</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
						</select>
						<br/>
		 				<a href="#" class="link link-info"  id="lista-calif-kinder-esp-interna-arji-xls-1">
							<i class="icon-print  bigger-125 icon-on-left"></i>
							Listado Calificaciones Español<br/>
						</a>
						<br/>
		 				<a href="#" class="link link-info"  id="lista-calif-kinder-ing-interna-arji-xls-1">
							<i class="icon-print  bigger-125 icon-on-left"></i>
							Listado Calificaciones Inglés<br/>
						</a>
						<br/>
		 				<a href="#" class="link link-info"  id="lista-prom-calif-kinder-esp-interna-arji-xls-1">
							<i class="icon-print  bigger-125 icon-on-left"></i>
							Listado de Promedio de Calificaciones Internas<br/>
						</a>
					</div>	

				</div>
				<div id="listadosPrimariaArji0">

					<select id="numeval0" name="numeval0" size="1">
						<option value="0" selected>Todas las Evaluaciones</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
					</select>

					<div class="well">

		 				<a href="#" class="link link-info"  id="lista-calif-primaria-esp-interna-arji-xls-1">
							<i class="icon-print  bigger-125 icon-on-left"></i>
							Listado Calificaciones Internas Español<br/>
						</a>
						<br/>
		 				<a href="#" class="link link-info"  id="lista-calif-primaria-ing-interna-arji-xls-1">
							<i class="icon-print  bigger-125 icon-on-left"></i>
							Listado Calificaciones Internas Inglés<br/>
						</a>
						<br/>
		 				<a href="#" class="link link-info"  id="lista-prom-calif-primaria-esp-interna-arji-xls-1">
							<i class="icon-print  bigger-125 icon-on-left"></i>
							Listado de Promedio de Calificaciones Internas<br/>
						</a>

					</div>

		 				<div class="well">
							<a href="#" class="link link-info"  id="printBolCalGruAlu1">
								<i class="icon-print  bigger-125 icon-on-left"></i>
								Imprimir Boletas Oficiales lado A
							</a><br/><br/>
							<a href="#" class="link link-info"  id="printBolCalGruAlu2">
								<i class="icon-print  bigger-125 icon-on-left"></i>
								Imprimir Boletas Oficiales lado B
							</a><br/><br/>

			 				<a href="#" class="link link-info"  id="lista-calif-primaria-esp-oficial-arji-xls-1">
								<i class="icon-print  bigger-125 icon-on-left"></i>
								Listado Calificaciones Oficiales<br/>
							</a>
							<br/>
							
						</div>	
	
				</div>

				<div id="listadosSecundariaArji0">
	 				<a href="#" class="link link-info"  id="lista-calif-secund-esp-interna-arji-xls-1">
						<i class="icon-print  bigger-125 icon-on-left"></i>
						Listado Calificaciones Español<br/>
					</a>
					<br/>
	 				<a href="#" class="link link-info"  id="lista-calif-secund-ing-interna-arji-xls-1">
						<i class="icon-print  bigger-125 icon-on-left"></i>
						Listado Calificaciones Inglés<br/>
					</a>
					<br/>

		 				<div class="well">
							<a href="#" class="link link-info"  id="printBolCalGruAlu3">
								<i class="icon-print  bigger-125 icon-on-left"></i>
								Imprimir Boletas Oficiales lado A
							</a><br/><br/>
							<a href="#" class="link link-info"  id="printBolCalGruAlu4">
								<i class="icon-print  bigger-125 icon-on-left"></i>
								Imprimir Boletas Oficiales lado B
							</a><br/><br/>

			 				<a href="#" class="link link-info"  id="lista-calif-secundaria-oficial-arji-xls-2">
								<i class="icon-print  bigger-125 icon-on-left"></i>
								Listado Calificaciones Oficiales<br/>
							</a><br/>

			 				<a href="#" class="link link-info"  id="lista-ina-secu-of-arji-xls-1">
								<i class="icon-print  bigger-125 icon-on-left"></i>
								Listado Inasistencias Oficiales<br/>
							</a><br/>

							<div class="control-group">
								<label class="control-label" for="form-field-1"><i class="icon-print grey bigger-125 icon-on-left"></i>Promedios por Materia</label>
								<div class="controls">
									<select id="idmateria" name="idmateria" size="1"></select>
									<span class="separatorSpan"></span>
									<a href="#" class="link link-info inline" id="lista-promedios-secundaria-interna-arji-pdf-1">Visualizar
									</a>
									<span class="separatorSpan"></span>
									<a href="#" class="link link-info inline" id="lista-promedios-secundaria-interna-arji-pdf-2">Visualizar Oficial
									</a>
								</div>
							</div>
							<br/>

							<div class="control-group">
								<label class="control-label" for="form-field-1">Actas Oficiales</label>
								<div class="controls">
									<select id="idmateria-acta-oficial-sec-arji" name="idmateria-acta-oficial-sec-arji" size="1"></select>
									<span class="separatorSpan"></span>
									<a href="#" class="link link-info inline" id="lista-actas-secundaria-oficial-arji-pdf-1">Visualizar</a>
								</div>
							</div>


							<br/>
							
						</div>	


				</div>


				<div id="listadosPrepaArji0">
	 				
	 				<a href="#" class="link link-info"  id="lista-calif-prepa-interna-arji-xls-1">
						<i class="icon-print  bigger-125 icon-on-left"></i>
						Listado Calificaciones Internas<br/>
					</a>
					<br/>
	 				<a href="#" class="link link-info"  id="lista-asist-prepa-interna-arji-xls-1">
						<i class="icon-print  bigger-125 icon-on-left"></i>
						Listado Inasistencias<br/>
					</a>
					<br/>
					<div class="control-group">
						<label class="control-label" for="form-field-1"><i class="icon-print grey bigger-125 icon-on-left"></i>Promedios por Materia</label>
						<div class="controls">
							<select id="idmateria-prepa" name="idmateria-prepa" size="1"></select>
							<span class="separatorSpan"></span>
							<a href="#" class="link link-info inline" id="lista-promedios-prepa-interna-arji-pdf-1">Visualizar-</a>
						</div>
					</div>
					<br/>
	 				<div class="well">
						<a href="#" class="link link-info"  id="printBolCalGruAlu1">
							<i class="icon-print  bigger-125 icon-on-left"></i>
							Imprimir Boletas Oficiales<br/>
						</a><br/>

						<div class="control-group">
							<label class="control-label" for="form-field-1">Actas Oficiales</label>
							<div class="controls">
								<select id="idmateria-acta-oficial" name="idmateria-acta-oficial" size="1"></select>
								<span class="separatorSpan"></span>
								<a href="#" class="link link-info inline" id="lista-actas-prepa-oficial-arji-pdf-1">Visualizar</a>
							</div>
						</div>

					</div>	
					<br/>


				</div>
 				<a href="#" class="link link-info"  id="btnVerListAlu0">
					<i class="icon-eye-open bigger-125 icon-on-left"></i>
					Ver Lista de Alumnos
				</a>
				<br/><br/>				
 				<a href="#" class="link link-info hide"  id="btnOcultarListAlu0">
					<i class="icon-eye-close bigger-125 icon-on-left"></i>
					Ocultar Lista de Alumnos
				</a>				
			</p>

			</div>
		</div>
	</div>
</div>		

<div class="widget-box span6 hide" id="span6Hide">
	<div class="widget-header widget-header-flat">
		<h4>Listado de Alumnos</h4>
	</div>

	<div class="widget-body">
		<div class="widget-main">
			<div class="row-fluid">

				<table id="tblGenNumListaPorGrupo" class="bordered">
					<thead>
						<th>Núm.</th>
						<th>Nombre Completo</th>
					</thead>
					<tbody></tbody>
				</table>			

				
			</div>
		</div>
	</div>
</div>		


<script typy="text/javascript">        

jQuery(function($) {

	// var stream = io.connect(obj.getValue(4));
	var arrItem = [];

	$("#preloaderPrincipal").hide();
	$("#spnwork0").hide();

	$("#boling0").hide();
	$("#listadosPrepaArji0").hide();

	$("#listadosSecundariaArji0").hide();
	
	$("#listadosPrimariaArji0").hide();

	$("#listadosKinderArji0").hide();

	var Grupo = '<?php echo $grupo; ?>';

	var idgrupo = <?php echo $idgrupo ?>;
	var Gradox = <?php echo $gradox ?>;
	var IdGruMat = 0;
	var strGruAlu = "";
	var IdCiclo = <?= $idciclo ?>;

	getGrupo(idgrupo);


	function getGrupo(IdGrupo){
		$("#tblGenNumListaPorGrupo > tbody").html('');
		var nc = "u="+localStorage.nc+"&idgrupo="+IdGrupo+"&idciclo="+IdCiclo;
		arrItem = [];
		$.post(obj.getValue(0) + "data/", {o:1, t:57, c:nc, p:0, from:0, cantidad:0,s:''},
			function(json){
				$.each(json, function(i, item) {
					arrItem[i] = {alumno:item.label, idgrualu:item.data, num_lista:item.num_lista, clave_nivel:item.clave_nivel};

					var xs = "<tr>";
							xs += "<td>"+item.num_lista+"</td>";
							xs += "<td>"+item.label+"</td>";
							strGruAlu += strGruAlu == ''?item.data:','+item.data;
						xs += "<tr>";
					$("#tblGenNumListaPorGrupo > tbody").append(xs);
					if (parseInt(arrItem[0].clave_nivel,0)==1){
						$("#boling0").show();
						$("#listadosKinderArji0").show();
				    }
					if (parseInt(arrItem[0].clave_nivel,0)==5){
						$("#listadosPrepaArji0").show();
				    }
					if (parseInt(arrItem[0].clave_nivel,0)==4){
						$("#listadosSecundariaArji0").show();
				    }
					if (parseInt(arrItem[0].clave_nivel,0)==2 || parseInt(arrItem[0].clave_nivel,0)==3){
						$("#listadosPrimariaArji0").show();
				    }

				});

				if ($("#listadosPrepaArji0").length > 0 ) {
					getMatPromPrep0(idgrupo);
					getActaMatPrepa0(idgrupo);
				}


				if ($("#listadosSecundariaArji0").length > 0 ) {
					getMatPromSec0(idgrupo);
					getActaMatSecundaria0(idgrupo);
				}

				$("#preloaderPrincipal").hide();
		},'json');
	}

	$(".closeFormGenListaGruAlu0").on("click",function(event){
        event.preventDefault();
        $("#preloaderPrincipal").hide();
        $("#contentLevel3").hide(function(){
            $("#contentLevel3").html("");
            $("#contentProfile").show();
        });
        resizeScreen();
        return false;
	});

	$("#prepareCal").on("click",function(event){
		event.preventDefault();

		var xquestion = confirm("Este proceso puede dudar algunos minutos, desea continuar?");

		console.log(xquestion);

		if (!xquestion){
			return false;
		}

		$("#preloaderPrincipal").show();
		$("#spnwork0").show();
		$("#prepareCal").hide();
		var nc = "user="+localStorage.nc+"&strgrualu="+strGruAlu+"&grado="+Gradox+"&idciclo="+IdCiclo;
		//alert(nc);
        var PARAMS = {o:0, t:40, c:nc, p:10, from:0, cantidad:0, s:' order by orden_impresion asc '};
        if (parseInt(arrItem[0].clave_nivel,0)==5){
        	url = obj.getValue(0)+"prepara-calif-prepa-interna-arji/";
        }else if (parseInt(arrItem[0].clave_nivel,0)==4){
        	url = obj.getValue(0)+"prepara-calif-secundaria-interna-arji/";
        }else if (parseInt(arrItem[0].clave_nivel,0)==2){
        	url = obj.getValue(0)+"prepara-calif-primaria-interna-arji/";
        }else if (parseInt(arrItem[0].clave_nivel,0)==3){
        	url = obj.getValue(0)+"prepara-calif-primaria-interna-arji/";
        }else if (parseInt(arrItem[0].clave_nivel,0)==1){
        	url = obj.getValue(0)+"prepara-calif-kinder-interna-arji/";
        }else{
			$("#preloaderPrincipal").hide();
			$("#spnwork0").hide();
			$("#prepareCal").show();
        	alert("Boleta en Construcción");
        	return false;
        }
        $.post(url, PARAMS,
            function(json) {
				$("#preloaderPrincipal").hide();
				$("#spnwork0").hide();
				$("#prepareCal").show();
                if(json[0].msg=="OK"){
					alert("Datos actualizados con éxito!");
					return true;
                }else{
	                alert(json[0].msg);
	                return false;
                }
        }, "json")
        .fail(function(data) {
				$("#preloaderPrincipal").hide();
				$("#spnwork0").hide();
				$("#prepareCal").show();
				console.log(data.responseText);
				alert(data.responseText);
		});
	});



	$("#printBolCalGruAlu0").on("click",function(event){
		
		event.preventDefault();

		var logoEmp =obj.getConfig(100,0); 
		var logoIbo =obj.getConfig(100,1); 
        var url;

		var nc = "user="+localStorage.nc+"&strgrualu="+strGruAlu+
				"&logoEmp="+logoEmp+
				"&logoIbo="+logoIbo+
				"&idciclo="+IdCiclo+
				"&grado="+Gradox;
		
		// alert(nc);		
        
        var PARAMS = {o:0, t:40, c:nc, p:10, from:0, cantidad:0, s:' order by orden_impresion asc '};
        if (parseInt(arrItem[0].clave_nivel,0)==5){
        	url = obj.getValue(0)+"print-calif-prepa-interna-arji/";
        }else if (parseInt(arrItem[0].clave_nivel,0)==4){
        	url = obj.getValue(0)+"print-calif-secundaria-interna-arji/";
        }else if (parseInt(arrItem[0].clave_nivel,0)==2){
        	url = obj.getValue(0)+"print-calif-primaria-interna-arji/";
        }else if (parseInt(arrItem[0].clave_nivel,0)==3){
        	url = obj.getValue(0)+"print-calif-primaria-interna-arji/";
        }else if (parseInt(arrItem[0].clave_nivel,0)==1){
        	url = obj.getValue(0)+"print-calif-kinder-interna-arji-esp/";
        }else{
        	alert("Boleta en Construcción");
        	return false;
        }

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


	$("#boling00").on("click",function(event){
		
		event.preventDefault();

		var logoEmp =obj.getConfig(100,0); 
		var logoIbo =obj.getConfig(100,1); 
        var url;

		var nc = "user="+localStorage.nc+"&strgrualu="+strGruAlu+
				"&logoEmp="+logoEmp+
				"&logoIbo="+logoIbo+
				"&idciclo="+IdCiclo;

        var PARAMS = {o:0, t:40, c:nc, p:10, from:0, cantidad:0, s:' order by orden_impresion asc '};
		if (parseInt(arrItem[0].clave_nivel,0)==1){
        	url = obj.getValue(0)+"print-calif-kinder-interna-arji-ing/";
        }else{
        	alert("Boleta en Construcción");
        	return false;
        }

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

	$("#btnVerListAlu0").on("click", function(event){
		event.preventDefault();
		$("#wgtPrinc0").addClass('span6').fadeIn('slow');
		$("#wgtPrinc0").removeClass("span10");
		$("#btnOcultarListAlu0").removeClass('hide');
		$("#span6Hide").removeClass("hide");
		$(this).addClass('hide').fadeOut('slow');

	});

	$("#btnOcultarListAlu0").on("click", function(event){
		event.preventDefault();
		$("#wgtPrinc0").addClass('span10').fadeIn('slow');
		$("#wgtPrinc0").removeClass("span6");
		$("#span6Hide").addClass("hide").fadeOut('slow');
		$("#btnVerListAlu0").removeClass('hide');
		$(this).addClass('hide').fadeOut('slow');
	});


	$("#lista-calif-prepa-interna-arji-xls-1").on("click",function(event){
		event.preventDefault();
		printListados(event.currentTarget.id, -1);
		return false;
 	});

	$("#lista-asist-prepa-interna-arji-xls-1").on("click",function(event){
		event.preventDefault();
		printListados(event.currentTarget.id, -1);
		return false;
 	});

	$("#lista-calif-secund-esp-interna-arji-xls-1").on("click",function(event){
		event.preventDefault();
		printListados(event.currentTarget.id, -1);
		//return false;
 	});

	$("#lista-calif-secund-ing-interna-arji-xls-1").on("click",function(event){
		event.preventDefault();
		printListados(event.currentTarget.id, -1);
		//return false;
 	});

	$("#lista-calif-primaria-esp-interna-arji-xls-1").on("click",function(event){
		event.preventDefault();
		var numeval = parseInt( $("#numeval0").val(), 0   );
		var fmt = event.currentTarget.id;
		if (numeval != 0){
			fmt = "lista-calif-primaria-esp-interna-arji-xls-2";
		}
		printListados(fmt, numeval);
 	});

	$("#lista-calif-primaria-ing-interna-arji-xls-1").on("click",function(event){
		event.preventDefault();
		var numeval = parseInt( $("#numeval0").val(), 0   );
		var fmt = event.currentTarget.id;
		if (numeval != 0){
			fmt = "lista-calif-primaria-ing-interna-arji-xls-2";
		}
		printListados(fmt, numeval);
 	});

	$("#lista-prom-calif-kinder-esp-interna-arji-xls-1").on("click",function(event){
		event.preventDefault();
		var numeval = parseInt( $("#numeval-1").val(), 0   );
		var fmt = event.currentTarget.id;
		printListados(fmt, numeval);
 	});

	$("#lista-prom-calif-primaria-esp-interna-arji-xls-1").on("click",function(event){
		event.preventDefault();
		var numeval = parseInt( $("#numeval-1").val(), 0   );
		var fmt = event.currentTarget.id;
		printListados(fmt, numeval);
 	});

	$("#lista-calif-primaria-esp-oficial-arji-xls-1").on("click",function(event){
		event.preventDefault();
		var numeval = parseInt( $("#numeval0").val(), 0   );
		var fmt = event.currentTarget.id;
		if (numeval != 0){
			fmt = "lista-calif-primaria-esp-oficial-arji-xls-1";
		}
		printListados(fmt, numeval);
 	});


	$("#lista-calif-secundaria-oficial-arji-xls-2").on("click",function(event){
		event.preventDefault();
		var numeval = parseInt( $("#numeval0").val(), 0   );
		var fmt = event.currentTarget.id;
		if (numeval != 0){
			fmt = "lista-calif-secundaria-oficial-arji-xls-2";
		}
		printListados(fmt, numeval);
 	});

	$("#lista-ina-secu-of-arji-xls-1").on("click",function(event){
		event.preventDefault();
		var numeval = parseInt( $("#numeval0").val(), 0   );
		var fmt = event.currentTarget.id;
		if (numeval != 0){
			fmt = "lista-ina-secu-of-arji-xls-1";
		}
		printListados(fmt, numeval);
 	});

	$("#lista-calif-kinder-esp-interna-arji-xls-1").on("click",function(event){
		event.preventDefault();
		var numeval = parseInt( $("#numeval-1").val(), 0   );
		var fmt = event.currentTarget.id;
		if (numeval != 0){
			fmt = "lista-calif-kinder-esp-interna-arji-xls-2";
		}
		printListados(fmt, numeval);
 	});

	$("#lista-calif-kinder-ing-interna-arji-xls-1").on("click",function(event){
		event.preventDefault();
		var numeval = parseInt( $("#numeval-1").val(), 0   );
		var fmt = event.currentTarget.id;
		if (numeval != 0){
			fmt = "lista-calif-kinder-ing-interna-arji-xls-2";
		}
		printListados(fmt, numeval);
 	});


 	$("#lista-promedios-prepa-interna-arji-pdf-1").on("click",function(event){
		event.preventDefault();
		IdGruMat = $("#idmateria-prepa").val();
		printActaMatWithExcRep0(idgrupo,IdGruMat,IdCiclo,"lista-prom-mat-0/");		
 	})

 	$("#lista-actas-prepa-oficial-arji-pdf-1").on("click",function(event){
		event.preventDefault();
		IdGruMat = $("#idmateria-acta-oficial").val();
		printActaMatPrepa1(idgrupo,IdGruMat,IdCiclo);		
 	})

 	$("#lista-actas-secundaria-oficial-arji-pdf-1").on("click",function(event){
		event.preventDefault();
		IdGruMat = $("#idmateria-acta-oficial-sec-arji").val();
		printActaMatSecundaria1(idgrupo,IdGruMat);		
 	})

 	$("#lista-actas-secundaria-oficial-arji-pdf-2").on("click",function(event){
		event.preventDefault();
		IdGruMat = $("#idmateria").val();
		printActaMatWithExcRep0(idgrupo,IdGruMat,IdCiclo,"lista-prom-mat-0/");		
 	})

 	$("#lista-promedios-secundaria-interna-arji-pdf-1").on("click",function(event){
		event.preventDefault();
		IdGruMat = $("#idmateria").val();
		printActaMatWithExcRep0(idgrupo,IdGruMat,IdCiclo,"lista-prom-mat-1/");		
 	})

 	$("#lista-promedios-secundaria-interna-arji-pdf-2").on("click",function(event){
		event.preventDefault();
		IdGruMat = $("#idmateria").val();
		printActaMatWithExcRep0(idgrupo,IdGruMat,IdCiclo,"lista-prom-mat-2/");		
 	})



	$("#printBolCalGruAlu1, #printBolCalGruAlu3").on("click",function(event){
		
		event.preventDefault();

		var logoEmp =obj.getConfig(100,0); 
		var logoIbo =obj.getConfig(100,1); 
        var url;

		var nc = "user="+localStorage.nc+"&strgrualu="+strGruAlu+
				"&logoEmp="+logoEmp+
				"&logoIbo="+logoIbo+
				"&IdEmp="+localStorage.IdEmp+
				"&idgrupo="+idgrupo+
				"&grado="+Gradox+
				"&idciclo="+IdCiclo;
		
		
		// alert(nc);		
        
        var PARAMS = {o:0, t:40, c:nc, p:10, from:0, cantidad:0, s:' order by orden_impresion asc '};

        switch( parseInt(arrItem[0].clave_nivel,0) ){
        	case 1:
	        	url = obj.getValue(0)+"print-calif-kinder-oficial-arji-esp/";
	        	break;
        	case 2:
        	case 3:
	        	switch(Gradox){
	        		case 1:
			        	url = obj.getValue(0)+"print-calif-primaria-oficial-arji-1-a/";
			        	break;
	        		case 2:
			        	url = obj.getValue(0)+"print-calif-primaria-oficial-arji-2-a/";
			        	break;
	        		case 3:
			        	url = obj.getValue(0)+"print-calif-primaria-oficial-arji-3-a/";
			        	break;
	        		case 4:
			        	url = obj.getValue(0)+"print-calif-primaria-oficial-arji-4-a/";
			        	break;
	        		case 5:
			        	url = obj.getValue(0)+"print-calif-primaria-oficial-arji-5-a/";
			        	break;
	        		case 6:
			        	url = obj.getValue(0)+"print-calif-primaria-oficial-arji-6-a/";
			        	break;
	        	}
	        	break;
        	case 4:
	        	switch(Gradox){
	        		case 1:
			        	url = obj.getValue(0)+"print-calif-secundaria-oficial-arji-1-a/";
			        	break;
	        		case 2:
			        	url = obj.getValue(0)+"print-calif-secundaria-oficial-arji-2-a/";
			        	break;
	        		case 3:
			        	url = obj.getValue(0)+"print-calif-secundaria-oficial-arji-3-a/";
			        	break;
	        	}
	        	break;
        	case 5:
	        	url = obj.getValue(0)+"print-calif-prepa-oficial-arji/";
	        	break;
        }

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

	$("#printBolCalGruAlu2, #printBolCalGruAlu4").on("click",function(event){
		
		event.preventDefault();

		var logoEmp =obj.getConfig(100,0); 
		var logoIbo =obj.getConfig(100,1); 
        var url;

		var nc = "user="+localStorage.nc+"&strgrualu="+strGruAlu+
				"&logoEmp="+logoEmp+
				"&logoIbo="+logoIbo+
				"&IdEmp="+localStorage.IdEmp+
				"&grado="+Gradox+
				"&idciclo="+IdCiclo;

		// alert(nc);		
        
        var PARAMS = {o:0, t:40, c:nc, p:10, from:0, cantidad:0, s:' order by orden_impresion asc '};

        switch( parseInt(arrItem[0].clave_nivel,0) ){
        	case 1:
	        	url = obj.getValue(0)+"print-calif-kinder-oficial-arji-esp/";
	        	break;
        	case 2:
        	case 3:
	        	switch(Gradox){
	        		case 1:
			        	url = obj.getValue(0)+"print-calif-primaria-oficial-arji-1-b/";
			        	break;
	        		case 2:
			        	url = obj.getValue(0)+"print-calif-primaria-oficial-arji-2-b/";
			        	break;
	        		case 3:
			        	url = obj.getValue(0)+"print-calif-primaria-oficial-arji-3-b/";
			        	break;
	        		case 4:
			        	url = obj.getValue(0)+"print-calif-primaria-oficial-arji-4-b/";
			        	break;
	        		case 5:
			        	url = obj.getValue(0)+"print-calif-primaria-oficial-arji-5-b/";
			        	break;
	        		case 6:
			        	url = obj.getValue(0)+"print-calif-primaria-oficial-arji-6-b/";
			        	break;
	        	}
	        	break;
        	case 4:
	        	switch(Gradox){
	        		case 1:
			        	url = obj.getValue(0)+"print-calif-secundaria-oficial-arji-1-b/";
			        	break;
	        		case 2:
			        	url = obj.getValue(0)+"print-calif-secundaria-oficial-arji-2-b/";
			        	break;
	        		case 3:
			        	url = obj.getValue(0)+"print-calif-secundaria-oficial-arji-3-b/";
			        	break;
	        	}
	        	break;
        	case 5:
	        	url = obj.getValue(0)+"print-calif-prepa-oficial-arji/";
	        	break;
        }

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



	function printListados(id, evalu){
		
		var logoEmp =obj.getConfig(100,0); 
		var logoIbo =obj.getConfig(100,1); 
        var url;
        var numeval;

        if ( evalu == -1 ){
	        if (  $("#numeval0").length > 0 ){
	        	numeval = $("#numeval0").val();
	    	}else{
	        	numeval = 0;
	    	}
    	}else{
    		numeval = evalu;
    	}

		var nc = "user="+localStorage.nc+"&strgrualu="+strGruAlu+"&numeval="+numeval+
				"&logoEmp="+logoEmp+
				"&logoIbo="+logoIbo+
				"&idciclo="+IdCiclo;
		
		// alert(nc);

        var PARAMS = {o:0, t:40, c:nc, p:10, from:0, cantidad:0, s:' order by orden_impresion asc '};

    	url = obj.getValue(0)+id+"/";

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
 	};


	function getMatPromPrep0(IdGrupo){
		var nc = "u="+localStorage.nc+"&idgrupo="+IdGrupo+"&idciclo="+IdCiclo;
		$("#idmateria-prepa").html('<option value="0" selected>Seleccione una Materia</option>');
		$.post(obj.getValue(0) + "data/", {o:16, t:31, c:nc, p:11, from:0, cantidad:0,s:'idgrumat'},
			function(json){
				$.each(json, function(i, item) {
					$("#idmateria-prepa").append('<option value="'+item.idgrumat+'">'+item.materia+'</option>');
				});				
		},'json');
	}

	function printActaMatWithExcRep0(IdGrupo,IdGruMat,IdCiclo,urlRep){
		
		var logoEmp =obj.getConfig(100,0); 
		var logoIbo =obj.getConfig(100,1); 
        var url;

		var nc = "user="+localStorage.nc+"&strgrualu="+strGruAlu+"&idgrupo="+IdGrupo+"&idgrumat="+IdGruMat+
				"&logoEmp="+logoEmp+
				"&logoIbo="+logoIbo+
				"&idciclo="+IdCiclo;

		// alert(nc);		
		
		console.log(nc);

        var PARAMS = {o:0, t:40, c:nc, p:10, from:0, cantidad:0, s:' order by orden_impresion asc '};

    	url = obj.getValue(0)+urlRep;

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
 	};

	function getActaMatPrepa0(IdGrupo){
		var nc = "u="+localStorage.nc+"&idgrupo="+IdGrupo;
		$("#idmateria-acta-oficial").html('<option value="0" selected>Seleccione una Materia</option>');
		$.post(obj.getValue(0) + "data/", {o:16, t:72, c:nc, p:11, from:0, cantidad:0,s:''},
			function(json){
				$.each(json, function(i, item) {
					$("#idmateria-acta-oficial").append('<option value="'+item.materia_oficial+'">'+item.materia_oficial+'</option>');
				});				
		},'json');
	}

	function getMatPromSec0(IdGrupo){
		var nc = "u="+localStorage.nc+"&idgrupo="+IdGrupo+"&idciclo="+IdCiclo;
		$("#idmateria").html('<option value="0" selected>Seleccione una Materia</option>');
		$.post(obj.getValue(0) + "data/", {o:16, t:31, c:nc, p:11, from:0, cantidad:0,s:'idgrumat'},
			function(json){
				$.each(json, function(i, item) {
					$("#idmateria").append('<option value="'+item.idgrumat+'">'+item.materia+'</option>');
				});				
		},'json');
	}


	function getActaMatSecundaria0(IdGrupo){
		var nc = "u="+localStorage.nc+"&idgrupo="+IdGrupo;
		$("#idmateria-acta-oficial-sec-arji").html('<option value="0" selected>Seleccione una Materia</option>');
		$.post(obj.getValue(0) + "data/", {o:16, t:99, c:nc, p:11, from:0, cantidad:0,s:''},
			function(json){
				$.each(json, function(i, item) {
					$("#idmateria-acta-oficial-sec-arji").append('<option value="'+item.idgrumat+'">'+item.materia+'</option>');
				});				
		},'json');
	}

	function printActaMatPrepa1(IdGrupo,IdGruMat,IdCiclo){
		
		var logoEmp =obj.getConfig(100,0); 
		var logoIbo =obj.getConfig(100,1); 
        var url;

		var nc = "user="+localStorage.nc+"&strgrualu="+strGruAlu+"&idgrupo="+IdGrupo+"&idgrumat="+IdGruMat+
				"&logoEmp="+logoEmp+
				"&logoIbo="+logoIbo+
				"&idciclo="+IdCiclo;
		
		console.log(nc);

        var PARAMS = {o:0, t:40, c:nc, p:10, from:0, cantidad:0, s:' order by orden_impresion asc '};

    	url = obj.getValue(0)+"acta-oficial-prepa-arji-0/";

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
 	};

	function printActaMatSecundaria1(IdGrupo,IdGruMat){
		
		var logoEmp =obj.getConfig(100,0); 
		var logoIbo =obj.getConfig(100,1); 
        var url;

		var nc = "user="+localStorage.nc+"&strgrualu="+strGruAlu+"&idgrupo="+IdGrupo+"&idgrumat="+IdGruMat+
				"&logoEmp="+logoEmp+
				"&logoIbo="+logoIbo+
				"&idciclo="+IdCiclo;
		
		console.log(nc);

        var PARAMS = {o:0, t:40, c:nc, p:10, from:0, cantidad:0, s:' order by orden_impresion asc '};

    	url = obj.getValue(0)+"acta-oficial-secundaria-arji-0/";

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
 	};


});

</script>
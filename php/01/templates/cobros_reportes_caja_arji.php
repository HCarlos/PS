<?php

include("includes/metas.php");
$user = $_POST["user"];
$IdUserNivelAcceso = intval( $_POST["IdUserNivelAcceso"] );

?>

<div  class="row-fluid">
	<div class="span12 widget-container-span ui-sortable">
		<div class="widget-header widget-hea1der-small header-color-green">
			<h5 class="smaller">
				<i class="icon-print"></i>
				Panel de Reportes
			</h5>
		</div>

		<div class="widget-body">
			<div class="widget-main padding-4">
				<div class="content">

					<form class="form-horizontal" class="form" role="form" id="frmPanelReports0">

						<table class="tblReports">
							<tr>
								<td><label for="iduserconceptoescenario">Target:</label></td>
								<td colspan="3">
									<select id="iduserconceptoescenario" name="iduserconceptoescenario" size="1"></select>							
								</td>
							</tr>
							<tr>
								<td><label for="emisor">Emisor:</label></td>
								<td colspan="3">
									<select id="emisor" name="emisor" size="1"></select>							
								</td>
							</tr>
							<tr>
								<td><label for="tiporeporte">Tipo Reporte:</label></td>
								<td colspan="3">
									<select id="tiporeporte" name="tiporeporte">
										<?php if ( 
													$IdUserNivelAcceso == 12 || 
													$IdUserNivelAcceso == 13 || 
													$IdUserNivelAcceso == 14 || 
													$IdUserNivelAcceso == 15 || 
													$IdUserNivelAcceso == 16 
												) 
										{ 
											?>
											<option value="-1" selected disabled>Seleccione un reporte</option>
											<option value="6">Análisis por Concepto</option>
										<?php } else { ?>
											<option value="0" selected>Pagos por Niveles y Conceptos</option>
											<option value="1">Movimientos diarios en PDF</option>
											<option value="2">Descuentos por Niveles y Conceptos</option>
											<option value="3">Reporte de Vencimientos</option>
											<option value="4">Recordatorios Vencimientos</option>
											<option value="5">Recargos por Niveles y Conceptos</option>
											<option value="6">Análisis por Concepto</option>
										<?php } ?>
									</select>							
								</td>
							</tr>
							<tr id="rowTBeca">
								<td><label for="tipoBeca">Tipo Beca:</label></td>
								<td colspan="3">
									<select id="tipoBeca" name="tipoBeca">
										<option value="-2">Solo Becas</option>
										<option value="-1">Solo Descuentos</option>
										<option value="0" selected>Becas y Descuentos</option>
										<option value="1">Beca Arjí</option>
										<option value="2">Beca S.E.P.</option>
										<option value="3">Beca Bachillerato</option>
										<option value="4">Beca S.P.F.</option>
									</select>							
								</td>
							</tr>
							<tr class="rowVencimientos serviciosCobrados clsAnalisis">
								<td><label for="vconcepto">Concepto:</label></td>
								<td colspan="3">
									<select id="vconcepto" name="vconcepto">
									</select>							
								</td>
							</tr>
							<tr class="rowVencimientos clsAnalisis">
								<td><label for="clave_nivel">Nivel:</label></td>
								<td colspan="3">
									<select id="clave_nivel" name="clave_nivel">
									</select>							
								</td>
							</tr>
							<tr class="rowVencimientos clsAnalisis">
								<td><label for="idgrupo">grupo:</label></td>
								<td colspan="3">
									<select id="idgrupo" name="idgrupo">
									</select>							
								</td>
							</tr>
							<tr class="rowVencimientos">
								<td><label for="fvencimiento">Vencimiento:</label></td>
								<td colspan="3">
									<input class="date-picker altoMoz" id="fvencimiento" name="fvencimiento" data-date-format="dd-mm-yyyy" type="text">
									<span class="add-on">
										<i class="icon-calendar"></i>
									</span>
								</td>
							</tr>
							<tr id="rowNivConceptos">
								<td><label for="conceptos">Conceptos:</label></td>
								<td colspan="3">
									<select id="conceptos" name="conceptos" size="1"></select>							
								</td>
							</tr>

							<tr class="clsAnalisis">
								<td><label for="status0">Status:</label></td>
								<td colspan="3">
									<input name="status0" id="status0-0" class="ace status0" type="radio" value="0" checked>
									<label class="lbl" for="status0-0"> Todos</label>

									<span class="marginLeft2em"></span>

									<input name="status0" id="status0-1" class="ace status0" type="radio" value="1" >
									<label class="lbl" for="status0-1"> Pagados</label>

									<span class="marginLeft2em"></span>

									<input name="status0" id="status0-2" class="ace status0" type="radio" value="2" >
									<label class="lbl" for="status0-2"> No Pagados</label>
								</td>
							</tr>

	 						<tr id="rangoFechas">
								<td><label for="fi">Desde: </label></td>
								<td>
									
										<input class="date-picker altoMoz" id="fi" name="fi" data-date-format="dd-mm-yyyy" type="text">
										<span class="add-on">
											<i class="icon-calendar"></i>
										</span>
									
								</td>
								<td><label for="ff">Hasta: </label></td>
								<td>
										<input class="date-picker altoMoz" id="ff" name="ff" data-date-format="dd-mm-yyyy" type="text">
										<span class="add-on">
											<i class="icon-calendar"></i>
										</span>
									
								</td>
							</tr>

							<tr>
								<td><label for="formato">Formato:</label></td>
								<td colspan="3">
									<input name="formato" id="formato-0" class="ace formato" type="radio" value="0" checked>
									<label class="lbl" for="formato-0"> PDF</label>

									<span class="marginLeft2em"></span>

									<input name="formato" id="formato-1" class="ace formato" type="radio" value="1" >
									<label class="lbl" for="formato-1"> Pantalla</label>
								</td>
							</tr>

						</table>
						<div class="form-actions">
							<button class="btn btn-success" type="submit">
								<i class="icon-ok bigger-110"></i>
								Consultar
							</button>
						</div>

						<input type="hidden" id="u" name="u" />
						<input type="hidden" id="cclave_nivel" name="cclave_nivel" value="" />
						<input type="hidden" id="cidgrupo" name="cidgrupo" value="" />
						<input type="hidden" id="cconceptos" name="cconceptos" value="" />
						<input type="hidden" id="concepto" name="concepto" value="" />
						<input type="hidden" id="ctipobeca" name="ctipobeca" value="" />

					</form>

				</div>
			</div>
		</div>	
	</div>
</div>


<div id="inline2">
	
</div>
<!--PAGE CONTENT ENDS-->

<script typy="text/javascript">        

jQuery(function($) {

	$("#preloaderPrincipal").hide();
	$("#rowTBeca").hide(); 
	$(".rowVencimientos").hide(); 

	$(".serviciosCobrados").hide(); 

	$("#u").val( localStorage.nc );

	var IdUserNivelAcceso = <?php echo $IdUserNivelAcceso; ?>;

    $("#frmPanelReports0").on("unsubmit");
    $("#frmPanelReports0").on("submit", function(event) {
        event.preventDefault();
        if ( !ValidateForm() ){
        	return false;
        }
        var opt    = parseInt( $(".formato:checked").val() );
        var optSts = parseInt( $(".status0:checked").val() );
        var tr     = parseInt($("#tiporeporte").val(),0);
        var url, PARAMS, queryString, nRep;
        
        $("#cconceptos").val( $("#conceptos option:selected").text() );
        $("#ctipobeca").val( $("#tipoBeca option:selected").text() );
        $("#cclave_nivel").val( $("#clave_nivel option:selected").text() );
        $("#cidgrupo").val( $("#idgrupo option:selected").text() );
        $("#concepto").val( $("#vconcepto option:selected").text() );

        queryString = $("#frmPanelReports0").serialize();

        // alert(queryString);
 
        if ( opt == 0) {
	        switch( tr ){
	        	case 0:
					nRep = "rep-caja-niv-concepto-arji/";
	        		break;
	        	case 1:
					nRep = "rep-caja-movimientos-arji/";
	        		break;
	        	case 2:
					nRep = "rep-caja-niv-concepto-descto/";
	        		break;
	        	case 3:
					nRep = "rep-caja-vencimiento-1/";
	        		break;
	        	case 4:
					
					// nRep = "rep-caja-vencimiento-1/";
					
					getViewRecordatorios();
					return false;
	        		break;

	        	case 5:
					nRep = "rep-caja-niv-concepto-recargo/";
	        		break;
	        	case 6:
					nRep = "rep-caja-analisis-conceptos/";
	        		break;
	        }

			url = obj.getValue(0)+nRep;
			
			PARAMS = {data:queryString};

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
		}else{


	        switch( tr ){
	        	case 0:
					// nRep = "rep-caja-niv-concepto-arji/";
					return false;
	        		break;
	        	case 1:
					nRep = "rep-caja-movimientos-arji/";
	        		break;
	        }

			url = obj.getValue(0)+nRep;
			
			PARAMS = {data:queryString};

	        $("#contentProfile").empty();
	        $("#contentMain").hide(function(){
		        $("#preloaderPrincipal").show();
		        obj.setIsTimeLine(false);
		        var nc = localStorage.nc;
		        $.post(obj.getValue(0) + "caja-report-detalle-html-1/", PARAMS,
		            function(html) {	                
		                $("#contentProfile").html(html).show('slow',function(){
			                $('#breadcrumb').html(getBar('Inicio, Listado de Facturas '));
		                });
		            }, "html");
	        });
	        return false;
		}
    });


	function getEscenario(){
		$("#preloaderPrincipal").show();		
	    var nc = "u="+localStorage.nc;
	 	$("#iduserconceptoescenario").empty();
	    $.post(obj.getValue(0)+"data/", { o:1, t:70, p:0,c:nc,from:0,cantidad:0, s:'' },
	        function(json){
	           $.each(json, function(i, item) {
	                $("#iduserconceptoescenario").append('<option value="'+item.data+'"> '+item.label+'</option>');
	            });
	           getEmisor();
	        }, "json"
	    );  
	}

	 $("#iduserconceptoescenario").on("change",function(event){
	 	event.preventDefault();
	 	getConceptos();
	 });

	function getEmisor(){
	    var nc = "u="+localStorage.nc;
	 	$("#emisor").empty();
	 	$("#emisor").html("<option value='0'>Seleccione un Emisor Fiscal</option>");
	    $.post(obj.getValue(0)+"data/", { o:1, t:26, p:0,c:nc,from:0,cantidad:0, s:'' },
	        function(json){
	        	var xp;
	           $.each(json, function(i, item) {
	           		xp = item.data.split("-");
	                $("#emisor").append('<option value="'+xp[0]+'"> '+item.label+'</option>');
	            });
	           	$("#preloaderPrincipal").hide();
	        }, "json"
	    );  
	}

	 $("#emisor").on("change",function(event){
	 	event.preventDefault();
	 	getConceptos();
	 });

	 function getConceptos(){
	 	$("#conceptos").empty();
	 	$("#conceptos").html("<option value='0' selected>Seleccione un Concepto</option>");
	 	var nc = "u="+localStorage.nc+"&idemisorfiscal=" + $("#emisor").val()+"&iduserconceptoescenario="+$("#iduserconceptoescenario").val();
	    $.post(obj.getValue(0)+"data/", { o:1, t:10026, p:11,c:nc,from:0,cantidad:0, s:'idconcepto' },
	        function(json){
	           $.each(json, function(i, item) {
	                $("#conceptos").append("<option value='"+item.idconcepto+"'>"+item.concepto+"</option>");
	            });
	        }, "json"
	    );  
       getConceptoVencimientos();	 	
	 }

	 function getConceptoVencimientos(idemisorfiscal){
	 	$("#preloaderPrincipal").show();
	 	$("#vconcepto").empty();
	 	$("#vconcepto").html("<option value='0' selected>Seleccione un Concepto</option>");
	 	var nc = "u="+localStorage.nc+"&idemisorfiscal=" + $("#emisor").val()+"&iduserconceptoescenario="+$("#iduserconceptoescenario").val();	 	
	    $.post(obj.getValue(0)+"data/", { o:1, t:10026, p:11,c:nc,from:0,cantidad:0, s:'idconcepto' },
	        function(json){
	           $.each(json, function(i, item) {
	                $("#vconcepto").append("<option value='"+item.idconcepto+"'>"+item.concepto+"</option>");
	            });
	           	$("#preloaderPrincipal").hide();
	        }, "json"
	    );  

	 }

	function getNivel(){
		$("#preloaderPrincipal").show();		
	    var nc = "u="+localStorage.nc;
        $("#clave_nivel").empty();
        $.post(obj.getValue(0)+"data/", { o:1, t:45, p:0,c:nc,from:0,cantidad:0, s:"" },
            function(json){
               $.each(json, function(i, item) {
                    $("#clave_nivel").append('<option value="'+item.data+'"> '+item.label+'</option>');
                });
		        $("#clave_nivel").append('<option value="-1">Todos los niveles</option>');
		        $("#preloaderPrincipal").hide();
                getGpoNiv();
            }, "json"
        );  
	}

    $("#clave_nivel").on("change",function(event){
        event.stopPropagation();
        // $("#alumno0").empty();
        // addAlumnosToTareas();
        getGpoNiv();
    });

    function getGpoNiv(){
		$("#preloaderPrincipal").show();		
        var cveniv = $("#clave_nivel option:selected").val();
        var nc = "u="+localStorage.nc+"&clave_nivel="+cveniv;
        $("#idgrupo").empty();
	 	$("#idgrupo").html("<option value='0' selected>Todos los de este Nivel</option>");
        $.post(obj.getValue(0)+"data/", {o:1, t:46, p:0, c:nc, from:0, cantidad:0, s:'' },
            function(json){
               $.each(json, function(i, item) {
                   $("#idgrupo").append('<option value="'+item.data+'"> '+item.label+'</option>');
                });
                $("#preloaderPrincipal").hide();

            }, "json"
        );  
    }

    function getViewRecordatorios(){

		$("#preloaderPrincipal").show();		
    	queryString = $("#frmPanelReports0").serialize();
		PARAMS = {data:queryString};

        $("#contentProfile").empty();
        $("#contentMain").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
	        $.post(obj.getValue(0) + "caja-recordatorios-detalle-html-1/", PARAMS,
	            function(html) {	                
	                $("#contentProfile").html(html).show('slow',function(){
		                $('#breadcrumb').html(getBar('Inicio, Listado de Facturas '));
	                });
					$("#preloaderPrincipal").hide();		
	            }, "html");
        });
        return false;


    }


	 $("#tiporeporte").on("change",function(event){
	 	event.preventDefault();
		var eval = parseInt( $(this).val() ,0 ); 
		
		$("#rowNivConceptos").removeClass("borderSelect"); 	
		$("#rangoFechas").removeClass("borderSelect"); 	
		$(".rowVencimientos").removeClass("borderSelect"); 	
		$(".clsAnalisis").removeClass("borderSelect"); 	


		$("#rowNivConceptos").hide(); 			
		$("#rowTBeca").hide(); 			
		// $("#rangoFechas").hide(); 			
		$(".rowVencimientos").hide(); 	
		$(".serviciosCobrados").hide(); 	
		$(".clsAnalisis").hide(); 	

		if (eval == 0){
			$("#rowNivConceptos").show(); 	
		}

		if (eval == 1){
			$("#rowNivConceptos").show(); 			
			$("#rowNivConceptos").addClass("borderSelect"); 	
			$("#rangoFechas").addClass("borderSelect"); 	
			 //$(".serviciosCobrados").show(); 			
		}

		if (eval == 2){
			$("#rowTBeca").show(); 			
			$("#rowTBeca").addClass("borderSelect"); 	
			$("#rangoFechas").addClass("borderSelect"); 	
		}

		if ( eval == 3 || eval == 4){
			// $("#rowNivConceptos").show(); 
			$(".rowVencimientos").show(); 			
			$(".rowVencimientos").addClass("borderSelect"); 	
		}

		if (eval == 5){
			$("#rangoFechas").addClass("borderSelect"); 	
		}

		if (eval == 6){
			$(".clsAnalisis").show(); 	
			$(".clsAnalisis").addClass("borderSelect"); 	
		}


	 });



/*
	$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
		$(this).prev().focus();
	});
	$('.date-picker').mask('99-99-9999');
	$('.date-picker').val(obj.getDateToday());
*/

	$('.date-picker').datepicker({
    	format: 'dd-mm-yyyy',
		autoclose: true
	});

	$('.date-picker').on('changeDate', function(event){
	    $(this).datepicker('hide');
	    //validDate();
	});

	$('.date-picker').val(obj.getDateToday());

	function ValidateForm(){
		var startDate = $('#fi').val(); //.replace('-','/');
		var endDate = $('#ff').val(); //.replace('-','/');
		
		// alert(startDate.getTime());
		// alert(endDate.getTime());
		

		if( obj.getDateDiff(startDate,endDate,'-') < 0 ){
		   alert("Rango de fecha incongruente");
		   return false;
		}		
		return true;
	}

	getEscenario();
	// getEmisor();
	getNivel();
	//getFechasVencimientos();
	
});

function resizeScreen() {
	
    $("#contentMain").css("min-height", obj.getMinHeight());
    $("#contentProfile").css("min-height", obj.getMinHeight());

}

</script>
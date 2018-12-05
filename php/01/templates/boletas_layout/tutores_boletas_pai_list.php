<?php

include("../includes/metas.php");

ini_set('display_errors', '0');     # don't show any errors...
error_reporting(E_ALL | E_STRICT);  # ...but do log them

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

$user = $_POST['user'];
$idgrualu = $_POST['idgrualu'];
$clave_nivel = $_POST['clave_nivel'];
$grupo = $_POST['grupo'];
$alumno = $_POST['alumno'];
$ispai_grupo = $_POST['ispai_grupo'];
$grado_pai = $_POST['grado_pai'];

$screenOrigen = $_POST['screenOrigen'];
$screenDestino = $_POST['screenDestino'];

?>
<div class="widget-box">
    <div class="widget-header widget-header-blue widget-header-flat">
        <i class="icon-circle green"></i> <strong id="spDetailBolCal002"><?= $alumno; ?></strong>: <b class="text-success"><?= $grupo; ?></b> 
        <div class="widget-toolbar no-border">

            <div class="widget-toolbar">
                <button  type="button" class="btn btn-minier btn-primary btn-app radius-4 marginTop025em closeFormUploadDeailt00 " >
                        <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
                        Regresar
                </button>
            </div>

            <div class="widget-toolbar no-border">
                <button  type="button" class="btn btn-minier btn-success btn-app radius-4 marginTop025em" id="btnViewPAICal00" >
                		<i class="fa fa-folder-open" aria-hidden="true"></i>
                        Abrir
                </button>
            </div>

			<div class="widget-toolbar black">
				<select id="cmbBimPAIBolCal00" size="1" class=" lbl00">
					<option value="1">Trimestre 1</option>
					<option value="2">Trimestre 2</option>
					<option value="3">Trimestre 3</option>
				</select>
			</div>
 
        </div>

    </div>
<style type="text/css">
	table{
		width: 100%;    
		border-collapse: collapse;
	}

	tr{  border:1px #CCC solid !important;}
	#cal1, #cal2, #ina0{font-size: 1.2em !important;}

	tr th{  border:1px #CCC solid !important;}

	.th1{margin-left: 1em !important;}

	.cl0{width: 50px !important;}
	.cl1{width: 18% !important;}
	.nobold{font-weight: normal !important;}

</style>

    <div class="widget-body">
        <div class="widget-main">
            
            <table id="tg" class="bordered2" style="font-size: 1em !important;" border="1">
            	<thead>
            		<tr>
            			<th rowspan="2" class="th1 text-left"><span class="col-lg-2 control-label "><strong>MATERIA</strong></span></th>
            			<th class="text-center" colspan="2" id="cr01">&nbsp;</th>
            			<th class="text-center" colspan="2" id="cr02">&nbsp;</th>
            			<th class="text-center" colspan="2" id="cr03">&nbsp;</th>
            			<th class="text-center" colspan="2" id="cr04">&nbsp;</th>
            		</tr>
            		<tr>
            			<th class="text-center nobold" id="dr11">&nbsp;</th>
            			<th class="text-center nobold" id="dr13">&nbsp;</th>
            			<th class="text-center nobold" id="dr21">&nbsp;</th>
            			<th class="text-center nobold" id="dr23">&nbsp;</th>
            			<th class="text-center nobold" id="dr31">&nbsp;</th>
            			<th class="text-center nobold" id="dr33">&nbsp;</th>
            			<th class="text-center nobold" id="dr41">&nbsp;</th>
            			<th class="text-center nobold" id="dr43">&nbsp;</th>
            		</tr>
            	</thead>
            	<tbody>
            		
            	</tbody>
            	<tfoot>
            		<tr>
            			<th class="text-left nobold" colspan="9" ><span class="col-lg-2 control-label "><strong>NIVELES DE LOGRO:</strong></span><span class="col-lg-1 control-label">0</span><span class="col-lg-1 control-label">1-2</span><span class="col-lg-1 control-label">3-4</span><span class="col-lg-1 control-label">5-6</span><span class="col-lg-1 control-label">7-8</span></th>
            		</tr>
            	</tfoot>
            </table>

            <div class="alert alert-warning" role="alert" id="emptyCal"></div>

			<p> </br></p>

            <div class="alert alert-warning" role="alert" id="preload01">
    			<h3 class="smaller lighter grey ">
					<i class="icon-spinner icon-spin orange bigger-125"></i>
					Cargando datos, por favor, espere....
				</h3>            	
            </div>

        </div><!--/widget-main-->
    </div><!--/widget-body-->

</div>

<script type="text/javascript"> 

jQuery(function($) {

	var IdGruAlu = <?= $idgrualu; ?>;
	var ClaveNivel = <?= $clave_nivel; ?>;
	var IsPAI_Grupo = <?= $ispai_grupo; ?>;
	var Grado_PAI = <?= $grado_pai; ?>;
    var arrItems = [];
	var arrHD = [];
	var screenOrigen = "#"+"<?= $screenOrigen; ?>";
	var screenDestino = "#"+"<?= $screenDestino; ?>";

	var Eval;

	$("#tg").hide();
	$("#emptyCal").hide();
	$("#preload01").hide();

	$(".closeFormUploadDeailt00").on("click",function(event){
		event.preventDefault();
        $("#preloaderPrincipal").hide();
		$(screenDestino).hide(function(){
			$(screenDestino).empty();
			$(screenOrigen).show();
		});
		resizeScreen();
		return false;
	});

	$("#btnViewPAICal00").on("click",function(event){
		event.preventDefault();

        $("#preloaderPrincipal").show();
		$("#emptyCal").hide();
	    $("#tg > tbody").empty();
		$("#tg").hide();
		$("#preload01").show();
	    
	    arrItems = [];

		Eval = parseInt($("#cmbBimPAIBolCal00").val(),0);
	    var nc = "u="+localStorage.nc+"&idgrualu="+IdGruAlu+"&clave_nivel="+ClaveNivel+"&eval="+Eval;
		$.ajax({
      	async:true,    
      	cache:false,   
      	dataType:"json",
      	type: "POST",   
      	url: obj.getValue(0)+"data/",
      	data: { o:15, t:15, p:51, c:nc, from:0, cantidad:0, s:"" }, 
      	success:  function(json){  
	        	var xs = "";
	        	if ( parseInt(json.length,0) <= 0 ){
	        		$("#emptyCal").html("<tr><td>No hay califiaciones </td></tr>");
					$("#emptyCal").show();
			        $("#preloaderPrincipal").hide();
	        		return false;
	        	}

	        	getCriterios(json);

			} // success
        
	    });
         
    });


	function getCriterios(json){

		var JSON = json;
		var nc = "u="+localStorage.nc+"&idpaiareadisciplinaria="+json[0].idpaiareadisciplinaria+"&grado_pai="+json[0].grado_pai;

		$.post(obj.getValue(0)+"data/", { o:1, t:116, p:11, c:nc, from:0, cantidad:0, s:"" },
			function(json2){

	        	if ( json2.length > 0 ){

	               $.each(json2, function(i, item) {

	               		arrHD[i] = {
	               					idpaicriterio 		 : item.idpaicriterio,
	               					criterio 			 : item.criterio,
	               					descripcion_criterio : item.descripcion_criterio,
	               					numCriterio          : i+1 
	               					};

	               		var numCriterio = i+1;
	               		$("#cr0"+numCriterio).html("Criterio "+item.criterio);

	               		$("#dr"+numCriterio+"1").html("<small>Cal</small>");
	               		$("#dr"+numCriterio+"3").html("<small>Ver</small>");
	                });

	               getValores(JSON);
	           }else{
	           		$("#preload01").hide();
	           }

		    }, "json"
		);

	}


	function getValores(json){

		var Long = parseInt(json.length,0);
		$("#tg").show();

        $.each(json, function(i, item) {

    		var IdBoleta, IdGruMat, Materia, Alumno, nLista, IdPAIAreaDisciplinaria, Grado_PAI;

    		IdBoleta 				= item.idboleta;
    		Materia  				= item.materia;
    		IdGruMat  				= item.idgrumat;
    		IdPAIAreaDisciplinaria  = item.idpaiareadisciplinaria;
    		Grado_PAI  				= item.grado_pai;
    		Alumno 					= item.alumno;
    		nLista 					= item.num_lista;

			var nc = "u="+localStorage.nc+"&idboleta="+IdBoleta+"&numval="+Eval+"&idpaiareadisciplinaria="+IdPAIAreaDisciplinaria+"&grado_pai="+Grado_PAI;

		    $.post(obj.getValue(0)+"data/", { o:1, t:118, p:11, c:nc, from:0, cantidad:0, s:"" },
		        function(dat){
		        	if ( dat.length > 0 && dat[0].idboletapaibi > 0 && IdBoleta > 0 ) {
					
					arrItems[i] = {
									idboletapaibi: 			dat[0].idboletapaibi,
									idboleta:      			IdBoleta,
									alumno:        			Alumno,
									materia:       			Materia,
									idpaiareadisciplinaria: IdPAIAreaDisciplinaria,
									grado_pai:       		Grado_PAI,
									idgrumat:       		IdGruMat,
									num_lista:     			nLista,
									
									e11: dat[0].e11,
									e1:  dat[0].e1,
									
									e21: dat[0].e21,
									e2:  dat[0].e2,
									
									e31: dat[0].e31,
									e3:  dat[0].e3,
									
									e41: dat[0].e41,
									e4:  dat[0].e4
								};
					}else{
						
						
					
					arrItems[i] = {
									idboletapaibi: 			0,
									idboleta:      			IdBoleta,
									alumno:        			Alumno,
									materia:       			Materia,
									idpaiareadisciplinaria: IdPAIAreaDisciplinaria,
									grado_pai:       		Grado_PAI,
									idgrumat:       		IdGruMat,
									num_lista:     			nLista,
									
									e11: -1,
									e1:  -1,
									
									e21: -1,
									e2:  -1,
									
									e31: -1,
									e3:  -1,
									
									e41: -1,
									e4:  -1
								};

						

					}
								
				   	if ( i == (Long-1) ) {
				   		printTable(arrItems);
				   	}

		        }, "json"
		    );  

         });

	}	

	function printTable(arrItems){

		$.each(arrItems, function(i, item) {

			var xs = "";

	    	xs += "<tr class='row2'>";
	    	xs += "<td><span class='blue'><strong>"+item.materia+"</strong></span></td>";	                
	
			var idboletapaibi = item.idboletapaibi;
			var idboleta =      item.idboleta;

			var e11 = parseInt(item.e11,0);
			var e1  = parseInt(item.e1,0);

			var e21 = parseInt(item.e21,0);
			var e2  = parseInt(item.e2,0);
			
			var e31 = parseInt(item.e31,0);
			var e3  = parseInt(item.e3,0);
			
			var e41 = parseInt(item.e41,0);
			var e4  = parseInt(item.e4,0);

			var IdPAIAreaDisciplinaria = parseInt(item.idpaiareadisciplinaria,0);
			var Grado_PAI = parseInt(item.grado_pai,0);

			var leg1,leg2,leg3,leg4 = "";
			var lg1,lg2,lg3,lg4 = "";

			lg1 = e1 == -1 ? " " : IdPAIAreaDisciplinaria+"-"+e11+"-"+Grado_PAI+"-"+e1+"-"+0;
			lg2 = e2 == -1 ? " " : IdPAIAreaDisciplinaria+"-"+e21+"-"+Grado_PAI+"-"+e2+"-"+1;
			lg3 = e3 == -1 ? " " : IdPAIAreaDisciplinaria+"-"+e31+"-"+Grado_PAI+"-"+e3+"-"+2;
			lg4 = e4 == -1 ? " " : IdPAIAreaDisciplinaria+"-"+e41+"-"+Grado_PAI+"-"+e4+"-"+3;

/*
			leg1 = e1 == -1 ? " " : "<a href='#' class='vL' id='"+lg1+"'><i class='middle icon-eye-open blue'></i></a>"; 
			leg2 = e2 == -1 ? " " : "<a href='#' class='vL' id='"+lg2+"'><i class='middle icon-eye-open blue'></i></a>"; 
			leg3 = e3 == -1 ? " " : "<a href='#' class='vL' id='"+lg3+"'><i class='middle icon-eye-open blue'></i></a>"; 
			leg4 = e4 == -1 ? " " : "<a href='#' class='vL' id='"+lg4+"'><i class='middle icon-eye-open blue'></i></a>"; 

            xs += "<td class='cl0'><span class='marginLeft1em cal1'>"+iVl(e1)+"</span></td> <td class='cl0 center'>"+Rng(e1)+"</td> <td class='cl0 center'>"+leg1+"</td>";	                
            xs += "<td class='cl0'><span class='marginLeft1em cal1'>"+iVl(e2)+"</span></td> <td class='cl0 center'>"+Rng(e2)+"</td> <td class='cl0 center'>"+leg2+"</td>";	                
            xs += "<td class='cl0'><span class='marginLeft1em cal1'>"+iVl(e3)+"</span></td> <td class='cl0 center'>"+Rng(e3)+"</td> <td class='cl0 center'>"+leg3+"</td>";	                
            xs += "<td class='cl0'><span class='marginLeft1em cal1'>"+iVl(e4)+"</span></td> <td class='cl0 center'>"+Rng(e4)+"</td> <td class='cl0 center'>"+leg4+"</td>";	                
*/

			leg1 = e1 == -1 ? " " : "<div class='action-buttons'><a href='#' class='vL' id='"+lg1+"'><i class='middle icon-eye-open blue bigger-130'></i></a></div>"; 
			leg2 = e2 == -1 ? " " : "<div class='action-buttons'><a href='#' class='vL' id='"+lg2+"'><i class='middle icon-eye-open blue bigger-130'></i></a></div>"; 
			leg3 = e3 == -1 ? " " : "<div class='action-buttons'><a href='#' class='vL' id='"+lg3+"'><i class='middle icon-eye-open blue bigger-130'></i></a></div>"; 
			leg4 = e4 == -1 ? " " : "<div class='action-buttons'><a href='#' class='vL' id='"+lg4+"'><i class='middle icon-eye-open blue bigger-130'></i></a></div>"; 

            xs += "<td class='cl0'><span class='marginLeft1em cal1'>"+iVl(e1)+"</span></td> <td class='cl0 center'>"+leg1+"</td>";	                
            xs += "<td class='cl0 label-light'><span class='marginLeft1em cal1'><strong>"+iVl(e2)+"</strong></span></td> <td class='cl0 center label-light'>"+leg2+"</td>";	                
            xs += "<td class='cl0'><span class='marginLeft1em cal1'>"+iVl(e3)+"</span></td> <td class='cl0 center'>"+leg3+"</td>";	                
            xs += "<td class='cl0 label-light'><span class='marginLeft1em cal1'><strong>"+iVl(e4)+"</strong></span></td> <td class='cl0 center label-light'>"+leg4+"</td>";	                

            xs += "</tr>";

	        $("#tg > tbody").append(xs);
		});

		$(".vL").on("click",function(event){
			event.preventDefault();
			var ids = event.currentTarget.id.split('-');
			var nc = "u="+localStorage.nc+"&idpaicriterio="+ids[1]+"&idpaiareadisciplinaria="+ids[0]+"&grado_pai="+ids[2]+"&rango_califica="+ids[3];

			$.post(obj.getValue(0)+"data/", { o:1, t:60, p:54, c:nc, from:0, cantidad:0, s:"" },
			function(json){
					if ( json.length > 0 ){
						var criterio  = json[0].criterio;
						var desccrit  = json[0].descripcion_criterio;
						var texto     = json[0].concepto;
						var texto     = texto.replace(/\n/g, "|");
						var arrTxt    = texto.split('|');
						var html = "<h3 class='header smaller lighter grey '><i class='icon-info-sign blue'></i> Criterio "+criterio+": <span class='smaller lighter orange'>"+desccrit+"</span></h3>";
						html += "<b class='green'>" + arrTxt[0] + "</b>"  + "<br /><br />";
						var slt = "";
						$.each(arrTxt, function(i, item) {
							if ( i !== 0){
								slt = i == (arrTxt.length-1) ? "." : ".<br /><br />" 
								html += $.trim(arrTxt[i]) + slt;
							}
						});
						
						html += "<p class='header center'></p>";
						html += "<p class='center'><button class='btn btn-small btn-success' id='closeBtnPai01'><i class='icon-ok bigger-150'></i>Aceptar</button></p>";

						$("#divUploadImage").css("height", "400px");
						$("#divUploadImage").css("padding", "1em");
						$("#divUploadImage").empty();
						$("#divUploadImage").html(html);
						$("#divUploadImage").modal('toggle');

						$("#closeBtnPai01").on("click",function(event){
							$("#preloaderPrincipal").hide();
							$("#divUploadImage").modal('hide');
						});

					}else{
						alert("No se encontraron datos");
					} 
    		}, "json");
		});

		$("#preload01").hide();
		$("#preloaderPrincipal").hide();

	}

	function iVl(val){
		return val == -1 ? '': val;
	}

	function Rng(val){
		var valor;
		switch( parseInt(val,0) ){
			case 0:
				valor = "0";
				break;
			case 1:
			case 2:
				valor = "1-2";
				break;
			case 3:
			case 4:
				valor = "3-4";
				break;
			case 5:
			case 6:
				valor = "5-6";
				break;
			case 7:
			case 8:
				valor = "7-8";
				break;
			default:	
				valor = "";
				break;
		}

		return valor;
	}

	$("#gotoPrintTable").on("click",function(event){
		event.preventDefault();
	});
	
	function getNivelPAI(){
		cad = "u="+localStorage.nc+"&llave=epai";
	    $.post(obj.getValue(0) + "data/", {o:1, t:-4, c:cad, p:10, from:0, cantidad:0, s:''},
	        function(json) {
	        	var Eval = parseInt(json[0].valor,0);
	            $("#cmbBimPAIBolCal00").val(Eval);
	    }, "json");
	}

	getNivelPAI();

	$("#preloaderPrincipal").hide();

});		

</script>

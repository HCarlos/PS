<?php

include("../includes/metas.php");

$user = $_POST['nc'];
$idgrualu = $_POST['idgrualu'];
$clave_nivel = $_POST['clave_nivel'];
$grupo = $_POST['grupo'];
$alumno = $_POST['alumno'];

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
                <button  type="button" class="btn btn-minier btn-success btn-app radius-4 marginTop025em" id="btnViewDetailColBol00" >
                		<i class="fa fa-folder-open" aria-hidden="true"></i>
                        Abrir
                </button>
            </div>

			<div class="widget-toolbar no-border">
				<select id="cmbListMatDetBolCal00" size="1" class=" lbl00"></select>
			</div>

			<div class="widget-toolbar black">
				<select id="cmbBimDetBolCal00" size="1" class=" lbl00">
					<option value="0">Trimestre 1</option>
					<option value="1">Trimestre 2</option>
					<option value="2">Trimestre 3</option>
<!-- 
					<option value="3">Bimestre 4</option>
					<option value="4">Bimestre 5</option>
 -->				
				</select>
			</div>
 

        </div>

    </div>
<style type="text/css">
	table{
		width: 100%;    
	}
	
	tr{  border:1px #CCC solid !important;}
	#cal1, #cal2, #ina0{font-size: 1.2em !important;}
	table caption{
		font: 1em bold;
		text-transform: uppercase;
		border: 1px solid #CCC !important;
	}

	table caption h5{
		margin-top: 0.5em !important; 
		margin-left: 1em !important;
	}
	table caption h6{
		margin-top: 0.7em !important; 
		margin-right: 1em !important;
		font-weight: bold !important;
	}

</style>

    <div class="widget-body">
        <div class="widget-main">
            
            <table id="tg" class="bordered2" style="font-size: 1em !important;">
            	<caption class="text-left widget-header-flat">
            		<h5 class="pull-left green">
            			<i class="icon-certificate green"></i>
            			<strong>Criterios de Evaluación: </strong>
            		</h5>
            		<h5 id="h5materia" class="pull-left orange bold"></h5> 
            		<h6 id="alumno" class="pull-right blue"></h6>
            	</caption>
            	<thead>
            		<tr>
            			<th class="text-left">Porcentaje</th>
            			<th class="text-right">Prom.</th>
            			<th class="text-center">Pts.</th>
            			<th class="text-center">Elementos</th>
            			<th class="text-center">Calificación</th>
            			<th class="text-center">Observaciones</th>
            			<th class="text-center">Objetivo</th>
            		</tr>
            	</thead>
            	<tbody>
            		
            	</tbody>
            	<tfoot>
            		<tr>
            			<td colspan="2"><strong>Calificación:</strong></td>
            			<td><strong id="cal2"></strong></td>
            			<td colspan="2"></td>
            			<td colspan="2"><strong>Profesor: </strong><strong id="cal3" class="grey"></strong></td>
            		</tr>
            	</tfoot>
            </table>

            <div class="alert alert-warning" role="alert" id="emptyCal"></div>

			<p> </br></p>

            <table id="laTutores00" class="bordered2" style="font-size: 1em !important;">
            	<caption class="text-left widget-header-flat"><h5 class="green"><i class="icon-bolt green"></i><strong>Inasistencias</strong></h5></caption>
            	<thead>
            		<tr>
            			<th class="text-center" width="100">Fecha</th>
            			<th class="text-center" width="100">Inasistencias</th>
            			<th class="text-center">Observaciones</th>
            		</tr>
            	</thead>
            	<tbody>
            		
            	</tbody>
            	<tfoot>
            		<tr>
            			<td><strong>Total:</strong></td>
            			<td><strong id="ina0"></strong></td>
            			<td></td>
            		</tr>
            	</tfoot>
            </table>


        </div><!--/widget-main-->
    </div><!--/widget-body-->

</div>

<script type="text/javascript"> 

jQuery(function($) {

	var IdGruAlu = <?= $idgrualu; ?>;
	var ClaveNivel = <?= $clave_nivel; ?>;

	var screenOrigen = "#"+"<?= $screenOrigen; ?>";
	var screenDestino = "#"+"<?= $screenDestino; ?>";

	var prefijo = "";
	var numeval = 0;

	$("#tg").hide();
	$("#emptyCal").hide();
	$("#laTutores00").hide();

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

	function getMatAluBolCalDetail00(ciclo){
	    var nc = "u="+localStorage.nc+"&idgrualu="+IdGruAlu+"&clave_nivel="+ClaveNivel;
        $("#cmbListMatDetBolCal00").append('<option value="0-0" selected> Seleccione una Materia</option>');
	    $.post(obj.getValue(0)+"data/", { o:4, t:4, p:51, c:nc, from:0, cantidad:0, s:"" },
	        function(json){
	        	$("#alumno").html(json[0].alumno);
	           $.each(json, function(i, item) {
	                $("#cmbListMatDetBolCal00").append('<option value="'+item.data+'-'+item.idboleta+'"> '+item.label+'</option>');
	            });
	        }, "json"
	    );  
	}

	$("#btnViewDetailColBol00").on("click",function(event){
		event.preventDefault();
        $("#preloaderPrincipal").show();
        $("#cal1, #cal2, #cal3, #ina0").empty();
		var arrMat = $("#cmbListMatDetBolCal00").val().split('-');
		var mat = $("#cmbListMatDetBolCal00 option:selected").text();
		var IdGruMat = parseInt( arrMat[0] );
		var IdBoleta = parseInt( arrMat[1] );
		var Init = true;
		if ( IdGruMat <= 0){
			alert("Seleccione una Materia");
	        $("#preloaderPrincipal").hide();
			return false;
		}

		$("#emptyCal").hide();

		$("#tg").hide();
	    $("#tg > tbody").empty();
		$("#laTutores00 > tbody").empty();
		$("#laTutores00").hide();
		$("#h5materia").html(mat);
		var Eval = $("#cmbBimDetBolCal00").val();
	    var nc = "u="+localStorage.nc+"&idgrualu="+IdGruAlu+"&clave_nivel="+ClaveNivel+"&idgrumat="+IdGruMat+"&idboleta="+IdBoleta+"&eval="+Eval;
		$.ajax({
      	async:true,    
      	cache:false,   
      	dataType:"json",
      	type: "POST",   
      	url: obj.getValue(0)+"data/",
      	data: { o:5, t:5, p:51, c:nc, from:0, cantidad:0, s:"" }, 
      	success:  function(json){  
	        	var xs = "";
	        	if ( parseInt(json.length,0) <= 0 ){
	        		$("#emptyCal").html("<tr><td>No hay califiaciones para "+mat+"</td></tr>");
					$("#emptyCal").show();
			        $("#preloaderPrincipal").hide();
	        		return false;
	        	}
	    		$("#tg").show();
	            $.each(json, function(i, item) {
	        		
	        		var porc,cal,calreal, desc;
	           		desc = item.desc2;
		        	porc = parseInt(item.porcentaje,0);
		        	cal = parseInt(item.calificacion,0);
		        	calreal = item.calreal;

	               	var nc = "u="+localStorage.nc+"&idgrualu="+IdGruAlu+"&idbolpar="+item.idbolpar+"&idgrumatcon="+item.idgrumatcon+"&idboleta="+IdBoleta+"&eval="+Eval;
				    $.post(obj.getValue(0)+"data/", { o:6, t:6, p:51, c:nc, from:0, cantidad:0, s:"" },
				        function(json){
				        	var cnt = parseInt(json.length,0) ;
				        	var cant = cnt > 1 ? ' rowspan="'+(cnt+1)+'" ' : ' rowspan="2" ' ;
				        	var colorcal = cal >= 60 ? "blue" : "red 2x@red";
				        	var IsPorc = false;
			                var xs = "<tr class='row2'>";
			                xs += "<td "+cant+"><span class='blue'><strong>"+desc+"</strong></span><strong class='marginLeft1em orange'>"+porc+"%</strong></td>";	                
			                xs += "<td "+cant+" class='"+colorcal+" text-right'>"+cal+"</td>";
			                xs += "<td "+cant+" class='text-right'><strong>"+calreal+"</strong></td>";
	            			
				            $.each(json, function(j, dat) {
					        	var obs, cal1, desc1, desc2;
					        	IsPorc = true;
				           		desc1 = dat.descripcion_breve;
					        	cal1 = parseInt(dat.calificacion,0);
					        	colorcal2 = cal1 <= 0 ? "grey" : "blue";
					        	cal1 = cal1 <= 0 ? 'No existe calificación' : cal1;
				           		obs = dat.observaciones;
				           		desc2 = dat.descavanz;

				                 if (j > 0){ 
				                	xs = "<tr>";
				            	}

				                xs += "<td><span class='marginLeft1em'>"+desc1+"</span></td>";	                
				                xs += "<td><span class='marginLeft2em "+colorcal2+" text-right'>"+cal1+"</span></td>";
				                xs += "<td><span class='green'>"+obs+"</span></td>";	                
				                xs += "<td><span class='blue'>"+desc2+"</span></td>";	                
				                xs += "</tr>";

				                $("#tg > tbody").append(xs);

				            });
				            if ( IsPorc ){
				                xs = "<tr class='tr2'>";
				                xs += "<td><span class='marginLeft1em'><strong>Promedio</strong></span></td>";	                
				                xs += "<td><span class='marginLeft2em text-right'></span>"+cal+"</td>";
				                xs += "<td><span class='green'></span></td>";	                
				                xs += "<td><span class='blue'></span></td>";	                
				                xs += "</tr>";
				                $("#tg > tbody").append(xs);
							}

					        $("#preloaderPrincipal").hide();



				        }, "json"
				    );  
					if ( Init ){
				        $("#preloaderPrincipal").show();
		               	var nc = "u="+localStorage.nc+"&idgrualu="+IdGruAlu+"&idboleta="+IdBoleta+"&eval="+Eval;
					    $.post(obj.getValue(0)+"data/", { o:7, t:7, p:51, c:nc, from:0, cantidad:0, s:"" },
					        function(json){
					        	$("#cal2").html( json[0].cal );
					        	$("#cal3").html( json[0].profesor );
				        		$("#cal2").removeClass('red');
				        		$("#cal2").removeClass('green');
					        	if ( parseInt(json[0].cal,0) < 60 ){
					        		$("#cal2").addClass('red');
					        	}else{
					        		$("#cal2").addClass('green');
					        	}
						        $("#preloaderPrincipal").hide();
						        getInasistencias02(IdGruAlu,Eval,IdBoleta,json[0].ina );
					        }, "json"
					    );  
				    	Init = false;
					}







	             });

		}


	    //     }, "json"
	    // );  
        

        
        });
         
                     
                     
        

	});


	function getInasistencias02(IdGruAlu, Eval, IdBoleta, Ina){
		$("#preloaderPrincipal").show();
		$("#ina0").removeClass('green');
		$("#ina0").empty();
		$("#laTutores00 > tbody").empty();
		$("#laTutores00").hide();
       	var nc = "u="+localStorage.nc+"&idgrualu="+IdGruAlu+"&eval="+Eval+"&idboleta="+IdBoleta;
	    $.post(obj.getValue(0)+"data/", { o:8, t:8, p:51, c:nc, from:0, cantidad:0, s:"" },
	        function(json){
	        		var total = parseInt(json.length,0);
	        		if (total <= 0){
	        			$("#preloaderPrincipal").hide();
	        			return false;
	        		}
	        		$("#laTutores00").show();
	        		$.each(json, function(i, item) {
	        			var xs = '<tr>';
		            		xs += '		<td class="text-center">'+item.cfecha+'</td>';
		            		xs += '		<td class="text-center">'+item.inasistencias+'</td>';
		            		xs += '		<td class="green">'+item.observaciones+'</td>';
		            		xs += '</tr>';
		            		$("#laTutores00 > tbody").append(xs);
	        		});
					$("#ina0").html( Ina );
					$("#ina0").addClass('green');
	        	  	$("#preloaderPrincipal").hide();
	        }, "json"
	    );  

	}

	function getNivel(ClaveNivel){
	    var nc = "u="+localStorage.nc+"&clave_nivel="+ClaveNivel;
        $("#cmbBimDetBolCal00").empty();
	    $.post(obj.getValue(0)+"data/", { o:9, t:9, p:51, c:nc, from:0, cantidad:0, s:"" },
	        function(json){
	           
	            for(i=0; i<parseInt(json[0].numero_evaluaciones,0); i++ ) {
	                $("#cmbBimDetBolCal00").append('<option value="'+i+'"> '+json[0].prefijo_evaluacion+' '+(i+1)+'</option>');
	            };

	        }, "json"
	    );  
	}


	getNivel(ClaveNivel);
	getMatAluBolCalDetail00();

	$("#preloaderPrincipal").hide();

});		

</script>

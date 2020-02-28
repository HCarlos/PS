<?php

include("includes/metas.php");

$de       = $_POST['user'];
$idgrupo  = $_POST['idgrupo'];
$grupo    = $_POST['grupo'];
$materia    = $_POST['materia'];
$idgrumat    = $_POST['idgrumat'];
$numeval    = $_POST['numeval'];

?>

<div  class="row-fluid">
	<div class="widget-box span12">

		<div  class="widget-header header-color-default widget-header-flat padtop05em">
			
			<div class="widget-toolbar orange pull-left no-border " >

				<h4 class="smaller">
					<i class="icon-edit green"></i>
					Calificaciones: <strong><?= $grupo; ?></strong>  <span color="white"><?= $materia; ?></span>
				</h4>

			</div>
		<div class="widget-toolbar border pull-right">
		    <button  type="button" class="btn btn-minier btn-primary arrowed-in-right arrowed  " id="btnCloseCapCal02" style="margin: 0 1em !important;" >
		        <i class="icon-angle-left icon-on-right"></i>
		        Regresar
		    </button>
		</div>

		</div>

		<div class="widget-body">
			<div class="widget-main padding-4">
				<div class="content">

					<form id="frmDataCapCal" class="form">
						<table id="tblCal" class="bordered">
							<thead></thead>
								<th></th>
							<tbody>
								<tr>
									<td>Lista de alumnos vacia. Haga click en 'Ver Calificaciones' para consultar su lista o configure sus Porcentajes de evaluación.</td>
								</tr>
							</tbody>

						</table>

						<div class="clearfix"></div>
						<input type="hidden" name="idgrupo" id="idgrupo" value="<?php echo $idgrupo; ?>">
						<input type="hidden" name="num_eval_capcal_fmt_0" id="num_eval_capcal_fmt_0" value="<?php echo $numeval; ?>">
						<input type="hidden" name="user" id="user" value="<?php echo $de; ?>">
						<div class="form-group w96" style='margin-right: 3em; margin-top: 1em;'>
							<button type="submit" class="btn btn-primary pull-left" style='margin-right: 4em;' id="cmdSaveCapCal"><i class="icon-save"></i>Guardar</button><span id="spLoading1" class="marginLeft1em"><i class="fa fa-spinner fa-spin orange" aria-hidden="true"></i> Guardando datos, por favor espere...</span>
						</div>

					</form>	
				</div>	
			</div>	
		</div>	
	</div>	
</div>	

<script type="text/javascript">        

jQuery(function($) {

	$("#cmdSaveCapCal").hide();
	$("#spLoading1").hide();

	var TRPP = 20;
	var IdUNA = localStorage.IdUserNivelAcceso;
	var arrItems = [];
	var arrHD = [];
	var arrRow = {};
	var evalDef = <?= $numeval; ?>;
	var evalMod = 0;
	var IdGruMat = <?= $idgrumat; ?>;
	var Materia = "<?= $materia; ?>";

	getGridCaptura( IdGruMat );

	function getGridCaptura(IdGruMat){
		$("#tblCal").html('<thead></thead><tbody></tbody>');
		$("#tblCal > thead").empty();
		$("#tblCal > tbody").empty();
		$("#preloaderPrincipal").show();
		var xTR;
		var nc = "u="+localStorage.nc+"&idgrumat="+IdGruMat+"&numval="+evalDef;
		$.post(obj.getValue(0)+"data/", { o:1, t:34, p:11, c:nc, from:0, cantidad:0, s:"" },
			function(json){
		        	if (json.length>0){
							xTR = "<tr>";
							xTR += "<th>No</th>";  
							xTR += "<th>Alumno</th>";  
				               $.each(json, function(i, item) {
				               		arrHD[i] = {
				               					idgrumatcon:item.idgrumatcon,
				               					descripcion:item.descripcion,
				               					porcentaje:parseInt(item.porcentaje,0)
				               					};
				               		
				               		xTR += "<th>"+item.descripcion+" "+parseInt(item.porcentaje,0)+"%"+"</th>"; 
				                });
				                getListaAlumnos(IdGruMat);
							xTR += "<th>Eval</th>";  
							xTR += "<th>Con</th>";  
							xTR += "<th>Ina</th>";  
							xTR += "<th>Obs</th>";  
						    xTR += "</tr>";
						   	$("#tblCal > thead").html(xTR);
						   	$("#cmdSaveCapCal").show();

					}else{
						xTR = "<table id='tblCal' class='bordered'>";
						xTR += "<thead></thead>";
						xTR += "<th></th>";
						xTR += "<tbody>";
						xTR += "<tr>";
						xTR += "<td>Lista de alumnos vacia. Haga click en 'Ver Calificaciones' para consultar su lista o configure sus Porcentajes de evaluación.</td>";
						xTR += "</tr>";
						xTR += "</tbody>";
						xTR += "</table>";
						$("#tblCal").html(xTR);
					}

		    }, "json"
		);
	    $("#preloaderPrincipal").hide();
	}

	function getListaAlumnos(IdGruMat){

		var nc = "u="+localStorage.nc+"&idgrumat="+IdGruMat+"&numval="+evalDef;
       	$("#preloaderPrincipal").show();
		$.post(obj.getValue(0)+"data/", { o:1, t:33, p:11, c:nc, from:0, cantidad:0, s:"" },
			function(json){
				
				arrItems = [];
				$.each(json, function(i, item) {

					arrItems[i] = {
									idboleta:item.idboleta,
									alumno:item.alumno,
									num_lista:item.num_lista,
									cal:item.cal,
									con:item.con,
									ina:item.ina,
									obs:item.obs,
					};

				});
               $("#preloaderPrincipal").hide();
               //alert(arrItems.length);
				paintTable();
			}, "json"
		);
	}

	function paintTable(){
		$("#tblCal > tbody").empty();
		var tNdxCon = 100;
		var tNdxIna = 200;
		var tNdxObs = 300;
		$.each(arrItems, function(i, item) {
	       	$("#preloaderPrincipal").show();
			var k = arrItems[i].idboleta;
			var mod = item.cal % parseInt(item.cal,0);
			var cal = mod==0?parseInt(item.cal,0):item.cal;
			var cnd = parseInt(item.con,0);
			var nss = parseInt(item.ina,0);
			var bsr = parseInt(item.obs,0);
			
			var defcolorep = cal<60?'colorreprobado':'';
		    var xTR = "<tr class='"+defcolorep+"'>";
				xTR += "<td class='center'>"+item.num_lista+"</td>";  
				xTR += "<td>"+item.alumno+"</td>";  

				$.each(arrHD, function(j, item) {

			  		xTR += "<td class='colclick alineaTextoalaDerecha' id='tdcol-"+k+'-'+item.idgrumatcon+"'></td>"; 
			  		// console.log("tdcol-"+k+'-'+item.idgrumatcon);
					if (j==arrHD.length-1){
							var vcal = cal>0?cal:'';
							var vina = nss>0?nss:'';
							var vcon = cnd>0?cnd:'';
							var vobs = bsr>0?bsr:'';
							xTR += "<td class='textRight colorcal'>"+vcal+"</td>";  
							xTR += "<td class='textRight'><input type='text' name='cond-"+k+'-'+evalDef+"' id='cond-"+k+'-'+evalDef+"' class='calif' maxlength='3' tabindex='"+tNdxCon+"' value='"+vcon+"' ></td>";  
							xTR += "<td class='center'>"+vina+"</td>";  
							xTR += "<td class='textRight'><input type='text' name='obs-"+k+'-'+evalDef+"' id='obs-"+k+'-'+evalDef+"'  class='calif' maxlength='3' tabindex='"+tNdxObs+"' value='"+vobs+"' ></td>";  
						   	//$("#tblCal > tbody").append(xTR);
						   	tNdxCon++;
						   	tNdxIna++;
						   	tNdxObs++;
			               $("#preloaderPrincipal").hide();
					}
			   	});
				xTR += "</tr>";
			   	$("#tblCal > tbody").append(xTR);
			   	if (i==arrItems.length-1){
			   		showTable();
			   	}

				$("#preloaderPrincipal").hide();
		});
	}

	function showTable(){
		
		var tNdxCal = 400;
		$.each(arrHD, function(j, item) {

	       	$("#preloaderPrincipal").show();

			var sfind = "idgrumatcon="+item.idgrumatcon;

			$.ajax({
              async:false,   
              cache:false,  
              dataType:"json",
              type: 'POST',  
              url: obj.getValue(0)+"data/",
              data:  { o:1, t:36, p:11, c:sfind, from:0, cantidad:0, s:"" },
              success:  function(json){

						$.each(json, function(j, item) {
							var vval = parseInt(item.calificacion,0) > 0 ? item.calificacion : '';
	  						$("#tdcol-"+item.idboleta+'-'+item.idgrumatcon).html(vval); 
	  					});
						
						$('#frmDataCapCal').find('input').each(function () {
							if ( $(this).attr('tabindex') == null ){
								$(this).attr('tabindex', tNdxCal);
								tNdxCal++;
							} 
						});

						},
							beforeSend:function(){},
							error:function(objXMLHttpRequest){
								alert(objXMLHttpRequest.text);
								return false;
							}
			            });
			$("#preloaderPrincipal").hide();
	   	});

		$( ".calif" ).on('keydown',function(event) {
			console.log(event.keyCode);
			var kLL = obj.getkeyLatLon( event.keyCode );
			if ( kLL == -1 && !event.shiftKey){
				event.preventDefault();
				$(this).keypress(8);
			}
			
			var arrKey = [];
			if ( 
				(localStorage.SOP == "iPad" && event.key == "*") || 
				(localStorage.SOP == "MacIntel" && event.key == "*") 
				){ 
				arrKey = [56, 106, 171, 187];
			}else{
				arrKey = [106, 171, 187];
			}

			if ( arrKey.indexOf( parseInt(event.keyCode,0) ) != -1 ){
				$(this).val(evalAsteriskCapCal(event.currentTarget.id));
			}

		});

		$(".calif").focus(function() {
		   $(this).select();
		});		

		$( ".calif" ).on('focusout',function(event) {
			var xs = parseInt($(this).val(),0);
			if (xs > 100){
				$(this).val(evalAsteriskCapCal(event.currentTarget.id,xs));
			}

		});

		$(".calif").on('keyup',function(event) {
			
			var ids;
			// alert(event.keyCode);

			if (event.currentTarget.id.indexOf('cond') != -1) {
				ids = 1;
			} else if (event.currentTarget.id.indexOf('obs') != -1) {
				ids = 3;
			}else{
				ids = 2;
			}	
			
			if ( $("#"+event.currentTarget.id).val().length >= ids ){
		        event.stopPropagation();
		        event.preventDefault();
		    	var ind = parseInt($("#"+event.currentTarget.id).attr('tabindex'),0)+1;
			 	$("[tabindex='"+ind+"']").focus();
		    	return false;
			};

		});

	}


    $("#frmDataCapCal").unbind("submit");
	$("#frmDataCapCal").on("submit",function(event){
		event.preventDefault();

		$("#preloaderPrincipal").show();
		$("#cmdSaveCapCal").prop("disabled",true);
		$("#spLoading1").show();
		
	    var queryString = $(this).serialize();	
	    				var xIdBolPar = '';
	    				var xIdBolParCal = '';
	    				var xIdBolCon = '';
	    				var xIdBolConCal = '';
	    				var xIdBolIna = '';
	    				var xIdBolInaCal = '';
	    				var xIdBolObs = '';
	    				var xIdBolObsCal = '';
						$('#frmDataCapCal').find('input').each(function () {
							var v1 = $(this).attr('id').split('-');
							var v0 = $(this).val()=='' ? 0 : $(this).val();
							if (v1[0]=="idbolpar"){
								xIdBolPar += xIdBolPar == '' ? v1[1] : '|'+v1[1];
								xIdBolParCal += xIdBolParCal == '' ? v0 : '|'+v0;
							}	

							if (v1[0]=="cond"){
								xIdBolCon += xIdBolCon == '' ? v1[1] : '|'+v1[1];
								xIdBolConCal += xIdBolConCal == '' ? v0 : '|'+v0;
							}	

							if (v1[0]=="ina"){
								xIdBolIna += xIdBolIna == '' ? v1[1] : '|'+v1[1];
								xIdBolInaCal += xIdBolInaCal == '' ? v0 : '|'+v0;
							}	

							if (v1[0]=="obs"){
								xIdBolObs += xIdBolObs == '' ? v1[1] : '|'+v1[1];
								xIdBolObsCal += xIdBolObsCal == '' ? v0 : '|'+v0;
							}	

						});

		queryString = "IdBolPar="+xIdBolPar+"&IdBolParCal="+xIdBolParCal+"&IdBolCon="+xIdBolCon+"&IdBolConCal="+xIdBolConCal+"&IdBolIna="+xIdBolIna+"&IdBolInaCal="+xIdBolInaCal+"&IdBolObs="+xIdBolObs+"&IdBolObsCal="+xIdBolObsCal+"&num_eval_capcal_fmt_0="+$("#num_eval_capcal_fmt_0").val()+"&user="+$("#user").val();				
	    // alert(queryString);
        $.post(obj.getValue(0) + "data/", {o:19, t:1, c:queryString, p:2, from:0, cantidad:0, s:''},
        function(json) {
        		if (json[0].msg=="OK"){
        			alert("Datos guardados con éxito.");
					$("#cmdSaveCapCal").prop("disabled",false);
					$("#spLoading1").hide();
					var igm = IdGruMat;
					closeCapCal02();
					$("#preloaderPrincipal").hide();
    			}else{
					$("#preloaderPrincipal").hide();
					$("#cmdSaveCapCal").prop("disabled",false);
					$("#spLoading1").hide();
    				alert("Error: "+json[0].msg);	
    			}
    	}, "json");

	});

/*
	var stream = io.connect(obj.getValue(4));
	stream.on("servidor", jsNewEstado);
	function jsNewEstado(datosServer) {
		var ms = datosServer.mensaje.split("-");
		if (ms[1]=='CAPCAL') {
			var idgm = IdGruMat;
		    // getGridCaptura( idgm );
		}
	}
*/

	$("#btnCloseCapCal02").on("click",function(event){
		event.preventDefault();
		closeCapCal02()
	});

	function closeCapCal02(){
		$("#preloaderPrincipal").hide();
		$("#contentProfile").hide(function(){
			$("#contentProfile").empty();
			$("#contentMain").show();
		});
		resizeScreen();
		return false;
	}


});


</script>
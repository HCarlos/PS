<?php

include("includes/metas.php");

$de       				= $_POST['user'];
$idgrupo  				= $_POST['idgrupo'];
$grupo    				= $_POST['grupo'];
$materia    			= $_POST['materia'];
$idgrumat    			= $_POST['idgrumat'];
$numeval    			= $_POST['num_eval'];
$idpaiareadisciplinaria = $_POST['idpaiareadisciplinaria'];
$grado_pai    			= $_POST['grado_pai'];

$xm = explode('-', $idgrumat);

$idgrumat = $xm[0];

?>

<div  class="row-fluid">
	<div class="widget-box span12">

		<div  class="widget-header header-color-default widget-header-flat padtop05em">
			
			<div class="widget-toolbar orange pull-left no-border " >

				<h4 class="smaller">
					<i class="icon-edit green"></i>
					Calificaciones: <strong><?= $grupo; ?></strong>  <span color="white"><?= $materia; ?></span>   Grado PAI: <strong><?= $grado_pai; ?>
				</h4>

			</div>

			<div class="widget-toolbar border pull-right">
			    <button  type="button" class="btn btn-minier btn-primary arrowed-in-right arrowed  " id="btnExitCapPAI02" style="margin: 0 1em !important;" >
			        <i class="icon-angle-left icon-on-right"></i>
			        Regresar
			    </button>
			</div>

			<div class="widget-toolbar border pull-right">

				<div class="hidden-phone visible-desktop action-buttons pull-left ">
					<a class="widget-toolbar cafe no-border isModMat01" href="#"  id="emptybtnListCalPAI01" title="Calificaciones PAI">
						<i class="fa fa-print bigger-130 "></i>
					</a>
				</div>

			</div>


		</div>

		<div class="widget-body">
			<div class="widget-main padding-4">
				<div class="content">

					<form id="frmCapCalPAI" class="form">
						<table id="tblCal" class="bordered">
							<thead></thead>
								<th></th>
							<tbody>
								<tr>
									<td>Lista de alumnos vacia.</td>
								</tr>
							</tbody>

						</table>

						<div class="clearfix"></div>
						<input type="hidden" name="grado_pai" id="grado_pai" value="<?php echo $grado_pai; ?>">
						<input type="hidden" name="idpaiareadisciplinaria" id="idpaiareadisciplinaria" value="<?php echo $idpaiareadisciplinaria; ?>">
						<input type="hidden" name="idgrupo" id="idgrupo" value="<?php echo $idgrupo; ?>">
						<input type="hidden" name="num_eval_capcal_fmt_0" id="num_eval_capcal_fmt_0" value="<?php echo $numeval; ?>">
						<input type="hidden" name="user" id="user" value="<?php echo $de; ?>">
						<div class="form-group w96" style='margin-right: 3em; margin-top: 1em;'>
							<button type="submit" class="btn btn-primary pull-left" style='margin-right: 4em;' id="cmdSaveCapCalPAI01"><i class="icon-save"></i>Guardar</button>
						</div>

					</form>	
				</div>	
			</div>	
		</div>	
	</div>	
</div>	

<script type="text/javascript">        

jQuery(function($) {
	$("#cmdSaveCapCalPAI01").hide();

	var TRPP = 20;
	var IdUNA = localStorage.IdUserNivelAcceso;
	var arrItems = [];
	var arrHD = [];
	var arrRow = {};
	var evalDef = <?= $numeval; ?>;
	var evalMod = 0;
	var IdGruMat = <?= $idgrumat; ?>;
	var Materia = "<?= $materia; ?>";
	var Grado_PAI = <?= $grado_pai; ?>;
	var Grupo = "<?= $grupo; ?>";
	var IdPAIAreaDisciplinaria = <?= $idpaiareadisciplinaria; ?>;

	var qr = "u="+localStorage.nc+"&idgrumat="+IdGruMat;
	$.post(obj.getValue(0)+"data/", { o:0, t:0, p:59, c:qr, from:0, cantidad:0, s:"" },
	function(json){
			if ( json[0].msg == "OK" ){
				getGridCaptura( IdGruMat );
			}
	    }, "json"
	);

	function getGridCaptura(IdGruMat){
		$("#tblCal").html('<thead></thead><tbody></tbody>');
		$("#tblCal > thead").empty();
		$("#tblCal > tbody").empty();
		$("#preloaderPrincipal").show();
		var xTR;

		var nc = "u="+localStorage.nc+"&idpaiareadisciplinaria="+IdPAIAreaDisciplinaria+"&grado_pai="+Grado_PAI;
		
		// alert(nc);

		$.post(obj.getValue(0)+"data/", { o:1, t:116, p:11, c:nc, from:0, cantidad:0, s:"" },
			function(json){
		        	if (json.length>0){
							xTR = "<tr>";
							xTR += "<th>No</th>";  
							xTR += "<th>Alumno</th>";  
				               $.each(json, function(i, item) {
				               		arrHD[i] = {
				               					idpaicriterio: 		  item.idpaicriterio,
				               					criterio: 			  item.criterio,
				               					descripcion_criterio: item.descripcion_criterio,
				               					numCriterio         : i+1 
				               					};
				               		
				               		xTR += "<th class='center'><b>Criterio "+item.criterio+"</b></br><small>"+item.descripcion_criterio+"</small></th>"; 
				                });
				                getListaAlumnos(IdGruMat, arrItems);
						    xTR += "</tr>";
						   	$("#tblCal > thead").html(xTR);
						   	$("#cmdSaveCapCalPAI01").show();

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

	function getListaAlumnos(IdGruMat, arrItems){

		// arrItems = [];
		$("#preloaderPrincipal").show();
					
		var nc = "u="+localStorage.nc+"&idgrumat="+IdGruMat+"&numval="+evalDef+"&idpaiareadisciplinaria="+IdPAIAreaDisciplinaria+"&grado_pai="+Grado_PAI;
		$.post(obj.getValue(0)+"data/", { o:1, t:117, p:18, c:nc, from:0, cantidad:0, s:"" },
			function(json){
				
				$.each(json, function(i, item) {

					var nodo = item.nodo;
					
					arrItems[i] = {
									idboletapaibi: nodo[0].idboletapaibi,
									idboleta:      item.idboleta,
									alumno:        item.alumno,
									num_lista:     item.num_lista,
									
									e11: nodo[0].e11,
									e1:  nodo[0].e1,
									e12: nodo[0].e12,
									
									e21: nodo[0].e21,
									e2:  nodo[0].e2,
									e22: nodo[0].e22,
									
									e31: nodo[0].e31,
									e3:  nodo[0].e3,
									e32: nodo[0].e32,
									
									e41: nodo[0].e41,
									e4:  nodo[0].e4,
									e42: nodo[0].e42
								};

				   	if ( i == (json.length-1) ){
				   		$("#preloaderPrincipal").hide();
				   		paintTable();
				   	}

				});

               

               // alert(arrItems.length);
				
				// paintTable();

			}, "json"
		);
	}

	function paintTable(){

		$("#tblCal > tbody").empty();

	    $("#preloaderPrincipal").show();

		$.each(arrItems, function(i, item) {


			var k = item.idboleta;
			var k1 = item.idboletapaibi;

			var defcolorep = ''; // c1<6?'colorreprobado':'';
		    var xTR = "<tr class='"+defcolorep+"'>";
				xTR += "<td class='center'>"+item.num_lista+"</td>";  
				xTR += "<td>"+item.alumno+"</td>";  

				$.each(arrHD, function(j, item) {

					var idcriterio = item.idpaicriterio;
					var numcrit = item.numCriterio;
					var idd = "id='tdcol-"+k1+'-'+idcriterio+'-'+numcrit+"'";
					var id1 = "tdinp-"+k1+'-'+idcriterio+'-'+numcrit;	

			  		xTR += "<td class='colclick alineaTextoalaDerecha' "+idd+">"+id1+"</td>"; 

			   	});

				xTR += "</tr>";
			   	$("#tblCal > tbody").append(xTR);
			   	if (i==arrItems.length-1){
					$("#preloaderPrincipal").hide();
			   		showTable();
			   	}

		});
	}

	function showTable(){

		
		var tNdxCal = 0;

		$.each(arrHD, function(j, item) {

			var idcriterio = item.idpaicriterio;
			var numcrit = item.numCriterio;
			var J = j
			var eval;

			$.each(arrItems, function(i, item) {

				var k1 = item.idboletapaibi;

				var c1 = parseInt(item.e1,0);
				var c2 = parseInt(item.e2,0);
				var c3 = parseInt(item.e3,0);
				var c4 = parseInt(item.e4,0);

				switch(J){
					case 0:
						eval = c1;
						break;
					case 1:
						eval = c2;
						break;
					case 2:
						eval = c3;
						break;
					case 3:
						eval = c4;
						break;
				}

				var defcolorep = eval<6?'colorreprobado':'';
				var idd = "tdcol-"+k1+'-'+idcriterio+'-'+numcrit;
				var id1 = "tdinp-"+k1+'-'+idcriterio+'-'+numcrit;	

				var leg = "";

				if ( eval == -1){
					$("#"+idd).addClass(defcolorep);
				}else{
					$("#"+idd).removeClass(defcolorep);
					leg = " <a class='VerLey' id='"+IdPAIAreaDisciplinaria+"-"+idcriterio+"-"+Grado_PAI+"-"+eval+"'> Ver</a>" 
				}

				var inp = "<input type='text' name='"+id1+"' id='"+id1+"'  value='"+eval+"' class='calif altoMoz' maxlength='1' tabindex='"+tNdxCal+"' >";


				$("#"+idd).html(inp+leg);

				tNdxCal++;


			});



	   	});

		$( ".calif" ).on('change',function(event) {
			event.preventDefault();
			validValor(event,0);
		});


		$( ".calif" ).on('keydown',function(event) {
			console.log(event.keyCode);

			// alert(event.keyCode);

			var kLL = obj.getkeyLatLon( event.keyCode );
			if ( kLL == -1 && !event.shiftKey){
				event.preventDefault();
				$(this).keypress(8);
			}
			// var arrKey = [56, 106, 171, 187];
			var arrKey = [106, 171, 187];
			if ( arrKey.indexOf( parseInt(event.keyCode,0) ) != -1 ){
				var Valor = evalAsteriskCapCal(event.currentTarget.id);
				$(this).val(Valor);
				validValor(event,Valor);
			}

			var arrKey = [109, 189];
			if ( arrKey.indexOf( parseInt(event.keyCode,0) ) != -1 ){
				var IDs = event.currentTarget.id.split('-');
				var Valor = evalAsteriskCapCal( IDs[0]+"M1" ) ;
				$(this).val(Valor);
				validValor(event,Valor);
			}

		});

		$(".calif").focus(function() {
		   $(this).select();
		});		

		$( ".calif" ).on('focusout',function(event) {
			var xs = parseInt($(this).val(),0);
			console.log(xs);
			if (xs > 8){
				var Valor = evalAsteriskCapCal(event.currentTarget.id,xs);
				$(this).val(Valor);
				validValor(event,Valor);
			}
		});

		$(".calif").on('keyup',function(event) {
			
			var ids = 1;
			if ( $("#"+event.currentTarget.id).val().length >= ids ){
		        event.stopPropagation();
		        event.preventDefault();
		    	var ind = parseInt($("#"+event.currentTarget.id).attr('tabindex'),0)+1;
			 	$("[tabindex='"+ind+"']").focus();
		    	return false;
			};

		});

		$(".VerLey").on("click",function(event){
			 event.preventDefault();
			 var ids = event.currentTarget.id.split('-');

			 var nc = "u="+localStorage.nc+"&idpaicriterio="+ids[1]+"&idpaiareadisciplinaria="+IdPAIAreaDisciplinaria+"&grado_pai="+Grado_PAI+"&rango_califica="+ids[3];
			$.post(obj.getValue(0)+"data/", { o:1, t:60, p:54, c:nc, from:0, cantidad:0, s:"" },
			function(json){
					alert(json[0].concepto);
					// alert(nc);
    		}, "json");
		});

	}

	function validValor(event,Valor){
			event.preventDefault();
			var xs = parseInt($("#"+event.currentTarget.id).val(),0);
			if ( Valor != 0 ){
				xs = Valor;
			} 
			var IDs = event.currentTarget.id.split('-');
			var idd = "tdcol-"+IDs[1]+'-'+IDs[2]+'-'+IDs[3];
			var defcolorep = 'colorreprobado';

			if ( xs == -1){
				$("#"+idd).addClass(defcolorep);
			}else{
				$("#"+idd).removeClass(defcolorep);
			}		
	}

    $("#frmCapCalPAI").unbind("submit");
	$("#frmCapCalPAI").on("submit",function(event){
		event.preventDefault();

		$("#preloaderPrincipal").show();
		
	    var queryString = $(this).serialize();	

		var xIdPAIID   = '';
		var xIdPAICRIT = '';
		var xIdPAICAL  = '';
		var xNUMCRIT   = '';

		$('#frmCapCalPAI').find('input').each(function () {

			var v1 = $(this).attr('id').split('-');
			var v0 = $(this).val()=='' ? 0 : $(this).val();

			// v1[1] = v1[1];

			if (v1[0]=="tdinp"){

				xIdPAIID += xIdPAIID == '' ? v1[1] : '|'+v1[1];
				xIdPAICRIT += xIdPAICRIT == '' ? v1[2] : '|'+v1[2];
				xIdPAICAL += xIdPAICAL == '' ? v0 : '|'+v0;
				xNUMCRIT += xNUMCRIT == '' ? v1[3] : '|'+v1[3];

			}

		});

		queryString =   "Grado_PAI="               + Grado_PAI +
						"&IdPAIAreaDisciplinaria=" + IdPAIAreaDisciplinaria + 
						"&IdPAIID="                + xIdPAIID + 
						"&IdPAICRIT="              + xIdPAICRIT + 
						"&IdPAICAL="               + xIdPAICAL + 
						"&NUMCRIT="                + xNUMCRIT + 
						"&num_eval_capcal_fmt_0="  + $("#num_eval_capcal_fmt_0").val() + 
						"&user="                   + $("#user").val();				
        
		// alert(queryString);
		// return false;

        $.post(obj.getValue(0) + "data/", {o:19, t:1, c:queryString, p:52, from:0, cantidad:0, s:''},
        function(json) {
        		if (json[0].msg=="OK"){
        			alert("Datos guardados con éxito.");
					// stream.emit("cliente", {mensaje: "PLATSOURCE-CAPCAL_PAI-PROP-"+localStorage.grupo_cal});
					var igm = IdGruMat;
					closeCapCal02();
					$("#preloaderPrincipal").hide();
    			}else{
					$("#preloaderPrincipal").hide();
    				alert("Error: "+json[0].msg);	
    			}
    	}, "json");

	});


	$("#emptybtnListCalPAI01").on("click",function(event){
		event.preventDefault();
		// $("#preloaderPrincipal").show();

		// var nc = "u="+localStorage.nc+"&strgrualu="+strGruAlu+"&grado="+Gradox+"&idciclo="+IdCiclo+"&grupo="+Grupo;
		var nc = "u="+localStorage.nc+
				"&idpaiareadisciplinaria="+IdPAIAreaDisciplinaria+
				"&grado_pai="+Grado_PAI+
				"&grupo="+Grupo+
				"&idgrumat="+IdGruMat+
				"&numval="+evalDef+
				"&materia="+Materia;
        
        var PARAMS = {c:nc};

        var	url = obj.getValue(0)+"lista-calificaciones-pai/";
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

/*
	var stream = io.connect(obj.getValue(4));
	stream.on("servidor", jsNewEstado);
	function jsNewEstado(datosServer) {
		var ms = datosServer.mensaje.split("-");
		if (ms[1]=='CAPCAL_PAI') {
			var idgm = IdGruMat;
		    // getGridCaptura( idgm );
		}
	}
*/

	$("#btnExitCapPAI02").on("click",function(event){
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
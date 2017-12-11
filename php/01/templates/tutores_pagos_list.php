<?php

include("includes/metas.php");

$de       = $_POST['user'];

?>


<div class="widget-box transparent">
	<div class="widget-header widget-header-blue widget-header-flat">

		<div class="widget-toolbar tools">

			<a href="#" class="ui-pg-div" data-action="reload" id="btnRefresh" >
				<i class="ui-icon icon-refresh green"></i>
			</a>

		</div>

		Hijos: <select class="altoMoz add-on"  name="listAlumnosTarTutor0" id="listAlumnosTarTutor0" size="1"></select>
		<span class="marginLeft2em"></span>

	</div>

	<div class="widget-body">
		<div class="widget-main">
			<div class="row-fluid">

				<table aria-describedby="sample-table-2_info" id="tblPagosTutor0001Mod001" class="table table-striped table-bordered table-hover dataTable">
									
					<thead>
						<tr role="row">
							<th aria-label="idpago: to sort column ascending" style="width: 10px;" aria-controls="tblPagosTutor0001Mod001" tabindex="0" role="columnheader" class="sorting" >ID</th>
							<th aria-label="concepto: to sort column ascending" style="width: 150px;" aria-controls="tblPagosTutor0001Mod001" tabindex="1" role="columnheader" class="sorting">CONCEPTO</th>
							<th aria-label="importe: to sort column ascending" style="width: 10px;" aria-controls="tblPagosTutor0001Mod001" tabindex="2" role="columnheader" class="sorting center">IMPORTE</th>
							<th aria-label="descto: to sort column ascending" style="width: 10px;" aria-controls="tblPagosTutor0001Mod001" tabindex="3" role="columnheader" class="sorting center">-DESCTO</th>
							<th aria-label="recargo: to sort column ascending" style="width: 10px;" aria-controls="tblPagosTutor0001Mod001" tabindex="4" role="columnheader" class="sorting center">+RECARGO</th>
							<th aria-label="importe: to sort column ascending" style="width: 10px;" aria-controls="tblPagosTutor0001Mod001" tabindex="5" role="columnheader" class="sorting center">TOTAL</th>
							<th aria-label="" style="width: 100px;" role="columnheader" class="sorting_disabled"></th>
						</tr>
					</thead>
									
					<tbody aria-relevant="all" aria-live="polite" role="alert"></tbody>
				</table>

			</div>	
		</div><!--/widget-main-->
	</div><!--/widget-body-->
</div>

<script type="text/javascript">        

jQuery(function($) {

    $("#preloaderPrincipal").show();
           //alert(localStorage.nc);

	var IsRegistry = false;
	var IdGrupo;	

	var IdFamilia = 0;
	var Tutor = IdFamilia;
	
	var oTable;


	if (localStorage.TRPP){
		TRPP = parseInt(localStorage.TRPP,0);	
	}
	oPag = {init:true, totalRegistros:0, totalPaginas:0, currentPage:0, registrosPorPagina:TRPP, Limit:'', Query:'' };

	function getTableTartTut0(){

		oTable = $('#tblPagosTutor0001Mod001').dataTable({
	        "oLanguage": {
	                    	"sLengthMenu": "_MENU_ registros por página",
	                    	"oPaginate": {
	                                		"sPrevious": "Prev",
	                                		"sNext": "Next"
	                                     },
	                        "sSearch": "Buscar",
	                        "sProcessing":"Procesando...",
	                        "sLoadingRecords":"Cargando...",
	 						"sZeroRecords": "No hay registros",
	            			"sInfo": "_START_ - _END_ de _TOTAL_ registros",
	            			"sInfoEmpty": "No existen datos",
	            			"sInfoFiltered": "(De _MAX_ registros)"                                        
	        			},	
	        "aaSorting": [[ 0, "asc" ]],			
			"aoColumns": [ null, null, null, null, null, null, { "bSortable": false }],
			"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
			"bRetrieve": true,
			"bDestroy": false
	 	});
	}


    function getListAluForTarTutor(){
	    var nc = "u="+localStorage.nc;
        $("#preloaderPrincipal").show();
	    $("#listAlumnosTarTutor0").empty();
	    $.post(obj.getValue(0)+"data/", { o:1, t:44, p:0,c:nc,from:0,cantidad:0, s:" order by idfamalu asc " },
	        function(json){
	            var st="";
	            $.each(json, function(i, item) {
	                $("#listAlumnosTarTutor0").append('<option value="'+item.data+'"> '+item.label+'</option>');
	            });
	            onClickFillTableTutorPagos();


	        $("#preloaderPrincipal").hide();
	        }, "json"

    	);
    }	  

   $("#listAlumnosTarTutor0").on("change", function(event) {
       event.stopPropagation();
       onClickFillTableTutorPagos();
   });


	function fillTableTutorPagos(){
						
		var tB = "";

		$("#preloaderPrincipal").show();

		$('#tblPagosTutor0001Mod001 > tbody').empty();

		var idalu = parseInt( $("#listAlumnosTarTutor0").val() );


		var nc = "u="+localStorage.nc+ "&idfamilia="+IdFamilia+"&idalumno="+idalu;
		
		$.post(obj.getValue(0) + "data/", {o:40, t:10010, c:nc, p:11, from:0, cantidad:0,s:' and is_mostrable = 1 order by orden_prioridad asc, status_movto asc, idpago asc '},
			function(json){
				if (json.length){
					var lec,arc,res,des;
					var arrPag = [];
					$.each(json, function(i, item) {

							var id = parseInt(item.idedocta,0);
							var idpago = item.idpago;
							var idconcepto = parseInt(item.idconcepto,0);
							var pagosDiv = parseInt(item.is_pagos_diversos,0); 
							if (item.is_pagos_diversos=="1" ){
								concp0 =  item.concepto+' '+item.mes;
							}else{
								concp0 =  item.concepto;
							}

						tB +=' 			<tr class="odd">';
						tB +=' ';
						tB +='				<td class=" ">';
						tB +='					<a class="modTutorPagoPro00" href="#" id="idprof0-'+id+'"  data-rel="tooltip" data-placement="top" title="Realizar Pago">'+padl(id,4)+'</a>';
						tB +='				</td>';
						tB +='				<td>'+concp0+'</td>';
						tB +='				<td class="textRight">'+item.importe+'</td>';
						tB +='				<td class="textRight">'+item.descto+'</td>';
						tB +='				<td class="textRight">'+item.recargo+'</td>';
						tB +='				<td class="textRight">'+item.total+'</td>';
						tB +='				<td>';
						tB +='					<div class="action-buttons">';

						if ( parseInt( item.status_movto,0 )  == 0 ) {
							if ( arrPag.indexOf(idconcepto) == -1 || pagosDiv == 0 ) {
								// tB +='						<a class="btn btn-minier  btn-success modTutorPagoPro0" href="#" id="idpago-'+id+'-'+id+'-'+item.concepto2+'-'+item.total+'-'+Tutor+'" data-rel="tooltip" data-placement="top" title="Realizar Pago">Pagar</a>';
								tB +='						<a class="btn btn-minier  btn-info modTutorPagoPro1" href="#" id="idpago-'+id+'-'+id+'-'+item.concepto2+'-'+item.total+'-'+Tutor+'" data-rel="tooltip" data-placement="top" title="Realizar Pago">Pagar</a>';
								arrPag.push(idconcepto);
								if ( id == 55914){
									// tB +='						<a class="btn btn-minier  btn-info modTutorPagoPro1" href="#" id="idpago-'+id+'-'+id+'-'+item.concepto2+'-'+item.total+'-'+Tutor+'" data-rel="tooltip" data-placement="top" title="Realizar Pago">Pagar</a>';
								}
							}else{
								tB +='';
							}
						}else {
							// ( parseInt( item.status_movto,0 )  != 0 && i > 0 ){	
							tB +='							<strong class="text-info">P A G A D O</strong> ( <small><i>'+item.fecha_de_pago+'</i></small> )';
						}	
						tB +='					</div">';
						tB +='				</td>';
						tB +='			</tr>'; 
					});
				 	
				 	//alert(tB);

					$('#tblPagosTutor0001Mod001 > tbody').html(tB);

					$("#preloaderPrincipal").hide();

					$(".modTutorPagoPro0").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						getPropPagoTutor2(arr[1],arr[2],arr[3],arr[4],arr[5]);
					});

					$(".modTutorPagoPro1").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						getPropPagoTutor3(arr[1],arr[2],arr[3],arr[4],arr[5]);
					});

					$('[data-rel=tooltip]').tooltip();

					if (init==true){
						getTableTartTut0();
						init = false;
					}else{
						oTable.fnClearTable();
						oTable.fnDraw();
					}
				}else{
					
					$('#tblPagosTutor0001Mod001 > tbody').empty();


					if (init==true){
						getTableTartTut0();
						init = false;
					}else{
						oTable.fnClearTable();
						oTable.fnDraw();
					}

					$("#preloaderPrincipal").hide();
				}		
        	},
        'json'
        );
							
	}
	

	$("#btnRefresh").on("click",function(event){
		event.stopPropagation();
		onClickFillTableTutorPagos();
	})

	function onClickFillTableTutorPagos(){
		
		
		if(oTable != null){
			oTable.fnDestroy();
			$('#tblPagosTutor0001Mod001 > tbody').empty();
			init = true;
		}
		
		fillTableTutorPagos();
	}

	function getPropPagoTutor2(IdPago, Referencia, Concepto2, Importe, Tutor){

		var oIdUser = localStorage.IdUser;
        var PARAMS = {s_transm:IdPago, c_referencia:Referencia, val_1:'000', t_servicio:Concepto2, t_importe:Importe, val_2:Tutor, val_3:1, val_4:1, val_5:1, val_6:1, IdUser: oIdUser};
        // var PARAMS = {s_transm:IdPago, c_referencia:Referencia, val_1:'000', t_servicio:Concepto2, t_importe:1.00, val_2:Tutor, val_3:1, val_4:1, val_5:1, val_6:1};

    	var url = "https://www.adquiramexico.com.mx/clb/endpoint/colegioarji/";
    			   // https://www.adquiramexico.com.mx/clb/endpoint/colegioarji/

        var tit = "Tutor-Pago-"+nc+'-'+IdPago;

        trackOutboundLink(url,tit);

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


	}


	function getPropPagoTutor3(IdPago, Referencia, Concepto2, Importe, Tutor){

		var oIdUser = localStorage.IdUser;
        var urlRetorno = "https://platsource.mx/savePagoFromWeb2MPE/";

        var PARAMS = {
        				importe:Importe,
        				referencia:IdPago,
        				urlretorno:urlRetorno,
        				idexpress:"928",
        				financiamiento:"0",
        				plazos:"",
        				mediospago:"111000"
        			};

    	var url = "https://www.adquiramexico.com.mx:443/mExpress/pago/avanzado";

        // var tit = "Tutor-Pago-"+nc+'-'+IdPago;

        // trackOutboundLink(url,tit);

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


	}


    $("#preloaderPrincipal").show();

    var nc = "u="+localStorage.nc;
    $.post(obj.getValue(0)+"data/", { o:1, t:43, p:0,c:nc,from:0,cantidad:0, s:" limit 1 " },
        function(json){
        	IdFamilia = json[0].data;
        	Tutor = json[0].nombre_tutor;
        	// getFacturasFromTutores(IdFamilia);
        	var fam = getBar('Inicio, Pagos por Alumno de la Familia');
        	$('#breadcrumb').html(fam+': <strong class="text-warning orange">'+json[0].label+'</strong>');
        $("#preloaderPrincipal").hide();
        }, "json"
	);

/*
	var stream = io.connect(obj.getValue(4));
	stream.on("servidor", jsNewSolMatEnc0);
	function jsNewSolMatEnc0(datosServer) {
		var ms = datosServer.mensaje.split("-");
		if (ms[1]=='UPLOAD_FILES_TAREAS_ALU') {
			// onClickFillTableTutorPagos();
		}
		
		if (ms[1]=='ADD_DESTINATARIOS_TAREAS_ALU') {
			// onClickFillTableTutorPagos();
		}
	}
*/


	getListAluForTarTutor();

	var init = true;	

    $("#preloaderPrincipal").hide();
	
});

</script>
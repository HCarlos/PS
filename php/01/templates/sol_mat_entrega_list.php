<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$de       = $_POST['user'];

?>
<div  class="row-fluid">
	<table class="ui-pg-table navtable" style="float:left;table-layout:auto;" border="0" cellpadding="0" cellspacing="0">
		<tbody>
			<tr>
				<td title="" data-original-title="" class="ui-pg-button ui-state-disabled" style="width:4px;">
					<span class="ui-separator marginLeft1em"></span>
				</td>
				<td data-original-title="Reload Grid" id="refresh_grid-table" title="" class="ui-pg-button ui-corner-all">
					<div class="ui-pg-div" id="btnRefresh">
						<span class="ui-icon icon-refresh green"></span>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="widget-toolbar orage">
		<label>
			<small class="green">
				<b>Ver Entregados</b>
			</small>

			<input id="isentregados" type="checkbox" class="ace ace-switch ace-switch-4 orange" />
			<span class="lbl"></span>
		</label>

	</div>

</div>

<div class="borderTopContainer">
	<div id="user-profile-1" class="user-profile row-fluid">
			<div id="sample-table-2_wrapper" class="dataTables_wrapper" role="grid">

				<table aria-describedby="sample-table-2_info" id="sample-table-2" class="table table-striped table-bordered table-hover dataTable">
									
					<thead>
						<tr role="row">
							<th aria-label="idsolicituddematerial: activate to sort column ascending" style="width: 30px;" colspan="1" rowspan="1" aria-controls="sample-table-2" tabindex="0" role="columnheader" class="sorting" >ID</th>
							<th aria-label="solicitante: activate to sort column ascending" style="width: 150px;" colspan="1" rowspan="1" aria-controls="sample-table-2" tabindex="1" role="columnheader" class="sorting">SOLICITA</th>
							<th aria-label="fecha_solicitud: activate to sort column ascending" style="width: 80px;" colspan="1" rowspan="1" aria-controls="sample-table-2" tabindex="1" role="columnheader" class="sorting">FECHA AUTORIZACION</th>
							<th aria-label="observaciones: activate to sort column ascending" style="width: 150px;" colspan="1" rowspan="1" aria-controls="sample-table-2" tabindex="1" role="columnheader" class="sorting">OBSERVACIONES</th>
							<th aria-label="status: activate to sort column ascending" style="width: 80px;" colspan="1" rowspan="1" aria-controls="sample-table-2" tabindex="1" role="columnheader" class="sorting">STATUS</th>
							<th aria-label="" style="width: 100px;" colspan="1" rowspan="1" role="columnheader" class="sorting_disabled"></th>
						</tr>
					</thead>
									
					<tbody aria-relevant="all" aria-live="polite" role="alert"></tbody>
				</table>

			</div><!--PAGE CONTENT ENDS-->

	</div>
</div>

<div id="inline2">
	
</div>
<!--PAGE CONTENT ENDS-->

<script typy="text/javascript">        

jQuery(function($) {

	var oTable;

	function getTable(){

		oTable = $('#sample-table-2').dataTable({
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
	        "aaSorting": [[ 0, "desc" ]],			
			"aoColumns": [ null, null, null, null, null, { "bSortable": false }],
			"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
			"bRetrieve": true,
			"bDestroy": false
	 	});
	}

	function fillTable(){
						
		var tB = "";

		$("#preloaderPrincipal").show();

		var sts = $("#isentregados").is(':checked') ? 2 : 1;	

		//var nc = "u="+localStorage.nc;
		var nc = "u="+localStorage.nc+"&sts="+sts;

		$.post(obj.getValue(0) + "data/", {o:34, t:89, c:nc, p:10, from:0, cantidad:0,s:''},
			function(json){
				if (json.length){
					$.each(json, function(i, item) {

						var pro = parseInt(item.status_solicitud_de_material,0) == 2 ? ' checked ' : ' ';

						tB +=' 			<tr class="odd">';
						tB +=' ';
						tB +='				<td class=" ">';
						tB +='					<a class="modSolMatEnc0Pro" href="#" id="idprof0-'+item.idsolicituddematerial+'"  data-rel="tooltip" data-placement="top" title="Editar la Solicitud">'+padl(item.idsolicituddematerial,4)+'</a>';
						tB +='				</td>';
						tB +='				<td>'+item.solicitante+'</td>';
						tB +='				<td>'+item.fecha_autorizacion+'</td>';
						tB +='				<td>'+item.observaciones+'</td>';
						tB +='				<td>'+item.cEstatus+'</td>';
						tB +='				<td>';
						tB +='					<div class="hidden-phone visible-desktop action-buttons">';
						tB +=' ';
						tB +='						<a class="blue modSolMatEnc2Pro" href="#" id="modSolMatEnc2Pro-'+item.idsolicituddematerial+'-'+item.solicitante+'" data-rel="tooltip" data-placement="top" title="Ver Artículos">';
						tB +='							<i class="icon-folder-open-alt bigger-130"></i>';
						tB +='						</a>';
						tB +=' ';
						tB +='						<label>';
						tB +='							<input name="vaut1-'+item.idsolicituddematerial+'" id="vaut1-'+item.idsolicituddematerial+'" class="ace ace-switch ace-switch-6 acent" type="checkbox" '+pro+' >';
						tB +='							<span class="lbl"></span>';
						tB +='						</label>';						
						tB +='					</div>';						
						tB +='				</td>';
						tB +='			</tr>';
					});
				 	
				 	//alert(tB);

					$('#sample-table-2 > tbody').html(tB);

					$("#preloaderPrincipal").hide();


					$(".modSolMatEnc2Pro").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						getPropSolMatEnc2(arr[1],arr[2]);
					});

					$(".acent").on("change",function(event){
						event.preventDefault();
						var x = confirm("Desea cerrar esta Requisición de Materiales");
						if (!x){
							return false;
						}
						var id = event.currentTarget.id.split('-');
						var id0 = id[1];
						var val0 = $(this).is(':checked') ? 2 : 0;
						var nc = "user="+localStorage.nc+"&id="+id0+"&val="+val0;
	                    $("#preloaderPrincipal").show();
				        $.post(obj.getValue(0)+"data/",  { o:38, t:4, p:2, c:nc, from:0, cantidad:0,s:'' },
				            function(json){
				                if (json[0].msg=="OK"){
				                    $("#preloaderPrincipal").hide();
				                }
				        }, "json");        

					});

					$('[data-rel=tooltip]').tooltip();

					if (init==true){
						getTable();
						init = false;
					}else{
						oTable.fnClearTable();
						oTable.fnDraw();
					}

				}else{
					
					$("#preloaderPrincipal").hide();

					if (init==true){
						getTable();
						init = false;
					}else{
						oTable.fnClearTable();
						oTable.fnDraw();
					}

					return false;
				}		
        	},
        'json'
        );
							
	}
	
	var init = true;			
	fillTable();


	$("#btnRefresh").on("click",function(event){
		event.preventDefault();
		onClickFillTable();
	})

	function onClickFillTable(){
		if(oTable != null){
			oTable.fnDestroy();
			$('#sample-table-2 > tbody').empty();
			init = true;
		}
		fillTable();
	}

	$("#isentregados").on("change",function(event){
		event.preventDefault();
		onClickFillTable();
	});

	function getPropSolMatEnc2(IdSolMatEnc0, Solicitante){
        $("#contentProfile").html("");
        $("#contentMain").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
	        $.post(obj.getValue(0) + "entrega_cat-sol-mat-asign_1/", {
				user: nc,
				idsolicituddematerial: IdSolMatEnc0,
				solicitante: Solicitante
	            },
	            function(html) {	                
	                $("#contentProfile").html(html).show('slow',function(){
	                	//$("#contentProfile");	
		                $('#breadcrumb').html(getBar('Inicio, Pedidos realizados '));
	                });
	            }, "html");
        });
        return false;
	}

	var stream = io.connect(obj.getValue(4));
	stream.on("servidor", jsNewSolMatEnc0);
	function jsNewSolMatEnc0(datosServer) {
		var ms = datosServer.mensaje.split("-");
		if (ms[1]=='SOL_MAT_ENTREGA') {
			onClickFillTable();
		}
	}




});



</script>
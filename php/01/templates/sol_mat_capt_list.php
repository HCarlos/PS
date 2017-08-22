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
				<td data-original-title="Add new row" id="add_grid-table" title="" class="ui-pg-button ui-corner-all">
					<div class="ui-pg-div" id="btnAddRegistry" >
						<span class="ui-icon icon-plus-sign purple"></span>
					</div>
				</td>
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
</div>

<div class="borderTopContainer">
	<div id="user-profile-1" class="user-profile row-fluid">
			<div id="sample-table-2_wrapper" class="dataTables_wrapper" role="grid">

				<table aria-describedby="sample-table-2_info" id="sample-table-2" class="table table-striped table-bordered table-hover dataTable">
									
					<thead>
						<tr role="row">
							<th aria-label="idsolicituddematerial: activate to sort column ascending" style="width: 30px;" colspan="1" rowspan="1" aria-controls="sample-table-2" tabindex="0" role="columnheader" class="sorting" >ID</th>
							<th aria-label="solicitante: activate to sort column ascending" style="width: 150px;" colspan="1" rowspan="1" aria-controls="sample-table-2" tabindex="1" role="columnheader" class="sorting">SOLICITA</th>
							<th aria-label="fecha_solicitud: activate to sort column ascending" style="width: 80px;" colspan="1" rowspan="1" aria-controls="sample-table-2" tabindex="1" role="columnheader" class="sorting">FECHA</th>
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

// alert(3);

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

	function fillTablePedido0(){
						
		var tB = "";
// alert(4);

		$("#preloaderPrincipal").show();
		var nc = "u="+localStorage.nc;
		$.post(obj.getValue(0) + "data/", {o:34, t:84, c:nc, p:10, from:0, cantidad:0,s:''},
			function(json){
				if (json.length){
					$.each(json, function(i, item) {

						tB +=' 			<tr class="odd">';
						tB +=' ';
						tB +='				<td class=" ">';
						tB +='					<a class="modSolMatEnc0Pro" href="#" id="idprof0-'+item.idsolicituddematerial+'"  data-rel="tooltip" data-placement="top" title="Editar la Solicitud">'+padl(item.idsolicituddematerial,4)+'</a>';
						tB +='				</td>';
						tB +='				<td>'+item.solicitante+' </td>';
						tB +='				<td>'+item.fecha_solicitud+'</td>';
						tB +='				<td>'+item.observaciones+'</td>';
						tB +='				<td>'+item.cEstatus+'</td>';
						tB +='				<td>';
						tB +='					<div class="hidden-phone visible-desktop action-buttons">';
						tB +=' ';
						tB +='						<a class="green modSolMatEnc0Pro" href="#" id="idsolicituddematerial-'+item.idsolicituddematerial+'" data-rel="tooltip" data-placement="top" title="Editar la Solicitud">';
						tB +='							<i class="icon-pencil bigger-130"></i>';
						tB +='						</a>';
						tB +=' ';
						if ( parseInt(item.status_solicitud_de_material,0) == 0 ){
							tB +='						<a class="red delSolMatEnc0" href="#" id="delSolMatEnc0-'+item.idsolicituddematerial+'"  data-rel="tooltip" data-placement="top" title="Eliminar Solicitud">';
							tB +='							<i class="icon-trash bigger-130"></i>';
							tB +='						</a>';
							tB +=' ';
						}
						tB +='						<a class="blue modSolMatEnc1Pro" href="#" id="modSolMatEnc1Pro-'+item.idsolicituddematerial+'-'+item.status_solicitud_de_material+ '-'+item.observaciones+ '" data-rel="tooltip" data-placement="top" title="Ver Artículos">';
						tB +='							<i class="icon-folder-open-alt bigger-130"></i>';
						tB +='						</a>';
						tB +=' ';
						tB +='				</td>';
						tB +='			</tr>';
					});
				 	
				 	//alert(tB);

					$('#sample-table-2 > tbody').html(tB);

					$("#preloaderPrincipal").hide();

					$(".modSolMatEnc0Pro").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						getPropSolMatEnc0(arr[1]);
					});

					$(".modSolMatEnc1Pro").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						getPropSolMatEnc1(arr[1],arr[2],arr[3]);
					});

					$(".delSolMatEnc0").on("click",function(event){
						event.preventDefault();
						$("#iconSaveCommentResp").show();
						var resp =  confirm("Desea eliminar esta Requisición?");
						//alert(resp);
						//return false;
						if (resp){
							var arr = event.currentTarget.id.split('-');
							//alert(arr[1]);
							obj.setIsTimeLine(false);
				            $.post(obj.getValue(0) + "data/", {o:34, t:2, c:arr[1], p:2, from:0, cantidad:0, s:''},
				            function(json) {
				            		if (json[0].msg=="OK"){
										onClickFillTable();
				        			}else{
				        				alert(json[0].msg);	
				        			}
				        	}, "json");
			        	}
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
	fillTablePedido0();


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
		fillTablePedido0();
	}

// alert(5);

	$("#btnAddRegistry").on("click",function(event){
		event.preventDefault();

		obj.setIsTimeLine(false);
		getPropSolMatEnc0(0);

	})

	function getPropSolMatEnc0(IdSolMatEnc0){
        $("#preloaderPrincipal").show();
        obj.setIsTimeLine(false);
        var nc = localStorage.nc;
		$.post(obj.getValue(0) + "cat-sol-mat-new/", {
				user: nc,
				idsolicituddematerial: IdSolMatEnc0
			},
			function(html) {
				$("#divUploadImage").html(html);
				$("#divUploadImage").modal('toggle');
		}, "html");
        return false;
	}

	function getPropSolMatEnc1(IdSolMatEnc0,Status,Solicitante){
        $("#contentProfile").html("");
        $("#contentMain").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
	        $.post(obj.getValue(0) + "cat-sol-mat-asign/", {
				user: nc,
				idsolicituddematerial: IdSolMatEnc0,
				status_solicitud_de_material:Status,
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
// alert(6);

/*
	var stream = io.connect(obj.getValue(4));
	stream.on("servidor", jsNewSolMatEnc0);
	function jsNewSolMatEnc0(datosServer) {
		var ms = datosServer.mensaje.split("-");
		if (ms[1]=='SOL_MAT_ENC') {
			onClickFillTable();
		}
	}
*/

    $("#preloaderPrincipal").hide();

// alert(7);


});



</script>
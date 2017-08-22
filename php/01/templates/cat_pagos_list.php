<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$de       = $_POST['user'];

?>
<div  class="row-fluid">
	<div class="action-buttons">
		<span class="ui-pg-div" id="btnAddRegistry" >
			<span class="ui-icon icon-plus-sign purple"></span>
		</span>
		<span class="ui-separator marginLeft1em"></span>
		<span class="ui-pg-div" id="btnRefresh">
			<span class="ui-icon icon-refresh green"></span>
		</span>
	</div>
</div>

<div class="borderTopContainer">
	<div id="user-profile-1" class="user-profile row-fluid">
			<div id="sample-table-2_wrapper" class="dataTables_wrapper" role="grid">

				<table aria-describedby="sample-table-2_info" id="sample-table-2" class="table table-striped table-bordered table-hover dataTable">
									
					<thead>
						<tr role="row">
							<th aria-label="idpago: activate to sort column ascending" style="width: 40px;" tabindex="0" role="columnheader" class="sorting" >ID</th>
							<th aria-label="concepto: activate to sort column ascending" style="width: 200px;" tabindex="1" role="columnheader" class="sorting">CONCEPTO</th>
							<th aria-label="emisor: activate to sort column ascending" style="width: 200px;" tabindex="2" role="columnheader" class="sorting">EMISOR</th>
							<th aria-label="claveprodservsat: activate to sort column ascending" style="width: 80px;" tabindex="3" role="columnheader" class="sorting">CPS</th>
							<th aria-label="claveunidadmedida: activate to sort column ascending" style="width: 80px;" tabindex="4" role="columnheader" class="sorting">CUM</th>
							<th aria-label="nivel: activate to sort column ascending" style="width: 80px;" tabindex="5" role="columnheader" class="sorting">NIVEL</th>
							<th aria-label="importe: activate to sort column ascending" style="width: 100px;" tabindex="6" role="columnheader" class="sorting">IMPORTE</th>
							<th aria-label="" style="width: 200px;" role="columnheader" class="sorting_disabled"></th>
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
			"aoColumns": [ null, null, null, null, null, null, null,  { "bSortable": false }],
			"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
			"bRetrieve": true,
			"bDestroy": false
	 	});
	}

	function fillTable(){
						
		var tB = "";

		$("#preloaderPrincipal").show();
		var nc = "u="+localStorage.nc;
		$.post(obj.getValue(0) + "data/", {o:27, t:10007, c:nc, p:11, from:0, cantidad:0,s:'idpago'},
			function(json){
				
					$.each(json, function(i, item) {

						tB +=' 			<tr class="odd">';
						tB +='';
						tB +='				<td class=" ">';
						tB +='					<a class="modPagoPro" href="#" id="idrf2-'+item.idpago+'">'+padl(item.idpago,4)+'</a>';
						tB +='				</td>';
						tB +='				<td class="tbl200W" >'+item.concepto+'</td>';
						tB +='				<td class="tbl200W" >'+item.razon_social+'</td>';
						tB +='				<td class="tbl80W" >'+item.claveprodserv+'</td>';
						tB +='				<td class="tbl40W" >'+item.claveunidadmedida+'</td>';
						tB +='				<td class="tbl80W" >'+item.nivel+'</td>';
						tB +='				<td class="tbl80W" >'+item.importe+'</td>';
						tB +='				<td >';
						tB +='					<div class="hidden-phone visible-desktop action-buttons">';
						tB +='';
						tB +='						<a class="green modPagoPro" href="#" id="idpago-'+item.idpago+'" >';
						tB +='							<i class="icon-pencil bigger-130"></i>';
						tB +='						</a>';
						tB +='	';
						tB +='						<a class="red delPago" href="#"  id="delPago-'+item.idpago+'" >';
						tB +='							<i class="icon-trash bigger-130"></i>';
						tB +='						</a>';
						tB +='					</div>';
						tB +='';
						tB +='				</td>';
						tB +='			</tr>';
					});

					$('#sample-table-2 > tbody').html(tB);

					$("#preloaderPrincipal").hide();

					$(".modPagoPro").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						getPropPago(arr[1]);
					});

					$(".delPago").on("click",function(event){
						event.preventDefault();
						$("#iconSaveCommentResp").show();
						var arr = event.currentTarget.id.split('-');
						var resp =  confirm("Desea eliminar este registro "+arr[1]+"?");
						//alert(resp);
						//return false;
						if (resp){
							//alert(arr[1]);
							obj.setIsTimeLine(false);
				            $.post(obj.getValue(0) + "data/", {o:27, t:2, c:arr[1], p:2, from:0, cantidad:0, s:''},
				            function(json) {
				            		if (json[0].msg=="OK"){
										onClickFillTable();
				        			}else{
				        				alert(json[0].msg);	
				        			}
				        	}, "json");
			        	}

					});

					if (init==true){
						getTable();
						init = false;
					}else{
						oTable.fnClearTable();
						oTable.fnDraw();
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


	$("#btnAddRegistry").on("click",function(event){
		event.preventDefault();

		obj.setIsTimeLine(false);
		getPropPago(0);

	})

	function getPropPago(IdPago){
        $("#contentProfile").html("");
        $("#contentMain").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
	        $.post(obj.getValue(0) + "cat-pagos-prop/", {
				user: nc,
				idpago: IdPago
	            },
	            function(html) {	                
	                $("#contentProfile").html(html).show('slow',function(){
	                	//$("#contentProfile");	
		                $('#breadcrumb').html(getBar('Inicio, Catálogo de Pagos '));
	                });
	            }, "html");
        });
        return false;


	}

/*
	var stream = io.connect(obj.getValue(4));
	stream.on("servidor", jsNewPago);
	function jsNewPago(datosServer) {
		var ms = datosServer.mensaje.split("-");
		//alert(datosServer);
		//obj.setIsTimeLine(true);
		if (ms[1]=='CAT_PAGOS') {
			// onClickFillTable();
		}
	}
*/

	
});



</script>
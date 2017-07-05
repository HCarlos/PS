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
					<div class="ui-pg-div" id="btnAddRegTA01" >
						<span class="ui-icon icon-plus-sign purple"></span>
					</div>
				</td>
				<td title="" data-original-title="" class="ui-pg-button ui-state-disabled" style="width:4px;">
					<span class="ui-separator marginLeft1em"></span>
				</td>
				<td data-original-title="Reload Grid" id="refresh_grid-table" title="" class="ui-pg-button ui-corner-all">
					<div class="ui-pg-div" id="btnRefrTA01">
						<span class="ui-icon icon-refresh green"></span>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<div class="borderTopContainer">
	<div id="user-profile-1" class="user-profile row-fluid">
			<div id="tbl-PDMTAtns_wrapper" class="dataTables_wrapper" role="grid">

				<table aria-describedby="tbl-PDMTAtns_info" id="tbl-PDMTAtns" class="table table-striped table-bordered table-hover dataTable">
									
					<thead>
						<tr role="row">
							<th aria-label="idgeneracion: activate to sort column ascending" style="width: 80px;" colspan="1" rowspan="1" aria-controls="tbl-PDMTAtns" tabindex="0" role="columnheader" class="sorting" >ID</th>
							<th aria-label="generacion: activate to sort column ascending" style="width: 200px;" colspan="1" rowspan="1" aria-controls="tbl-PDMTAtns" tabindex="1" role="columnheader" class="sorting">GENERACIONES</th>
							<th aria-label="predeterminado: activate to sort column ascending" style="width: 50px;" colspan="1" rowspan="1" aria-controls="tbl-PDMTAtns" tabindex="1" role="columnheader" class="sorting">PREDETERMINADA</th>
							<th aria-label="" style="width: 200px;" colspan="1" rowspan="1" role="columnheader" class="sorting_disabled"></th>
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

		oTable = $('#tbl-PDMTAtns').dataTable({
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
	        "aaSorting": [[ 1, "desc" ]],			
			"aoColumns": [ null, null, null,  { "bSortable": false }],
			"aLengthMenu": [[-1, 10, 25, 50], ["Todos", 10, 25, 50]],
			"bRetrieve": true,
			"bDestroy": false
	 	});
	}

	function fillTable(){
						
		var tB = "";

		$("#preloaderPrincipal").show();
		var nc = "u="+localStorage.nc;
		// alert(nc);
		$.post(obj.getValue(0) + "data/", {o:61, t:49, c:nc, p:55, from:0, cantidad:0,s:''},
			function(json){
				
					$.each(json, function(i, item) {

						var pred = parseInt(item.predeterminado,0) == 1 ? '<i class="icon-ok green"></i>':'';

						tB +=' 			<tr class="odd">';
						tB +='';
						tB +='				<td>';
						tB +='					<a class="modTAtnsPro" href="#" id="idprof-'+item.idgeneracion+'" >'+padl(item.idgeneracion,4)+'</a>';
						tB +='				</td>';
						tB +='				<td>'+item.generacion+'</td>';
						tB +='				<td class="center" >'+pred+'</td>';
						tB +='				<td>';
						tB +='					<div class="hidden-phone visible-desktop action-buttons">';
						tB +='';
						tB +='						<a class="green modTAtnsPro" href="#" id="idgeneracion-'+item.idgeneracion+'" >';
						tB +='							<i class="icon-pencil bigger-130"></i>';
						tB +='						</a>';
						tB +='	';
						tB +='						<a class="red delTAtns" href="#" id="delTAtns-'+item.idgeneracion+'" >';
						tB +='							<i class="icon-trash bigger-130"></i>';
						tB +='						</a>';
						tB +='					</div>';
						tB +='';
						tB +='				</td>';
						tB +='			</tr>';
					});

					$('#tbl-PDMTAtns > tbody').html(tB);

					$("#preloaderPrincipal").hide();

					$(".modTAtnsPro").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						getPropTAtns(arr[1]);
					});

					$(".delTAtns").on("click",function(event){
						event.preventDefault();
						$("#iconSaveCommentResp").show();
						var resp =  confirm("Desea eliminar este registro?");
						//alert(resp);
						//return false;
						if (resp){
							var arr = event.currentTarget.id.split('-');
							//alert(arr[1]);
							obj.setIsTimeLine(false);
				            $.post(obj.getValue(0) + "data/", {o:61, t:2, c:arr[1], p:52, from:0, cantidad:0, s:''},
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


	$("#btnRefrTA01").on("click",function(event){
		event.preventDefault();
		onClickFillTable();
	})

	function onClickFillTable(){
		if(oTable != null){
			oTable.fnDestroy();
			$('#tbl-PDMTAtns > tbody').empty();
			init = true;
		}
		fillTable();
	}


	$("#btnAddRegTA01").on("click",function(event){
		event.preventDefault();

		obj.setIsTimeLine(false);
		getPropTAtns(0);

	})

	function getPropTAtns(IdTAtns){
        $("#contentProfile").empty();
        $("#contentMain").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
	        $.post(obj.getValue(0) + "cat-generaciones-prop/", {
				user: nc,
				idgeneracion: IdTAtns
	            },
	            function(html) {	                
	                $("#contentProfile").html(html).show('slow',function(){
		                $('#breadcrumb').html(getBar('Inicio, Propiedades de un nuevo Registro '));
	                });
	            }, "html");
        });
        return false;
	}


	var stream = io.connect(obj.getValue(4));
	stream.on("servidor", jsNewTAtns);
	function jsNewTAtns(datosServer) {
		var ms = datosServer.mensaje.split("-");
		if (ms[1]=='GENERACION') {
			// onClickFillTable();
		}
	}

	

});



</script>
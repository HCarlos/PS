<?php

include("includes/metas.php");

$de       = $_POST['user'];

?>
<div  class="row-fluid">
	<table class="ui-pg-table navtable" style="float:left;table-layout:auto;" border="0" cellpadding="0" cellspacing="0">
		<tbody>
			<tr>
				<td data-original-title="Add new row" id="add_grid-table" title="" class="ui-pg-button ui-corner-all">
					<div class="ui-pg-div" id="btnAddPC0" >
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
			<div id="tblPAICC0_wrapper" class="dataTables_wrapper" role="grid">

				<table aria-describedby="tblPAICC0_info" id="tblPAICC0" class="table table-striped table-bordered table-hover dataTable">
									
					<thead>
						<tr role="row">
							<th aria-label="idpaiconcepto: activate to sort column ascending" style="width: 50px;" colspan="1" rowspan="1" aria-controls="tblPAICC0" tabindex="0" role="columnheader" class="sorting" >ID</th>
							<th aria-label="area_disciplinaria: activate to sort column ascending" style="width: 100px;" colspan="1" rowspan="1" aria-controls="tblPAICC0" tabindex="1" role="columnheader" class="sorting">Área</th>
							<th aria-label="descripcion_criterio: activate to sort column ascending" style="width: 100px;" colspan="1" rowspan="1" aria-controls="tblPAICC0" tabindex="1" role="columnheader" class="sorting">Criterio</th>
							<th aria-label="concepto: activate to sort column ascending" style="width: 350px;" colspan="1" rowspan="1" aria-controls="tblPAICC0" tabindex="1" role="columnheader" class="sorting">Descriptor</th>
							<th aria-label="grado_pai: activate to sort column ascending" style="width: 50px;" colspan="1" rowspan="1" aria-controls="tblPAICC0" tabindex="1" role="columnheader" class="sorting">Grado</th>
							<th aria-label="calif: activate to sort column ascending" style="width: 50px;" colspan="1" rowspan="1" aria-controls="tblPAICC0" tabindex="1" role="columnheader" class="sorting">Valor</th>
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

		oTable = $('#tblPAICC0').dataTable({
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
			"aoColumns": [ null, null, null, null, null, null,  { "bSortable": false }],
			"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
			"bRetrieve": true,
			"bDestroy": false
	 	});
	}

	function fillTable(){
						
		var tB = "";

		$("#preloaderPrincipal").show();
		var nc = "u="+localStorage.nc;
		$.post(obj.getValue(0) + "data/", {o:64, t:55, c:nc, p:54, from:0, cantidad:0,s:''},
			function(json){
				
					$.each(json, function(i, item) {
						tB +=' 			<tr class="odd">';
						tB +='';
						tB +='				<td>'+padl(item.idpaiconcepto,4)+'</td>';
						tB +='				<td>'+item.area_disciplinaria+'</td>';
						tB +='				<td>'+item.descripcion_criterio_large+'</td>';
						tB +='				<td>'+item.concepto+'</td>';
						tB +='				<td class="center">'+item.grado_pai+'</td>';
						tB +='				<td class="center">'+item.rango_califica+'</td>';
						tB +='				<td>';
						tB +='					<div class="hidden-phone visible-desktop action-buttons">';
						tB +='';
						tB +='						<a class="green modPAIC0Pro" href="#" id="idpaiconcepto-'+item.idpaiconcepto+'" >';
						tB +='							<i class="icon-pencil bigger-130"></i>';
						tB +='						</a>';
						tB +='	';
						tB +='						<a class="red delPAIC0" href="#"  id="delPAIC0-'+item.idpaiconcepto+'" >';
						tB +='							<i class="icon-trash bigger-130"></i>';
						tB +='						</a>';
						tB +='					</div>';
						tB +='';
						tB +='				</td>';
						tB +='			</tr>';
					});

					$('#tblPAICC0 > tbody').html(tB);

					$("#preloaderPrincipal").hide();

					$(".modPAIC0Pro").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						getPropPAIC0(arr[1]);
					});

					$(".delPAIC0").on("click",function(event){
						event.preventDefault();
						$("#iconSaveCommentResp").show();
						var resp =  confirm("Desea eliminar este registro?");
						//alert(resp);
						//return false;
						if (resp){
							var arr = event.currentTarget.id.split('-');
							//alert(arr[1]);
							obj.setIsTimeLine(false);
				            $.post(obj.getValue(0) + "data/", {o:64, t:2, c:arr[1], p:52, from:0, cantidad:0, s:''},
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
			$('#tblPAICC0 > tbody').empty();
			init = true;
		}
		fillTable();
	}


	$("#btnAddPC0").on("click",function(event){
		event.preventDefault();

		obj.setIsTimeLine(false);
		getPropPAIC0(0);

	});

	function getPropPAIC0(IdPAIC0){
        $("#contentProfile").empty();
        $("#contentMain").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
	        $.post(obj.getValue(0) + "cat-pai-conceptos-prop/", {
				user: nc,
				idpaiconcepto: IdPAIC0
	            },
	            function(html) {	                
	                $("#contentProfile").html(html).show('slow',function(){
	                	//$("#contentProfile");	
		                $('#breadcrumb').html(getBar('Inicio, Descriptor PAI '));
	                });
	            }, "html");
        });
        return false;
	}


/*
	var stream = io.connect(obj.getValue(4));
	stream.on("servidor", jsNewPAIC0);
	function jsNewPAIC0(datosServer) {
		var ms = datosServer.mensaje.split("-");
		//alert(datosServer);
		//obj.setIsTimeLine(true);
		if (ms[1]=='PAI_CONCEPTOS') {
			onClickFillTable();
		}
	}
*/
	

});



</script>
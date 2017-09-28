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
		<div id="tblAluListBecas_wrapper" class="dataTables_wrapper" role="grid">
			<table aria-describedby="tblAluListBecas_info" id="tblAluListBecas" class="table table-striped table-bordered table-hover dataTable">
				<thead>
					<tr role="row">
						<th aria-label="idalumno: activate to sort column ascending" style="width: 80px;" colspan="1" rowspan="1" aria-controls="tblAluListBecas" tabindex="0" role="columnheader" class="sorting" >ID</th>
						<th aria-label="nombre_alumno: activate to sort column ascending" style="width: 200px;" colspan="1" rowspan="1" aria-controls="tblAluListBecas" tabindex="1" role="columnheader" class="sorting">Alumno</th>
						<th aria-label="usuario: activate to sort column ascending" style="width: 60px;" colspan="1" rowspan="1" aria-controls="tblAluListBecas" tabindex="1" role="columnheader" class="sorting">Usuario</th>
						<th aria-label="mod: activate to sort column ascending" style="width: 5px;" colspan="1" rowspan="1" aria-controls="tblAluListBecas" tabindex="1" role="columnheader" class="sorting">M</th>
						<th aria-label="" style="width: 200px;" colspan="1" rowspan="1" role="columnheader" class="sorting_disabled"></th>
					</tr>
				</thead>
				<tbody aria-relevant="all" aria-live="polite" role="alert"></tbody>
			</table>
		</div>
	</div>
</div>

<div id="inline2">
	
</div>
<!--PAGE CONTENT ENDS-->

<script typy="text/javascript">        

jQuery(function($) {

	var lc = parseInt(localStorage.IdUserNivelAcceso,0);

	var oTable;

	function getTable(){

		oTable = $('#tblAluListBecas').dataTable({
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
			"aoColumns": [ null, null, null, null,  { "bSortable": false }],
			"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
			"bRetrieve": true,
			"bDestroy": false
	 	});
	}

	function fillTable(){
						
		var tB = "";

		$("#preloaderPrincipal").show();
		var nc = "u="+localStorage.nc;
		$.post(obj.getValue(0) + "data/", {o:5, t:9, c:nc, p:10, from:0, cantidad:0,s:''},
			function(json){
					$.each(json, function(i, item) {

						var vad = parseInt(item.valid_for_admin,0) == 0 ? ' <i class="icon icon-certificate red"></i> ' : '';

						tB +=' 			<tr class=" odd ">';
						tB +='';
						tB +='				<td>';
						tB +='					<a href="#" >'+padl(item.idalumno,4)+'</a>';
						tB +='				</td>';
						tB +='				<td >'+item.nombre_alumno+'</td>';
						tB +='				<td >'+item.username+'</td>';
						tB +='				<td class="center" >'+vad+'</td>';
						tB +='				<td>';
						tB +='					<div class="hidden-phone visible-desktop action-buttons">';
						tB +='';
						tB +='						<a class="green modAlumnoPro" href="#" id="idalumno-'+item.idalumno+'" >';
						tB +='							<i class="icon-pencil bigger-130"></i>';
						tB +='						</a>';
						tB +='';
						tB +='				</td>';
						tB +='			</tr>';
					});

					$('#tblAluListBecas > tbody').html(tB);

					$("#preloaderPrincipal").hide();

					$(".modAlumnoPro").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						getPropAlumno(arr[1]);
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
			$('#tblAluListBecas > tbody').empty();
			init = true;
		}
		fillTable();
	}

	function getPropAlumno(IdAlumno){
        $("#contentProfile").empty();
        $("#contentMain").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
	        $.post(obj.getValue(0) + "cat-alumnos-p-becas/", {
				user: nc,
				idalumno: IdAlumno
	            },
	            function(html) {	                
	                $("#contentProfile").html(html).show('slow',function(){
		                $('#breadcrumb').html(getBar('Inicio, Propiedades del Alumno '));
	                });
	            }, "html");
        });
        return false;
	}

/*
	var stream = io.connect(obj.getValue(4));
	stream.on("servidor", jsNewAlumno);
	function jsNewAlumno(datosServer) {
		var ms = datosServer.mensaje.split("-");
		//alert(datosServer);
		//obj.setIsTimeLine(true);
		if (ms[1]=='ALUMNOS_BECAS_CAJA') {
			//onClickFillTable();
		}
	}
*/
	

});



</script>
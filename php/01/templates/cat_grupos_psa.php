<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$de       = $_POST['user'];

?>

<div class="borderTopContainer">
	<div id="catGpo001" class="user-profile row-fluid">
			<div id="tblCatGpo001" class="dataTables_wrapper" role="grid">

				<table aria-describedby="sample-table-2_info" id="tblCatGpo003" class="table table-striped table-bordered table-hover dataTable">
									
					<thead>
						<tr role="row">
							<th aria-label="idgponiv: activate to sort column ascending" style="width: 60px;" colspan="1" rowspan="1" aria-controls="tblCatGpo003" tabindex="0" role="columnheader" class="sorting" >ID</th>
							<th aria-label="idgrupo: activate to sort column ascending" style="width: 80px;" colspan="1" rowspan="1" aria-controls="tblCatGpo003" tabindex="1" role="columnheader" class="sorting" >ID GPO</th>
							<th aria-label="clave: activate to sort column ascending" style="width: 60px;" colspan="1" rowspan="1" aria-controls="tblCatGpo003" tabindex="2" role="columnheader" class="sorting">Clave</th>
							<th aria-label="grupo: activate to sort column ascending" style="width: 200px;" colspan="1" rowspan="1" aria-controls="tblCatGpo003" tabindex="3" role="columnheader" class="sorting">Grupo</th>
							<th aria-label="ciclo: activate to sort column ascending" style="width: 100px;" colspan="1" rowspan="1" aria-controls="tblCatGpo003" tabindex="4" role="columnheader" class="sorting">Ciclo</th>
							<th aria-label="visible: activate to sort column ascending" style="width: 10px;" colspan="1" rowspan="1" aria-controls="tblCatGpo003" tabindex="5" role="columnheader" class="sorting">Visible</th>
							<th aria-label="bloqueado: activate to sort column ascending" style="width: 10px;" colspan="1" rowspan="1" aria-controls="tblCatGpo003" tabindex="6" role="columnheader" class="sorting">Bloqueado</th>
							<th aria-label="" style="width: 200px;" colspan="1" rowspan="1" role="columnheader" class="sorting_disabled"></th>
						</tr>
					</thead>
									
					<tbody aria-relevant="all" aria-live="polite" role="alert"></tbody>
				</table>

			</div><!--PAGE CONTENT ENDS-->

	</div>
</div>

<script typy="text/javascript">        

jQuery(function($) {

	var Param = localStorage.Param1;

	var oTable;

	function getTable(){

		oTable = $('#tblCatGpo003').dataTable({
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
	        "aaSorting": [[ 1, "asc" ]],			
			"aoColumns": [ null, null, null, null, null, null, null,  { "bSortable": false }],
			"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
			"bRetrieve": true,
			"bDestroy": false
	 	});
	}

	function fillTable(){
						
		var tB = "";

		$("#preloaderPrincipal").show();
		var nc = "u="+localStorage.nc+"&clavenivelacceso="+localStorage.ClaveNivelAcceso;
		
		// alert(nc);

		$.post(obj.getValue(0) + "data/", {o:4, t:7, c:nc, p:11, from:0, cantidad:0,s:Param},
			function(json){
					
					$.each(json, function(i, item) {
						var bloqueado = parseInt(item.bloqueado,0)==1?'<i class="fa fa-lock"></i>':'';
						var visible = parseInt(item.grupo_ciclo_nivel_visible,0)==1?'<i class="fa fa-eye"></i>':'';
						tB +=' 			<tr class="odd">';
						tB +='';
						tB +='				<td class=" " >'+item.idgponiv+'</td>';
						tB +='				<td class=" ">';
						tB +='					<a class="modGrupoPro" href="#" id="idgpo-'+item.idgrupo+'" >'+padl(item.idgrupo,4)+'</a>';
						tB +='				</td>';
						tB +='				<td class=" " >'+item.clave+'</td>';
						tB +='				<td class=" " >'+item.grupo+'</td>';
						tB +='				<td class=" " >'+item.ciclo+'</td>';
						tB +='				<td class="center" >'+visible+'</td>';
						tB +='				<td class="center" >'+bloqueado+'</td>';
						tB +='				<td class=" ">';
						tB +='					<div class="hidden-phone visible-desktop action-buttons">';
						tB +='';
						tB +='	';
						tB +='						<a class="orange listPasesSalidas" href="#"  id="listPasesSalidas*|*'+item.idgrupo+'*|*'+item.grupo+'*|*'+item.clave_nivel+'*|*'+item.grado+'*|*'+item.idciclo+'" title="Pases de Salida" >';
						tB +='							<i class="fa fa-ticket bigger-130"></i>';
						tB +='						</a>';
						tB +='	';
						tB +='					</div>';
						tB +='';
						tB +='				</td>';
						tB +='			</tr>';
					});

					$('#tblCatGpo003 > tbody').html(tB);

					$("#preloaderPrincipal").hide();

					$(".listPasesSalidas").on("click",function(event){
						event.preventDefault();
						// alert( event.currentTarget.id);
						var arr = event.currentTarget.id.split('*|*');
						obj.setIsTimeLine(false);
						//alert(arr[3]);
						getListPasesSalida(arr[1],arr[2],arr[3],arr[4],arr[5]);
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


	function onClickFillTable(){
		if(oTable != null){
			oTable.fnDestroy();
			$('#tblCatGpo003 > tbody').empty();
			init = true;
		}
		fillTable();
	}



	function getListPasesSalida(IdGrupo,Grupo,Clave_Nivel, Grado, IdCiclo){
        $("#contentProfile").html("");
        $("#contentMain").hide(function(){
			var nc = localStorage.nc; //.split("@");
			// alert(IdCiclo);
			$.post(obj.getValue(0) + "psa-list/", {
					user: nc,
					idgrupo: IdGrupo,
					grupo:Grupo,
					clave_nivel:Clave_Nivel,
					grado: Grado,
					idciclo: IdCiclo
				},
				function(html) {
		                $("#contentProfile").html(html).show('slow',function(){
		                $('#breadcrumb').html(getBar('Inicio, Pases de Salida por Grupo | <span class="intense-red">'+Grupo+'</span>'));
		            });
			}, "html");
		});
	}


	

});



</script>
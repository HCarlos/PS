<?php

include("includes/metas.php");

$de       = $_POST['user'];

?>
<div  class="row-fluid">
	<table class="ui-pg-table navtable" style="float:left;table-layout:auto;" border="0" cellpadding="0" cellspacing="0">
		<tbody>
			<tr>
				<td data-original-title="Add new row" id="add_grid-table" title="" class="ui-pg-button ui-corner-all">
					<div class="ui-pg-div" id="btnAddAse1" >
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
			<div id="tblAse1_wrapper" class="dataTables_wrapper" role="grid">

				<table aria-describedby="tblAse1_info" id="tblAse1" class="table table-striped table-bordered table-hover dataTable">
									
					<thead>
						<tr role="row">
							<th aria-label="idasesoria: activate to sort column ascending" style="width: 50px;" tabindex="0" role="columnheader" class="sorting" >ID</th>
							<th aria-label="alumno: activate to sort column ascending" style="width: 100px;" tabindex="1" role="columnheader" class="sorting">Alumno</th>
							<th aria-label="grupo: activate to sort column ascending" style="width: 100px;" tabindex="2" role="columnheader" class="sorting">Grupo</th>
							<th aria-label="titulo_reporte: activate to sort column ascending" style="width: 350px;" tabindex="3" role="columnheader" class="sorting">Reporte</th>
							<th aria-label="tutor: activate to sort column ascending" style="width: 50px;" tabindex="4" role="columnheader" class="sorting">Tutor/Familiar</th>
							<th aria-label="asesor: activate to sort column ascending" style="width: 50px;" tabindex="5" role="columnheader" class="sorting">Asesor</th>
							<th aria-label="fecha: activate to sort column ascending" style="width: 50px;" tabindex="6" role="columnheader" class="sorting">Fecha</th>
							<th style="width: 100px;" colspan="1" rowspan="1" role="columnheader" class="sorting_disabled"></th>
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

		oTable = $('#tblAse1').dataTable({
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
		$.post(obj.getValue(0) + "data/", {o:69, t:82, c:nc, p:54, from:0, cantidad:0,s:''},
			function(json){
				
					$.each(json, function(i, item) {
						tB +=' 			<tr class="odd">';
						tB +='';
						tB +='				<td>'+padl(item.idasesoria,4)+'</td>';
						tB +='				<td>'+item.nombre_alumno+'</td>';
						tB +='				<td>'+item.grupo+'</td>';
						tB +='				<td>'+item.titulo_reporte+'</td>';
						tB +='				<td>'+item.nombre_persona_acuerdo+'</td>';
						tB +='				<td>'+item.nombre_persona_asesoria+'</td>';
						tB +='				<td>'+item.cfecha+'</td>';
						tB +='				<td>';
						tB +='					<div class="hidden-phone visible-desktop action-buttons">';
						tB +='';
						tB +='						<a class="green modAse0Pro" href="#" id="idase0-'+item.idasesoria+'-'+item.idalumno+'" >';
						tB +='							<i class="icon-pencil bigger-130"></i>';
						tB +='						</a>';
						tB +='	';
						tB +='						<a class="red delAse0" href="#"  id="idase1-'+item.idasesoria+'-'+item.idalumno+'" >';
						tB +='							<i class="icon-trash bigger-130"></i>';
						tB +='						</a>';
						tB +='					</div>';
						tB +='';
						tB +='				</td>';
						tB +='			</tr>';
					});

					$('#tblAse1 > tbody').html(tB);

					$("#preloaderPrincipal").hide();

					$(".modAse0Pro").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						getPropAse0(arr[1],arr[2]);
					});

					$(".delAse0").on("click",function(event){
						event.preventDefault();
						$("#iconSaveCommentResp").show();
						var resp =  confirm("Desea eliminar este registro?");
						if (resp){
							var arr = event.currentTarget.id.split('-');
							obj.setIsTimeLine(false);
				            $.post(obj.getValue(0) + "data/", {o:69, t:2, c:arr[1], p:52, from:0, cantidad:0, s:''},
				            function(json) {
				            		if (json[0].msg=="OK"){
										onClickFillTable();
				        			}else{
				        				alert(json[0].msg);	
				        			}
				        	}, "json");
			        	}

					});

					getTable();
					$("#preloaderPrincipal").hide();

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
			$('#tblAse1 > tbody').empty();
			init = true;
		}
		fillTable();
	}


	$("#btnAddAse1").on("click",function(event){
		event.preventDefault();

		obj.setIsTimeLine(false);
		getPropAse0(0,0);

	});

	function getPropAse0(IdAsesoria, IdAlumno){
        $("#contentProfile").empty();
        $("#contentMain").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
	        $.post(obj.getValue(0) + "asesores-anotaciones-prop/", {
				user: nc,
				idasesoria: IdAsesoria,
				idalumno: IdAlumno
	            },
	            function(html) {	                
	                $("#contentProfile").html(html).show('slow',function(){
		                $('#breadcrumb').html(getBar('Inicio, Propiedades Asesorías '));
	                });
	            }, "html");
        });
        return false;
	}
	

});



</script>
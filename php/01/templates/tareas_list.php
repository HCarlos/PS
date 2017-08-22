<?php

include("includes/metas.php");

$de       = $_POST['user'];

?>


<div class="widget-box">
	<div class="widget-header widget-header-blue widget-header-flat">
		<h4 class="lighter">Tareas</h4>
		<!--
		<div class="widget-toolbar orage">
			<a href="#" data-action="collapse">
				<i class="icon-chevron-up"></i>
			</a>					

		</div>
		-->
		<div class="widget-toolbar orage">
			<label>
				<small class="green">
					<b>Activas</b>
				</small>

				<input id="isnuevas" type="checkbox" class="ace ace-switch ace-switch-4" checked />
				<span class="lbl"></span>
			</label>

		</div>
		<div class="widget-toolbar orage">

			<a href="#" class="ui-pg-div" id="btnAddRegistry">
				<i class="ui-icon icon-plus-sign purple"></i>
			</a>
			<a href="#" class="ui-pg-div" data-action="reload" id="btnRefresh" >
				<i class="ui-icon icon-refresh green"></i>
			</a>

		</div>

<!--

		<div class="widget-toolbar orage">

				<select name="lstGruposTr0" id="lstGruposTr0" size="1" class="lstGruposTr0" style="margin: 0 0 0 0 !important;"></select> 
				<select name="lstMatsTr0" id="lstMatsTr0" size="1" class="lstMatsTr0" style="margin: 0 0 0 0 !important; "></select> 
			</label>

		</div>
--> 

	</div>

	<div class="widget-body">
		<div class="widget-main">
			<div class="row-fluid">

				<div id="user-profile-1" class="user-profile row-fluid">

					<div id="tblTarProf01_wrapper" class="dataTables_wrapper" role="grid">

						<table aria-describedby="tblTarProf01_info" id="tblTarProf01" class="table table-striped table-bordered table-hover dataTable">
											
							<thead>
								<tr role="row">
									<th aria-label="idtarea: to sort column ascending" style="width: 10px;" tabindex="0" >ID</th>
									<th aria-label="titulo: to sort column ascending" style="width: 150px;" tabindex="1">TAREA</th>
									<th aria-label="fecha_inicio: to sort column ascending" style="width: 10px;" tabindex="2" class=" center">INICIA</th>
									<th aria-label="fecha_fin: to sort column ascending" style="width: 10px;" tabindex="3" class=" center">VENCE</th>
									<th aria-label="lecturas: to sort column ascending" style="width: 5px;" tabindex="4" class=" center">LEC</th>
									<th aria-label="respuestas: to sort column ascending" style="width: 5px;" tabindex="5" class=" center">RESP</th>
									<th aria-label="archivos: to sort column ascending" style="width: 5px;" tabindex="6" class=" center">ARCH</th>
									<th aria-label="destinatarios: to sort column ascending" style="width: 5px;" tabindex="7" class=" center">DEST</th>
									<th aria-label="" style="width: 120px;" class="sorting_disabled"></th>
								</tr>
							</thead>
											
							<tbody aria-relevant="all" aria-live="polite" role="alert"></tbody>
						</table>

					</div><!--PAGE CONTENT ENDS-->

				</div>


			</div>	
		</div><!--/widget-main-->
	</div><!--/widget-body-->
</div>

<script type="text/javascript">        

jQuery(function($) {

	var TRPP = 20;
	var IdUNA = localStorage.IdUserNivelAcceso;
	var arrItems = [];
	var arrHD = [];
	var arrRow = {};
	var evalDef = 0;
	var evalMod = 0;

	var oTable;

	function getTable(){

		oTable = $('#tblTarProf01').dataTable({
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
			"aoColumns": [ null, null, null, null, null, null, null, null, { "bSortable": false }],
			"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
			"bRetrieve": true,
			"bDestroy": false
	 	});
	}


	if (localStorage.TRPP){
		TRPP = parseInt(localStorage.TRPP,0);	
	}
	oPag = {init:true, totalRegistros:0, totalPaginas:0, currentPage:0, registrosPorPagina:TRPP, Limit:'', Query:'' };

	var IsRegistry = false;
	var IdGrupo;	




	function fillTable(){
						
		var tB = "";

		$("#preloaderPrincipal").show();
		var sts = $("#isnuevas").is(':checked') ? 0 : 1;
		var nc = "u="+localStorage.nc+"&sts="+sts;

		// alert(nc);
		
		$.post(obj.getValue(0) + "data/", {o:40, t:20000, c:nc, p:10, from:0, cantidad:0,s:''},
			function(json){
				if (json.length){
					var lec,arc,res,des;
					$.each(json, function(i, item) {
						lec = item.lecturas>0?item.lecturas:'';
						res = item.respuestas>0?item.respuestas:'';
						arc = item.archivos>0?item.archivos:'';
						des = item.destinatarios>0?item.destinatarios:'';

						tB +=' 			<tr class="odd">';
						tB +=' ';
						tB +='				<td class=" ">';
						tB +='					<a class="modTarPro0" href="#" id="idprof0-'+item.idtarea+'"  data-rel="tooltip" data-placement="top" title="Editar la Solicitud">'+padl(item.idtarea,4)+'</a>';
						tB +='				</td>';
						tB +='				<td>'+item.titulo_tarea+'</td>';
						tB +='				<td>'+item.fecha_inicio+'</td>';
						tB +='				<td>'+item.fecha_fin+'</td>';
						tB +='				<td class="center">'+lec +'</td>';
						tB +='				<td class="center">'+res+'</td>';
						tB +='				<td class="center">'+arc+'</td>';
						tB +='				<td class="center">'+des+'</td>';
						tB +='				<td>';
						tB +='					<div class="action-buttons">';
						tB +='						<a class="green modTarPro0" href="#" id="idtarea-'+item.idtarea+'" data-rel="tooltip" data-placement="top" title="Editar Tarea">';
						tB +='							<i class="icon-pencil bigger-130"></i>';
						tB +='						</a>';
						tB +=' ';
						if ( parseInt(item.status_tarea,0) == 1 ){
							tB +='						<a class="red delTarAB0" href="#" id="delTarAB0-'+item.idtarea+'"  data-rel="tooltip" data-placement="top" title="Eliminar Tarea">';
							tB +='							<i class="icon-trash bigger-130"></i>';
							tB +='						</a>';
						}
						tB +='						<a class="cafe modTarFileAddProProf1" href="#" id="modTarFileAddProProf1-'+item.idtarea+'-'+item.titulo_tarea+ '" data-rel="tooltip" data-placement="top" title="Ver Archivos">';
						tB +='							<i class="fa fa-paperclip bigger-130"></i>';
						tB +='						</a>';
						tB +=' ';
						tB +='						<a class="blue marginLeft1em modTarPro2" href="#" id="modTarPro2-'+item.idtarea+'-'+item.titulo_tarea+ '" data-rel="tooltip" data-placement="top" title="Ver Destinatarios" >';
						tB +='							<i class="icon-group bigger-130"></i>'
						tB +='						</a>';
						tB +=' ';
						tB +='						<a class="green marginLeft1em refreshTarPro2" href="#" id="refreshTarPro2-'+item.idtarea+'-'+item.titulo_tarea+ '" data-rel="tooltip" data-placement="top" title="Actualizar datos" >';
						tB +='							<i class="icon-refresh bigger-130"></i>'
						tB +='						</a>';
						tB +='					</div>';
						tB +='				</td>';
						tB +='			</tr>';
					});
				 	
				 	//alert(tB);

					$('#tblTarProf01 > tbody').html(tB);

					$("#preloaderPrincipal").hide();

					$(".modTarPro0").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						getPropTar0(arr[1]);
					});

					$(".modTarFileAddProProf1").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						modTarFileAddProProf1(arr[1],arr[2]);
					});

					$(".modTarPro2").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						getDestinatariosTar1(arr[1],arr[2]);
					});

					$(".delTarAB0").on("click",function(event){
						event.preventDefault();
						$("#iconSaveCommentResp").show();
						var resp =  confirm("Desea eliminar este registro?");
						if (resp){
							var arr = event.currentTarget.id.split('-');
							obj.setIsTimeLine(false);
							var nc = "u="+localStorage.nc+"&idtarea="+arr[1];
				            $.post(obj.getValue(0) + "tt-del-1a/", {data:nc},
				            function(json) {
				            		if (json[0].msg=="OK"){
										onClickFillTable();
				        			}else{
				        				alert(json[0].msg);	
				        			}
				        	}, "json");
			        	}
					});
					
					$(".refreshTarPro2").on("click",function(event){
						event.preventDefault();
						$("#preloaderPrincipal").show();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
				        $.post(obj.getValue(0) + "data/", {o:40, t:10, c:arr[1], p:2, from:0, cantidad:0, s:''},
			            function(json) {
			            		if (json[0].msg=="OK"){
									onClickFillTable();
			        			}else{
			        				alert(json[0].msg);	
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
		event.stopPropagation();
		onClickFillTable();
	})

	function onClickFillTable(){
		if(oTable != null){
			oTable.fnDestroy();
			$('#tblTarProf01 > tbody').empty();
			init = true;
		}
		fillTable();
	}

	$("#isnuevas").on("change",function(event){
		event.stopPropagation();
		onClickFillTable();
			
	});

	$("#btnAddRegistry").on("click",function(event){
		event.preventDefault();

		obj.setIsTimeLine(false);
		getPropTar0(0);

	})

	function getPropTar0(IdTarea){
        $("#contentProfile").html("");
        $("#contentMain").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
	        $.post(obj.getValue(0) + "tareas-prop/", {
				user: nc,
				idtarea: IdTarea
	            },
	            function(html) {	                
	                $("#contentProfile").html(html).show('slow',function(){
	                	//$("#contentProfile");	
		                $('#breadcrumb').html(getBar('Inicio, Tarea '));
	                });
	            }, "html");
        });
        return false;
	}

	function modTarFileAddProProf1(IdTarea,Tarea){
        $("#contentProfile").html("");
        $("#contentMain").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
	        $.post(obj.getValue(0) + "tareas-archivos-list/", {
				user: nc,
				idtarea: IdTarea,
				tarea: Tarea
	            },
	            function(html) {	                
	                $("#contentProfile").html(html).show('slow',function(){
		                $('#breadcrumb').html(getBar('Inicio, Archivos de la Tarea '));
	                });
	            }, "html");
        });
        return false;
	}

	function getDestinatariosTar1(IdTarea,Tarea){
        $("#contentProfile").html("");
        $("#contentMain").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
	        $.post(obj.getValue(0) + "tareas-destinatarios-list/", {
				user: nc,
				idtarea: IdTarea,
				tarea: Tarea
	            },
	            function(html) {	                
	                $("#contentProfile").html(html).show('slow',function(){
		                $('#breadcrumb').html(getBar('Inicio, Listado de Tareas '));
	                });
	            }, "html");
        });
        return false;
	}

/*
	var stream = io.connect(obj.getValue(4));
	stream.on("servidor", jsNewSolMatEnc0);
	function jsNewSolMatEnc0(datosServer) {
		var ms = datosServer.mensaje.split("-");
		if (ms[1]=='UPLOAD_FILES_TAREAS') {
			onClickFillTable();
		}
		
		if (ms[1]=='ADD_DESTINATARIOS_TAREAS') {
			onClickFillTable();
		}
	}
*/

	$("#preloaderPrincipal").hide();

});

</script>
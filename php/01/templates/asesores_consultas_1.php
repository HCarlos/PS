<?php

include("includes/metas.php");
$user = $_POST["user"];
$IdUserNivelAcceso = intval( $_POST["IdUserNivelAcceso"] );
$ClaveNivelAcceso = intval( $_POST["ClaveNivelAcceso"] );
?>

<div  class="row-fluid">
	
	<div class="span12 widget-container-span ui-sortable">
		<div class="widget-header widget-hea1der-small header-color-green">
			<h5 class="smaller">
				<i class="icon-print"></i>
				Opciones
			</h5>
		</div>

		<div class="widget-body">
			<div class="widget-main padding-4">
				<div class="content">

					<form class="form-horizontal" class="form" role="form" id="frmQryAses0">

						<table class="tblReports">
							<tr>
								<td><label for="tipoFiltro">Filtrar por:</label></td>
								<td colspan="3">
									<select id="tipoFiltro" name="tipoFiltro" size="1">
										<option value="0">Seleccione una opción</option>
										<option value="1">Profesores</option>
										<option value="2">Grupos</option>
										<option value="3">Alumnos</option>
									</select>							
								</td>
							</tr>
							<tr>
								<td><label for="selAsesType">Elementos:</label></td>
								<td colspan="2" class="wd60prc">
									<select id="selAsesType" name="selAsesType" size="1" class="wd100prc altoMoz">
									</select>							
								</td>
								<td>
									<button class="btn btn-success" type="submit">
										<i class="icon-ok smaller-110"></i>
										Consultar
									</button>
								</td>
							</tr>
						</table>
						<input type="hidden" id="u" name="u" />

					</form>

					<div id="tblTarAses01_temp" class="dataTables_wrapper" role="grid">

						<table aria-describedby="tblTarAses01_info" id="tblTarAses01" class="table table-striped table-bordered table-hover dataTable">
											
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
		</div>

	</div>

</div>

<script typy="text/javascript">        

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

		oTable = $('#tblTarAses01').dataTable({
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
		
		var tFiltro = parseInt($("#tipoFiltro").val(),0);
		var valSel  = parseInt($("#selAsesType").val(),0);
		var txtSel  = $("#selAsesType :selected").text();
		var nc      = "u="+localStorage.nc;

		switch( tFiltro ){
			case 1:
				nc += "&idprofesor="+valSel;
				break;
			case 2:
				nc += "&idgrupo="+valSel;
				break;
			case 3:
				nc += "&idalumno="+valSel;
				break;
		}
		nc += "&tType=" + tFiltro;

		// alert(nc);

		$.post(obj.getValue(0) + "data/", {o:40, t:81, c:nc, p:55, from:0, cantidad:0,s:''},
			function(json){
				if (parseInt(json[0].msg,0) > 0){
					var lec,arc,res,des;
					$.each(json, function(i, item) {
						if (tFiltro == 1 || tFiltro == 2){
						lec = item.lecturas>0?item.lecturas:'';
						res = item.respuestas>0?item.respuestas:'';
						arc = item.archvos_tareas>0?item.archvos_tareas:'';
						des = item.destinatarios>0?item.destinatarios:'';
					}else{
						lec = parseInt(item.isleida) == 1 ? '<i class="icon-ok green"></i>':'';
						res = item.iteracciones>0?item.iteracciones:'';
						arc = item.archivos>0?item.archivos:'';						
						des = '';
					}


						tB +=' 			<tr class="odd">';
						tB +=' ';
						tB +='				<td class=" ">';
						tB +='					<a class="modTarAse0" href="#" id="idprof0-'+item.idtarea+'"  data-rel="tooltip" data-placement="top" title="Editar la Solicitud">'+padl(item.idtarea,4)+'</a>';
						tB +='				</td>';
						// tB +='				<td>'+item.grupo+': '+item.materia+'</br>'+item.titulo_tarea+'</td>';
						switch(tFiltro)
						{
							case 1:
								tB +='				<td><small><span class="orange">'+item.materia+'</span>: <span class="grey">'+item.grupo+'</span></small><br/><b>'+item.titulo_tarea+'</b></td>';
								break;
							case 2:
								tB +='				<td><small><span class="green">'+txtSel+'</span>: <span class="orange">'+item.materia+'</span>: <span class="grey">'+item.profesor+'</span></small><br/><b>'+item.titulo_tarea+'</b></td>';
								break;
							case 3:
								tB +='				<td><small><span class="orange">'+item.materia+'</span>: <span class="grey">'+item.profesor+'</span></small><br/><b>'+item.titulo_tarea+'</b></td>';
								break;
						}

						tB +='				<td>'+item.fecha_inicio+'</td>';
						tB +='				<td>'+item.fecha_fin+'</td>';
						tB +='				<td class="center">'+lec +'</td>';
						tB +='				<td class="center">'+res+'</td>';
						tB +='				<td class="center">'+arc+'</td>';
						tB +='				<td class="center">'+des+'</td>';
						tB +='				<td>';
						tB +='					<div class="action-buttons">';
						tB +='						<a class="green modTarAse0" href="#" id="idtarea-'+item.idtarea+'" data-rel="tooltip" data-placement="top" title="Editar Tarea">';
						tB +='							<i class="icon-pencil bigger-130"></i>';
						tB +='						</a>';
						tB +=' ';
						tB +='						<a class="cafe modTarFileAddProAses1" href="#" id="modTarFileAddProAses1-'+item.idtarea+'-'+item.titulo_tarea+ '" data-rel="tooltip" data-placement="top" title="Ver Archivos">';
						tB +='							<i class="fa fa-paperclip bigger-130"></i>';
						tB +='						</a>';
						tB +=' ';
						tB +='						<a class="blue marginLeft1em modTarAse2" href="#" id="modTarAse2-'+item.idtarea+'-'+item.titulo_tarea+ '" data-rel="tooltip" data-placement="top" title="Ver Destinatarios" >';
						tB +='							<i class="icon-group bigger-130"></i>'
						tB +='						</a>';
						tB +='					</div>';
						tB +='				</td>';
						tB +='			</tr>';
					});
				 	
					$('#tblTarAses01 > tbody').html(tB);


					$(".modTarAse0").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						getAsesTar0(arr[1]);
					});

					$(".modTarFileAddProAses1").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						modTarFileAddProAses1(arr[1],arr[2]);
					});

					$(".modTarAse2").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						getDestAses1(arr[1],arr[2]);
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
					
					$(".refreshTarAse2").on("click",function(event){
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


				}		
				getTable();
				$("#preloaderPrincipal").hide();

        	},
        'json'
        );
							
	}
	

	$("#preloaderPrincipal").hide();
	var tipoConsulta = 78;

	$("#tipoFiltro").on("change",function(event){
		event.preventDefault();
		switch( parseInt($(this).val(),0) ){
			case 1:
				tipoConsulta = 78; 
				break;
			case 2:
				tipoConsulta = 79; 
				break;
			case 3:
				tipoConsulta = 80; 
				break;
		}
		getSelEle0();
	});

	function getSelEle0(){
	    var nc = "u="+localStorage.nc;
	    $("#selAsesType").empty();
	    $.post(obj.getValue(0)+"data/", {o:2, t:tipoConsulta, p:55,c:nc,from:0,cantidad:0, s:"" },
	        function(json){
	           $.each(json, function(i, item) {
	               $("#selAsesType").append('<option value="'+item.data+'"> '+item.label+'</option>');
	            });
	        }, "json"
	    );  
		
	};

	$("#frmQryAses0").on("submit",function(event){
		event.preventDefault();
		if(oTable != null){
			oTable.fnDestroy();
			$('#tblTarAses01 > tbody').empty();
		}
		fillTable();
	});

	function getAsesTar0(IdTarea){
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

	function modTarFileAddProAses1(IdTarea,Tarea){
        $("#contentProfile").html("");
        $("#contentMain").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
	        $.post(obj.getValue(0) + "tareas-archivos-list/", {
				user: nc,
				idtarea: IdTarea,
				tarea: Tarea,
				tfuete: 0
	            },
	            function(html) {	                
	                $("#contentProfile").html(html).show('slow',function(){
		                $('#breadcrumb').html(getBar('Inicio, Archivos de la Tarea '));
	                });
	            }, "html");
        });
        return false;
	}

	function getDestAses1(IdTarea,Tarea){
        $("#contentProfile").html("");
        $("#contentMain").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
	        $.post(obj.getValue(0) + "tareas-destinatarios-list/", {
				user: nc,
				idtarea: IdTarea,
				tarea: Tarea,
				tfuete: 0
	            },
	            function(html) {	                
	                $("#contentProfile").html(html).show('slow',function(){
		                $('#breadcrumb').html(getBar('Inicio, Listado de Tareas '));
	                });
	            }, "html");
        });
        return false;
	}


});

</script>
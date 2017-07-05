<?php

include("includes/metas.php");

$de       = $_POST['user'];

?>


<div class="widget-box transparent">
	<div class="widget-header widget-header-blue widget-header-flat">

		<div class="widget-toolbar orage">

			<a href="#" class="ui-pg-div" data-action="reload" id="btnRefresh" >
				<i class="ui-icon icon-refresh green"></i>
			</a>

		</div>


		<select class="altoMoz add-on"  name="matListTarAlu0" id="matListTarAlu0" size="1">
		 	<option value="-1" >Tareas Revisadas</option>
		 	<option value="0" selected>Tareas Nuevas</option>
		</select>


	</div>

	<div class="widget-body">
		<div class="widget-main">
			<div class="row-fluid">

				<table aria-describedby="sample-table-2_info" id="sample-table-2" class="table table-striped table-bordered table-hover dataTable">
									
					<thead>
						<tr role="row">
							<th aria-label="idtarea: to sort column ascending" style="width: 10px;" aria-controls="sample-table-2" tabindex="0" role="columnheader" class="sorting" >ID</th>
							<th aria-label="titulo: to sort column ascending" style="width: 150px;" aria-controls="sample-table-2" tabindex="2" role="columnheader" class="sorting">TAREA</th>
							<th aria-label="materia: to sort column ascending" style="width: 150px;" aria-controls="sample-table-2" tabindex="2" role="columnheader" class="sorting">MATERIA</th>
							<th aria-label="fecha_inicio: to sort column ascending" style="width: 10px;" aria-controls="sample-table-2" tabindex="3" role="columnheader" class="sorting center">INICIA</th>
							<th aria-label="fecha_fin: to sort column ascending" style="width: 10px;" aria-controls="sample-table-2" tabindex="3" role="columnheader" class="sorting center">VENCE</th>
							<th aria-label="leidos: to sort column ascending" style="width: 10px;" aria-controls="sample-table-2" tabindex="3" role="columnheader" class="sorting center">LECT</th>
							<th aria-label="respuestas: to sort column ascending" style="width: 10px;" aria-controls="sample-table-2" tabindex="4" role="columnheader" class="sorting center">RESP</th>
							<th aria-label="archivos: to sort column ascending" style="width: 10px;" aria-controls="sample-table-2" tabindex="3" role="columnheader" class="sorting center">ARCH</th>
							<th aria-label="" style="width: 100px;" role="columnheader" class="sorting_disabled"></th>
						</tr>
					</thead>
									
					<tbody aria-relevant="all" aria-live="polite" role="alert"></tbody>
				</table>

			</div>	
		</div><!--/widget-main-->
	</div><!--/widget-body-->
</div>

<script type="text/javascript">        

jQuery(function($) {

    $("#preloaderPrincipal").show();
           //alert(localStorage.nc);

	var IsRegistry = false;
	var IdGrupo;	
	
	var oTable;

	if (localStorage.TRPP){
		TRPP = parseInt(localStorage.TRPP,0);	
	}
	oPag = {init:true, totalRegistros:0, totalPaginas:0, currentPage:0, registrosPorPagina:TRPP, Limit:'', Query:'' };

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
			"aoColumns": [ null, null, null, null, null, null, null, null, { "bSortable": false }],
			"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
			"bRetrieve": true,
			"bDestroy": false
	 	});
	}


    var nc = "u="+localStorage.nc;
    $.post(obj.getValue(0)+"data/", { o:1, t:40, p:0,c:nc,from:0,cantidad:0, s:" order by idboleta asc " },
        function(json){
            var st="";
            $.each(json, function(i, item) {
                $("#matListTarAlu0").append('<option value="'+item.data+'"> '+item.label+'</option>');
            });

		   $("#matListTarAlu0").on("change", function(event) {
		       event.stopPropagation();
		       onClickFillTable();
		   });


        $("#preloaderPrincipal").hide();
        }, "json"

    );  



	function fillTable(){
						
		var tB = "";

		$("#preloaderPrincipal").show();

		var sts = 0;
		var val = parseInt( $("#matListTarAlu0").val() );


		switch(val){
			case -1:
				sts = "-1";
				break;
			case 0:
				sts = "0";
				break;
			default:
				sts = val;
				break;
		}

		var nc = "u="+localStorage.nc+"&sts="+sts;
		$.post(obj.getValue(0) + "data/", {o:40, t:20004, c:nc, p:10, from:0, cantidad:0,s:''},
			function(json){
				if (json.length){
					var lec,arc,res,des;
					$.each(json, function(i, item) {
						lec = parseInt(item.isleida) == 1 ? '<i class="icon-ok green"></i>':'';
						res = item.iteracciones>0?item.iteracciones:'';
						arc = item.archivos>0?item.archivos:'';
						tB +=' 			<tr class="odd">';
						tB +=' ';
						tB +='				<td class=" ">';
						tB +='					<a class="modTarPro0" href="#" id="idtarea0-'+item.idtarea+'-'+item.idtareadestinatario+'-'+item.profesor_tarea+'" data-rel="tooltip" data-placement="top" title="Editar Tarea">'+padl(item.idtarea,4)+'</a>';
						tB +='				</td>';
						tB +='				<td>'+item.titulo_tarea+'</td>';
						tB +='				<td>'+item.materia+'</td>';
						tB +='				<td>'+item.fecha_inicio+'</td>';
						tB +='				<td>'+item.fecha_fin+'</td>';
						tB +='				<td class="center">'+lec +'</td>';
						tB +='				<td class="center">'+res+'</td>';
						tB +='				<td class="center">'+arc+'</td>';
						tB +='				<td>';
						tB +='					<div class="action-buttons">';
						tB +=' ';
						tB +='						<a class="blue modTarPro0" href="#" id="idtarea-'+item.idtarea+'-'+item.idtareadestinatario+'-'+item.profesor_tarea+'" data-rel="tooltip" data-placement="top" title="Ver Tarea">';
						tB +='							<i class="fa fa-file-text bigger-130"></i>';
						tB +='						</a>';
						tB +='				</td>';
						tB +='			</tr>';
					});
				 	
				 	//alert(tB);

					$('#sample-table-2 > tbody').html(tB);

					$("#preloaderPrincipal").hide();

					$(".modTarPro0").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						getPropTarAlu0(arr[1],arr[2],arr[3]);
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
					
					$('#sample-table-2 > tbody').empty();

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
	

	$("#btnRefresh").on("click",function(event){
		event.stopPropagation();
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
		getPropTarAlu0(0);
	})

	function getPropTarAlu0(IdTarea, IdTareaDestinatario, Profesor){
        $("#contentProfile").empty();
        $("#contentMain").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;

	        var url = obj.getValue(0) + "tareas-alu-prop/";
	        var tit = "Alumno-Tarea-"+nc+'-'+IdTarea;

	        trackOutboundLink(url,tit);

	        $.post(url, {
				user: nc,
				idtarea: IdTarea,
				idtareadestinatario: IdTareaDestinatario,
				iddestinatario : localStorage.IdUser,
				origenacceso: 0,
				profesor: Profesor
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

	var stream = io.connect(obj.getValue(4));
	stream.on("servidor", jsNewSolMatEnc0);
	function jsNewSolMatEnc0(datosServer) {
		var ms = datosServer.mensaje.split("-");
		if (ms[1]=='UPLOAD_FILES_TAREAS_ALU') {
			onClickFillTable();
		}
		
		if (ms[1]=='ADD_DESTINATARIOS_TAREAS_ALU') {
			onClickFillTable();
		}
	}

	var init = true;			
	fillTable();


    $("#preloaderPrincipal").hide();
	
});

</script>
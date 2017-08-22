<?php

include("includes/metas.php");

$de       = $_POST['user'];
$objeto  = !isset( $_POST['objeto'] ) ? 'contentMain' : $_POST['objeto'];

?>


<div class="widget-box transparent">
	<div class="widget-header widget-header-blue widget-header-flat">

		<div class="widget-toolbar orage">

			<a href="#" class="ui-pg-div" data-action="reload" id="btnRefresh" >
				<i class="ui-icon icon-refresh green"></i>
			</a>

		</div>


		<select class="altoMoz add-on"  name="matListComMenAlu1" id="matListComMenAlu1" size="1">
		 	<option value="-1" >Revisados</option>
		 	<option value="0" selected>Nuevos</option>
		</select>


	</div>

	<div class="widget-body">
		<div class="widget-main">
			<div class="row-fluid">

				<table aria-describedby="sample-table-2_info" id="tblComMenAlu2" class="table table-striped table-bordered table-hover dataTable">
									
					<thead>
						<tr role="row">
							<th aria-label="idcommensaje: to sort column ascending" style="width: 10px;" aria-controls="tblComMenAlu2" tabindex="0" role="columnheader" class="sorting" >ID</th>
							<th aria-label="titulo: to sort column ascending" style="width: 150px;" aria-controls="tblComMenAlu2" tabindex="2" role="columnheader" class="sorting">TITULO</th>
							<th aria-label="fecha: to sort column ascending" style="width: 10px;" aria-controls="tblComMenAlu2" tabindex="3" role="columnheader" class="sorting center">FECHA</th>
							<th aria-label="leidoas: to sort column ascending" style="width: 10px;" aria-controls="tblComMenAlu2" tabindex="4" role="columnheader" class="sorting center">LEC</th>
							<th aria-label="respuestas: to sort column ascending" style="width: 10px;" aria-controls="tblComMenAlu2" tabindex="4" role="columnheader" class="sorting center">RESP</th>
							<th aria-label="archivos: to sort column ascending" style="width: 10px;" aria-controls="tblComMenAlu2" tabindex="3" role="columnheader" class="sorting center">ARCH</th>
							<th aria-label="destinatarios: to sort column ascending" style="width: 10px;" aria-controls="tblComMenAlu2" tabindex="4" role="columnheader" class="sorting center">DEST</th>
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
    var objContainer = "#<?= $objeto; ?>";

	var IsRegistry = false;
	var IdGrupo;	
	
	var oTable;

	if (localStorage.TRPP){
		TRPP = parseInt(localStorage.TRPP,0);	
	}
	oPag = {init:true, totalRegistros:0, totalPaginas:0, currentPage:0, registrosPorPagina:TRPP, Limit:'', Query:'' };

	function getTable(){

		oTable = $('#tblComMenAlu2').dataTable({
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
			"aoColumns": [ null, null, null, null, null, null, null, { "bSortable": false }],
			"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
			"bRetrieve": true,
			"bDestroy": false
	 	});
	}


   	$("#matListComMenAlu1").on("change", function(event) {
       event.stopPropagation();
       onClickFillTable();
   	});

	function fillTable(){
						
		var tB = "";

		$("#preloaderPrincipal").show();

		var sts = 0;
		var val = parseInt( $("#matListComMenAlu1").val() );


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
		$.post(obj.getValue(0) + "data/", {o:42, t:31009, c:nc, p:10, from:0, cantidad:0,s:''},
			function(json){
				if (json.length){
					var lec,arc,res,des;
					$.each(json, function(i, item) {
						lec = item.isleida>0?'Leida':'';
						res = item.isrespuesta>0?item.isrespuesta:'';
						//arc = item.archivos>0?item.archivos:'';
						//des = item.destinatarios>0?item.destinatarios:'';
						
						// alert(res);

						tB +=' 			<tr class="odd">';
						tB +=' ';
						tB +='				<td class=" ">';
						tB +='					<a class="modComMenAlu1" href="#" id="idprof0-'+item.idcommensaje+'"  data-rel="tooltip" data-placement="top" title="Editar la Solicitud">'+padl(item.idcommensaje,4)+'</a>';
						tB +='				</td>';
						tB +='				<td>'+item.titulo_mensaje+'</td>';
						tB +='				<td>'+item.fecha+'</td>';
						tB +='				<td class="center">'+lec +'</td>';
						tB +='				<td class="center">'+res+'</td>';
						tB +='				<td class="center">+arc+</td>';
						tB +='				<td class="center">+des+</td>';
						tB +='				<td>';
						tB +='					<div class="action-buttons">';
						tB +=' ';
						tB +='						<a class="blue modComMenAlu1" href="#" id="idcommensaje-'+item.idcommensaje+'-'+item.idcommensajedestinatario+'-'+item.nombre_remitente+'" data-rel="tooltip" data-placement="top" title="Editar Mensaje">';
						tB +='							<i class="fa fa-file-text bigger-130"></i>';
						tB +='						</a>';
						tB +='				</td>';
						tB +='			</tr>';
					});
				 	
				 	//alert(tB);

					$('#tblComMenAlu2 > tbody').html(tB);

					$("#preloaderPrincipal").hide();

					$(".modComMenAlu1").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						getPropComMenAlu1(arr[1],arr[2],arr[3]);
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
					
					$('#tblComMenAlu2 > tbody').empty();

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
			$('#tblComMenAlu2 > tbody').empty();
			init = true;
		}
		fillTable();
	}


	function getPropComMenAlu1(IdComMensaje, IdComMensajeDestinatario, Remitente){
        $("#contentLevel3").empty();
        $("#contentLevel3").hide();
        $(objContainer).hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;

	        var url = obj.getValue(0) + "comunica-mensaje-destinatarios-prop/";
	        var tit = "Tutor-Comunicado-"+nc+'-'+IdComMensaje;

	        trackOutboundLink(url,tit);

	        $.post(url, {
				user: nc,
				idcommensaje: IdComMensaje,
				idcommensajedestinatario: IdComMensajeDestinatario,
				iddestinatario : localStorage.IdUser,
				origenacceso: 1,
				remitente: Remitente
	            },
	            function(html) {	            
		            //$("#contentLevel3").show();    
	                $("#contentLevel3").html(html).show('slow',function(){
	                	//$("#contentProfile");	
		                $('#breadcrumb').html(getBar('Inicio, Mensaje '));
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
		
		if (ms[1]=='UPLOAD_FILES_COM_MENSAJE_RESP') {
			onClickFillTable();
		}
		
		if (ms[1]=='RESPUESTA_COM_MEN') {
			onClickFillTable();
		}
	}
*/

	var init = true;			
	fillTable();


    $("#preloaderPrincipal").hide();
	
});

</script>
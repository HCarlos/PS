<?php

include("includes/metas.php");

$de       = $_POST['user'];
$idgrupo  = $_POST['idgrupo'];
$grupo  = $_POST['grupo'];
$clave_nivel  = $_POST['clave_nivel'];
$grado  = $_POST['grado'];
$idciclo  = $_POST['idciclo'];

?>
<div  class="row-fluid">
	<table class="ui-pg-table navtable" style="float:left;table-layout:auto;" border="0" cellpadding="0" cellspacing="0">
		<tbody>
			<tr>
				<td data-original-title="Add new row" id="add_grid-table" title="" class="ui-pg-button ui-corner-all">
					<div class="ui-pg-div" id="btnAddGruMat" >
						<span class="ui-icon icon-plus-sign purple"></span>
					</div>
				</td>
				
				<td title="" data-original-title="" class="ui-pg-button ui-state-disabled" style="width:4px;">
					<span class="ui-separator marginLeft1em"></span>
				</td>
				<td data-original-title="Reload Grid" id="refresh_grid-table" title="" class="ui-pg-button ui-corner-all">
					<div class="ui-pg-div" id="btnRefreshGruMat">
						<span class="ui-icon icon-refresh green"></span>
					</div>
				</td>
				
				<td title="" data-original-title="" class="ui-pg-button ui-state-disabled" style="width:4px;">
					<span class="ui-separator marginLeft1em"></span>
				</td>
				<td data-original-title="Reload Grid" title="Agrupar Materias" class="ui-pg-button ui-corner-all">
					<div class="ui-pg-div" id="configAgruGruMat">
						<span class="ui-icon icon-cogs orange"></span>
					</div>
				</td>

				<td title="" data-original-title="" class="ui-pg-button ui-state-disabled" style="width:4px;">
					<span class="ui-separator marginLeft1em"></span>
				</td>
				<td data-original-title="Reload Grid" title="Generar Números de Lista para este Grupo" class="ui-pg-button ui-corner-all">
					<div class="ui-pg-div" id="genNumListaPorGrupo">
						<span class="ui-icon icon-sort-by-attributes-alt blue"></span>
					</div>
				</td>

				<div id="divDatAdicOf">
					<td title="" data-original-title="" class="ui-pg-button ui-state-disabled" style="width:4px;">
						<span class="ui-separator marginLeft1em"></span>
					</td>
					<td data-original-title="Datos adicionales oficiales" title="Datos adicionales oficiales" class="ui-pg-button ui-corner-all">
						<div class="ui-pg-div" id="getDatosAdicionalesOficiales">
							<span class="ui-icon icon-edit cafe"></span>
						</div>
					</td>
				</div>	
				
				<td title="" data-original-title="" class="ui-pg-button ui-state-disabled" style="width:4px;">
					<span class="ui-separator marginLeft1em"></span>
				</td>
				<td data-original-title="Reload Grid" title="Imprime Boletas" class="ui-pg-button ui-corner-all">
					<div class="ui-pg-div" id="printBolCal0">
						<span class="ui-icon icon-table intense-red"></span>
					</div>
				</td>
				
				<td data-original-title="Reload Grid" title="Regresar" class="ui-pg-button ui-corner-all wd100prc">
					<div class="ui-pg-div closeFormUpload pull-right" >
						<a class="label label-info arrowed-in-right arrowed">Regresar</a>
					</div>
				</td>

			</tr>
		</tbody>
	</table>

</div>

<div class="borderTopContainer">
	<div id="user-profile-1" class="user-profile row-fluid">
			<div id="tblGruMatList_wrapper" class="dataTables_wrapper" role="grid">

				<table aria-describedby="tblGruMatList_info" id="tblGruMatList" class="table table-striped table-bordered table-hover dataTable">
									
					<thead>
						<tr role="row">
							<th aria-label="idgrumat: activate to sort column ascending" style="width: 50px;" aria-controls="tblGruMatList" tabindex="0" role="columnheader" class="sorting" >ID</th>
							<th aria-label="grupo: activate to sort column ascending" style="width: 80px;" aria-controls="tblGruMatList" tabindex="1" role="columnheader" class="sorting">Grupo</th>
							<th aria-label="Materia: activate to sort column ascending" style="width: 200px;" aria-controls="tblGruMatList" tabindex="2" role="columnheader" class="sorting">Materia</th>
							<th aria-label="Profesor: activate to sort column ascending" style="width: 150px;" aria-controls="tblGruMatList" tabindex="3" role="columnheader" class="sorting">Profesor</th>
							<th aria-label="Impresion: activate to sort column ascending" style="width: 60px;" aria-controls="tblGruMatList" tabindex="4" role="columnheader" class="sorting" title="Orden Impresión">O. I.</th>
							<th aria-label="Historial: activate to sort column ascending" style="width: 60px;" aria-controls="tblGruMatList" tabindex="5" role="columnheader" class="sorting" title="Orden Historial">O. H.</th>
							<th aria-label="Oficial: activate to sort column ascending" style="width: 60px;" aria-controls="tblGruMatList" tabindex="5" role="columnheader" class="sorting" title="Orden Oficial">O. O.</th>
							<th aria-label="bloqueado: activate to sort column ascending" style="width: 10px;" colspan="1" rowspan="1" aria-controls="sample-table-2" tabindex="7" role="columnheader" class="sorting">B</th>
							<th aria-label="" style="width: 100px;" aria-controls="tblGruMatList" role="columnheader" class="sorting_disabled"></th>
						</tr>
					</thead>
									
					<tbody aria-relevant="all" aria-live="polite" role="alert"></tbody>
				
				</table>

			</div><!--PAGE CONTENT ENDS-->

	</div>
</div>

<div id="inline2">
	
</div>

<div class="form-actions" >
	<button type="button" class="btn btn-default pull-right closeFormUpload" data-dismiss="modal" id="closeFormUpload"><i class="icon-close"></i>Regresar</button>
</div>

<!--PAGE CONTENT ENDS-->

<script typy="text/javascript">        

jQuery(function($) {

	$("#divDatAdicOf").hide();

	var IdGrupo = <?php echo $idgrupo; ?>;
	var Grupo = '<?php echo $grupo; ?>';
	var Clave_Nivel = <?php echo $clave_nivel; ?>;
	var Grado = <?php echo $grado; ?>;
	var IdCiclo = <?= $idciclo; ?>;

	if ( Clave_Nivel == 2 && Clave_Nivel == 3  && Clave_Nivel == 4 ){
		$("#divDatAdicOf").show();
	}

	var oTable;

	function getTable(){

		oTable = $('#tblGruMatList').dataTable({
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
			"aoColumns": [ null, null, null, null, null, null, null, null,  { "bSortable": false }],
			"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
			"bRetrieve": true,
			"bDestroy": false
	 	});
	}

	function fillTable(){
						
		var tB = "";

		$("#preloaderPrincipal").show();
		var nc = "u="+localStorage.nc+"&idgrupo="+IdGrupo+"&idciclo="+IdCiclo;
		// alert(nc);
		$.post(obj.getValue(0) + "data/", {o:16, t:31, c:nc, p:11, from:0, cantidad:0,s:'idgrumat'},
			function(json){
					$.each(json, function(i, item) {
						var oo = parseInt(item.orden_oficial,0)==999?999:item.orden_oficial;
						var bloqueado = parseInt(item.materia_bloqueada,0)==1?'<i class="fa fa-lock"></i>':'';
						// +item.padre+' '+item.idioma+' '+item.idgrumat	
						tB +=' 			<tr class="odd">';
						tB +='';
						tB +='				<td class=" ">';
						tB +='					<a href="#" >'+padl(item.idgrumat,4)+'</a>';
						tB +='				</td>';
						tB +='				<td class=" " >'+item.grupo+'</td>';
						tB +='				<td class=" " >'+item.materia+' ('+item.abreviatura+') '+'</td>';
						tB +='				<td class=" " >'+item.profesor+'</td>';
						tB +='				<td class=" " >'+item.orden_impresion+'</td>';
						tB +='				<td class=" " >'+item.orden_historial+'</td>';
						tB +='				<td class=" " >'+oo+'</td>';
						tB +='				<td class=" " >'+bloqueado+'</td>';
						tB +='				<td class=" ">';
						tB +='					<div class="hidden-phone visible-desktop action-buttons">';
						tB +='';
						tB +='						<a class="green modGruMatPro" href="#" id="idgrumat-'+item.idgrumat+'-'+item.idgrupo+'" >';
						tB +='							<i class="icon-pencil bigger-130"></i>';
						tB +='						</a>';
						tB +='	';
						tB +='						<a class="red delGruMat" href="#"  id="delGruMat-'+item.idgrumat+'" >';
						tB +='							<i class="icon-trash bigger-130"></i>';
						tB +='						</a>';
						tB +='	';
						tB +='						<a class="blue listGruAluMat" href="#"  id="listGruAluMat-'+item.idgrumat+'-'+item.grado+'" >';
						tB +='							<i class="icon-group bigger-130"></i>';
						tB +='						</a>';
						tB +='					</div>';
						tB +='';
						tB +='				</td>';
						tB +='			</tr>';
					});

					$('#tblGruMatList > tbody').html(tB);

					$("#preloaderPrincipal").hide();

					$(".modGruMatPro").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						getPropGruMat(arr[1],IdGrupo, Grupo);
					});

					$(".listGruAluMat").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						getListAluGruMat(arr[1],IdGrupo, Grupo,arr[2]);
					});

					$(".delGruMat").on("click",function(event){
						event.preventDefault();
						$("#iconSaveCommentResp").show();
						var resp =  confirm("Desea eliminar este registro?");
						//alert(resp);
						//return false;
						if (resp){
							var arr = event.currentTarget.id.split('-');
							//alert(arr[1]);
							obj.setIsTimeLine(false);
				            $.post(obj.getValue(0) + "data/", {o:16, t:2, c:arr[1], p:2, from:0, cantidad:0, s:''},
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

	$(".closeFormUpload").on("click",function(event){
		event.preventDefault();
		$("#preloaderPrincipal").hide();
		$("#contentProfile").hide(function(){
			$("#contentProfile").empty();
			$("#contentMain").show();
		});
		resizeScreen();
		return false;
	});


	$("#btnRefreshGruMat").on("click",function(event){
		event.preventDefault();
		onClickFillTable();
	})

	function onClickFillTable(){
		if(oTable != null){
			oTable.fnDestroy();
			$('#tblGruMatList > tbody').empty();
			init = true;
		}
		fillTable();
	}


	$("#btnAddGruMat").on("click",function(event){
		event.preventDefault();

		obj.setIsTimeLine(false);
		getPropGruMat(0,IdGrupo, Grupo);

	})


	function getPropGruMat(IdGruMat,IdGrupo, Grupo){
		$("#divUploadImage").empty();
		var nc = localStorage.nc; //.split("@");
		$.post(obj.getValue(0) + "gru-mats-prop/", {
				user: nc,
				idgrumat: IdGruMat,
				idgrupo: IdGrupo,
				grupo: Grupo,
				idciclo: IdCiclo
			},
			function(html) {
				$("#divUploadImage").html(html);
				$("#divUploadImage").modal('toggle');
		}, "html");
	}



	$("#configAgruGruMat").on("click",function(event){
		event.preventDefault();

		obj.setIsTimeLine(false);
		getAgruGruMat(0,IdGrupo, Grupo);

	})


	function getAgruGruMat(IdGruMat,IdGrupo,Grupo){
        $("#contentLevel3").empty();
        $("#contentProfile").hide(function(){
			var nc = localStorage.nc; //.split("@");
		$.post(obj.getValue(0) + "gru-mats-agru/", {
				user: nc,
				idgrumat: IdGruMat,
				idgrupo: IdGrupo,
				grupo: Grupo,
				idciclo: IdCiclo
			},
			function(html) {
	                $("#contentLevel3").html(html).show('slow',function(){
	               	//$('#breadcrumb').html(getBar('Inicio, Configuración de Agrupación de Materias '));
	            	});
			}, "html");
		});
	}


	$("#genNumListaPorGrupo").on("click",function(event){
		event.preventDefault();

		obj.setIsTimeLine(false);
		// genNumListaPorGrupo(0,IdGrupo, Grupo);
		genNumListaPorGrupoXLS(0,IdGrupo, Grupo);

	})


	function genNumListaPorGrupo(IdGruMat,IdGrupo, Grupo){
        $("#contentLevel3").empty();
        $("#contentProfile").hide(function(){
			var nc = localStorage.nc; //.split("@");
		$.post(obj.getValue(0) + "gru-mats-num-lista-grupo/", {
				user: nc,
				idgrumat: IdGruMat,
				idgrupo: IdGrupo,
				grupo: Grupo,
				idciclo: IdCiclo
			},
			function(html) {
	                $("#contentLevel3").html(html).show('slow',function(){
	               	//$('#breadcrumb').html(getBar('Inicio, Orden por Número de Lista '));
	            	});
			}, "html");
		});
	}

	function genNumListaPorGrupoXLS(IdGruMat,IdGrupo, Grupo){
        $("#contentLevel3").empty();
        $("#contentProfile").hide(function(){
			var nc = localStorage.nc; //.split("@");
		$.post(obj.getValue(0) + "gru-mats-num-lista-grupo-xls-0/", {
				user: nc,
				idgrumat: IdGruMat,
				idgrupo: IdGrupo,
				grupo: Grupo,
				idciclo: IdCiclo
			},
			function(html) {
	                $("#contentLevel3").html(html).show('slow',function(){
	               	//$('#breadcrumb').html(getBar('Inicio, Orden por Número de Lista '));
	            	});
			}, "html");
		});
	}


	function getListAluGruMat(IdGruMat, IdGrupo, Grupo, Grado){
		$("#divUploadImage").empty();
		var nc = localStorage.nc; //.split("@");
		$.post(obj.getValue(0) + "gru-mats-alumnos/", {
				user: nc,
				idgrumat: IdGruMat,
				idgrupo: IdGrupo,
				grupo: Grupo,
				grado: Grado,
				idciclo: IdCiclo
			},
			function(html) {
				$("#divUploadImage").html(html);
				$("#divUploadImage").modal('toggle');
		}, "html");

	}

	$("#printBolCal0").on("click",function(event){
		event.preventDefault();

		obj.setIsTimeLine(false);
		getBolCal0(0,IdGrupo, Grupo, Grado);

	})

	function getBolCal0(IdGruMat,IdGrupo, Grupo, Grado){
        $("#contentLevel3").empty();
        $("#contentProfile").hide(function(){
		var nc = localStorage.nc; //.split("@");
		$.post(obj.getValue(0) + "gru-bol-calif/", {
				user: nc,
				idgrumat: IdGruMat,
				idgrupo: IdGrupo,
				grupo: Grupo,
				gradox: Grado,
				idciclo: IdCiclo
			},
			function(html) {
	                $("#contentLevel3").html(html).show('slow',function(){
	               	//$('#breadcrumb').html(getBar('Inicio, Imprimir Boletas de Califiaciones | <span class="intense-red">'+Grupo+'</span>'));
	            	});
			}, "html");
		});
	}



	$("#getDatosAdicionalesOficiales").on("click",function(event){
		event.preventDefault();

		obj.setIsTimeLine(false);
		getDatosAdicionalesOficiales(0,IdGrupo, Grupo, Grado);

	})

	function getDatosAdicionalesOficiales(IdGruMat,IdGrupo, Grupo, Grado){
        $("#contentLevel3").empty();
        $("#contentProfile").hide(function(){
		var nc = localStorage.nc; //.split("@");
		$.post(obj.getValue(0) + "gru-dat-adic-of-list/", {
				user: nc,
				idgrumat: IdGruMat,
				idgrupo: IdGrupo,
				grupo: Grupo,
				grado: Grado,
				idciclo: IdCiclo
			},
			function(html) {
	                $("#contentLevel3").html(html).show('slow',function(){
	            	});
			}, "html");
		});
	}

/*
	var stream = io.connect(obj.getValue(4));
	stream.on("servidor", jsNewGruMat);
	function jsNewGruMat(datosServer) {
		var ms = datosServer.mensaje.split("-");
		//alert(datosServer);
		//obj.setIsTimeLine(true);
		if (ms[1]=='GRUMATS') {
			// onClickFillTable();
		}
	}
*/
	

});



</script>
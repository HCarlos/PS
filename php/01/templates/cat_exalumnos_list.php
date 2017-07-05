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
					<div class="ui-pg-div" id="btnAddRegExa" >
						<span class="ui-icon icon-plus-sign purple"></span>
					</div>
				</td>
				<td title="" data-original-title="" class="ui-pg-button ui-state-disabled" style="width:4px;">
					<span class="ui-separator marginLeft1em"></span>
				</td>
				<td data-original-title="Reload Grid" id="refresh_grid-table" title="" class="ui-pg-button ui-corner-all">
					<div class="ui-pg-div" id="btnRefExa">
						<span class="ui-icon icon-refresh green"></span>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<div class="borderTopContainer">
	<div id="userpropexa01" class="user-profile row-fluid">
			<div id="tblExa01" class="dataTables_wrapper" role="grid">

				<table aria-describedby="tblExal_info" id="tblExal" class="table table-striped table-bordered table-hover dataTable">

					<thead>
						<tr role="row">
							<th aria-label="idexalumno: activate to sort column ascending" style="width: 50px;" aria-controls="tblExal" tabindex="0" role="columnheader" class="sorting" >ID</th>
							<th aria-label="nombre_exalumno: activate to sort column ascending" style="width: 200px;" aria-controls="tblExal" tabindex="1" role="columnheader" class="sorting">EXALUMNO</th>
							<th aria-label="generacion: activate to sort column ascending" style="width: 50px;" aria-controls="tblExal" tabindex="2" role="columnheader" class="sorting">GEN.</th>
							<!-- <th aria-label="email: activate to sort column ascending" style="width: 100px;" aria-controls="tblExal" tabindex="3" role="columnheader" class="sorting">EMAIL</th> -->
							<th aria-label="profesion: activate to sort column ascending" style="width: 100px;" aria-controls="tblExal" tabindex="4" role="columnheader" class="sorting">PROF.</th>
							<th aria-label="ocupacion: activate to sort column ascending" style="width: 100px;" aria-controls="tblExal" tabindex="5" role="columnheader" class="sorting">OCUP.</th>
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

	var lc = parseInt(localStorage.IdUserNivelAcceso,0);

	var oTable;

	function getTable(){

		oTable = $('#tblExal').dataTable({
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
			"aoColumns": [ null, null, null, null, null, { "bSortable": false }],
			"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
			"bRetrieve": true,
			"bDestroy": false
	 	});
	}

	function fillTable(){
						
		var tB = "";

		$("#preloaderPrincipal").show();
		var nc = "u="+localStorage.nc;
		$.post(obj.getValue(0) + "data/", {o:60, t:47, c:nc, p:54, from:0, cantidad:0,s:''},
			function(json){
					$.each(json, function(i, item) {

						var vad = parseInt(item.valid_for_admin,0) == 0 ? ' <i class="icon icon-certificate red"></i> ' : '';

						tB +=' 			<tr class=" odd ">';
						tB +='				<td>'+padl(item.idexalumno,4)+'</td>';
						tB +='				<td>'+item.nombre_exalumno+'</td>';
						tB +='				<td>'+item.generacion+'</td>';
						// tB +='				<td>'+item.email+'</td>';
						tB +='				<td>'+item.profesion+'</td>';
						tB +='				<td>'+item.ocupacion+'</td>';
						tB +='				<td>';
						tB +='					<div class="hidden-phone visible-desktop action-buttons">';
						tB +='';
						tB +='						<a class="green modExaPro" href="#" id="idexalumno-'+item.idexalumno+'" >';
						tB +='							<i class="icon-pencil bigger-130"></i>';
						tB +='						</a>';
						tB +='	';
						tB +='						<a class="red delExa" href="#"  id="delExa-'+item.idexalumno+'" >';
						tB +='							<i class="icon-trash bigger-130"></i>';
						tB +='						</a>';
						tB +='	';

						if ( parseInt(item.genero,0) == 0 ){
							tB += '			<a class="pink modGruMatProKRDX02 tooltip-info " href="#" id="idgrualu2two-'+item.idexalumno+'" title="Editar Datos" >';
							tB += '				<i class="fa fa-female bigger-150"></i>';
							tB += '			</a>';
						}else{
							tB += '			<a class="blue modGruMatProKRDX02 tooltip-info " href="#" id="idgrualu2two-'+item.idexalumno+'" title="Editar Datos" >';
							tB += '				<i class="fa fa-male bigger-150"></i>';
							tB += '			</a>';
						}
						tB +='					</div>';
						tB +='';
						tB +='				</td>';
						tB +='			</tr>';
					});

					$('#tblExal > tbody').html(tB);

					$("#preloaderPrincipal").hide();

					$(".modExaPro").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						getPropExa(arr[1]);
					});

					$(".delExa").on("click",function(event){
						event.preventDefault();
						$("#iconSaveCommentResp").show();
						var resp =  confirm("Desea eliminar este registro?");
						//alert(resp);
						//return false;
						if (resp){
							var arr = event.currentTarget.id.split('-');
							//alert(arr[1]);
							obj.setIsTimeLine(false);
				            $.post(obj.getValue(0) + "data/", {o:60, t:2, c:arr[1], p:52, from:0, cantidad:0, s:''},
				            function(json) {
			            		if (json[0].msg=="OK"){
									onClickFillTable();
			        			}else{
			        				alert(json[0].msg);	
			        			}
				        	}, "json");
			        	}

					});

					$(".configMedExa").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						getListMedExa(arr[1],arr[2]);
					});

					$(".configEmerExa").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						getListEmerExa(arr[1],arr[2]);
					});


					$(".modGruMatProKRDX02").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						modGruMatProKRDX02(arr[1]);
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


	$("#btnRefExa").on("click",function(event){
		event.preventDefault();
		onClickFillTable();
	})

	function onClickFillTable(){
		if(oTable != null){
			oTable.fnDestroy();
			$('#tblExal > tbody').empty();
			init = true;
		}
		fillTable();
	}


	$("#btnAddRegExa").on("click",function(event){
		event.preventDefault();

		obj.setIsTimeLine(false);
		getPropExa(0);

	})

	function getPropExa(IdExa){
        $("#contentProfile").empty();
        $("#contentMain").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
	        $.post(obj.getValue(0) + "cat-exalumnos-prop/", {
				user: nc,
				idexalumno: IdExa,
				objOrigen: 'contentProfile',
				objDestino: 'contentMain'
	            },
	            function(html) {	                
	                $("#contentProfile").html(html).show('slow',function(){
	                	//$("#contentProfile");	
		                $('#breadcrumb').html(getBar('Inicio, Propiedades de un nuevo ExAlumno '));
	                });
	            }, "html");
        });
        return false;
	}

	function getListMedExa(IdExa, Exa){
        $("#contentProfile").empty();
        $("#contentMain").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
	        $.post(obj.getValue(0) + "cat-exalumno-medicos-asign/", {
				user: nc,
				idexalumno: IdExa,
				exalumno: Exa
	            },
	            function(html) {	                
	                $("#contentProfile").html(html).show('slow',function(){
	                	//$("#contentProfile");	
		                $('#breadcrumb').html(getBar('Inicio, Propiedades de un nuevo Exa '));
	                });
	            }, "html");
        });
        return false;
	}

	function getListEmerExa(IdExa, Exa){
        $("#contentProfile").empty();
        $("#contentMain").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
	        $.post(obj.getValue(0) + "cat-exalumno-emergencias-asign/", {
				user: nc,
				idexalumno: IdExa,
				exalumno: Exa
	            },
	            function(html) {	                
	                $("#contentProfile").html(html).show('slow',function(){
		                $('#breadcrumb').html(getBar('Inicio, Telefonos de Emergencia Exas '));
	                });
	            }, "html");
        });
        return false;
	}

 	function modGruMatProKRDX02(IdExa){

		var nc = "u="+localStorage.nc+"&idexalumno="+IdExa+'&idgrupo=0';        
        var PARAMS = {o:1, t:21, c:nc, p:0, from:0, cantidad:0, s:''};  
        var url = obj.getValue(0)+"kardex-exalumno-arji/";

        var temp=document.createElement("form");
        temp.action=url;
        temp.method="POST";
        temp.target="_blank";
        temp.style.display="none";
        for(var x in PARAMS) {
            var opt=document.createElement("textarea");
            opt.name=x;
            opt.value=PARAMS[x];
            temp.appendChild(opt);
        }
        document.body.appendChild(temp);
        temp.submit();
        return temp;
 	}

	var stream = io.connect(obj.getValue(4));
	stream.on("servidor", jsNewExa);
	function jsNewExa(datosServer) {
		var ms = datosServer.mensaje.split("-");
		//alert(datosServer);
		//obj.setIsTimeLine(true);
		if (ms[1]=='EXALUMNOS') {
			//onClickFillTable();
		}
	}

	

});



</script>
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
					<div class="ui-pg-div" id="btnAddRegistry" >
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
			<div id="sample-table-2_wrapper" class="dataTables_wrapper" role="grid">

				<table aria-describedby="sample-table-2_info" id="sample-table-2" class="table table-striped table-bordered table-hover dataTable">
									
					<thead>
						<tr role="row">
							<th aria-label="idalumno: activate to sort column ascending" style="width: 80px;" colspan="1" rowspan="1" aria-controls="sample-table-2" tabindex="0" role="columnheader" class="sorting" >ID</th>
							<th aria-label="nombre_alumno: activate to sort column ascending" style="width: 200px;" colspan="1" rowspan="1" aria-controls="sample-table-2" tabindex="1" role="columnheader" class="sorting">Alumno</th>
							<th aria-label="usuario: activate to sort column ascending" style="width: 60px;" colspan="1" rowspan="1" aria-controls="sample-table-2" tabindex="1" role="columnheader" class="sorting">Usuario</th>
							<th aria-label="is_mobile: activate to sort column ascending" style="width: 80px;" colspan="1" rowspan="1" aria-controls="sample-table-2" tabindex="1" role="columnheader" class="sorting">Is Mobile</th>
							<th aria-label="mod: activate to sort column ascending" style="width: 5px;" colspan="1" rowspan="1" aria-controls="sample-table-2" tabindex="1" role="columnheader" class="sorting">M</th>
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
			"aoColumns": [ null, null, null, null, null,  { "bSortable": false }],
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
						var is_mobile = item.is_mobile=="1"?"<i class='green glyphicon glyphicon-ok'></i> SI":"";
						tB +=' 			<tr class=" odd ">';
						tB +='';
						tB +='				<td class=" ">';
						tB +='					<a href="#" >'+padl(item.idalumno,4)+'</a>';
						tB +='				</td>';
						tB +='				<td class=" " >'+item.nombre_alumno+'</td>';
						tB +='				<td class=" " >'+item.username+'</td>';
						tB +='				<td class="center" >'+is_mobile+'</td>';
						tB +='				<td class="center" >'+vad+'</td>';
						tB +='				<td class=" ">';
						tB +='					<div class="hidden-phone visible-desktop action-buttons">';
						tB +='';
						tB +='						<a class="green modAlumnoPro" href="#" id="idalumno-'+item.idalumno+'" >';
						tB +='							<i class="icon-pencil bigger-130"></i>';
						tB +='						</a>';
						tB +='	';
						if ( lc > 900 ) {
							tB +='						<a class="red delAlumno" href="#"  id="delAlumno-'+item.idalumno+'" >';
							tB +='							<i class="icon-trash bigger-130"></i>';
							tB +='						</a>';
						}
						tB +='						<a class="blue configMedAlu" href="#"  id="configMedAlu-'+item.idalumno+'-'+item.nombre_alumno+'" >';
						tB +='							<i class="fa fa-user-md bigger-150"></i>';
						tB +='						</a>';
						tB +='						<a class="yellow configEmerAlu " href="#"  id="configEmerAlu-'+item.idalumno+'-'+item.nombre_alumno+'" >';
						tB +='							<i class="fa fa fa-phone bigger-150"></i>';
						tB +='						</a>';
						if ( parseInt(item.genero,0) == 0 ){
							tB += '			<a class="pink modGruMatProKRDX02 tooltip-info " href="#" id="idgrualu2two-'+item.idalumno+'-'+item.idusername+'" data-rel="tooltip" data-placement="top" data-original-title="Ver Kardex" title="Ver Kardex" >';
							tB += '				<i class="fa fa-female bigger-150"></i>';
						}else{
							tB += '			<a class="blue modGruMatProKRDX02 tooltip-info " href="#" id="idgrualu2two-'+item.idalumno+'-'+item.idusername+'" data-rel="tooltip" data-placement="top" data-original-title="Ver Kardex" title="Ver Kardex" >';
							tB += '				<i class="fa fa-male bigger-150"></i>';
						}
						tB +='						</a>';

						if ( item.is_mobile == "1" ){
							tB +='						<a class="black mobileAlumno" href="#" id="mobileAlumno-'+item.username+'" >';
							tB +='							<i class="glyphicon glyphicon-phone bigger-130"></i>';
							tB +='						</a>';
						}

						tB +='					</div>';
						tB +='';
						tB +='				</td>';
						tB +='			</tr>';
					});

					$('#sample-table-2 > tbody').html(tB);

					$("#preloaderPrincipal").hide();

					$(".modAlumnoPro").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						getPropAlumno(arr[1]);
					});

					$(".delAlumno").on("click",function(event){
						event.preventDefault();
						$("#iconSaveCommentResp").show();
						var resp =  confirm("Desea eliminar este registro?");
						//alert(resp);
						//return false;
						if (resp){
							var arr = event.currentTarget.id.split('-');
							//alert(arr[1]);
							obj.setIsTimeLine(false);
				            $.post(obj.getValue(0) + "data/", {o:5, t:2, c:arr[1], p:2, from:0, cantidad:0, s:''},
				            function(json) {
			            		if (json[0].msg=="OK"){
									onClickFillTable();
			        			}else{
			        				alert(json[0].msg);	
			        			}
				        	}, "json");
			        	}

					});

					$(".configMedAlu").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						getListMedAlu(arr[1],arr[2]);
					});

					$(".configEmerAlu").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						getListEmerAlu(arr[1],arr[2]);
					});


					$(".modGruMatProKRDX02").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						if (arr[2] != 'null'){
							modGruMatProKRDX02(arr[1],arr[2]);
						}else{
							alert("Aún no se ha generado un Usuario a este alumno");
						}	
					});

					$(".mobileAlumno").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						sendMobileAlumno(arr[1]);
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
			$('#sample-table-2 > tbody').empty();
			init = true;
		}
		fillTable();
	}


	$("#btnAddRegistry").on("click",function(event){
		event.preventDefault();

		obj.setIsTimeLine(false);
		getPropAlumno(0);

	})

	function getPropAlumno(IdAlumno){
        $("#contentProfile").html("");
        $("#contentMain").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
	        $.post(obj.getValue(0) + "cat-alumnos-prop/", {
				user: nc,
				idalumno: IdAlumno
	            },
	            function(html) {	                
	                $("#contentProfile").html(html).show('slow',function(){
	                	//$("#contentProfile");	
		                $('#breadcrumb').html(getBar('Inicio, Propiedades de un nuevo Alumno '));
	                });
	            }, "html");
        });
        return false;
	}

	function getListMedAlu(IdAlumno, Alumno){
        $("#contentProfile").html("");
        $("#contentMain").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
	        $.post(obj.getValue(0) + "cat-alumno-medicos-asign/", {
				user: nc,
				idalumno: IdAlumno,
				alumno: Alumno
	            },
	            function(html) {	                
	                $("#contentProfile").html(html).show('slow',function(){
	                	//$("#contentProfile");	
		                $('#breadcrumb').html(getBar('Inicio, Propiedades de un nuevo Alumno '));
	                });
	            }, "html");
        });
        return false;
	}

	function getListEmerAlu(IdAlumno, Alumno){
        $("#contentProfile").html("");
        $("#contentMain").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
	        $.post(obj.getValue(0) + "cat-alumno-emergencias-asign/", {
				user: nc,
				idalumno: IdAlumno,
				alumno: Alumno
	            },
	            function(html) {	                
	                $("#contentProfile").html(html).show('slow',function(){
		                $('#breadcrumb').html(getBar('Inicio, Telefonos de Emergencia Alumnos '));
	                });
	            }, "html");
        });
        return false;
	}

 	function modGruMatProKRDX02(IdAlumno,IdUserAlu){

		var nc = "u="+localStorage.nc+"&idalumno="+IdAlumno+'&idgrupo=0&iduseralu='+IdUserAlu;        
		
		// alert(nc);
		// return false;

        var PARAMS = {o:1, t:21, c:nc, p:0, from:0, cantidad:0, s:''};  
        var url = obj.getValue(0)+"kardex-alumno-arji/";

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

	function sendMobileAlumno(username){
        $("#contentProfile").empty();
		var nc = localStorage.nc; 
		$.post(obj.getValue(0) + "cat-usuario-send-message/", {
				user: username,
				context: 'send-user-notification/'
			},
			function(html) {
				$("#divUploadImage").html(html);
				$("#divUploadImage").modal('toggle');
		}, "html");
        return false;
	}
	

});



</script>
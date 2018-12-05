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
							<th aria-label="idgponiv: activate to sort column ascending" style="width: 60px;" colspan="1" rowspan="1" aria-controls="sample-table-2" tabindex="0" role="columnheader" class="sorting" >ID</th>
							<th aria-label="idgrupo: activate to sort column ascending" style="width: 80px;" colspan="1" rowspan="1" aria-controls="sample-table-2" tabindex="1" role="columnheader" class="sorting" >ID GPO</th>
							<th aria-label="clave: activate to sort column ascending" style="width: 60px;" colspan="1" rowspan="1" aria-controls="sample-table-2" tabindex="2" role="columnheader" class="sorting">Clave</th>
							<th aria-label="grupo: activate to sort column ascending" style="width: 200px;" colspan="1" rowspan="1" aria-controls="sample-table-2" tabindex="3" role="columnheader" class="sorting">Grupo</th>
							<th aria-label="ciclo: activate to sort column ascending" style="width: 100px;" colspan="1" rowspan="1" aria-controls="sample-table-2" tabindex="4" role="columnheader" class="sorting">Ciclo</th>
							<th aria-label="visible: activate to sort column ascending" style="width: 10px;" colspan="1" rowspan="1" aria-controls="sample-table-2" tabindex="5" role="columnheader" class="sorting">Visible</th>
							<th aria-label="bloqueado: activate to sort column ascending" style="width: 10px;" colspan="1" rowspan="1" aria-controls="sample-table-2" tabindex="6" role="columnheader" class="sorting">Bloqueado</th>
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

		$.post(obj.getValue(0) + "data/", {o:4, t:7, c:nc, p:11, from:0, cantidad:0,s:localStorage.Param1},
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
						tB +='						<a class="green modGrupoPro" href="#" id="idgrupo-'+item.idgrupo+'" >';
						tB +='							<i class="icon-pencil bigger-130"></i>';
						tB +='						</a>';
						tB +='	';
						tB +='						<a class="red delGrupo" href="#"  id="delGrupo-'+item.idgrupo+'" >';
						tB +='							<i class="icon-trash bigger-130"></i>';
						tB +='						</a>';
						tB +='	';
						tB +='						<a class="blue listGruMats" href="#"  id="listGruMats*|*'+item.idgrupo+'*|*'+item.grupo+'*|*'+item.clave_nivel+'*|*'+item.grado+'*|*'+item.idciclo+'" >';
						tB +='							<i class="icon-book bigger-130"></i>';
						tB +='						</a>';
						tB +='	';
						tB +='						<a class="orange listPasesSalidas" href="#"  id="listPasesSalidas*|*'+item.idgrupo+'*|*'+item.grupo+'*|*'+item.clave_nivel+'*|*'+item.grado+'*|*'+item.idciclo+'" title="Pases de Salida" >';
						tB +='							<i class="fa fa-ticket bigger-130"></i>';
						tB +='						</a>';
						tB +='	';
						tB +='						<a class="grey hideGroupNiv" href="#"  id="hideGroupNiv-'+item.idgponiv+'" title="Ocultar Grupo" >';
						tB +='							<i class="fa fa-eye-slash bigger-130"></i>';
						tB +='						</a>';
						tB +='	';
						tB +='						<a class="cafe marginLeft1em tarjetaReinsc" href="#" id="tarjetaReinsc*|*'+item.idgrupo+'*|*'+item.grupo+'*|*'+item.clave_nivel+'*|*'+item.grado+'*|*'+item.idciclo+'" title="Tarjeta de Reinscripcion">';
						tB +='							<i class="fa fa-columns bigger-130"></i>';
						tB +='						</a>';
						tB +='					</div>';
						tB +='';
						tB +='				</td>';
						tB +='			</tr>';
					});
		
					$('#sample-table-2 > tbody').html(tB);

					$("#preloaderPrincipal").hide();

					$(".modGrupoPro").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						getPropGrupo(arr[1]);
					});

					$(".listGruMats").on("click",function(event){
						event.preventDefault();
						// alert( event.currentTarget.id);
						var arr = event.currentTarget.id.split('*|*');
						obj.setIsTimeLine(false);
						//alert(arr[3]);
						getListGruMats(arr[1],arr[2],arr[3],arr[4],arr[5]);
					});

					$(".listPasesSalidas").on("click",function(event){
						event.preventDefault();
						// alert( event.currentTarget.id);
						var arr = event.currentTarget.id.split('*|*');
						obj.setIsTimeLine(false);
						//alert(arr[3]);
						getListPasesSalida(arr[1],arr[2],arr[3],arr[4],arr[5]);
					});


					$(".delGrupo").on("click",function(event){
						event.preventDefault();
						$("#iconSaveCommentResp").show();
						var resp =  confirm("Desea eliminar este registro?");
						//alert(resp);
						//return false;
						if (resp){
							var arr = event.currentTarget.id.split('-');
							//alert(arr[1]);
							obj.setIsTimeLine(false);
				            $.post(obj.getValue(0) + "data/", {o:4, t:2, c:arr[1], p:2, from:0, cantidad:0, s:''},
				            function(json) {
				            		if (json[0].msg=="OK"){
										onClickFillTable();
				        			}else{
				        				alert(json[0].msg);	
				        			}
				        	}, "json");
			        	}

					});



					$(".hideGroupNiv").on("click",function(event){
						event.preventDefault();
						$("#iconSaveCommentResp").show();
						var resp =  confirm("Desea ocultar este Grupo?");
						if (resp){
							var arr = event.currentTarget.id.split('-');
							obj.setIsTimeLine(false);
							alert(arr[1]);
				            $.post(obj.getValue(0) + "data/", {o:4, t:3, c:arr[1], p:2, from:0, cantidad:0, s:''},
				            function(json) {
				            		if (json[0].msg=="OK"){
										onClickFillTable();
				        			}else{
				        				alert(json[0].msg);	
				        			}
				        	}, "json");
			        	}

					});

					$(".tarjetaReinsc").on("click",function(event){
						event.preventDefault();
						// alert( event.currentTarget.id);
						var arr = event.currentTarget.id.split('*|*');
						obj.setIsTimeLine(false);
						//alert(arr[3]);
						printTarjetaReinscripcion(arr[1],arr[2],arr[3],arr[4],arr[5]);

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
		getPropGrupo(0);

	})

	function getPropGrupo(IdGrupo){
		$("#divUploadImage").empty();
		var nc = localStorage.nc; //.split("@");
		$.post(obj.getValue(0) + "cat-grupos-prop/", {
				user: nc,
				idgrupo: IdGrupo
			},
			function(html) {
				$("#divUploadImage").html(html);
				$("#divUploadImage").modal('toggle');
		}, "html");

	}

	function getListGruMats(IdGrupo,Grupo,Clave_Nivel, Grado, IdCiclo){
        $("#contentProfile").empty();
        $("#contentMain").hide(function(){
			var nc = localStorage.nc; //.split("@");
			// alert(IdCiclo);
			$.post(obj.getValue(0) + "gru-mats-list/", {
					user: nc,
					idgrupo: IdGrupo,
					grupo:Grupo,
					clave_nivel:Clave_Nivel,
					grado: Grado,
					idciclo: IdCiclo
				},
				function(html) {
		                $("#contentProfile").html(html).show('slow',function(){
		                $('#breadcrumb').html(getBar('Inicio, Relación Grupo - Materias - Profesores | <span class="intense-red">'+Grupo+'</span>'));
		            });
			}, "html");
		});
	}

	function getListPasesSalida(IdGrupo,Grupo,Clave_Nivel, Grado, IdCiclo){
        $("#contentProfile").empty();
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


	function printTarjetaReinscripcion(IdGrupo,Grupo,Clave_Nivel, Grado, IdCiclo){

		var logoEmp   = obj.getConfig(100,0); 
		var logoIbo   = obj.getConfig(100,1); 
		var logoFR    = obj.getConfig(101,0); 
		var proxCiclo = obj.getConfig(102,0);

		var nc = "u="+localStorage.nc+
				"&idgrupo="+IdGrupo;
		var IdAlumnos = "";		
		$.post(obj.getValue(0) + "data/", {o:0, t:23, c:nc, p:54, from:0, cantidad:0,s:localStorage.Param1},
		function(json){			
			$.each(json, function(i, item) {
				if ( parseInt(item.idgrualu) > 0 ){
					IdAlumnos += IdAlumnos==""?item.idgrualu:"|"+item.idgrualu;
				}
			});

			var nc = "user="+localStorage.nc+
					"&logoEmp="+logoEmp+
					"&logoIbo="+logoIbo+
					"&logoFR="+logoFR+
					"&idemp="+localStorage.IdEmp+
					"&idgrupo="+IdGrupo+
					"&grupo="+Grupo+
					"&clave_nivel="+Clave_Nivel+
					"&grado="+Grado+
					"&idciclo="+IdCiclo+
					"&idalumnos="+IdAlumnos+
					"&proximociclo="+proxCiclo;

	        var PARAMS = {o:0, t:24, c:nc, p:54, from:0, cantidad:0, s:' order by num_lista asc '};

		    var url = obj.getValue(0)+"tarjeta-reinscripcion-arji-0/";
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


			}, 'json'
		);

	}

/*
	var stream = io.connect(obj.getValue(4));
	stream.on("servidor", jsNewGrupo);
	function jsNewGrupo(datosServer) {
		var ms = datosServer.mensaje.split("-");
		//alert(datosServer);
		//obj.setIsTimeLine(true);
		if (ms[1]=='GRUPOS') {
			//onClickFillTable();
		}
	}
*/
	

});



</script>
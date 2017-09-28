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
				<td title="" data-original-title="" class="ui-pg-button ui-state-disabled" style="width:4px;">
					<span class="ui-separator marginLeft1em"></span>
				</td>
				<td data-original-title="Reload Grid" id="report_grid-table" title="" class="ui-pg-button ui-corner-all">
					<div class="widget-toolbar border pull-right">
						<button data-toggle="dropdown" class="btn btn-minier btn-success arrowed-in-right arrowed dropdown-toggle">
							<i class="white icon-print bigger-110"></i>Informes
							<span class="caret"></span>
						</button>

						<ul class="dropdown-menu dropdown-success">
							<li>
								<a href="#" id="repProftoXLSX01">Formato 1 XLSX</a>
							</li>

						</ul>
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
							<th aria-label="idprofesor: activate to sort column ascending" style="width: 80px;" colspan="1" rowspan="1" aria-controls="sample-table-2" tabindex="0" role="columnheader" class="sorting" >ID</th>
							<th aria-label="nombre_profesor: activate to sort column ascending" style="width: 200px;" colspan="1" rowspan="1" aria-controls="sample-table-2" tabindex="1" role="columnheader" class="sorting">profesor</th>
							<th aria-label="username: activate to sort column ascending" style="width: 80px;" colspan="1" rowspan="1" aria-controls="sample-table-2" tabindex="2" role="columnheader" class="sorting">Username</th>
							<th aria-label="is_mobile: activate to sort column ascending" style="width: 80px;" colspan="1" rowspan="1" aria-controls="sample-table-2" tabindex="3" role="columnheader" class="sorting">Is Mobile</th>
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
	        "aaSorting": [[ 0, "desc" ]],			
			"aoColumns": [ null, null, null, null,  { "bSortable": false }],
			"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
			"bRetrieve": true,
			"bDestroy": false
	 	});
	}

	function fillTable(){
						
		var tB = "";

		$("#preloaderPrincipal").show();
		var nc = "u="+localStorage.nc;
		$.post(obj.getValue(0) + "data/", {o:6, t:11, c:nc, p:10, from:0, cantidad:0,s:''},
			function(json){
				
					$.each(json, function(i, item) {
						var is_mobile = item.is_mobile=="1"?"<i class='green glyphicon glyphicon-ok'></i> SI":"";

						tB +=' 			<tr class="odd">';
						tB +='';
						tB +='				<td class=" ">';
						tB +='					<a class="modProfesorPro" href="#" id="idprof-'+item.idprofesor+'" >'+padl(item.idprofesor,4)+'</a>';
						tB +='				</td>';
						tB +='				<td class=" " >'+item.nombre_profesor+'</td>';
						tB +='				<td class="center" >'+item.username+'</td>';
						tB +='				<td class="center" >'+is_mobile+'</td>';
						tB +='				<td class="left">';
						tB +='					<div class="hidden-phone visible-desktop action-buttons">';
						tB +='';
						tB +='						<a class="green modProfesorPro" href="#" id="idprofesor-'+item.idprofesor+'" >';
						tB +='							<i class="icon-pencil bigger-130"></i>';
						tB +='						</a>';
						tB +='	';
						tB +='						<a class="red delProfesor" href="#" id="delProfesor-'+item.idprofesor+'" >';
						tB +='							<i class="icon-trash bigger-130"></i>';
						tB +='						</a>';
						if ( item.is_mobile == "1" ){
							tB +='						<a class="black mobileProfesor" href="#" id="mobileProfesor-'+item.username+'" >';
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

					$(".modProfesorPro").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						getPropprofesor(arr[1]);
					});

					$(".mobileProfesor").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						sendMobileProfesor(arr[1]);
					});


					$(".delProfesor").on("click",function(event){
						event.preventDefault();
						$("#iconSaveCommentResp").show();
						var resp =  confirm("Desea eliminar este registro?");
						//alert(resp);
						//return false;
						if (resp){
							var arr = event.currentTarget.id.split('-');
							//alert(arr[1]);
							obj.setIsTimeLine(false);
				            $.post(obj.getValue(0) + "data/", {o:6, t:2, c:arr[1], p:2, from:0, cantidad:0, s:''},
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
		getPropprofesor(0);

	})

	$("#repProftoXLSX01").on("click",function(event){
		event.preventDefault();

		var logoEmp =obj.getConfig(100,0); 
		var logoIbo =obj.getConfig(100,1); 
        var url = obj.getValue(0)+"profesores_reportes/";

		var nc = "user="+localStorage.nc+
				"&logoEmp="+logoEmp+
				"&logoIbo="+logoIbo+
				"&IdEmp="+localStorage.IdEmp;
		
        var PARAMS = {o:0, t:40, c:nc, p:10, from:0, cantidad:0, s:' order by orden_impresion asc '};

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

	});

	function getPropprofesor(Idprofesor){
        $("#contentProfile").html("");
        $("#contentMain").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
	        $.post(obj.getValue(0) + "cat-profesores-prop/", {
				user: nc,
				idprofesor: Idprofesor
	            },
	            function(html) {	                
	                $("#contentProfile").html(html).show('slow',function(){
	                	//$("#contentProfile");	
		                $('#breadcrumb').html(getBar('Inicio, Propiedades de un nuevo profesor '));
	                });
	            }, "html");
        });
        return false;
	}

	function sendMobileProfesor(username){
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
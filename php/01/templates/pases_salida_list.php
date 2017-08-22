<?php

include("includes/metas.php");

$de       		= $_POST['user'];
$idgrupo        = $_POST['idgrupo'];
$clave_nivel    = $_POST['clave_nivel'];
$idciclo        = $_POST['idciclo'];

?>


<div class="widget-box">
	<div class="widget-header widget-header-blue widget-header-flat">
		<h4 class="lighter">Pases de Salida de Alumnos</h4>

		<div class="widget-toolbar orage">

			<label>
		    	<a class="label label-info closeWinPSA00">Regresar</a>
			</label>

		</div>

		<div class="widget-toolbar orage">

			<a href="#" class="ui-pg-div" id="btnAddRegistryPSA00">
				<i class="ui-icon icon-plus-sign purple"></i>
			</a>

			<a href="#" class="ui-pg-div" data-action="reload" id="btnRefreshPSA00" >
				<i class="ui-icon icon-refresh green"></i>
			</a>

		</div>

	</div>

	<div class="widget-body">
		<div class="widget-main">
			<div class="row-fluid">

				<div id="userPSA00Info" class="user-profile row-fluid">

					<div id="tblPSA00_wrapper" class="dataTables_wrapper" role="grid">

						<table aria-describedby="tblPSA00_info" id="tblPSA00" class="table table-striped table-bordered table-hover dataTable">
											
							<thead>
								<tr role="row">
									<th aria-label="idpsa: to sort column ascending" style="width: 10px;" aria-controls="tblPSA00" tabindex="0" role="columnheader" class="sorting" >ID</th>
									<th aria-label="referencia: to sort column ascending" style="width: 150px;" aria-controls="tblPSA00" tabindex="2" role="columnheader" class="sorting">REFERENCIA</th>
									<th aria-label="fecha: to sort column ascending" style="width: 10px;" aria-controls="tblPSA00" tabindex="3" role="columnheader" class="sorting center">FECHA</th>
									<th aria-label="" style="width: 120px;" role="columnheader" class="sorting_disabled"></th>
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

	var Param = localStorage.Param1;
	var IdGrupo = <?= $idgrupo; ?>;
	var Clave_Nivel = <?= $clave_nivel; ?>;
	var IdCiclo = <?= $idciclo; ?>;

	var oTable;

	function getTable(){

		oTable = $('#tblPSA00').dataTable({
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
			"aoColumns": [ null, null, null, { "bSortable": false }],
			"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
			"bRetrieve": true,
			"bDestroy": false
	 	});
	}


	function fillTable(){
						
		var tB = "";

		$("#preloaderPrincipal").show();
		// var nc = "u="+localStorage.nc+"&sts="+sts;
		var nc = "u="+localStorage.nc+"&clave_nivel="+Clave_Nivel+"&idciclo="+IdCiclo+"&idgrupo="+IdGrupo;
		

		$.post(obj.getValue(0) + "data/", {o:51, t:10, c:nc, p:54, from:0, cantidad:0,s:""},
			function(json){
				if (json.length){
					var lec,arc,res,des;
					$.each(json, function(i, item) {

						tB +=' 			<tr class="odd">';
						tB +=' ';
						tB +='				<td class=" ">';
						tB +='					<a class="modPSA00" href="#" id="idprof0-'+item.idpsa+'"  data-rel="tooltip" data-placement="top" title="Editar">'+padl(item.idpsa,4)+'</a>';
						tB +='				</td>';
						tB +='				<td>'+item.referencia+'</td>';
						tB +='				<td>'+item.fecha+'</td>';
						tB +='				<td>';
						tB +='					<div class="action-buttons">';

						tB +=' ';
						tB +='						<a class="green modPSA00" href="#" id="idpsa-'+item.idpsa+'" data-rel="tooltip" data-placement="top" title="Editar">';
						tB +='							<i class="icon-pencil bigger-130"></i>';
						tB +='						</a>';
						tB +=' ';
						tB +='						<a class="red delPSA00" href="#" id="delPSA00-'+item.idpsa+'"  data-rel="tooltip" data-placement="top" title="Eliminar">';
						tB +='							<i class="icon-trash bigger-130"></i>';
						tB +='						</a>';
						tB +=' ';
						tB +='						<a class="blue marginLeft1em modPSA01" href="#" id="modPSA01-'+item.idpsa+'-'+item.referencia+ '" data-rel="tooltip" data-placement="top" title="Ver Alumnos" >';
						tB +='							<i class="icon-group bigger-130"></i>'
						tB +='						</a>';
						tB +=' ';
						tB +='						<a class="cafe marginLeft1em printPSA01" href="#" id="printPSA01-'+item.idpsa+'-'+item.referencia+ '" data-rel="tooltip" data-placement="top" title="Imprimir Pases de Salida" >';
						tB +='							<i class="icon-print bigger-130"></i>'
						tB +='						</a>';
						tB +='					</div>';
						tB +=' ';
						tB +='				</td>';
						tB +='			</tr>';
					});
				 	
					$('#tblPSA00 > tbody').html(tB);

					$("#preloaderPrincipal").hide();

					$(".modPSA00").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						getPropPSA00(arr[1]);
					});

					$(".modPSA01").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						getAlumnosPSA00(arr[1],arr[2]);
					});

					$(".delPSA00").on("click",function(event){
						event.preventDefault();
						$("#iconSaveCommentResp").show();
						var resp =  confirm("Desea eliminar este registro?");
						//alert(resp);
						//return false;
						if (resp){
							var arr = event.currentTarget.id.split('-');
							//alert(arr[1]);
							obj.setIsTimeLine(false);
				            $.post(obj.getValue(0) + "data/", {o:51, t:2, c:arr[1], p:52, from:0, cantidad:0, s:''},
				            function(json) {
				            		if (json[0].msg=="OK"){
										onClickFillTable();
				        			}else{
				        				alert(json[0].msg);	
				        			}
				        	}, "json");
			        	}
					});

					$(".printPSA01").on("click",function(event){
						event.preventDefault();
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
						printAlumnosPSA00(arr[1],arr[2]);
					});


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


	$("#btnRefreshPSA00").on("click",function(event){
		event.stopPropagation();
		onClickFillTable();
	})

	function onClickFillTable(){
		if(oTable != null){
			oTable.fnDestroy();
			$('#tblPSA00 > tbody').empty();
			init = true;
		}
		fillTable();
	}

	$("#isnuevas").on("change",function(event){
		event.stopPropagation();
		onClickFillTable();
			
	});

	$("#btnAddRegistryPSA00").on("click",function(event){
		event.preventDefault();

		obj.setIsTimeLine(false);
		getPropPSA00(0);

	})

	function getPropPSA00(IdPSA){
        $("#contentLevel3").empty();
        $("#contentProfile").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
	        // alert(Param);
	        $.post(obj.getValue(0) + "psa-prop/", {
				user: nc,
				idpsa: IdPSA,
				param: Param,
				idgrupo: IdGrupo,
				idciclo: IdCiclo,
				clave_nivel: Clave_Nivel
	            },
	            function(html) {	                
	                $("#contentLevel3").html(html).show('slow',function(){
	                	//$("#contentProfile");	
		                $('#breadcrumb').html(getBar('Inicio, Permiso '));
	                });
	            }, "html");
        });
        return false;
	}

	$(".closeWinPSA00").on("click",function(event){
		event.preventDefault();
		$("#preloaderPrincipal").hide();
		$("#contentProfile").hide(function(){
			$("#contentProfile").html("");
			$("#contentMain").show();
		});
		resizeScreen();
		return false;
	});

	function getAlumnosPSA00(IdPSA,Referencia){
        $("#contentLevel3").empty();
        $("#contentProfile").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
	        $.post(obj.getValue(0) + "psa-alumnos/", {
				user: nc,
				idpsa: IdPSA,
				referencia: Referencia,
				param: Param,
				idgrupo: IdGrupo,
				idciclo: IdCiclo,
				clave_nivel: Clave_Nivel
	            },
	            function(html) {	                
	                $("#contentLevel3").html(html).show('slow',function(){
		                $('#breadcrumb').html(getBar('Inicio, Listado de Pases de Salida de Alumnos '));
	                });
	            }, "html");
        });
        return false;
	}





	function printAlumnosPSA00(IdPSA,Referencia){

		var logoEmp =obj.getConfig(100,0); 
		var logoIbo =obj.getConfig(100,1); 
        var a0;
        var idalumnos = "";
        var nc = "u="+localStorage.nc+"&idpsa="+IdPSA;
        $.post(obj.getValue(0) + "data/", {o:51, t:12, c:nc, p:54, from:0, cantidad:0,s:''},
            function(json){
            		var a0;
                    $.each(json, function(i, item) {
		                a0 = item.idalumno;
		                idalumnos += idalumnos == '' ?  a0  : "," + a0;
                    });

					var nc = "u="+localStorage.nc+"&idalumnos="+idalumnos+
							"&logoEmp="+logoEmp+
							"&logoIbo="+logoIbo+
							"&idciclo="+IdCiclo+
							"&idpsas="+IdPSA;
					

			        var PARAMS = {o:51, t:12, c:nc, p:54, from:0, cantidad:0,s:''};

			    	url = obj.getValue(0)+"psa-alumnos-print/";

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

            },
        'json'
        );


	}

/*
	var stream = io.connect(obj.getValue(4));
	stream.on("servidor", jsNewSolMatEnc0);
	function jsNewSolMatEnc0(datosServer) {
		var ms = datosServer.mensaje.split("-");		
		if (ms[1]=='ADD_ALUMNOS_PSA') {
			onClickFillTable();
		}
	}

*/

    $("#preloaderPrincipal").hide();
	

});

</script>
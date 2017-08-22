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
				<td data-original-title="Add new row" id="add_grid-table" class="ui-pg-button ui-corner-all">
					<div class="ui-pg-div" id="btnAddRegExa" >
						<span class="ui-icon icon-plus-sign purple"></span>
					</div>
				</td>
				<td title="" data-original-title="" class="ui-pg-button ui-state-disabled" style="width:4px;">
					<span class="ui-separator marginLeft1em"></span>
				</td>
				<td data-original-title="Reload Grid" id="refresh_grid-table" class="ui-pg-button ui-corner-all">
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
							<th aria-label="idexaimage: activate to sort column ascending" style="width: 50px;" aria-controls="tblExal" tabindex="0" role="columnheader" class="sorting" >ID</th>
							<th aria-label="descripcion_archivo: activate to sort column ascending" style="width: 200px;" aria-controls="tblExal" tabindex="1" role="columnheader" class="sorting">DESCRIPCION</th>
							<th aria-label="archivo: activate to sort column ascending" style="width: 50px;" aria-controls="tblExal" tabindex="2" role="columnheader" class="sorting">ARCHIVO</th>
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
			"aoColumns": [ null, null, null, { "bSortable": false }],
			"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
			"bRetrieve": true,
			"bDestroy": false
	 	});
	}

	function fillTable(){
						
		var tB = "";

		$("#preloaderPrincipal").show();
		var nc = "u="+localStorage.nc;
		$.post(obj.getValue(0) + "data/", {o:67, t:67, c:nc, p:54, from:0, cantidad:0,s:''},
			function(json){
					$.each(json, function(i, item) {

						var urlImg = "http://platsource.mx/"+item.directorio+item.archivo;
						var imgUrl =  '<span class="profile-picture">';
							imgUrl += '<img id="avatar" class="editable editable-click editable-empty" src="'+urlImg+'">';
							imgUrl += '</span>';

						tB +=' 			<tr class=" odd ">';
						tB +='				<td>'+padl(item.idexaimage,4)+'</td>';
						tB +='				<td>'+item.descripcion_archivo+'</td>';
						tB +='				<td><a href="'+urlImg+'" target="_blank" >'+imgUrl+'</td>';
						tB +='				<td class="center">';
						tB +='					<div class="hidden-phone visible-desktop action-buttons">';
						tB +='						<a class="red delExaImg" href="#"  id="delExaImg-'+item.idexaimage+'-'+item.archivo+'" title="Quitar imagen">';
						tB +='							<i class="icon-trash bigger-130"></i>';
						tB +='						</a>';
						tB +='					</div>';
						tB +='				</td>';
						tB +='			</tr>';
					});

					$('#tblExal > tbody').html(tB);

					$("#preloaderPrincipal").hide();

					$(".delExaImg").on("click",function(event){
						event.preventDefault();
						$("#iconSaveCommentResp").show();
						var resp =  confirm("Desea eliminar este registro?");
						//alert(resp);
						//return false;
						if (resp){
							var arr = event.currentTarget.id.split('-');
							//alert(arr[1]);
							DelteFileExist(arr[1],arr[2]);
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
		getProExaImg(0);

	})

	function getProExaImg(IdExa){
        $("#contentProfile").empty();
        $("#contentMain").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
	        $.post(obj.getValue(0) + "exa-images-prop/", {
				user: nc,
				idexaimage: IdExa,
				objOrigen: 'contentProfile',
				objDestino: 'contentMain'
	            },
	            function(html) {	                
	                $("#contentProfile").html(html).show('slow',function(){
	                	//$("#contentProfile");	
		                $('#breadcrumb').html(getBar('Inicio, Nueva Imagen '));
	                });
	            }, "html");
        });
        return false;
	}

    function DelteFileExist(IdExaImage,Archivo){

                $("#preloaderPrincipal").show();

                var queryString = "idexaimage="+IdExaImage+"&archivo="+Archivo;

                var data = new FormData();

                data.append('data', queryString);


                $.ajax({
                    url:obj.getValue(0)+"fu-exaimg-del/",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    type: 'POST',
                    success: function(json){
                        if (json.status=="OK"){
                            alert( json.message );
                            // stream.emit("cliente", {mensaje: "PLATSOURCE-DELETE_IMAGES_EXA-PROP-"+IdExaImage});
                            onClickFillTable();
                            
                        }else{
                            $("#preloaderPrincipal").hide();
                            alert("Error: "+json.message);    
                        }
                    }
                });


    }

/*
	var stream = io.connect(obj.getValue(4));
	stream.on("servidor", jsNewExa);
	function jsNewExa(datosServer) {
		var ms = datosServer.mensaje.split("-");
		//alert(datosServer);
		//obj.setIsTimeLine(true);
		if (ms[1]=='DELETE_IMAGES_EXA') {
			//onClickFillTable();
		}

		if (ms[1]=='UPLOAD_EXA_IMAGES-PROP') {
			//onClickFillTable();
		}
	}
*/

	

});



</script>
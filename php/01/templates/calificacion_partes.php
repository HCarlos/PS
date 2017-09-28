<?php

include("includes/metas.php");

$idgrumat  = $_POST['idgrumat'];
$materia  = $_POST['materia'];
$num_eval = $_POST["num_eval"];
$grupo  = $_POST['grupo'];

?>



<div class="widget-box transparent">
	<div class="widget-header widget-header-blue widget-header-flat">

		<div class="widget-toolbar border pull-right">
		    <button  type="button" class="btn btn-minier btn-primary arrowed-in-right arrowed btnCloseFormUploadPartesConfig001 " id="btnCloseFormUploadPartesConfig001" style="margin: 0 1em !important;" >
		        <i class="icon-angle-left icon-on-right"></i>
		        Regresar
		    </button>
		</div>

		<div class="widget-toolbar border pull-right">
			<div class="ui-pg-div" id="viewListMatConSave">
				<span class="ui-icon icon-briefcase orange"></span>
				
			</div>
		</div>


		<div class="widget-toolbar orange pull-left no-border ">

		    <h3 id="title"><i class="icon-edit"></i><?php echo $grupo.' | '.$materia; ?></h3>

		</div>

 		<div class="widget-toolbar pull-left border-left">
			<div class="ui-pg-div" id="btnAddGruMatConfig05">
				<span class="ui-icon icon-plus-sign purple"></span>
			</div>
		</div>

		<div class="widget-toolbar pull-left no-border">
				<div class="ui-pg-div" id="btnRefreshGruMatConfig05">
					<span class="ui-icon icon-refresh green"></span>
				</div>

		</div>

		<div class="widget-toolbar pull-left no-border">
				<div class="ui-pg-div" id="btnCopyGruMatConfig05">
					<i class="ui-icon icon-save blue"></i>
				</div>

		</div>

		<div class="widget-toolbar pull-left no-border">

				<div class="ui-pg-div" id="btnCloneGruMatConfig05" >
					<span class="ui-icon icon-share-alt grey"></span>
				</div>

		</div>

	</div>

	<div class="widget-body">
		<div class="widget-main">
			<div class="row-fluid">

			<div style="display: block; margin-top: 1em;">
				<div id="user-profile-1" class="user-profile row-fluid">
					<div id="tblGruMatList001_wrapper" class="dataTables_wrapper" role="grid">

						<table id="tblPartesConfig001" class="bordered">
							<thead>
								<tr>
									<th>ID</th>
									<th>Descripción</th>
									<th>Porcentaje</th>
									<th>No Eval</th>
									<th>Categoría</th>
									<th>Items MKB</th>
									<th></th>
								</tr>	
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>

		</div><!--/widget-main-->
	</div><!--/widget-body-->
</div>


<script type="text/javascript">        

jQuery(function($) {

	var IdGruMat = <?php echo $idgrumat; ?>;
	var Materia = '<?php echo $materia; ?>';
	var Grupo = '<?php echo $grupo; ?>';
	var Num_Eval = <?php echo $num_eval; ?>;

	function getGruMatConPartesList0(){
	   $("#preloaderPrincipal").show();
	   $("#tblPartesConfig001 > tbody").empty();
	    var nc = "u="+localStorage.nc+"&idgrumat="+IdGruMat+"&numval="+Num_Eval;
	    // alert(nc);
	    $.post(obj.getValue(0)+"data/", { o:1, t:38, p:11, c:nc, from:0, cantidad:0, s:" order by idgrumatcon desc " },
	        function(json){
	            if (json.length>0){
	            	var xHT = "";
	               $.each(json, function(i, item) {
	               		xHT += '<tr>';
							xHT += '<td><a class="green modGruMatCon" href="#" id="modGruMatCon1-'+item.idgrumatcon+'-'+item.idgrumat+'" >'+item.idgrumatcon+'</a></td>';
							xHT += '<td>'+item.descripcion+'</td>';
							xHT += '<td>'+item.porcentaje+'</td>';
							xHT += '<td class="center">'+item.num_eval+'</td>';
							xHT += '<td>'+item.tipo_actividad+'</td>';
							xHT += '<td class="center">'+item.elementos+'</td>';
							xHT += '<td>';
							xHT +='		<div class="hidden-phone visible-desktop action-buttons tbl120W">';
							xHT +='';
							xHT +='						<a class="green modGruMatCon" href="#" id="modGruMatCon-'+item.idgrumatcon+'-'+item.idgrumat+'" >';
							xHT +='							<i class="icon icon-pencil bigger-150"></i>';
							xHT +='						</a>';
							xHT +='	';
							xHT +='						<a class="red delGruMatCon border" href="#"  id="delGruMatCon-'+item.idgrumatcon+'" >';
							xHT +='							<i class="icon icon-trash bigger-150"></i>';
							xHT +='						</a>';
							xHT +='	';
							xHT +='						<a class="blue cnfGruMatConMkb" href="#"  id="cnfGruMatConMkb-'+item.idgrumatcon+'-'+item.idgrumat+ '-'+ item.descripcion + '" >';
							xHT +='							<i class="icon icon-cog bigger-150"></i>';
							xHT +='						</a>';
							xHT +='		</div>';			
							xHT +='	</td>';
						xHT += '</tr>';

	                });
	               
					$("#tblPartesConfig001 > tbody").html(xHT);
	           	}else{
					$("#preloaderPrincipal").hide();	
					$("#tblPartesConfig001 > tbody").empty();           		
	           	}

			    $("#preloaderPrincipal").hide();


				$(".modGruMatCon").on("click",function(event){
					event.preventDefault();
					var arr = event.currentTarget.id.split('-');
					obj.setIsTimeLine(false);
					getPropGruMatCon(arr[1],arr[2],Materia);
				});

				$(".delGruMatCon").on("click",function(event){
					event.preventDefault();
					$("#iconSaveCommentResp").show();
					var arr = event.currentTarget.id.split('-');
					var resp =  confirm("Desea eliminar este registro: "+arr[1]+"?");
					if (resp){
						obj.setIsTimeLine(false);
			            $.post(obj.getValue(0) + "data/", {o:18, t:2, c:arr[1], p:2, from:0, cantidad:0, s:''},
			            function(json) {
			            		if (json[0].msg=="OK"){
									getGruMatConPartesList0();
			        			}else{
			        				alert(json[0].msg);	
			        			}
			        	}, "json");
		        	}

				});


				$(".cnfGruMatConMkb").on("click",function(event){
					event.preventDefault();
					var arr = event.currentTarget.id.split('-');
					obj.setIsTimeLine(false);
					getListGruMatConMkb(arr[1],arr[2],arr[3]);
				});



	        }, "json"
	    );
	};

	$("#btnCloseFormUploadPartesConfig001").on("click",function(event){
		event.preventDefault();
		$("#preloaderPrincipal").hide();
		$("#contentProfile").hide(function(){
			$("#contentProfile").empty();
			$("#contentMain").show();
		});
		resizeScreen();
		return false;
	});


	function getPropGruMatCon(IdGruMatCon,IdGruMat,Materia){
		$("#divUploadImage").empty();
		var nc = localStorage.nc; //.split("@");
		$.post(obj.getValue(0) + "gru-mats-con-prop/", {
				user: nc,
				idgrumatcon: IdGruMatCon,
				idgrumat: IdGruMat,
				materia: Materia,
				num_eval: Num_Eval,
				grupo: Grupo
			},
			function(html) {
				$("#divUploadImage").html(html);
				$("#divUploadImage").modal('toggle');
		}, "html");

	}




	function getListGruMatConMkb(IdGruMatCon,IdGruMat,Parte){
		var nc = localStorage.nc; //.split("@");
        $("#contentLevel3").empty();
        $("#contentProfile").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
	        $.post(obj.getValue(0) + "gru-mats-con-mkb-list/", {
				user: nc,
				idgrumatcon: IdGruMatCon,
				idgrumat: IdGruMat,
				parte: Parte,
				num_eval: Num_Eval,
				grupo: Grupo,
				materia: Materia
	            },
	            function(html) {	                
	                $("#contentLevel3").html(html).show('slow',function(){
		                $('#breadcrumb').html(getBar('Inicio, Configuración de Partes del Markbook' ));
	                });
	            }, "html");
        });
	}


	function btnCloneGruMatConfig05(IdGruMatCon,IdGruMat,Materia){
		$("#preloaderPrincipal").show();
		var nc = "user="+localStorage.nc+"&idgrumat="+IdGruMat+"&numval="+Num_Eval; //.split("@");
        $.post(obj.getValue(0) + "data/", {o:0, t:0, c:nc, p:14, from:0, cantidad:0, s:''},
        function(json) {
        		if (json[0].msg=="OK"){
					getGruMatConPartesList0();
					alert("Proceso ejecutado con éxito");
				    $("#preloaderPrincipal").hide();
    			}else{
    				alert(json[0].msg);	
				    $("#preloaderPrincipal").hide();
    			}
    	}, "json");

	}

	$("#btnRefreshGruMatConfig05").on("click",function(event){
		event.preventDefault();
		getGruMatConPartesList0();
	})

	$("#btnAddGruMatConfig05").on("click",function(event){
		event.preventDefault();

		getPropGruMatCon(0,IdGruMat,Materia);

	})


	$("#btnCloneGruMatConfig05").on("click",function(event){
		event.preventDefault();
		var x = confirm("Este proceso copiará la configuración inmediatamente anterior.\n\nDesea continuar?");
		if (x){
			btnCloneGruMatConfig05(0,IdGruMat,Materia);
		}

	})


	$("#btnCopyGruMatConfig05").on("click",function(event){
		event.preventDefault();
		var nc = localStorage.nc; 
		$.post(obj.getValue(0) + "cal-grumatcon-save-prop/", {
				user: nc,
				idgrumat: IdGruMat,
				num_eval: Num_Eval
			},
			function(html) {
				$("#divUploadImage").html(html);
				$("#divUploadImage").modal('toggle');
		}, "html");

	});



	$("#viewListMatConSave").on("click",function(event){
		event.preventDefault();
		var nc = localStorage.nc; 
		$.post(obj.getValue(0) + "cal-grumatcon-save-list/", {
				user: nc,
				idgrumat: IdGruMat,
				num_eval: Num_Eval
			},
			function(html) {
				$("#divUploadImage").html(html);
				$("#divUploadImage").modal('toggle');
		}, "html");
	});

	getGruMatConPartesList0();

/*
	var stream = io.connect(obj.getValue(4));
	stream.on("servidor", jsNewEstado);
	function jsNewEstado(datosServer) {
		var ms = datosServer.mensaje.split("-");
		if (ms[1]=='GRUMATCON') {
			// getGruMatConPartesList0();
		}
	}
*/


});

</script>
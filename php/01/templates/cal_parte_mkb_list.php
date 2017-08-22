<?php

include("includes/metas.php");

$idgrumatcon  = $_POST['idgrumatcon'];
$idgrumat  = $_POST['idgrumat'];
$parte  = $_POST['parte'];
$num_eval = $_POST['num_eval'];
?>



<div class="widget-box transparent">
	<div class="widget-header widget-header-blue widget-header-flat">

		<div class="widget-toolbar border pull-right">
		    <button  type="button" class="btn btn-minier btn-primary arrowed-in-right arrowed closeFormUploadMKB003A " style="margin: 0 1em !important;" >
		        <i class="icon-angle-left icon-on-right"></i>
		        Regresar
		    </button>
		</div>

		<div class="widget-toolbar orange pull-left no-border ">

		    <h3 id="title"><i class="icon-edit"></i><?php echo $parte; ?></h3>

		</div>

 		<div class="widget-toolbar pull-left border-left">
				<div class="ui-pg-div" id="btnAddGruMatConMKB0001">
					<span class="ui-icon icon-plus-sign purple"></span>
				</div>
		</div>

		<div class="widget-toolbar pull-left no-border">
				<div class="ui-pg-div" id="btnRefreshGruMatConMKB0001">
					<span class="ui-icon icon-refresh green"></span>
				</div>

		</div>

		<div class="widget-toolbar pull-left no-border">

				<div class="ui-pg-div" id="btnCloneGruMatConMKB001" >
					<span class="ui-icon icon-share-alt grey"></span>
				</div>

		</div>





	</div>

	<div class="widget-body">
		<div class="widget-main">
			<div class="row-fluid">

			<div style="display: block; margin-top: 1em;">
				<div id="user-profile-1" class="user-profile row-fluid">
					<div id="tblGruMatMKB0List001_wrapper" class="dataTables_wrapper" role="grid">

						<table id="tblPartesMKB001AAA" class="bordered">
							<thead>
								<tr>
									<th>ID</th>
									<th>Descripción Breve</th>
									<th>Descripcón Avazada</th>
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

	var IdGruMatMKB0 = <?php echo $idgrumatcon; ?>;
	var Materia = '<?php echo $parte; ?>';
	var Num_Eval = <?php echo $num_eval; ?>;


	function getGruMatConMKB0PartesList0(){
	   $("#preloaderPrincipal").show();
	   $("#tblPartesMKB001AAA > tbody").empty();
	    var nc = "u="+localStorage.nc+"&idgrumatcon="+IdGruMatMKB0;
	    // alert(nc);
	    $.post(obj.getValue(0)+"data/", { o:45, t:104, p:11, c:nc, from:0, cantidad:0, s:" order by idgrumatconmkb asc " },
	        function(json){
	            if (json.length>0){
	            	var xHT = "";
	               $.each(json, function(i, item) {
					    
					    var html = item.descripcion_avanzada;
					    html = html.replace(/\r?\n/g, '<br />');
	               		xHT += '<tr>';
							xHT += '<td><a class="green modGruMatConMKB0" href="#" id="modGruMatConMKB01-'+item.idgrumatconmkb+'-'+item.idgrumatcon+'" >'+item.idgrumatconmkb+'</a></td>';
							xHT += '<td>'+item.descripcion_breve+'</td>';
							xHT += '<td>'+html+'</td>';
							xHT += '<td>';
							xHT +='		<div class="hidden-phone visible-desktop action-buttons tbl120W">';
							xHT +='';
							xHT +='						<a class="green modGruMatConMKB0" href="#" id="modGruMatConMKB0-'+item.idgrumatconmkb+'-'+item.idgrumatcon+'" >';
							xHT +='							<i class="icon icon-pencil bigger-150"></i>';
							xHT +='						</a>';
							xHT +='	';
							xHT +='						<a class="red delGruMatConMKB0 border" href="#"  id="delGruMatConMKB0-'+item.idgrumatconmkb+'" >';
							xHT +='							<i class="icon icon-trash bigger-150"></i>';
							xHT +='						</a>';
							xHT +='		</div>';			
							xHT +='	</td>';
						xHT += '</tr>';

	                });
	               
					$("#tblPartesMKB001AAA > tbody").html(xHT);
	           	}else{
					$("#tblPartesMKB001AAA > tbody").html('<tr><td colspan="4" class="center alert">No hay elementos</td></tr>');	           		
	           	}

			    $("#preloaderPrincipal").hide();


				$(".modGruMatConMKB0").on("click",function(event){
					event.preventDefault();
					var arr = event.currentTarget.id.split('-');
					obj.setIsTimeLine(false);
					getPropGruMatConMKB0(arr[1],arr[2],Materia);
				});

				$(".delGruMatConMKB0").on("click",function(event){
					event.preventDefault();
					$("#iconSaveCommentResp").show();
					var resp =  confirm("Desea eliminar este registro?");
					if (resp){
						var arr = event.currentTarget.id.split('-');
						obj.setIsTimeLine(false);
			            $.post(obj.getValue(0) + "data/", {o:45, t:2, c:arr[1], p:2, from:0, cantidad:0, s:''},
			            function(json) {
			            		if (json[0].msg=="OK"){
									getGruMatConMKB0PartesList0();
			        			}else{
			        				alert(json[0].msg);	
			        			}
			        	}, "json");
		        	}

				});


				$(".cnfGruMatConMKB0Mkb").on("click",function(event){
					event.preventDefault();
					var arr = event.currentTarget.id.split('-');
					obj.setIsTimeLine(false);
					getListGruMatConMKB0Mkb(arr[1],arr[2],Materia);
				});



	        }, "json"
	    );
	};

	$(".closeFormUploadMKB003A").on("click",function(event){
		event.preventDefault();
		$("#preloaderPrincipal").hide();
		$("#contentLevel3").hide(function(){
			$("#contentLevel3").empty();
			$('#breadcrumb').html(getBar('Inicio, Configuración de Partes' ));
			$("#contentProfile").show();
		});
		resizeScreen();
		return false;
	});


	function getPropGruMatConMKB0(IdGruMatConMKB0,IdGruMatMKB0,Materia){
		$("#divUploadImage").empty();
		var nc = localStorage.nc; //.split("@");
		$.post(obj.getValue(0) + "gru-mats-con-mkb-prop/", {
				user: nc,
				idgrumatconmkb: IdGruMatConMKB0,
				idgrumatcon: IdGruMatMKB0,
				descripcion_mkb: Materia,
				num_eval: Num_Eval
			},
			function(html) {
				$("#divUploadImage").html(html);
				$("#divUploadImage").modal('toggle');
		}, "html");

	}




	function getListGruMatConMKB0Mkb(IdGruMatConMKB0,IdGruMatMKB0,Materia){
		$("#divUploadImage").empty();
		var nc = localStorage.nc; //.split("@");
		$.post(obj.getValue(0) + "gru-mats-con-prop/", {
				user: nc,
				idgrumatcon: IdGruMatConMKB0,
				idgrumat: IdGruMatMKB0,
				parte: Materia,
				num_eval: Num_Eval
			},
			function(html) {
				$("#divUploadImage").html(html);
				$("#divUploadImage").modal('toggle');
		}, "html");

	}

	function btnCloneGruMatConMKB001(IdGruMatConMKB0,IdGruMatMKB0,Materia){
		$("#preloaderPrincipal").show();
		var nc = "user="+localStorage.nc+"&idgrumat="+IdGruMatMKB0+"&numval="+Num_Eval; //.split("@");
        $.post(obj.getValue(0) + "data/", {o:0, t:0, c:nc, p:14, from:0, cantidad:0, s:''},
        function(json) {
        		if (json[0].msg=="OK"){
					getGruMatConMKB0PartesList0();
					alert("Proceso ejecutado con éxito");
				    $("#preloaderPrincipal").hide();
    			}else{
    				alert(json[0].msg);	
				    $("#preloaderPrincipal").hide();
    			}
    	}, "json");

	}

	$("#btnRefreshGruMatConMKB0001").on("click",function(event){
		event.preventDefault();
		getGruMatConMKB0PartesList0();
	})

	$("#btnAddGruMatConMKB0001").on("click",function(event){
		event.preventDefault();

		getPropGruMatConMKB0(0,IdGruMatMKB0,Materia);

	})


	$("#btnCloneGruMatConMKB001").on("click",function(event){
		event.preventDefault();
		var x = confirm("Este proceso copiará la configuración inmediatamente anterior.\n\nDesea continuar?");
		if (x){
			btnCloneGruMatConMKB001(0,IdGruMatMKB0,Materia);
		}

	})

	getGruMatConMKB0PartesList0();

	/*
	var stream = io.connect(obj.getValue(4));
	stream.on("servidor", jsNewEstado);
	function jsNewEstado(datosServer) {
		var ms = datosServer.mensaje.split("-");
		if (ms[1]=='GRUMATCONMKB') {
			//getGruMatConMKB0PartesList0();
		}
	}
	*/


});

</script>
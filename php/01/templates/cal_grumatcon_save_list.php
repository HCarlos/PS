<?php

include("includes/metas.php");


$user = $_POST['user'];
$idgrumat  = $_POST['idgrumat'];
$num_eval  = $_POST['num_eval'];

if ( isset($_POST['idmatconsave']) ){
	$idmatconsave  = $_POST['idmatconsave'];
}else{
	$idmatconsave  = 0;
}

?>
<div class="row-fluid">
<div class="span12" style="padding-left: 1em; padding-right: 1em;">
<div class="tabbable">

	<h3 class="header smaller lighter blue" id="title"></h3>
	<form id="frmData" role="form">

		<ul class="nav nav-tabs" id="myTab">

			<li class="active">
				<a data-toggle="tab" href="#general">
					<i class="red icon-home bigger-110"></i>
					Lista de Configuraciones Guardadas
				</a>
			</li>

		</ul>

		<div class="tab-content">

			<div id="general" class="tab-pane active">
			

				<div class="form-group ">
			    	<label for="titulo" class="col-lg-2 control-label">Replicar</label>
			    	<div class="col-lg-10">
			            <select class=" altoMoz" name="selMatConSave" id="selMatConSave" size="1">
			            </select>
			            <button class="btn btn-minier btn-danger pull-right" id="delMatConSave01" type="button"><i class="fa fa-trash-o"></i>  Quitar</button>
		      		</div>
			    </div>

				<div class="form-group ">
					<table id="tblMatConSave01" class="table">
						<thead>
							<th>ID</th>
							<th>DESCRIPCIÓN</th>
							<th>PORCENTAJE</th>
							<th>EVAL.</th>
							<th>CATEGORIA</th>
							<th>ITEMS</th>
						</thead>
						<tbody>
						</tbody>
					</table>
			    </div>

			</div>

		</div>

	    <input type="hidden" name="idmatconsave" id="idmatconsave" value="<?= $idmatconsave; ?>">
	    <input type="hidden" name="idgrumat" id="idgrumat" value="<?php echo $idgrumat; ?>">
	    <input type="hidden" name="num_eval" id="num_eval" value="<?php echo $num_eval; ?>">
	    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
	    <div class="form-group w96" style='margin-right: 3em; margin-top: 1em;'>
	    	<button type="button" class="btn btn-inverse pull-right" data-dismiss="modal" id="closeFormUpload"><i class="icon-signout"></i>Cerrar</button>
	    	<span class="muted"></span>
	    	<button type="submit" class="btn btn-success pull-right" style='margin-right: 4em;' id="cmdMatConSave01"><i class="icon icon-ok"></i>Aplicar</button>
			<span class="pull-left" id="preloaderLocal"><i class="fa fa-cog fa-spin bigger-150"></i>  Cargando...</span>
		</div>

	</form>

</div>




</div>
</div>
<!--PAGE CONTENT ENDS-->

<script typy="text/javascript">        

jQuery(function($) {

	$("#preloaderPrincipal").hide();

	var stream = io.connect(obj.getValue(4));

	var idmatconsave = <?php echo $idmatconsave ?>;
	var IdGruMat = <?php echo $idgrumat; ?>;
	var Num_Eval = <?php echo $num_eval; ?>;

	$("#preloaderLocal").hide();

	$("#delMatConSave01").prop('disabled',true);
	$("#cmdMatConSave01").prop('disabled',true);

	function getMatConSaveList(IdGruMat,Num_Eval){
	   $("#preloaderPrincipal").show();
	   $("#preloaderLocal").show();
	   $("#tblMatConSave01 > tbody").empty();
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
						xHT += '</tr>';

	                });
	               
					$("#tblMatConSave01 > tbody").html(xHT);

					$("#delMatConSave01").prop('disabled',false);
					$("#cmdMatConSave01").prop('disabled',false);

	           	}else{

					buttonDisabled();
	           	
	           	}

			    $("#preloaderPrincipal").hide();
			    $("#preloaderLocal").hide();

	        }, "json"
	    );
	}

    $("#frmData").unbind("submit");
	$("#frmData").on("submit",function(event){
		event.preventDefault();
		$("#preloaderPrincipal").show();

		var ids = $("#selMatConSave").val().split('-');

		if ( parseInt(ids[0],0) <= 0 ){
			buttonDisabled();
			return false;
		}

		var x = confirm("Este proceso REPLICARÁ la configuración actual seleccionada.\n\nDesea continuar?");
		if (!x){
			return false;
		}

		$("#preloaderPrincipal").show();

        var nc = "u="+localStorage.nc+"&idgrumatold="+ids[0]+"&num_eval_old="+ids[1]+"&isitem="+ids[3]+"&idgrumat="+IdGruMat+"&num_eval="+Num_Eval;

        // alert(nc);
        // return false;

        $.post(obj.getValue(0)+"data/", { o:55, t:55, p:58, c:nc, from:0, cantidad:0, s:"" },
            function(json){
        		if (json[0].msg=="OK"){
        			alert("Datos guardados con éxito.");
					stream.emit("cliente", {mensaje: "PLATSOURCE-MATCONSAVEMOVE-PROP-"+idmatconsave});
					$("#preloaderPrincipal").hide();
					$("#divUploadImage").modal('hide');
    			}else{
					$("#preloaderPrincipal").hide();
    				alert(json[0].msg);	
    			}
            }, "json"
        );  


	});

	$("#closeProp").on("click",function(event){
		$("#preloaderPrincipal").hide();
		$("#divUploadImage").modal('hide');
	});

	function validForm(){

		if($("#titulo").val().length <= 0){
			alert("Faltan el Estado");
			$("#titulo").focus();
			return false;
		}

		return true;

	}


	$("#selMatConSave").on("change",function(event){
		event.preventDefault();

		var ids = $(this).val().split('-');

		if ( parseInt(ids[0],0) <= 0 ){

			buttonDisabled();
			return false;
		}

		getMatConSaveList(ids[0],ids[1]);

	});	

	function buttonDisabled(){
		$("#preloaderPrincipal").hide();	
		$("#preloaderLocal").hide();
		$("#tblMatConSave01 > tbody").empty();           		
		$("#delMatConSave01").prop('disabled',true);
		$("#cmdMatConSave01").prop('disabled',true);
	}

    function getMatConSave(){
        var nc = "u="+localStorage.nc+"&idgrumat="+IdGruMat+"&num_eval="+Num_Eval;
        $("#selMatConSave").append("<option value='0-0'>Seleccione un Elemento</option>");
        $.post(obj.getValue(0)+"data/", { o:55, t:55, p:51, c:nc, from:0, cantidad:0, s:"" },
            function(json){
                var nc;
               $.each(json, function(i, item) {
	               	// if ( parseInt(item.idgrumat,0) != IdGruMat || parseInt(item.num_eval,0) != Num_Eval ){
	                    $("#selMatConSave").append('<option value="'+item.idgrumat+'-'+item.num_eval+'-'+item.idmatconsave+'-'+item.isitem+'"> '+item.titulo+'</option>');
	               	// }
                });
            }, "json"
        );  
    }

	$("#delMatConSave01").on("click",function(event){
		event.preventDefault();
		var ids = $("#selMatConSave").val().split('-');
        $.post(obj.getValue(0) + "data/", {o:55, t:2, c:ids[2], p:52, from:0, cantidad:0, s:''},
        function(json) {
        		if (json[0].msg=="OK"){
        			alert("Configuración Eliminada con éxito.");
					stream.emit("cliente", {mensaje: "PLATSOURCE-MATCONSAVE-PROP-"+ids[2]});
					$("#preloaderPrincipal").hide();
					$("#divUploadImage").modal('hide');
    			}else{
					$("#preloaderPrincipal").hide();
    				alert(json[0].msg);	
    			}
    	}, "json");


	});

	getMatConSave();


	$("#titulo").focus();




});

</script>
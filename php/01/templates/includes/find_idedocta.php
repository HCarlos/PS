<?php

$user = $_POST["user"];

?>
<div class="widget-box">
	<div class="widget-header">
		<h4>Buscar ID de Pago </h4>
	</div>

	<div class="alert alert-danger" role="alert" id="msgEsp"></div>

	<div class="widget-body">
		<div class="widget-main">
			<form class="form-inline padBot2em" id="frmFindIdEdoCta0">
				<div class="form-group">
					<label for="idedocta">ID Pago </label>
					<input type="text" class="form-control altoMoz marginLeft1em" id="idedocta" name="idedocta" >
				</div>
				<button id="findIdEdoCta" class="btn btn-small btn-primary marginLeft1em" type="button">
					<i class="icon-filter bigger-110"></i>
					Buscar
				</button>
				<button id="reviveIdEdoCta" class="btn btn-small btn-success marginLeft1em" type="button">
					<i class="icon-refresh bigger-110"></i>
					Revertir Pago
				</button>
                <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
			</form>
 
 			<table class="table">
 				<tbody>
	 				<tr>
	 					<th width="120">FAMILIA:</th>
	 					<td id="fndfamilia0"></td>
	 				</tr>
	 				<tr>
	 					<th>ALUMNO:</th>
	 					<td id="fndalumno0" class="text-left"></td>
	 				</tr>
	 				<tr>
	 					<th>CONCEPTO:</th>
	 					<td id="fndconcepto0" class="text-left"></td>
	 				</tr>

	 				<tr>
	 					<th>SUBTOTAL:</th>
	 					<td id="fndsubtotal0" class="text-left"></td>
	 				</tr>

	 				<tr>
	 					<th>DESCTO BECA:</th>
	 					<td id="fnddesctobeca0" class="text-left"></td>
	 				</tr>

	 				<tr>
	 					<th>IMPORTE:</th>
	 					<td id="fndimporte00" class="text-left"></td>
	 				</tr>

	 				<tr>
	 					<th>DESCTO:</th>
	 					<td id="fnddescto0" class="text-left"></td>
	 				</tr>

	 				<tr>
	 					<th>RECARGO:</th>
	 					<td id="fndrecargo0" class="text-left"></td>
	 				</tr>

	 				<tr>
	 					<th>TOTAL:</th>
	 					<td id="fndtotal0" class="text-left"></td>
	 				</tr>

	 				<tr>
	 					<th>PAGADO EL:</th>
	 					<td id="fndfechapago0" class="text-left"></td>
	 				</tr>
 				</tbody>
 			</table>
    
			<div class="form-actions pull-right">
				<button onclick="return false;" id="closeConvenio" class="btn btn-small btn-default" type="button">
					Cerrar
					<i class="icon-arrow-up icon-on-up bigger-110"></i>
				</button>
			</div>

		</div>
	</div>
</div>	

<script type="text/javascript">

	$("#reviveIdEdoCta").hide();

	// var stream = io.connect(obj.getValue(4));

	var pIdEdoCta = 0;
	var pIdUser = localStorage.IdUser;
	var pUsuario = localStorage.nc;
	var UUID = "";
	$("#msgEsp").hide();

	$("#frmFindIdEdoCta0").on("submit",function(event){
		event.preventDefault();
	});

	$("#findIdEdoCta").on("click",function(event){
		event.preventDefault();
		var queryString = $("#frmFindIdEdoCta0").serialize();
       $.post(obj.getValue(0) + "data/", {o:32, t:32, c:queryString, p:55, from:0, cantidad:0, s:''},
        function(json) {
        	var classColor = 'green';
        	var statusMovto = parseInt(json[0].status_movto,0);
        	switch( statusMovto ){
        		case 0:
        				classColor = 'blue';
        				break;
        		case 1:
        				classColor = 'orange';
        				break;
        		case 2:
        				classColor = 'red';
        				break;
        	}
        	$("#fndfamilia0").html("<strong class='blue'>"+json[0].idfamilia+"</strong> <strong class='green marginLeft2em'>"+json[0].familia+' ('+json[0].tutor+')'+"</strong>");
        	$("#fndalumno0").html("<strong class='blue'>"+json[0].idalumno+"</strong> <strong class='green marginLeft2em'>"+json[0].alumno+"</strong>");
    		$("#fndconcepto0").html("<strong class='blue'>"+json[0].idconcepto+"</strong> <strong class='green marginLeft2em'>"+json[0].concepto + ' ' + json[0].mes+ '  (' + json[0].cvencimiento+ ')  <span class="'+classColor+'">' + json[0].statusmovto +"</span></strong>");

    		$("#fndsubtotal0").html("<strong class='green'>"+json[0].subtotal  +"</strong>");
    		$("#fnddesctobeca0").html("<strong class='green'>"+json[0].descto_becas  +"</strong>");
    		$("#fndimporte00").html("<strong class='green'>"+json[0].importe  +"</strong>");
    		$("#fnddescto0").html("<strong class='green'>"+json[0].descto  +"</strong>");
    		$("#fndrecargo0").html("<strong class='green'>"+json[0].recargo  +"</strong>");
    		$("#fndtotal0").html("<strong class='green'>"+json[0].total  +"</strong>");

    		$("#fndfechapago0").html("<strong class='green'>"+json[0].fecha_de_pago+ ' ' + json[0].pdf +"</strong>");
    		
    		var status_pago = parseInt(json[0].status_movto,0);

    		if ((status_pago == 1 || status_pago == 2) && json[0].pdf == "" ){
				$("#msgEsp").hide();
    			$("#reviveIdEdoCta").show();
 		   		$("#reviveIdEdoCta").prop("disabled",false);
    		}else{
				$("#msgEsp").show();
				$("#msgEsp").html("<strong>Item!</strong> ya facturado");
    			$("#reviveIdEdoCta").show();
	   			$("#reviveIdEdoCta").prop("disabled",true);
    		}

    		pIdEdoCta = parseInt(json[0].idedocta,0);

        }, "json");

	});

	$("#reviveIdEdoCta").on("click",function(event){
		event.preventDefault();

		var x = confirm("Esta seguro que desea reactivar este pago? \n\rEste proceso será irreversible");
		if (!x){
			return false;
		}

		var cad = "pIdEdoCta="+pIdEdoCta+"&pIdUser="+pIdUser+"&pUsuario="+pUsuario;
        $.post(obj.getValue(0) + "data/", {o:32, t:32, c:cad, p:60, from:0, cantidad:0, s:''},
        function(json) {

        	if ( json[0].msg = "OK"){
                // stream.emit("cliente", {mensaje: "PLATSOURCE-PAGO_REACTIVADO-PROP-"+pIdEdoCta});
        		alert("Pago REACTIVADO con éxito");
				goBack()
        	}else{
        		alert("No se pudo reactivar el pago");
				goBack()
        	}

		});
	
	});



	$("#closeConvenio").on("click",function(event){
		goBack()
	});

	function goBack(){
		$("#preloaderPrincipal").hide();
		$("#divUploadImage").modal('hide');

	}





</script>
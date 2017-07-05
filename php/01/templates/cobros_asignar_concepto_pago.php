<?php

include("includes/metas.php");

require_once("../oFunctions.php");
$F = oFunctions::getInstance();

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idfamilia  = $_POST['idfamilia'];
$idalumno  = $_POST['idalumno'];
$clave_nivel  = $_POST['clave_nivel'];
$idciclo  = $_POST['idciclo'];
$beca_sep  = $_POST['beca_sep'];
$beca_arji  = $_POST['beca_arji'];
$beca_sp  = $_POST['beca_sp'];
$beca_bach  = $_POST['beca_bach'];

?>
<div class="row-fluid">
<div class="span12" style="padding-left: 1em; padding-right: 1em;">
<div class="tabbable">

	<h3 class="header smaller lighter blue" id="title">Asignar Concepto | FAM: <?php echo $idfamilia; ?> | ALU: <?php echo $idalumno; ?></h3>
	<form id="frmData" role="form">

		<ul class="nav nav-tabs" id="myTab">

			<li class="active">
				<a data-toggle="tab" href="#general">
					<i class="red icon-percent bigger-110"></i>
					Concepto
				</a>
			</li>

		</ul>

		<div class="tab-content">

			<div id="general" class="tab-pane active">

				<div class="form-group ">
			    	<label for="idemisorfiscal" class="col-lg-4 control-label">Emisor Fiscal</label>
			    	<div class="col-lg-8">
                        <select name="idemisorfiscal" id="idemisorfiscal" size="1" class="form-control altoMoz"> </select>
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="idconcepto" class="col-lg-4 control-label">Concepto</label>
			    	<div class="col-lg-8">
                        <select name="idconcepto" id="idconcepto" size="1" class="form-control altoMoz"> </select>
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="num_pagos" class="col-lg-4 control-label">Número Pagos</label>
			    	<div class="col-lg-8">
						<select class="form-control altoMoz"  name="num_pagos" id="num_pagos" size="1">
							<option value="1" selected>1 Pago</option>
							<option value="10">10 Pagos</option>
							<option value="12">12 Pagos</option>
							<option value="6">6 Pagos</option>
							<option value="4">4 Pagos</option>
							<option value="3">3 Pagos</option>
							<option value="2">2 Pagos</option>
						</select>
		      		</div>
			    </div>
			
				<div class="form-group ">
			    	<label for="subtotal" class="col-lg-4 control-label">Subtotal</label>
			    	<div class="col-lg-8">
				    	<input type="text" class="form-control altoMoz" id="subtotal" name="subtotal" value="0" required readonly>
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="descuento" class="col-lg-4 control-label">Descuento</label>
			    	<div class="col-lg-8">
				    	<input type="text" class="form-control altoMoz" id="descuento" name="descuento" value="0" required readonly>
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="recargo" class="col-lg-4 control-label">Recargo</label>
			    	<div class="col-lg-8">
				    	<input type="text" class="form-control altoMoz" id="recargo" name="recargo" value="0" required readonly>
		      		</div>
			    </div>

				<div class="form-group ">
			    	<label for="importe" class="col-lg-4 control-label">Importe</label>
			    	<div class="col-lg-8">
				    	<input type="text" class="form-control altoMoz" id="importe" name="importe" value="0" required readonly>
		      		</div>
			    </div>

			</div>

		</div>

	    <input type="hidden" name="idfamilia" id="idfamilia" value="<?php echo $idfamilia; ?>">
	    <input type="hidden" name="idalumno" id="idalumno" value="<?php echo $idalumno; ?>">
	    <input type="hidden" name="clave_nivel" id="clave_nivel" value="<?php echo $clave_nivel; ?>">
	    <input type="hidden" name="idciclo" id="idciclo" value="<?php echo $idciclo; ?>">
	    <input type="hidden" name="beca_sep" id="beca_sep" value="<?php echo $beca_sep; ?>">
	    <input type="hidden" name="beca_arji" id="beca_arji" value="<?php echo $beca_arji; ?>">
	    <input type="hidden" name="beca_sp" id="beca_sp" value="<?php echo $beca_sp; ?>">
	    <input type="hidden" name="beca_bach" id="beca_bach" value="<?php echo $beca_bach; ?>">
	    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>">
	    <div class="form-group w96" style='margin-right: 3em; margin-top: 1em;'>
	    	<button type="button" class="btn btn-default pull-right" data-dismiss="modal" id="closeFormUpload"><i class="icon-signout"></i>Cerrar</button>
	    	<span class="muted"></span>
	    	<button type="submit" class="btn btn-primary pull-right" style='margin-right: 4em;'><i class="icon-ok"></i>Aplicar</button>
		</div>

	</form>

</div>




</div>
</div>
<!--PAGE CONTENT ENDS-->

<script typy="text/javascript">        

jQuery(function($) {

	var stream = io.connect(obj.getValue(4));
	var idfamilia = <?php echo $idfamilia; ?>;
	var idalumno = <?php echo $idalumno; ?>;
	var clave_nivel = <?php echo $clave_nivel; ?>;

	var idconcepto = 0;
	$("#preloaderPrincipal").hide();

    $("#frmData").unbind("submit");
	$("#frmData").on("submit",function(event){
		event.preventDefault();

		$("#preloaderPrincipal").show();

	    var queryString = $(this).serialize();	
	    
	    //alert(queryString)
	    // return false;

		var data = new FormData();

		if (validForm()){
            $.post(obj.getValue(0) + "data/", {o:28, t:7, c:queryString, p:2, from:0, cantidad:0, s:''},
            function(json) {
            		if (json[0].msg=="OK"){
            			alert("Concepto de Pago Agregado con éxito.");
						stream.emit("cliente", {mensaje: "PLATSOURCE-APLYNEWCONCEPT-PROP-"+idfamilia});
						$("#preloaderPrincipal").hide();
						$("#divUploadImage").modal('hide');
        			}else{
						$("#preloaderPrincipal").hide();
        				alert(json[0].msg);	
        			}
        	}, "json");
		}else{
			$("#preloaderPrincipal").hide();
		}

	});

	$("#closeProp").on("click",function(event){
		$("#preloaderPrincipal").hide();
		$("#divUploadImage").modal('hide');
	});

    function getEmisoresFiscales(){
        var nc = "u="+localStorage.nc;
        $("#idemisorfiscal").append('<option value="0">Seleccione un Emisor Fiscal</option>');
        $.post(obj.getValue(0)+"data/", { o:1, t:26, p:0,c:nc,from:0,cantidad:0, s:"" },
            function(json){
               $.each(json, function(i, item) {
                    $("#idemisorfiscal").append('<option value="'+item.data+'"> '+item.label+'</option>');
                });
            }, "json"
        );  
    }

    function getPagos(){
        $("#idconcepto").html('');
        $("#idconcepto").append('<option value="0-0">Seleccione un Concepto</option>');
        var idrf = $("#idemisorfiscal").val().split('-');
        var nc = "u="+localStorage.nc+"&clave_nivel="+clave_nivel+"&idemisorfiscal="+idrf[0];
        //alert(nc);
        $.post(obj.getValue(0)+"data/", { o:1, t:10011, p:11,c:nc,from:0,cantidad:0, s:"concepto" },
            function(json){
               $.each(json, function(i, item) {
                    $("#idconcepto").append('<option value="'+item.idpago+'-'+item.importe+'"> '+item.concepto+'</option>');
                });
               $("#subtotal").focus();
            }, "json"
        );  
    }

	$("#idemisorfiscal").on("change",function(event){
		event.preventDefault();
        getPagos();    
	});

	$("#idconcepto").on("change",function(event){
		event.preventDefault();
		var item = $(this).val().split('-');
		//console.log($(this).val());
		idconcepto = item[0];
		$("#subtotal").val(item[1]);
	});

	$("#num_pagos").on("change",function(event){
		event.preventDefault();
		var item = $(this).val();

		var imp = $("#subtotal").val() /  $(this).val();
		
		$("#importe").val(imp);

	});

	function validForm(){

/*
		if( parseFloat( $("#familia").val() ) <= 0){
			alert("Faltan el Porcentaje");
			$("#familia").focus();
			return false;
		}
*/

		return true;

	}

	getEmisoresFiscales();

	

});

</script>
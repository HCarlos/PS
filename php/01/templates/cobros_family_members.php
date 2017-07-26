<?php

include("includes/metas.php");

require_once("../oCentura.php");
$f = oCentura::getInstance();

$user = $_POST['user'];
$idfam = $_POST['idfamilia'];
$tutor = $_POST['tutor'];

$arr = $f->getQuerys(10009,"idfamilia=".$idfam."&u=".$user,0,0,0,array(),'alumno');
	
foreach ($arr as $i => $value) {

	$arrAlu = $f->getQuerys(10023,"idfamilia=".$idfam."&u=".$user."&idciclo=".$arr[$i]->idciclo."&idalumno=".$arr[$i]->idalumno,0,0,0,array(),'alumno');
	if ( count($arrAlu) > 0 ) {


		$arr[$i]->clave_nivel 		= $arrAlu[0]->clave_nivel; 
		$arr[$i]->nivel 			= $arrAlu[0]->nivel; 
		$arr[$i]->grupo 			= $arrAlu[0]->grupo; 
		$arr[$i]->genero 			= $arrAlu[0]->genero;
		$arr[$i]->beca_sep 			= $arrAlu[0]->beca_sep; 
		$arr[$i]->beca_arji 		= $arrAlu[0]->beca_arji; 
		$arr[$i]->beca_sp 			= $arrAlu[0]->beca_sp; 
		$arr[$i]->beca_bach 		= $arrAlu[0]->beca_bach;	
		$arr[$i]->grupo_bloqueado 	= intval($arrAlu[0]->grupo_bloqueado);	


	}

}

if (count($arr)>0){
?>
<div class="tabbable">
		<div class="pull-right" style=" background-color: red; margin-top:0"></div>
	<ul class="nav nav-tabs" id="myTab">
		<?php
			// $arr = $f->getQuerys(10009,"idfamilia=".$idfam."&u=".$user,0,0,0,array(),'alumno');
			foreach ($arr as $i => $value) {
				if ( $arr[$i]->grupo_bloqueado == 0 || $arr[$i]->grupo_bloqueado == 1 ){
					$cls = $i==0?"active":"";
					$xg =  $arr[$i]->genero==0?'pink':'blue';
		?>

		<li class="<?php echo $cls; ?>">
			<a data-toggle="tab" href="#ali<?php echo $i; ?>" title="<?= $arr[$i]->grupo; ?>">
				<i class="<?= $xg; ?> icon-user bigger-110 propAlu0" id="propAlu0-<?= $arr[$i]->idalumno; ?>" ></i>
				<?php echo $arr[$i]->alumno. ' (' . substr($arr[$i]->nivel,0,4) . ')'; ?>
				<span class="separatorSpan"></span>
				<span class="icon icon-cogs orange bigger-110 asigConceptoAluPago0" 
						id="configalu-<?php echo $idfam.'-'.$arr[$i]->idalumno.'-'.$arr[$i]->clave_nivel.'-'.$arr[$i]->nivel.'-'.$arr[$i]->idciclo.'-'.$arr[$i]->beca_sep.'-'.$arr[$i]->beca_arji.'-'.$arr[$i]->beca_sp.'-'.$arr[$i]->beca_bach; ?>" 
						style="cursor: pointer;"></span>
			</a>
		</li>

		<?php
				}
			}
		?>

	</ul>

	<div class="tab-content">
		<?php
			foreach ($arr as $i => $value) {

				$cls = $i==0?"active":"";
		?>

		<div id="ali<?php echo $i; ?>" class="tab-pane <?php echo $cls; ?>">
			
			<table class="detFac" id="tblPagos0">
				<thead>
					<tr>
						<th>ID</th>
						<th>Concepto</th>
						<th>Descto</th>
						<th>Recargo</th>
						<th>Importe</th>
						<th>Docto</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
						$arrAlu = $f->getQuerys(10010,"idfamilia=".$idfam."&idalumno=".$arr[$i]->idalumno."&u=".$user,0,0,0,array(),' order by deuda_anterior asc, status_movto asc, orden_prioridad asc, idpago asc ');
						foreach ($arrAlu as $j => $value) {
							$id = $arrAlu[$j]->idedocta;
							$idpago = $arrAlu[$j]->idpago;
							
							$porigen = intval($arrAlu[$j]->origen);

							if ($arrAlu[$j]->is_pagos_diversos=="1" ){
								if ($arrAlu[$j]->status_movto=="1" ){
									$concp0 =  $arrAlu[$j]->concepto.' '.$arrAlu[$j]->mes.' <small class="inline chikirimbita"> ('. date("d-m-Y", strtotime($arrAlu[$j]->fecha_de_pago)) .')</small> ';
								}else{
									$concp0 =  $arrAlu[$j]->concepto.' '.$arrAlu[$j]->mes;
								}
							}else{
								
								if ($arrAlu[$j]->status_movto=="1" ){
									$concp0 =  $arrAlu[$j]->concepto.' <small class="inline chikirimbita"> ('. date("d-m-Y", strtotime($arrAlu[$j]->fecha_de_pago)) .')</small> ';
								}else{
									$concp0 =  $concp0 =  $arrAlu[$j]->concepto;
								}

							}
							// $concp0 = $arrAlu[$j]->is_pagos_diversos=="1" ? $arrAlu[$j]->concepto.' '.$arrAlu[$j]->mes : $arrAlu[$j]->concepto;
							$concp1 = $arrAlu[$j]->concepto;
							$tr0 = "id0-".$id; 
							$lbl0 = "id0*".$id.'*'.$idfam.'*'.$arr[$i]->idalumno.'*'.$arrAlu[$j]->descto.'*'.$arrAlu[$j]->recargo.'*'.$arrAlu[$j]->total.'*'.$arrAlu[$j]->subtotal.'*'.$arrAlu[$j]->importe.'*'.$arrAlu[$j]->idpago.'*'.$arrAlu[$j]->descto_becas; 
							if ($arrAlu[$j]->is_descto_beca == 1){
								$oDescto = $arrAlu[$j]->porcdescto + $arrAlu[$j]->beca_sep + $arrAlu[$j]->beca_arji + $arrAlu[$j]->beca_bach + $arrAlu[$j]->beca_sp;
								if ($oDescto > 0){
									$pcd0 = ( ceil($oDescto) % floor($oDescto) ) <= 0 ? intval($oDescto) : $oDescto;
									$leyDescto = '<small class="inline chikirimbita"> ('.$pcd0.'%)</small>  '.number_format(($arrAlu[$j]->descto_becas+$arrAlu[$j]->descto), 2, '.', ',');
								}else{
									$leyDescto = '';
								}
							}else{
								$leyDescto = '';
							}
							
							if ($arrAlu[$j]->porcrecargo > 0){
								if ($arrAlu[$j]->porcrecargo >= 1){
									$pcr0 = ( $arrAlu[$j]->porcrecargo - intval($arrAlu[$j]->porcrecargo) ) == 0 ? intval($arrAlu[$j]->porcrecargo) : $arrAlu[$j]->porcrecargo;
								}else{
									$pcr0 = $arrAlu[$j]->porcrecargo;
								}
								$leyRecargo = '<small class="inline chikirimbita"> ('.$pcr0.'%)</small>  '.number_format($arrAlu[$j]->recargo, 2, '.', ',');
							}else{
								if ($arrAlu[$j]->recargo > 0){
									$pcr0 = $arrAlu[$j]->recargo;
									$leyRecargo = number_format($arrAlu[$j]->recargo, 2, '.', ',');
								}else{
									$leyRecargo = '';
								}
							}
							
						
							$defcolorep = '';

							if ( intval($arrAlu[$j]->deuda_anterior) == 1 ){
								$defcolorep = 'colorisdeudaanterior';
							}

							if ( intval($arrAlu[$j]->status_movto) != 0){
								$defcolorep = 'colorpagado';
							}

					?>
					<tr class="<?php echo $defcolorep; ?>" id="<?php echo $tr0; ?>">
						<td class="tbl50W">
							
							<?php
							if (intval($arrAlu[$j]->status_movto)!=1){ 
								$trashSmall = ' <a href="#" id="ch-'.$id.'" class="chEdoCta " ><i class="fa fa-trash red" aria-hidden="true"></i></a>';
							?>

								<input  id="<?php echo $lbl0; ?>" class="chkPago0 inline" type="checkbox"/> 
								<label for="<?php echo $lbl0; ?>" class="inline inputDetFac"><?php echo $id.' '.$trashSmall; ?> </label>
							
							<?php
								}else{
							?>
								<?php echo $id; ?>							
							
							<?php
								}
							?>

						</td>
						<td id="idconcept0-<?php echo $id; ?>"><?php echo $concp0; ?></td>
						<td class="tbl80W textRight" ><?php echo $leyDescto; ?></td>
						<td class="tbl80W textRight"><?php echo $leyRecargo; ?></td>
						<td class="tbl70W textRight" ><?php echo number_format($arrAlu[$j]->total, 2, '.', ','); ?></td>
						<td class="tbl30W textRight" >

							<?php
								if ($arrAlu[$j]->status_movto == 1 and $arrAlu[$j]->isfe == 0){
									echo $arrAlu[$j]->idfactura; 
								} else if ($arrAlu[$j]->status_movto == 1 and $arrAlu[$j]->isfe == 1){
									echo $arrAlu[$j]->cfolio;
								}
							?>	

						</div>
						<td class="tbl80W textRight btns0 " >
							<?php
							if (intval($arrAlu[$j]->status_movto)==0){ 
							?>

							<div class="hidden-phone visible-desktop action-buttons pull-right">
								<a class="blue clsdescto0 margen0" href="#" id="iddescto0-<?php echo $id; ?>" data-original-title="Aplicar Descuento" class="btn btn-small" data-rel="tooltip" title="Aplicar Descuento">
									<i class="icon icon-circle-blank bigger-130"></i>
								</a>
								<a class="blue clsrecargo0 margen0" href="#" id="idrecargo0-<?php echo $id; ?>-<?php echo $arrAlu[$j]->subtotal; ?>-<?php echo $arrAlu[$j]->importe; ?>"  data-original-title="Aplicar Recargo" class="btn btn-small" data-rel="tooltip" title="Aplicar Recargo">
									<i class="icon icon-circle bigger-130"></i>
								</a>
								<a class="red iddeledocta0 margen0" href="#" id="iddeledocta0-<?php echo $id; ?>-<?php echo $idpago; ?>-<?php echo $concp1; ?>-<?php echo $arr[$i]->alumno; ?>-<?php echo $idfam; ?>-<?php echo $arr[$i]->idalumno; ?>"  data-original-title="Quitar Concepto" class="btn btn-small" data-rel="tooltip" title="Quitar Concepto">
									<i class="icon icon-trash bigger-130"></i>
								</a>
							</div>

							<?php
								}else{
									if ($arrAlu[$j]->status_movto == 1 and $arrAlu[$j]->isfe == 0){
							?>

							<div class="hidden-phone visible-desktop action-buttons pull-right">
								
								<a class="blue clsidfac0 margen0" href="#" id="idfac0-<?php echo $arrAlu[$j]->idfactura.'-'. $idfam.'-'.$arrAlu[$j]->idmetododepago.'-'.$arrAlu[$j]->referencia; ?>" data-original-title="Timbrar Factura" class="btn btn-small" data-rel="tooltip" title="Timbrar Factura">
									<?php
										$clrOrigen = $porigen == 2 ? " orange " : "";
									?>
									<i class="icon icon-print bigger-130 <?= $clrOrigen; ?> "></i>
								</a>
							</div>

							<?php
								} else if ($arrAlu[$j]->status_movto == 1 and $arrAlu[$j]->isfe == 1){
							?>

								<div class="hidden-phone visible-desktop action-buttons pull-right ">
									<a class="blue clsidfac1 margen0" href="#" id="idfac1*<?php echo $arrAlu[$j]->directorio.$arrAlu[$j]->pdf; ?>" data-original-title="Visualizar Factura" class="btn btn-small" data-rel="tooltip" title="<?php echo $arrAlu[$j]->cfolio; ?>">
										<i class="icon icon-file-text bigger-130"></i>
									</a>
								</div>

							<?php
								}
							}
							?>

						</td>
					</tr>
					<?php
						}
					?>

				</tbody>
			</table>


		</div>

		<?php
			}
		?>

	</div>

</div>

<script type="text/javascript" >


jQuery(function($){

	var stream = io.connect(obj.getValue(4));

	var IdFamilia = <?php echo $idfam; ?>;
	var Tutor = "<?php echo $tutor; ?>";

	$(".asigConceptoAluPago0").on("click",function(event){
		event.preventDefault();
		var item = this.id.split('-');
		console.log(item[0]+'-'+item[1]);
		
		var nc = localStorage.nc; 
		$.post(obj.getValue(0) + "asig-concepto-pago/", {
				user: nc,
				idfamilia: item[1],
				idalumno: item[2],
				clave_nivel: item[3],
				idciclo: item[5],
				beca_sep: item[6],
				beca_arji: item[7],
				beca_sp: item[8],
				beca_bach: item[9]

			},
			function(html) {
				//alert(html);
				$("#divUploadImage").html(html);
				$("#divUploadImage").modal('toggle');
		}, "html");
	});

	$(".clsdescto0").on("click",function(event){
		event.preventDefault();
		var item = this.id.split('-');
		console.log(item[0]+'-'+item[1]);
		
		var nc = localStorage.nc; 
		$.post(obj.getValue(0) + "set-descto-pago/", {
				user: nc,
				idfamilia: IdFamilia,
				idedocta: item[1]
			},
			function(html) {
				//alert(html);
				$("#divUploadImage").html(html);
				$("#divUploadImage").modal('toggle');
		}, "html");

	});

	

	$(".chEdoCta").on("click",function(event){
		event.preventDefault();
		var item = this.id.split('-');
		if (!confirm("Esta seguro que desea eliminar el registro de pago: "+item[1])  ){
			return false;
		}

		// var x = prompt("Ingrese la Clave de Autorización");

		var thePrompt = window.open("", "", "widht=500");
	    var theHTML = "";

	    theHTML += "Clave Autorización: <input type='password' id='thePass' placeholder=''/>";
	    theHTML += "<br />";
	    theHTML += "<input type='button' value='OK' id='authOK'/>";
	    thePrompt.document.body.innerHTML = theHTML;		

		thePrompt.document.getElementById("authOK").onclick = function () {

		var thePass = thePrompt.document.getElementById("thePass").value;
 		var nc = "u="+localStorage.nc+"&claveAutorizacion="+thePass+"&idedocta="+item[1];
 		// alert(nc);
       	$.post(obj.getValue(0) + "data/", {o:0, t:0, c:nc, p:61, from:0, cantidad:0, s:''},
        function(json) {
				$("#preloaderPrincipal").hide();
        		if (json[0].msg=="OK"){
        			alert("Registro CANCELADO con éxito.");
    			}else{
    				alert(json[0].msg);	
    			}
    	}, "json");

    	thePrompt.close();
    	// K4rl0sH;9602
    	// R1v3dg7;

    }


	});


	$(".clsrecargo0").on("click",function(event){
		event.preventDefault();
		var item = this.id.split('-');
		
		var nc = localStorage.nc; 
		$.post(obj.getValue(0) + "set-recargo-pago/", {
				user: nc,
				idfamilia: IdFamilia,
				idedocta: item[1],
				subtotal:item[2],
				importe:item[3]
			},
			function(html) {
				//alert(html);
				$("#divUploadImage").html(html);
				$("#divUploadImage").modal('toggle');
		}, "html");
	});

	$(".iddeledocta0").on("click",function(event){
		event.preventDefault();
		var item = this.id.split('-');
		// 
		$("#preloaderPrincipal").show();
		var r = confirm("¿Desea ELIMINAR el concepto ("+item[2]+") "+item[3]+" de "+item[4]+"?");
		console.log(r);
		if (r){
			var nc = "";
			if ( parseInt(item.length,0) == 7 ){
				nc = "user="+localStorage.nc+"&idedocta="+item[1]+"&idpago="+item[2]+"&idfamilia="+item[5]+"&idalumno="+item[6];
			}else{				
				nc = "user="+localStorage.nc+"&idedocta="+item[1]+"&idpago="+item[2]+"&idfamilia="+item[6]+"&idalumno="+item[7];
			}
			console.log(nc);
            $.post(obj.getValue(0) + "data/", {o:28, t:8, c:nc, p:2, from:0, cantidad:0, s:''},
            function(json) {
					$("#preloaderPrincipal").hide();
            		if (json[0].msg=="OK"){
            			alert("Concepto ELIMINADO con éxito.");
						stream.emit("cliente", {mensaje: "PLATSOURCE|DELETECONCEPTFROMALU|PROP|"+item[2]});
        			}else{
        				alert(json[0].msg);	
        			}
        	}, "json");
        }
	});


	$(".clsidfac0").on("click",function(event){
		event.preventDefault();
		var item = this.id.split('-');
		console.log(item[2]);
		var nc = localStorage.nc; 
		

        $("#contentProfile").html("");
        $("#contentMain").hide(function(){
	        $("#preloaderPrincipal").show();
	        obj.setIsTimeLine(false);
	        var nc = localStorage.nc;
			// alert(Tutor);
	        $.post(obj.getValue(0) + "cob-fe-0/", {
				user: nc,
				idfactura:item[1],
				idfamilia:item[2],
				idmetododepago:item[3],
				referencia:item[4],
				tutor: Tutor,
	            },
	            function(html) {	
	                $("#contentProfile").html(html).show('slow',function(){
		                $('#breadcrumb').html(getBar('Inicio, Facturación '));
	                });
	                $("#preloaderPrincipal").hide();
	            }, "html");
        });


	});

	$(".clsidfac1").on("click",function(event){
		event.preventDefault();
		var item = this.id.split('*');
		window.open(obj.getValue(0) + "uw_fe/"+item[1],'_blank');
	});



});


</script>

<?php
}else{
	echo "NoFamilia";
}
?>
